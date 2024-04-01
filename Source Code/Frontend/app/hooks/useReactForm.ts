import { DeepPartial, SubmitHandler, UnpackNestedValue, useForm } from 'react-hook-form';
import { yupResolver } from '@hookform/resolvers/yup';
import { SchemaOf } from 'yup';
import { UseFormProps } from 'react-hook-form/dist/types';
import { FormEventHandler, useEffect, useRef, useState } from 'react';
import getObjectProperties, { filterOutEmptyProperties } from 'shared/objectProperties';
import { getPromiseFieldName } from 'hooks/useFormPreSubmit';
import useNotificationContext from 'contexts/notification.context';
import useFormContainerContext from 'contexts/form.context';
import { apiRequest, IHandledApiError, IRequestType } from 'requests/api';
import useAppRouteContext from 'contexts/app.route.context';
import { IRequestConfig } from 'types/request.types';
import useIsMounted from 'hooks/useIsMounted';

type IFormMutationOptions<TRes, TReq> = {
  formOptions?: UseFormProps<TReq>;
  onSuccess?: (data: TRes) => void;
  onError?: (error: IHandledApiError) => void;
  preSubmit?: (data: TReq) => Promise<TReq | undefined | void> | undefined;
  preventLeaveIntent?: boolean;
} & Omit<IRequestConfig, 'setError'>;

export default function useReactForm<TRes, TReq extends Record<string, unknown>>(
  requestType: IRequestType,
  submitUrl: string,
  schema: SchemaOf<TReq>,
  initialValues?: Partial<TReq>,
  options: IFormMutationOptions<TRes, TReq> = {}
) {
  const fields = Object.keys(schema.fields) as (keyof UnpackNestedValue<DeepPartial<TReq>>)[];
  const { formOptions = {} } = options;

  const defaultValues = getObjectProperties(
    (initialValues || undefined) as UnpackNestedValue<DeepPartial<TReq>>,
    ...fields
  ) as DeepPartial<TReq> | undefined;

  const methods = useForm<TReq>({
    defaultValues,
    resolver: yupResolver(schema),
    shouldFocusError: true,
    mode: formOptions.mode || 'onSubmit',
  });

  const { hasPendingChanges, setHasPendingChanges } = useFormContainerContext();

  useEffect(() => {
    if (!options.preventLeaveIntent) {
      return;
    }
    if (methods.formState.isDirty) {
      setHasPendingChanges(true);
    }

    return () => {
      if (hasPendingChanges) {
        setHasPendingChanges(false);
      }
    };
  }, [options.preventLeaveIntent, methods.formState.isDirty]);

  let axiosConfig = {
    silent: options.silent || false,
    doNotHandleError: options.doNotHandleError || false,
    setError: methods.setError,
  } as IRequestConfig<TReq>;

  // @ts-ignore
  if (options.baseUrl) {
    // @ts-ignore
    axiosConfig.baseURL = options.baseUrl;
  }

  const onSuccess = async (data: TRes) => {
    if (hasPendingChanges) {
      setHasPendingChanges(false);
    }

    options.onSuccess && (await options.onSuccess(data));
  };

  const onError = (e: IHandledApiError) => {
    options.onError && options.onError(e);
  };

  const { isLoading: isRouteChanging } = useAppRouteContext();
  const [isLoading, setIsLoading] = useState(false);
  const [postProcessing, setPostProcessing] = useState(false);
  const isMounted = useIsMounted();

  const { notify } = useNotificationContext();
  const customData = useRef<Partial<TReq>>();

  useEffect(() => {
    // console.log('isLoading', isLoading);
    // console.log('postProcessing', postProcessing);
    // console.log('isRouteChanging', isRouteChanging);
    setIsLoading(isLoading || postProcessing || isRouteChanging);
  }, [postProcessing, isRouteChanging]);

  const onSubmit: SubmitHandler<TReq> = async (data) => {
    delete data.promise;
    const hasChanged = requestType !== 'patch' || hasFieldsChanged(data, initialValues || {});
    if (customData.current) {
      Object.assign(data, customData.current);
    }

    setIsLoading(true);

    return apiRequest<TRes, TReq>(
      requestType,
      submitUrl,
      hasChanged ? (data as TReq) : ({ noChange: 'no-change', data: initialValues } as unknown as TReq),
      axiosConfig
    )
      .then(async (response) => {
        setPostProcessing(true);
        await onSuccess(response);
        isMounted && setPostProcessing(false);
        return response;
      })
      .catch((e: IHandledApiError) => {
        onError(e);
        return e;
      })
      .finally(() => {
        setIsLoading(false);
      });
  };

  const formSubmitHandler = methods.handleSubmit(onSubmit);
  const submitHandler: typeof formSubmitHandler = async (e) => {
    e?.preventDefault();
    const data = methods.getValues();
    const promise = filterOutEmptyProperties(data.promise || {}) as Record<string, string>;
    if (typeof promise === 'object') {
      const keys = Object.keys(promise);
      if (keys?.length > 0) {
        const field = keys[0];
        // @ts-ignore
        methods.setError(getPromiseFieldName(field), { message: promise[field] });
        notify(promise[field], { toastId: 'form-promise' });

        return undefined;
      }
    }

    return formSubmitHandler(e);
  };

  const preSubmitHandler: FormEventHandler = async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target as HTMLFormElement);
    if (options.preSubmit) {
      const response = await options.preSubmit(formData as unknown as TReq);
      customData.current = (response as TReq) || undefined;
      if (!response) {
        return;
      }
    }
    submitHandler(e).then();
  };

  return {
    onSubmit,
    methods,
    isLoading,
    submitHandler: options.preSubmit ? preSubmitHandler : submitHandler,
    errors: methods.formState.errors,
  };
}

function hasFieldsChanged(data: Record<string, unknown>, existing: Record<string, unknown>) {
  return Object.keys(data).some((key) => {
    if (key.endsWith('Id') || key.endsWith('Ids')) {
      let field = key.replace(`Ids`, '').replace('Id', '');
      if (key.endsWith('Ids')) {
        if (field.endsWith('y')) {
          field = field.slice(0, -1) + 'ie';
        }
        field += 's';
      }

      const existingValue = existing[field] as unknown[];
      const newValue = data[key] as unknown[];

      if (existingValue?.constructor?.name === 'Array' || newValue?.constructor?.name === 'Array') {
        // this is a foreign key workaround since api is not sending them at all.
        const fieldData = existing[field] as { id: string } | { id: string }[];
        const ids = (
          fieldData?.constructor?.name === 'Array'
            ? (fieldData as unknown as { id: string }[])
            : [fieldData as unknown as { id: string }]
        )
          .map((x) => x?.id)
          .filter((x) => x)
          .join(', ');

        const newIds =
          ((data[key] || []) as string[]).constructor?.name === 'Array' ? (data[key] as string[]) : [data[key] || ''];

        return newIds.filter((x) => x).join(', ') !== ids;
      }
    }

    if (!existing[key] && !data[key]) {
      return false;
    }
    if (typeof existing[key] === 'object') {
      return JSON.stringify(data[key]) !== JSON.stringify(existing[key]);
    }
    return data[key] !== existing[key];
  });
}
