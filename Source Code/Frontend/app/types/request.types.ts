import { AxiosError, AxiosRequestConfig, AxiosResponse } from 'axios';
import { IUndefinedCanBeNullable } from 'schemas/baseSchema';
import { UseFormSetError } from 'react-hook-form';

export type IRequestConfig<TReq = Record<string, unknown>> = AxiosRequestConfig & {
  silent?: boolean;
  setError?: UseFormSetError<TReq>;
  doNotHandleError?: boolean;
};

export type IValidationErrors = Record<string, [string]>;

export type IApiResponse<TRes = Record<string, unknown>> = IUndefinedCanBeNullable<{
  message?: string;
  url?: string;
  data: TRes;
  view?: string;
}>;

export type IApiError = IUndefinedCanBeNullable<{
  message: string;
  errors?: IValidationErrors;
}>;

export type IAxiosResponse<TRes = Record<string, unknown>> = AxiosResponse<IApiResponse<TRes>>;

export type IAxiosError = AxiosError<IApiError>;
