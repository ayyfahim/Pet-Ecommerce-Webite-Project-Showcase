import { atom, useRecoilState, useRecoilValue, selector } from 'recoil';
import localStorageEffect from 'hooks/useAtomLocalStorage';

const wishlistAtom = atom<[]>({
  key: 'wishlist',
  default: [],
  effects: [localStorageEffect('wishlist')],
});

export default wishlistAtom;

export const useWishListState = () => useRecoilState(wishlistAtom);

export const useWishListValue = () => useRecoilValue(wishlistAtom);
