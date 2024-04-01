/* eslint-disable no-process-env */
import '@/bootstrap/monkeyPatcher';
import { envConfig } from '@/env.config';

export type IEnv<T, P extends keyof IEnvConfig> = IEnvConfig[P] extends undefined
  ? T extends string
    ? string
    : T extends number
    ? number
    : T extends boolean
    ? boolean
    : IEnvConfig[P]
  : IEnvConfig[P];

export type IEnvConfig = Omit<typeof envConfig, 'nodeEnd'> & {
  nodeEnv: 'development' | 'staging' | 'production';
};

export function getEnv<P extends keyof IEnvConfig, T extends IEnvConfig[P]>(key: P, defaultValue?: T): IEnv<T, P> {
  const value = (envConfig[key] || defaultValue) as IEnv<T, P>;

  if (isNaN(Number(value))) {
    return value;
  }

  return Number(value) as IEnv<T, P>;
}

export function isLocal() {
  return ['local', 'development'].includes(getEnv('nodeEnv'));
}
