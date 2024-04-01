import React, { FC } from 'react';
import { IMainCategory } from '@/app/types/CategoryInterface';

interface IMegaDropDownCategoryItemProps {
  category: IMainCategory;
}

const MegaDropDownCategoryItem: FC<IMegaDropDownCategoryItemProps> = ({ category }) => {
  return (
    <ul className="mx-4">
      <li className="pb-4 font-bold font-15">{category.name}</li>
      {category.children.data?.map((item) => (
        <li key={item.id} className="font-15 py-1.5 ">
          <a href={`/category/${item?.slug}`}>{item.name}</a>
        </li>
      ))}
    </ul>
  );
};

export default MegaDropDownCategoryItem;
