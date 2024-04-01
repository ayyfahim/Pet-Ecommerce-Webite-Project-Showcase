import React, { useContext, useState } from 'react';
import Link from 'next/link';

import style from 'styles/auth/emailLogin/style.module.scss';
import { UserContext } from 'contexts/user.context';
import Modal from '@/components/Modal';
import { NextPageWithLayout } from 'types/next.types';
import AuthLayout, { AuthLayoutTitle } from 'layouts/Auth.layout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';

const LoginPage: NextPageWithLayout = () => {
  const userContext = useContext(UserContext);
  const [password, setPassword] = useState('');
  const [open, setOpen] = useState(false);
  return (
    <>
      <AuthLayoutTitle>Welcome back Ryan!</AuthLayoutTitle>
      <div className={style.wrapper}>
        <form className="" action="pages/auth/index#" method="POST">
          {/* <p className={style.email}>{userContext.email}</p> */}
          <label htmlFor="password" className={style.passwordLabel}>
            Password
          </label>
          <div className="mt-1">
            <input
              id="password"
              name="password"
              type="password"
              autoComplete="password"
              placeholder="Enter Password"
              value={password}
              onChange={(e) => {
                setPassword(e.target.value);
              }}
              required
              className={style.password}
              formNoValidate={password === ''}
            />
          </div>
          <div className={style.forgetWrapper}>
            <button
              type="button"
              className={style.forget}
              onClick={() => {
                setOpen(true);
              }}
            >
              Forgot Password?
            </button>
          </div>
          <Link href="/pages">
            <a type="submit" className={style.loginButton}>
              Login
            </a>
          </Link>
        </form>
        <Modal open={open} setOpen={setOpen} />
      </div>
    </>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(LoginPage);

LoginPage.Layout = AuthLayout;
export default LoginPage;
