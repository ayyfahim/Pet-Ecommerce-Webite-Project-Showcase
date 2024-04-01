import { IUserSchema } from 'schemas/account.schema';
import { setTokenInCookie } from 'requests/token.request';
import { setToken } from 'requests/api';
import { useCallback } from 'react';
import { useAuthState } from 'app/atom/auth.atom';
import { useRouter } from 'next/router';

export default function useAuthService() {
  const [_authState, setAuthState] = useAuthState();
  const router = useRouter();

  const fn = useCallback((token: string, user: IUserSchema, redirect = true) => {
    setTokenInCookie(token, user).then(() => {
      setToken(token);
      setAuthState({
        token: token,
        user: user,
      });
      if (redirect) {
        router.push('/').then();
      }
    });
  }, []);

  return fn;
}
