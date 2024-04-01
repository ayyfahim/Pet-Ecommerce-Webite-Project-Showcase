import { postRequest, removeToken, setToken } from 'requests/api';
import { IAuthCookie } from 'types/cookies.types';
import { IUserSchema } from 'schemas/account.schema';
import getObjectProperties from 'shared/objectProperties';

export function getUserForCookie(user: IUserSchema): IAuthCookie['user'] | null {
  if (!user?.id) {
    return null;
  }
  return getObjectProperties(
    user,
    'id',
    'first_name',
    'last_name',
    'role',
    'email',
    'full_name',
    'mobile',
    'total_reward_points',
    'total_reward_points_exchange'
  );
}

export async function setTokenInCookie(token: string, user: IUserSchema): Promise<boolean> {
  // if (!token || !user?.id) {
  //   return false;
  // }
  return postRequest(
    `/cookie-api`,
    {
      auth: {
        token,
        user: getUserForCookie(user),
      } as IAuthCookie,
    },
    {
      baseURL: '/api',
    }
  )
    .then(() => {
      if (token && token.length > 10) {
        setToken(token);
      } else {
        removeToken();
      }
      return true;
    })
    .catch(() => {
      // need to display unable to persist authentication token
      return false;
    });
}
