import axios, { AxiosRequestConfig } from 'axios';
import type { AxiosError } from 'axios';
import { IAxiosError, IRequestConfig, IValidationErrors } from 'types/request.types';
import { IPaginator } from 'types/pagination.types';
import { toast } from 'react-toastify';
import { getEnv } from '@/bootstrap/app.config';

import mutate from 'swr';

export const api = axios.create({
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
  baseURL: getEnv('apiUrl', 'http://localhost:3000/api'),
});

type IRequests = Pick<typeof api, 'put' | 'patch' | 'post'>;

export type IRequestType = keyof IRequests;

const defaultConfig = {
  mode: 'no-cors',
} as unknown as AxiosRequestConfig;

api.interceptors.response.use(
  (res) => {
    return res;
  },
  (error: AxiosError) => {
    if (error.isAxiosError && error.code == '401') {
      //
    }

    return Promise.reject(error);
  }
);

export function setToken(token: string) {
  if (!token || token.length < 10) {
    return;
  }

  api.defaults.headers.common = {
    ...(api.defaults.headers.common || {}),
    Authorization: `Bearer ${token}`,
  };
}

export function removeToken() {
  delete api.defaults.headers.common.Authorization;
}

export function getRequest<TResponse = Record<string, unknown>>(
  url: string,
  query = {} as IPaginator,
  config?: Omit<IRequestConfig, 'silent' | 'doNotHandleError' | 'setError'>
) {
  const queryString = getQueryStringFromParams(query);
  const path = url.includes('?') ? url + queryString : url + `?${queryString}`;
  return api
    .get<TResponse>(path, config)
    .then((r) => r.data)
    .catch((_e) => {
      return null;
    });
}

export function swrFetcher(
  url: string,
  query = {} as IPaginator,
  config?: Omit<IRequestConfig, 'silent' | 'doNotHandleError' | 'setError'>
) {
  return api
    .get(url, config)
    .then((r) => r.data)
    .catch((e: IAxiosError) => {
      const handledError = handleError(e, config || {});
    });
}

export function getRequestSwr<TResponse = Record<string, unknown>>(
  url: string,
  query = {} as IPaginator,
  returnIsValidating?: boolean,
  config?: Omit<IRequestConfig, 'silent' | 'doNotHandleError' | 'setError'>
) {
  const { data, isValidating, error } = mutate<TResponse>(url, (url) => swrFetcher(url, query, config), {
    revalidateOnFocus: false,
    revalidateIfStale: false,
    revalidateOnReconnect: false,
  });

  if (error) {
    const handledError = handleError(error, config || {});
    return;
  }

  if (returnIsValidating) {
    return {
      data: data,
      isValidating: isValidating,
    };
  }

  return data || null;
}

export function apiRequest<TRes = Record<string, unknown>, TReq = Record<string, unknown> | FormData>(
  requestType: IRequestType,
  url: string,
  data: TReq,
  options = {} as IRequestConfig<TReq>
): Promise<TRes> {
  // @ts-ignore
  if (data?.noChange === 'no-change') {
    // @ts-ignore
    return Promise.resolve(data?.data as TRes);
  }
  (Object.keys(data) as (keyof TReq)[]).forEach((key) => {
    // @ts-ignore
    if (!data[key] && data[key] !== 0) {
      data[key] = null as unknown as TReq[keyof TReq];
    } else if ((data[key] as unknown as string[]).constructor?.name === 'Array') {
      data[key] = (data[key] as unknown as string[]).filter((x) => x) as unknown as TReq[keyof TReq];
    }
  });
  if (requestType === 'patch' && typeof data === 'object') {
    Object.keys(data).forEach((key) => {
      // @ts-ignore
      if (!data[key]) {
        // @ts-ignore
        data[key] = null;
      }
    });
  }
  return new Promise((resolve, reject) => {
    return api[requestType || 'post']<TRes>(url, data, { ...options, ...defaultConfig })
      .then((response) => {
        resolve(response.data as TRes);
        return response;
      })
      .catch((e: IAxiosError) => {
        const handledError = handleError(e, options);
        reject(handledError as IHandledApiError);
        return e;
      });
  });
}

export function postRequest<TResponse = Record<string, unknown>, TReq = Record<string, unknown>>(
  url: string,
  data: TReq,
  config?: IRequestConfig<TReq>
) {
  return apiRequest<TResponse, TReq>('post', url, data, config);
}

export function patchRequest<TResponse = Record<string, unknown>, TReq = Record<string, unknown>>(
  url: string,
  data: TReq,
  config?: IRequestConfig<TReq>
) {
  return apiRequest<TResponse, TReq>('patch', url, data, config);
}

export function putRequest<TResponse = Record<string, unknown>, TReq = Record<string, unknown>>(
  url: string,
  data: TReq,
  config?: IRequestConfig<TReq>
) {
  return apiRequest<TResponse, TReq>('put', url, data, config);
}

export function getQueryStringFromParams(params: IPaginator) {
  const queryStrings = Object.keys(params).reduce((queries, key) => {
    let value = params[key];
    if (typeof value === 'undefined' || value === '' || key === 'total') {
      return queries;
    }
    if (value?.constructor?.name === 'Set') {
      value = JSON.stringify(
        [...(value as string[])].reduce((obj, val) => {
          obj[val] = 1;
          return obj;
        }, {} as IPaginator)
      );
    } else if (value?.constructor?.name === 'Array') {
      value = (value as string[]).join(',');
      if (!value) {
        return queries;
      }
    } else if (value?.constructor?.name === 'Object') {
      value = JSON.stringify(value);
      if (!value) {
        return queries;
      }
    }
    queries.push(`${key}=${value}`);
    return queries;
  }, [] as string[]);

  return queryStrings.join('&');
}

export function getValidationErrors(errorResponse: IAxiosError): IValidationErrors {
  const validationErrors = errorResponse?.response?.data?.errors;

  if (validationErrors) {
    return validationErrors;
  }

  return {};
}

export function getAxiosErrorMessage(
  errorResponse: IAxiosError,
  defaultMessage = 'Sorry. Something went wrong. Please try again soon.'
): string {
  const apiError = errorResponse?.response?.data;
  const message = apiError?.message;

  return message || defaultMessage;
}

function handleError<TReq = Record<string, unknown>>(e: IAxiosError, options: IRequestConfig<TReq>) {
  const message = getAxiosErrorMessage(e);

  if (options.doNotHandleError) {
    return {
      message,
      error: e,
    };
  }

  if (!options.silent) {
    toast.clearWaitingQueue();
    toast.error(message, { toastId: 'notification' });
  }

  if (e.response?.status == 422 && options.setError) {
    const setError = options.setError;
    const errors = getValidationErrors(e);
    Object.keys(errors).forEach((key) => {
      const errorMessages = errors[key] || [''];
      const message = errorMessages[0];
      if (message) {
        // @ts-ignore
        setError(key, {
          message: message
            .replace(key + "'s", key.convertToReadable().capitalize(true).toLowerCase())
            .replace(key, key.convertToReadable().toLowerCase())
            .replace(/Ids|ids|id/, ''),
        });
      }
    });
  }

  return {
    message,
    error: e,
  };
}

export type IHandledApiError = ReturnType<typeof handleError>;
