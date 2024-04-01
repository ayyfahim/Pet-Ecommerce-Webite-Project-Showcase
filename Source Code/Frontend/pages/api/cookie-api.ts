import { NextApiRequest, NextApiResponse } from 'next';
import { clearCookie, getCookie, setCookie } from 'shared/server/cookie.server';
import { IAuthCookie } from 'types/cookies.types';

export type INextApiError = {
  message: string;
  fields?: Record<string, string>;
};

function isAuthCookieValid(authCookie: IAuthCookie) {
  return !!(authCookie?.token && authCookie.user?.id);
}

export default function handler(
  req: NextApiRequest,
  res: NextApiResponse<{ data: IAuthCookie } | INextApiError>
) {
  if (req.method === 'POST') {
    const authCookie = req.body.auth as IAuthCookie;
    const hasAuthCookie = isAuthCookieValid(authCookie);
    hasAuthCookie
      ? setCookie(res, {
          auth: authCookie,
        })
      : clearCookie(res, 'auth');
    res.status(200).json({ message: hasAuthCookie ? 'Token set!' : 'Token removed!' });
    return;
  }

  const authCookie = JSON.parse(getCookie(req, 'auth') || 'null');

  if (isAuthCookieValid(authCookie)) {
    res.status(200).json({
      data: authCookie,
    });

    return;
  }

  res.status(400).json({
    message: 'Auth cookie is either invalid or does not exist.',
  });
}
