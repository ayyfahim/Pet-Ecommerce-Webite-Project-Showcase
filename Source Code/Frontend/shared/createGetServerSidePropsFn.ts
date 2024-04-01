import { GetServerSideProps } from 'next';
import { getAxiosErrorMessage, removeToken, setToken } from 'requests/api';
import { NextPageWithLayout } from 'types/next.types';
import { IMiddleware } from 'types/middleware.types';
import { ParsedUrlQuery } from 'querystring';
import { IAxiosError } from 'types/request.types';
import { IAuthCookie } from 'types/cookies.types';
import { clearCookie } from 'shared/server/cookie.server';


export default function createGetServerSidePropsFn<T = unknown>(
  Component: NextPageWithLayout<T>,
  getServerSideProps?: GetServerSideProps
): GetServerSideProps {
  return async (ctx) => {
    const { req, res: res, params, query } = ctx;
    const cookies = req?.cookies || {};
    const authCookie = JSON.parse(cookies.auth || 'null') as IAuthCookie | null;
    const token = authCookie?.token || '';
    const user = authCookie?.user;

    token && setToken(token);

    if (!user?.id || !token) {
      removeToken();
      clearCookie(res, 'auth');
    }

    const _PageLayout = Component.Layout;
    const middleWares = [...(_PageLayout?.middleWares || []), ...(Component.middleWares || [])];
    const response = executeMiddlewareSequentially(middleWares, user as IAuthCookie['user'], {
      ...query,
      ...params,
    });
    if (response && middleWares.length) {
      return {
        redirect: response,
      };
    }

    let error = '';
    let errorStatus = '';
    const resp = getServerSideProps
      ? await getServerSideProps(ctx).catch((e: IAxiosError) => {
          errorStatus = '' + (e.code || e.response?.status || '');
          error = getAxiosErrorMessage(e);
          return { props: {} };
        })
      : { props: {} };

    return {
      ...resp,
      props: {
        // @ts-ignore
        ...(resp?.props || {}),
        error,
        errorStatus,
        user: user || ({} as IAuthCookie['user']),
        token,
        redirectedFrom: cookies.redirectPath || null,
        isServerRendered: true,
      },
    };
  };
}

function executeMiddlewareSequentially(middleWares: IMiddleware[], user: IAuthCookie['user'], query: ParsedUrlQuery) {
  for (const middleware of middleWares) {
    try {
      const response = middleware(user, query);
      if (response) {
        return {
          destination: response,
          permanent: false,
        };
      }
    } catch (e) {
      // eslint-disable-next-line no-console
      console.error(e);
    }
  }

  return '';
}
