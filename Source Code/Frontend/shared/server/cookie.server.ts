import { parse } from 'cookie';
import '@/bootstrap/app.config';
import { NextApiRequest, NextApiResponse } from 'next';
import { filterOutEmptyProperties } from 'shared/objectProperties';
import { ServerResponse } from 'http';
import { ICookies } from 'types/cookies.types';
import { isLocal } from '@/bootstrap/app.config';

type ICookieNames = keyof ICookies;

const cookieSetting = `Path=/; HttpOnly; SameSite=${!isLocal() ? 'none' : 'lax'}${!isLocal() ? '; Secure=true' : ''}`;

export function setCookie(res: NextApiResponse | ServerResponse, cookie: Partial<ICookies>): void {
  const value = filterOutEmptyProperties(cookie);
  const cookies = [] as string[];
  Object.keys(value).forEach((key) => {
    const cookieValue = value[key as ICookieNames];
    cookies.push(
      `${key}=${typeof cookieValue === 'object' ? JSON.stringify(cookieValue) : cookieValue}; ${cookieSetting}`
    );
  });

  res.setHeader('Set-Cookie', cookies);
}

export function clearCookie(res: NextApiResponse | ServerResponse, ...keys: ICookieNames[]): void {
  const cookies = [] as string[];
  keys.forEach((key) => {
    cookies.push(`${key}=; ${cookieSetting}; maxAge=1`);
  });

  res.setHeader('Set-Cookie', cookies);
}

export function getCookie(req: NextApiRequest, name: ICookieNames = 'auth'): string {
  return parse(req.headers.cookie || '')[name] || '';
}
