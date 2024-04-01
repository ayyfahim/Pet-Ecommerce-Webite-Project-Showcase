import { atom, selector } from 'recoil';
import { IData, ISmartSearchBrands } from '../types/smartSearchInterface';
import { smartSearchStrAtom } from './SmartSearchStrAtom';
import localStorageEffect from '../hooks/useAtomLocalStorage';

export const smartSearchProductsAtom = atom<IData[]>({
  key: 'smartSearchProducts',
  default: [],
  effects: [localStorageEffect('smartSearchProducts')],
});

export const smartSearchBrandsAtom = atom({
  key: 'smartSearchBrands',
  default: [],
  effects: [localStorageEffect('smartSearchBrands')],
});

export const smartSearchAtomState = atom({
  key: 'smartSearchActive',
  default: false,
});

export const smartSearchAtomProductSelector = selector({
  key: 'smartSearchProductSelector',
  get: ({ get }) => {
    const smartSearchItems = get(smartSearchProductsAtom);
    const smartSearchStr = get(smartSearchStrAtom);
    const tips: string[] = [];
    const filteredProducts: IData[] = [];
    if (smartSearchStr === '') return { filteredProducts: [], tips: [] };
    smartSearchItems.map((item) => {
      const res = Object.entries(item).some(([key, value]) => {
        if (typeof value !== 'string') return false;
        if (value.toLowerCase().includes(smartSearchStr.toLowerCase()) && (key === 'title' || key === 'excerpt')) {
          tips.push(value);
          return true;
        }
        return false;
      });
      res ? filteredProducts.push(item) : null;
    });
    return { filteredProducts: filteredProducts.slice(0, 6), tips: tips.slice(0, 5) };
  },
});

export const smartSearchBrandSelector = selector({
  key: 'smartSearchBrandsSelector',
  get: ({ get }) => {
    const brands: any[] = get(smartSearchBrandsAtom);
    const smartSearchStr = get(smartSearchStrAtom);
    if (smartSearchStr === '') return { filteredBrands: [] };
    const filteredBrands = brands.reduce((acc: string[], currItem: ISmartSearchBrands) => {
      let tipsArr: string[] = [];
      Object.entries(currItem).some(([key, value]) => {
        if (typeof value !== 'string') return false;
        if (key !== 'name') return false;
        if (value.toLowerCase().includes(smartSearchStr.toLowerCase())) {
          tipsArr.push(value);
          return true;
        }
        return false;
      });
      return [...acc, ...tipsArr];
    }, []);
    return { filteredBrands: filteredBrands.slice(0, 5) };
  },
});
