import { useState } from 'react';
import AuthLayout from 'layouts/Auth.layout';
import { NextPageWithLayout } from 'types/next.types';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import LoginForm from 'features/auth/login.form';
import LoginPasswordForm from 'features/auth/login.password.form';
import RegisterForm from 'features/auth/register.form';

export type IAuthFormData = {
  email: string;
  exists: boolean;
};

const Login: NextPageWithLayout = () => {
  const [loginFormState, setLoginFormState] = useState<IAuthFormData>({
    exists: false,
    email: '',
  });

  return (
    <>
      {!loginFormState.email && <LoginForm setLoginFormState={setLoginFormState} />}
      {loginFormState.email && (
        <>
          {loginFormState.exists ? (
            <LoginPasswordForm email={loginFormState.email} />
          ) : (
            <RegisterForm email={loginFormState.email} />
          )}
        </>
      )}
    </>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Login);

Login.Layout = AuthLayout;
export default Login;

// TODO:- if user.id is true then, we need password field. If user.email is set but user.id is not set, then show register form.
