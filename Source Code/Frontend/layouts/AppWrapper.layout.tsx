import React, { FC, ReactNode, useEffect, useState } from 'react';

import { IUserSchema } from 'schemas/account.schema';
import { setToken } from 'requests/api';
import { useRouter } from 'next/router';
import LoadingState from 'components/LoadingState';
import { NotificationContext } from 'contexts/notification.context';
import { appRouteContext } from 'contexts/app.route.context';
import { useAuthState } from 'app/atom/auth.atom';
import { useSiteConfig } from 'atom/siteConfig.atom';
import usePromise from 'hooks/usePromise';
import { getGenericAppData } from 'requests/header.request';

type IProps = {
  user?: IUserSchema;
  token?: string;
  error?: string;
  errorStatus?: string;
  redirectedFrom?: string;
  isServerRendered: boolean;
  authCheckStatus: boolean;
  setAuthCheckStatus: (status: boolean) => void;
  children: ReactNode;
};

export const AppWrapper: FC<IProps> = ({
  children,
  user,
  token: cookieToken,
  isServerRendered,
  authCheckStatus,
  setAuthCheckStatus,
}) => {
  const router = useRouter();
  const [isLoading, setIsLoading] = useState(false);
  const [_authState, setAuthState] = useAuthState();

  const [_s, setSiteConfig] = useSiteConfig();
  const { callApi } = usePromise(() => getGenericAppData());

  useEffect(() => {
    if (localStorage.getItem('initiated')) {
      localStorage.removeItem('initiated');
      return;
    }
    localStorage.setItem('initiated', 'true');
    callApi().then((response) => {
      response && setSiteConfig(response);
    });
  }, []);

  // useEffect(() => {
  //   if (!isServerRendered) {
  //     // Need to fetch token first
  //     throw new Error('Sorry every page should be server rendered!');
  //   }
  // }, []);

  useEffect(() => {
    if (cookieToken && user?.id) {
      setAuthState({
        token: cookieToken,
        user,
      });
    }
  }, []);

  const onRouteChangeStart = (_path: string) => {
    setIsLoading(true);
  };

  const onRouteChangeComplete = () => {
    setIsLoading(false);
  };

  // TODO:- verify user from cookie on first load only

  useEffect(() => {
    router.events.on('routeChangeStart', onRouteChangeStart);
    router.events.on('routeChangeError', onRouteChangeComplete);
    router.events.on('routeChangeComplete', onRouteChangeComplete);
    return () => {
      router.events.off('routeChangeComplete', onRouteChangeComplete);
      router.events.off('routeChangeError', onRouteChangeComplete);
      router.events.off('routeChangeStart', onRouteChangeStart);
    };
  }, []);

  useEffect(() => {
    cookieToken && setToken(cookieToken as string);
  }, [cookieToken]);

  useEffect(() => {
    if (user?.id) {
      !authCheckStatus && setAuthCheckStatus(true);
      cookieToken && setToken(cookieToken as string);
      return;
    }

    if (!user?.id) {
      // need to redirect to login page if required

      return;
    }
  }, [user?.id, isServerRendered]);

  return (
    <NotificationContext>
      <appRouteContext.Provider value={{ isLoading }}>
        {isLoading ? <LoadingState /> : null}
        {children}
      </appRouteContext.Provider>
    </NotificationContext>
  );
};
