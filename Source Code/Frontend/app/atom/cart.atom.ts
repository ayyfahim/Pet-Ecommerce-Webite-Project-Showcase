import { atom, useRecoilState, useRecoilValue, selector } from 'recoil';
import { ICartSchema } from 'schemas/cart.schema';
import localStorageEffect from 'hooks/useAtomLocalStorage';

const cartAtom = atom<ICartSchema[]>({
  key: 'cart',
  default: [],
  effects: [localStorageEffect('cart')],
});

export default cartAtom;

export const useCartState = () => useRecoilState(cartAtom);

export const useCartValue = () => useRecoilValue(cartAtom);

export const getCartTotal = selector({
  key: 'cartTotal',
  get: ({ get }) => {
    const cart = get(cartAtom);

    return cart.reduce((total, item) => {
      return total + item.product.sale_price * item.quantity;
    }, 0);
  },
});
