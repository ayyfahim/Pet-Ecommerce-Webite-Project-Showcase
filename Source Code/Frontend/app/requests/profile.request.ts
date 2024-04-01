import { getRequest } from 'requests/api';
import { IUserSchema } from 'schemas/account.schema';
import {IPaginator} from "types/pagination.types";
import {IRequestConfig} from "types/request.types";

export function getProfileRequest(query = {} as IPaginator, config = {} as IRequestConfig) {
  // eslint-disable-next-line no-prototype-builtins
  if (!config.hasOwnProperty('doNotHandleError')) {
    config.doNotHandleError = false;
  }
  return getRequest<IUserSchema>(`/users/me`, query, config)
    .then((data) => {
      return data;
    })
}
