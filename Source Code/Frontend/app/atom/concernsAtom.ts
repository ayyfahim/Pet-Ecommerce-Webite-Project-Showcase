import { atom } from 'recoil';
import { IMainCategory } from '@/app/types/CategoryInterface';
import localStorageEffect from '../hooks/useAtomLocalStorage';

export const concernsAtom = atom<any[]>({
  key: 'concerns',
  default: [],
  effects: [localStorageEffect('concerns')],
});
