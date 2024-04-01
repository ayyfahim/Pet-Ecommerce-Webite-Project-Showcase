import React, { createContext, useContext, useEffect, useState } from 'react';
import Image from 'next/image';
import Link from 'next/link';
import logo from 'public/img/header/logo-horizontal.svg';
import fbIcon from 'public/img/email/fbIcon.webp';
import twtIcon from 'public/img/email/twtIcon.webp';
import igIcon from 'public/img/email/igIcon.webp';
import style from 'styles/EmailLayout.module.scss';
import { ILayout } from 'types/next.types';
import classNames from 'classnames';

const emailLayoutContext = createContext({
  useHeader: false as boolean | null,
  setUseHeader: (_useHeader: boolean) => {},
  useFooter: false as boolean | null,
  setUseFooter: (_useFooter: boolean) => {},
});

emailLayoutContext.displayName = 'EmailLayoutContext';
const EmailLayoutProvider = emailLayoutContext.Provider;

const Component: ILayout = ({ children }) => {
  const { useHeader, useFooter } = useContext(emailLayoutContext);

  const wrapperClass = classNames(style.wrapper, {
    ['justify-between']: useFooter == true,
    ['justify-start']: useFooter == false,
  });

  return (
    <div className={wrapperClass}>
      {useHeader && <Header />}

      <div className={style.contentWrapper}>
        <div className={style.square}>
          <main>{children}</main>
        </div>
      </div>

      {useFooter && <Footer />}
    </div>
  );
};

const EmailLayout: ILayout = ({ children }) => {
  const [useHeader, setUseHeader] = useState<boolean>(true);
  const [useFooter, setUseFooter] = useState<boolean>(true);
  return (
    <EmailLayoutProvider value={{ useHeader, setUseHeader, useFooter, setUseFooter }}>
      <Component>{children}</Component>
    </EmailLayoutProvider>
  );
};

export function useHeader(value = true) {
  const { setUseHeader } = useContext(emailLayoutContext);

  useEffect(() => {
    setUseHeader(value);
  }, [value]);
  return null;
}

export function useFooter(value = true) {
  const { setUseFooter } = useContext(emailLayoutContext);

  useEffect(() => {
    setUseFooter(value);
  }, [value]);
  return null;
}

export const Header = () => {
  return (
    <div className={style.image}>
      <Image alt="logo" src={logo} />
    </div>
  );
};

export const Footer = ({ ...props }) => {
  const { className } = props;
  return (
    <div className={classNames(style.bottomWrapper, className)}>
      <div className={style.bottomIcons}>
        <div className={style.icon}>
          <a href={'#'}>
            <Image src={fbIcon} />
          </a>
        </div>
        <div className={style.icon}>
          <a href={'#'}>
            <Image src={twtIcon} />
          </a>
        </div>
        <div className={style.icon}>
          <a href={'#'}>
            <Image src={igIcon} />
          </a>
        </div>
      </div>
      <p className={style.bottomText}>
        This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to
        this message.
      </p>
    </div>
  );
};

export default EmailLayout;
