import { createContext, useContext } from 'react';

export const appRouteContext = createContext({ isLoading: false });
appRouteContext.displayName = 'AppRoute';

export default function useAppRouteContext() {
  return useContext(appRouteContext);
}
