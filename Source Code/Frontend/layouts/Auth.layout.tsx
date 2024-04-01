import React, { createContext, ReactNode, useContext, useEffect, useState } from 'react';
import Image from 'next/image';
import logo from '@/public/img/logo/logo-white.svg';
import style from 'styles/AuthLayout.module.scss';
import { ILayout } from 'types/next.types';

const authLayoutContext = createContext({
  title: '' as ReactNode | null,
  setTitle: (_title: ReactNode | null) => {},
});

authLayoutContext.displayName = 'AuthLayoutContext';
const AuthLayoutProvider = authLayoutContext.Provider;

const Component: ILayout = ({ children }) => {
  const { title } = useContext(authLayoutContext);
  return (
    <div className={style.wrapper}>
      <div className={style.image}>
        <Image alt="logo" src={logo} />
      </div>
      <div className={style.contentWrapper}>
        <div className={style.square}>
          {!!title && <p className={style.title}>{title}</p>}
          <main>{children}</main>
        </div>
      </div>
      <div className={style.bottomWrapper}>
        <p className={style.bottom}>Copyright © 2021-2029 VitalPawz.</p>
        <p className={style.bottom}>{'  '}All rights reserved.</p>
      </div>
    </div>
  );
};

const AuthLayout: ILayout = ({ children }) => {
  const [title, setTitle] = useState<ReactNode | null>(null);
  return (
    <AuthLayoutProvider value={{ title, setTitle }}>
      <Component>{children}</Component>
    </AuthLayoutProvider>
  );
};

export function AuthLayoutTitle({ children }: { children: ReactNode }) {
  const { setTitle } = useContext(authLayoutContext);

  useEffect(() => {
    setTitle(children || null);
  }, [children]);

  return null;
}

export default AuthLayout;
