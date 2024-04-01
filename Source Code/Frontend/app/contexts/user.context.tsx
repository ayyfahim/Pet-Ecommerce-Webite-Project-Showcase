import React, { useState, createContext, ReactNode, FC } from 'react';

type ICategory = {
  selected: boolean;
  title: string;
  count: number;
};

type IBrand = ICategory;

type ILifeStage = ICategory;

type IUserContext = {
  email: string;
  setEmail: (email: string) => void;
  url: string;
  setUrl: (url: string) => void;
  categories: ICategory[];
  setCategories: (categories: ICategory[]) => void;
  brand: IBrand[];
  setBrand: (brands: IBrand[]) => void;
  lifestage: ILifeStage[];
  setLifestage: (stages: ILifeStage[]) => void;
};
export const UserContext = createContext<IUserContext>({
  email: 'ryan.rkina@gmail.com',
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  setEmail: () => {},
  url: '/img/HomePage/rectangle.png',
  setUrl: () => {},
  categories: [],
  setCategories: () => {},
  brand: [],
  setBrand: () => {},
  lifestage: [],
  setLifestage: () => {},
});

type IUserProviderProps = {
  children: ReactNode;
};
const UserProvider: FC<IUserProviderProps> = ({ children }) => {
  const [email, setEmail] = useState('ryan.rkina@gmail.com');
  const [url, setUrl] = useState('/img/HomePage/rectangle.png');
  const [categories, setCategories] = useState([
    { selected: false, title: 'Dog Allergy Medicine & Itch Relief', count: 8 },
    { selected: false, title: 'Dog Calming Aids', count: 12 },
    { selected: false, title: 'Dog Dewormers & Worm Medicine', count: 10 },
    { selected: false, title: 'Dog Ear & Eye Care', count: 14 },
    { selected: false, title: 'Dog First Aid & Paw Care', count: 12 },
    { selected: false, title: 'Dog Health & Wellness By Lifestage', count: 37 },
    { selected: false, title: 'Dog Pill Capsules', count: 10 },
    { selected: false, title: 'Dog Recovery Cones', count: 6 },
    { selected: false, title: 'Dog Vitamins & Supplements', count: 4 },
  ]);
  const [brand, setBrand] = useState([
    { selected: false, title: '5Strands', count: 1 },
    { selected: false, title: 'Adaptil', count: 5 },
    { selected: false, title: 'Adenquan Canine', count: 1 },
    { selected: false, title: 'All Four Paws', count: 2 },
    { selected: false, title: 'Amitriptyline', count: 3 },
    { selected: false, title: "Angels' Eyes", count: 3 },
  ]);
  const [lifestage, setLifestage] = useState([
    { selected: false, title: '5Strands', count: 1 },
    { selected: false, title: 'Adaptil', count: 5 },
    { selected: false, title: 'Adenquan Canine', count: 1 },
    { selected: false, title: 'All Four Paws', count: 2 },
    { selected: false, title: 'Amitriptyline', count: 3 },
    { selected: false, title: "Angels' Eyes", count: 3 },
  ]);
  return (
    <UserContext.Provider
      value={{
        email,
        setEmail,
        url,
        setUrl,
        categories,
        setCategories,
        brand,
        setBrand,
        lifestage,
        setLifestage,
      }}
    >
      {children}
    </UserContext.Provider>
  );
};

export default UserProvider;
