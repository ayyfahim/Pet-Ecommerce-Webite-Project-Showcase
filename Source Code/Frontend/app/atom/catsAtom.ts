import { atom } from 'recoil';
import { IMainCategory } from '@/app/types/CategoryInterface';
import localStorageEffect from '../hooks/useAtomLocalStorage';

export const categoriesAtom = atom<IMainCategory[]>({
  key: 'categories',
  default: [],
  effects: [localStorageEffect('categories')],
});
