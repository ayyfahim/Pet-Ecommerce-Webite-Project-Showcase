import { AuthLayoutTitle } from 'layouts/Auth.layout';
import style from 'styles/auth/login/style.module.scss';
import GoogleAuthBtn from 'features/auth/google.auth.btn';
import FacebookAuthBtn from 'features/auth/facebook.auth.btn';
import { useEffect, useState } from 'react';
import { ISocialAuthUser } from 'types/auth.types';
import { object, SchemaOf, string } from 'yup';
import useReactForm from 'hooks/useReactForm';
import { IUserSchema } from 'schemas/account.schema';

import { FormProvider } from 'react-hook-form';
import usePromise from 'hooks/usePromise';
import { postRequest, getRequest } from 'requests/api';
import { IApiResponse } from 'types/request.types';
import RHookFormControl from 'components/forms/RHookFormControl';
import { IAuthFormData } from '@/pages/auth/login';
import useAuthService from 'features/auth/hooks/useAuthService';
import { useRouter } from 'next/router';

type ILoginFormProps = {
  setLoginFormState: (data: IAuthFormData) => void;
};

type ILoginRequest = {
  email: string;
};

const formSchema: SchemaOf<ILoginRequest> = object().shape({
  email: string().label('Email').required().email(),
});

export default function LoginForm({ setLoginFormState }: ILoginFormProps) {
  const setAuth = useAuthService();
  const [_mail, _setMail] = useState('');
  const router = useRouter();

  const { methods, submitHandler, isLoading } = useReactForm<{ user_exist: boolean }, ILoginRequest>(
    'post',
    `/auth/check`,
    formSchema,
    undefined,
    {
      onSuccess: ({ user_exist }) => {
        setLoginFormState({ email: methods.getValues('email'), exists: user_exist });
      },
    }
  );

  const { callApi, isPending } = usePromise((provider: string) =>
    getRequest<IApiResponse<{ token: string; user: IUserSchema }>>(
      `/auth/social-login/${provider}/callback`,
      // @ts-ignore
      router.query
    )
  );

  const onSocialBtnClick = async (provider: string) => {
    // @ts-ignore
    const getRedirectUrl = await getRequest(`/auth/social-login/${provider}`, router.query);
    if (getRedirectUrl) {
      router.push(getRedirectUrl);
    }
    console.log('getRedirectUrl', getRedirectUrl);
  };

  useEffect(() => {
    async function socialLogin(provider: string) {
      const response = await callApi(provider).catch(() => null);
      if (response) {
        const data = response.data;
        setAuth(data.token, data.user);
      }
    }

    if (Object.keys(router.query).length > 0) {
      // @ts-ignore
      if (router.query?.code?.match('4/[0-9A-Za-z-_]+')) {
        socialLogin('google');
      } else {
        socialLogin('facebook');
      }
      //   // @ts-ignore
      //   const getRedirectUrl = async () => await getRequest(`/auth/social-login/google/callback`, router.query);
      //   console.log('getRedirectUrl', getRedirectUrl());
    }
    // console.log('router.query', router.query);
  }, []);

  return (
    <>
      <AuthLayoutTitle>Login or Create an Account</AuthLayoutTitle>
      <FormProvider {...methods}>
        <form onSubmit={submitHandler}>
          <div className={style.wrapper}>
            <RHookFormControl
              name={'email'}
              type={'email'}
              autoComplete={'email'}
              inputClassName={style.email}
              label={'Email Address'}
              placeholder={'Enter Email Address'}
            />
            <button type="submit" className={style.emailButton}>
              Continue with Email
            </button>
            <div className={style.orWrapper}>
              <p className={style.or}>OR</p>
            </div>
            <GoogleAuthBtn onClick={() => onSocialBtnClick('google')} disabled={isPending || isLoading} />
            <FacebookAuthBtn onClick={() => onSocialBtnClick('facebook')} disabled={isPending || isLoading} />
            <div className={style.bottom_text}>
              <p className="text-xs ">
                By continuing, you agree to{' '}
                <a className={style.a_text} href="@/pages/auth/login#">
                  Terms of use
                </a>{' '}
                &
                <a className={style.a_text} href="@/pages/auth/login#">
                  Privacy policy
                </a>
                .
              </p>
            </div>
          </div>
        </form>
      </FormProvider>
    </>
  );
}
