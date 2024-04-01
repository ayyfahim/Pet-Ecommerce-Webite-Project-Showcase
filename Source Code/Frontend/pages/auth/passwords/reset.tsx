import { useState } from 'react';
import Link from 'next/link';
import AuthLayout, { AuthLayoutTitle } from 'layouts/Auth.layout';
import style from 'styles/auth/changePassword/style.module.scss';
import { NextPageWithLayout } from 'types/next.types';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';

const LoginPage: NextPageWithLayout = () => {
  const [password, setPassword] = useState('');
  const [confirmP, setConfirmP] = useState('');
  return (
    <>
      <AuthLayoutTitle>Create new password</AuthLayoutTitle>
      <div className={style.wrapper}>
        <form className="" action="#" method="POST">
          <label htmlFor="password" className={style.passwordLabel}>
            Password
            <span className="text-xs text-light_black">(Must be at least 8 characters)</span>
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
          <label htmlFor="password" className={style.passwordLabel}>
            Confirm Password
          </label>
          <div className="mt-1">
            <input
              id="password"
              name="password"
              type="password"
              autoComplete="password"
              placeholder="Enter Confirm Password"
              value={confirmP}
              onChange={(e) => {
                setConfirmP(e.target.value);
              }}
              required
              className={style.password}
              formNoValidate={confirmP === '' && password !== confirmP}
            />
          </div>
          <Link href="/">
            <a type="submit" className={style.loginButton}>
              Login
            </a>
          </Link>
        </form>
      </div>
    </>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(LoginPage);

LoginPage.Layout = AuthLayout;

export default LoginPage;
