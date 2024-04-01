import { atom, useRecoilState, useRecoilValue, selector } from 'recoil';

export const recommendProducts = atom<{}>({
  key: 'recommendProducts',
  default: {
    petName: '',
    petTypeId: '',
    breedId: '',
    petAge: '',
    concern: [],
  },
});

export default recommendProducts;

export const useRcmState = () => useRecoilState(recommendProducts);

export const useRcmValue = () => useRecoilValue(recommendProducts);
