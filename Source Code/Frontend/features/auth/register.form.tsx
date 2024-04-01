import { AuthLayoutTitle } from 'layouts/Auth.layout';
import style from 'styles/auth/login/style.module.scss';
import { object, ref, SchemaOf, string } from 'yup';
import useReactForm from 'hooks/useReactForm';

import { FormProvider } from 'react-hook-form';
import RHookFormControl from 'components/forms/RHookFormControl';
import { IApiResponse } from 'types/request.types';
import { IUserSchema } from 'schemas/account.schema';
import useAuthService from 'features/auth/hooks/useAuthService';

type ILoginFormProps = {
  email: string;
};

type ILoginRequest = {
  email: string;
  password: string;
  full_name: string;
  password_confirmation: string;
};

const formSchema: SchemaOf<ILoginRequest> = object().shape({
  email: string().label('Email').required().email(),
  password: string().label('Password').required().min(6),
  full_name: string().label('Full name').required().min(5),
  password_confirmation: string()
    .label('Password confirmation')
    .required()
    .oneOf([ref('password'), null], 'Passwords do not match.'),
});

export default function RegisterForm({ email }: ILoginFormProps) {
  const setAuth = useAuthService();
  const { methods, submitHandler, isLoading } = useReactForm<
    IApiResponse<{ user: IUserSchema; token: string }>,
    ILoginRequest
  >(
    'post',
    `/auth/register`,
    formSchema,
    { email },
    {
      onSuccess: ({ data: { user, token } }) => {
        setAuth(token, user);
      },
    }
  );

  return (
    <>
      <AuthLayoutTitle>Please register!</AuthLayoutTitle>
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
              name={'full_name'}
              autoComplete={'name'}
              inputClassName={style.email}
              className={'mt-2'}
              label={'Full Name'}
              placeholder={'Enter Your Name'}
            />
            <RHookFormControl
              name={'password'}
              type={'password'}
              autoComplete={'password'}
              inputClassName={style.email}
              className={'mt-2'}
              label={'Password'}
              placeholder={'Enter Password'}
            />

            <RHookFormControl
              name={'password_confirmation'}
              type={'password'}
              autoComplete={'password'}
              inputClassName={style.email}
              className={'mt-2'}
              label={'Confirm Password'}
              placeholder={'Re-Enter Password'}
            />
            <button disabled={isLoading} type="submit" className={style.emailButton}>
              Register
            </button>
          </div>
        </form>
      </FormProvider>
    </>
  );
}
