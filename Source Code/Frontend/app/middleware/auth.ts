import { IMiddleware } from 'types/middleware.types';

export const withAuth: IMiddleware = (user, query) => {
  if (!user || !user?.id) {
    return '/auth/login';
  }
  return '';
};
