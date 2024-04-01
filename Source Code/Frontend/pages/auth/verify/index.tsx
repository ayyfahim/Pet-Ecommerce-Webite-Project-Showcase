import React, { useState } from 'react';
import Link from 'next/link';
import style from 'styles/auth/verify/style.module.scss';
import AuthLayout, { AuthLayoutTitle } from 'layouts/Auth.layout';
import { NextPageWithLayout } from 'types/next.types';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';

const VerifyPage: NextPageWithLayout = () => {
  const [password, setPassword] = useState('');
  return (
    <>
      <AuthLayoutTitle>Welcome Ryan!</AuthLayoutTitle>
      <div className={style.wrapper}>
        <form className="" action="#" method="POST">
          <p className={style.email}>
            {`We want to make sure it's really you. In order to verify identity,
          enter the verfication code that was sent to 
          r****@gmail.com`}
          </p>
          <label htmlFor="password" className={style.passwordLabel}>
            Enter verification code
          </label>
          <div className="mt-1">
            <input
              id="password"
              name="password"
              type="password"
              autoComplete="password"
              placeholder="Enter verification code"
              value={password}
              onChange={(e) => {
                setPassword(e.target.value);
              }}
              required
              className={style.password}
              formNoValidate={password === ''}
            />
          </div>
          <Link href="/">
            <a type="submit" className={style.loginButton}>
              Confirm
            </a>
          </Link>
        </form>
        <div className={style.bottomTextWrapper}>
          <p className={style.text}>{`Didn't recieve code?`}</p>
          <button type="submit" className={style.button}>
            Request again
          </button>
        </div>
      </div>
    </>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(VerifyPage);

VerifyPage.Layout = AuthLayout;

export default VerifyPage;
