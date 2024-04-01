import { setTokenInCookie } from 'requests/token.request';
import { removeToken } from 'requests/api';
import { IUserSchema } from 'schemas/account.schema';

export async function logoutRequest() {
  await setTokenInCookie('', {} as IUserSchema);
  removeToken();
}
