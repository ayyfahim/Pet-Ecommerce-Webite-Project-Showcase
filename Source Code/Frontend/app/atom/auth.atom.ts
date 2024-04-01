import { atom, useRecoilState, useRecoilValue } from 'recoil';
import { IUserSchema } from 'schemas/account.schema';
import localStorageEffect from '../hooks/useAtomLocalStorage';

type IAuthState = {
  token: string;
  user: IUserSchema | {};
};
const authAtom = atom<IAuthState>({
  key: 'auth',
  default: {
    token: '',
    user: {},
  },
  effects: [localStorageEffect('auth')],
});

export default authAtom;

export const useAuthState = () => useRecoilState(authAtom);

export const useAuthValue = () => useRecoilValue(authAtom);
