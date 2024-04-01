import { ParsedUrlQuery } from 'querystring';
import { IAuthCookie } from 'types/cookies.types';

export type IMiddleware = (user?: IAuthCookie['user'], query?: ParsedUrlQuery) => string;
