import { AuthLayoutTitle } from 'layouts/Auth.layout';
import style from 'styles/auth/login/style.module.scss';
import { object, SchemaOf, string } from 'yup';
import useReactForm from 'hooks/useReactForm';

import { FormProvider } from 'react-hook-form';
import RHookFormControl from 'components/forms/RHookFormControl';
import useAuthService from 'features/auth/hooks/useAuthService';
import { IApiResponse } from 'types/request.types';
import { IUserSchema } from 'schemas/account.schema';

type ILoginFormProps = {
  email: string;
};

type ILoginPasswordRequest = {
  email: string;
  password: string;
};

const formSchema: SchemaOf<ILoginPasswordRequest> = object().shape({
  email: string().label('Email').required().email(),
  password: string().label('Password').required().min(6),
});

export default function LoginPasswordForm({ email }: ILoginFormProps) {
  const setAuth = useAuthService();
  const { methods, submitHandler, isLoading } = useReactForm<
    IApiResponse<{ user: IUserSchema; token: string }>,
    ILoginPasswordRequest
  >(
    'post',
    `/auth/login`,
    formSchema,
    {
      email,
    },
    {
      onSuccess: ({ data: { user, token } }) => {
        setAuth(token, user);
      },
    }
  );

  return (
    <>
      <AuthLayoutTitle>Welcome back!</AuthLayoutTitle>
      <FormProvider {...methods}>
        <form onSubmit={submitHandler}>
          <div className={style.wrapper}>
            <RHookFormControl
              hidden={true}
              name={'email'}
              type={'email'}
              autoComplete={'email'}
              inputClassName={style.email}
              label={'Email Address'}
              placeholder={'Enter Email Address'}
            />
            <RHookFormControl
              name={'password'}
              type={'password'}
              autoComplete={'password'}
              inputClassName={style.password}
              label={'Password'}
              placeholder={'Enter Password'}
            />
            <button disabled={isLoading} type="submit" className={style.emailButton}>
              Login
            </button>
          </div>
        </form>
      </FormProvider>
    </>
  );
}
