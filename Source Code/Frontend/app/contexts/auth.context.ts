import { createContext, useContext } from 'react';
import { IUserSchema } from 'schemas/account.schema';

type IAuthContext = {
  user?: IUserSchema;
  setUser: (user: IUserSchema | undefined) => void;
};
const authContext = createContext<IAuthContext>({ setUser: () => {} });
authContext.displayName = 'Auth';

export const AuthContextProvider = authContext.Provider;

export const useAuthContext = () => {
  const data = useContext(authContext);
  const isUserAdmin = () => data.user?.role === 'admin';

  const isCustomer = () => data.user?.role === 'customer';

  return {
    isUserAdmin,
    isCustomer,
    ...data,
  };
};
