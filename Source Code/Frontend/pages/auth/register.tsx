import React, { useContext, useState } from 'react';
import Link from 'next/link';
import AuthLayout, { AuthLayoutTitle } from 'layouts/Auth.layout';
import { UserContext } from 'contexts/user.context';
import style from 'styles/auth/createAccount/style.module.scss';
import { NextPageWithLayout } from 'types/next.types';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';

const RegisterPage: NextPageWithLayout = () => {
  const userContext = useContext(UserContext);
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [inputType, setInputType] = useState(true);
  return (
    <>
      <AuthLayoutTitle>Create an Account</AuthLayoutTitle>
      <div className={style.wrapper}>
        <form className="" action="@/pages/auth/index#" method="POST">
          {/* <p className={style.email}>{userContext.email}</p> */}
          <label htmlFor="username" className={style.passwordLabel}>
            Full Name
          </label>
          <div className="mt-1">
            <input
              id="text"
              name="username"
              type="username"
              autoComplete="username"
              placeholder="Enter Username"
              value={username}
              onChange={(e) => {
                setUsername(e.target.value);
              }}
              required
              className={style.password}
              formNoValidate={username === ''}
            />
          </div>
          <label htmlFor="password" className={style.passwordLabel}>
            Create Password <span className="text-xs text-light_black">(Must be at least 8 characters)</span>
          </label>
          <div className="mt-1">
            <input
              id="password"
              name="password"
              type={inputType === true ? 'password' : 'text'}
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
          <div className={style.showBtnWrapper}>
            <button
              type="button"
              className={style.showBtn}
              onClick={() => {
                setInputType((prev) => !prev);
              }}
            >
              {inputType === true ? 'show' : 'hide'}
            </button>
          </div>
          <div className={style.bottom_text}>
            <input type="checkbox" className={style.checkbox} />
            <p className="ml-3 text-sm text-medium_black">
              I accept the{' '}
              <a className={style.a_text} href="@/pages/auth/index#">
                Terms of use
              </a>{' '}
              &
              <a className={style.a_text} href="@/pages/auth/index#">
                Privacy policy
              </a>
              .
            </p>
          </div>
          <Link href="/pages">
            <a type="submit" className={style.loginButton}>
              Login
            </a>
          </Link>
        </form>
      </div>
    </>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(RegisterPage);

RegisterPage.Layout = AuthLayout;

export default RegisterPage;
