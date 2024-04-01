import { atom, selector, useRecoilState } from 'recoil';
import { ICategorySchema } from 'schemas/category.schema';
import localStorageEffect from '../hooks/useAtomLocalStorage';

export type ISiteConfig = {
  googleAnalytics: string;
  address: string;
  title: string;
  metaTitle: string;
  facebook: string;
  metaKeywords: string;
  contactNumbers: string;
  facebookPixel: string;
  instagram: string;
  emails: string;
  twitter: string;
  metaDescription: string;
  logo: string;
  googleTagManager: string;
  favicon: string;
  linkedin: string;
};

const data = {} as unknown as ISiteConfig;

const fakeObj = (Object.keys(data) as (keyof ISiteConfig)[]).map((key) => ({ key, value: data[key] }));

export type ISiteConfigArray = typeof fakeObj;

export type IPage = {
  slug: string;
  title: string;
};

export type ISiteConfigState = {
  categories: ICategorySchema;
  // footer pages
  pages: { category: string; pages: IPage[] }[];
  order: {
    shipping_methods: { id: number; color: string; title: string }[];
    payment_methods: { id: number; color: string; title: string }[];
  };
  config: ISiteConfigArray;
};

const siteConfig = atom<ISiteConfigState | null>({
  key: 'siteConfig',
  default: null,
  effects: [localStorageEffect('siteConfig')],
});

export default siteConfig;

export const useSiteConfig = () => useRecoilState(siteConfig);

export const getSiteConfig = selector({
  key: 'getSiteConfig',
  get: ({ get }) => {
    const data = get(siteConfig);
    return ((data?.config || []) as unknown as { key: string; value: unknown }[]).reduce((config, data) => {
      // @ts-ignore
      config[data.key] = data.value;
      return config;
    }, {} as unknown as ISiteConfig);
  },
});

export const getSitePages = selector({
  key: 'getSitePages',
  get: ({ get }) => {
    const data = get(siteConfig);
    return data?.pages || [];
  },
});
