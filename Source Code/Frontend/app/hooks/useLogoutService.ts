import { logoutRequest } from 'requests/logout.request';
import { useRouter } from 'next/router';
import { useAuthContext } from 'contexts/auth.context';
import { removeToken } from 'requests/api';
import { useAuthState } from 'app/atom/auth.atom';

export default function useLogoutService() {
  // const [_authState, setAuthState] = useAuthState();
  const router = useRouter();
  const { setUser } = useAuthContext();
  return async () => {
    return await logoutRequest().then(() => {
      setUser(undefined);
      // setAuthState({
      //   token: '',
      //   user: {},
      // });
      removeToken();
      router.push('/');
    });
  };
}
