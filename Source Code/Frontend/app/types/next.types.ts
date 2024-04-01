import type { ReactElement } from 'react';
import { NextPage } from 'next';
import { AppProps } from 'next/app';
import { IMiddleware } from 'types/middleware.types';
import {IAuthCookie} from "types/cookies.types";

export type ILayoutProps = {
  children: ReactElement;
  error?: string;
  errorStatus?: number;
};

export type NextPageWithLayout<P = object> = NextPage<P & Omit<ILayoutProps, 'children'>> & {
  Layout?: ILayout;
  middleWares?: IMiddleware[];
};

type IAppProps = AppProps<{
  user?: IAuthCookie['user'];
  token?: string;
  Layout?: ILayout;
}>;

export type AppPropsWithLayout = IAppProps & {
  Component: NextPage & {
    Layout?: ILayout;
    middleWares?: IMiddleware[];
  };
  appUrl: string;
  isServerRendered?: boolean;
  redirectUrl?: string;
};

export type ILayout = {
  (props: ILayoutProps): ReactElement;
  middleWares?: IMiddleware[];
};
