import { IUserSchema } from 'schemas/account.schema';

export type IAuthCookie = {
  token: string;
  user: Pick<IUserSchema, 'id' | 'first_name' | 'last_name' | 'email' | 'role' | 'full_name' | 'mobile'>;
};

export type ICookies = {
  auth: IAuthCookie;
  redirectPath: string;
};
