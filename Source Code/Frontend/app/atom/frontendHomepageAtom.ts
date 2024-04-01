import { atom } from 'recoil';
import localStorageEffect from '../hooks/useAtomLocalStorage';

export const frontendHomepageAtom = atom({
  key: 'frontendHomepageData',
  default: [],
  effects: [localStorageEffect('frontendHomepageData')],
});
