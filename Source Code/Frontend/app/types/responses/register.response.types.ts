import {IUserSchema} from "schemas/account.schema";

export type IRegisterResponse = {
  token: string;
  user: IUserSchema;
};
