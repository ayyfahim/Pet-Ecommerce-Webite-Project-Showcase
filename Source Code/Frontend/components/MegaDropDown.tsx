import Image from 'next/image';
import React, { FC } from 'react';
import styles from 'styles/MegaDropDown.module.css';
import calmIcon from 'public/img/shop-by-concern/calm.svg';
import immunityIcon from 'public/img/shop-by-concern/immunity.svg';
import mobilityIcon from 'public/img/shop-by-concern/mobility.svg';
import petsIcon from 'public/img/shop-by-concern/pets.svg';
import reliefIcon from 'public/img/shop-by-concern/relief.svg';
import wellnessIcon from 'public/img/shop-by-concern/wellness.svg';
import { IMainCategory } from '@/app/types/CategoryInterface';
import MegaDropDownCategoryItem from './MegaDropDownCategoryItem';

interface IMegaDropDownProps {
  categories: IMainCategory[];
  brands: any;
  concerns: any;
}

const MegaDropDown: FC<IMegaDropDownProps> = ({ categories, brands, concerns }) => {
  // console.log(
  //   categories,
  //   categories?.slice()?.sort(() => Math.random() - Math.random())
  // );
  return (
    <div className={styles.megaWrapper}>
      <div className={styles.megaContainer}>
        <div className="flex flex-row flex-wrap sm:flex-col w-full sm:w-1/5 bg-light-purple mx-auto">
          <ul className="py-4 text-left">
            <li className="text-sm pl-12 py-1.5 text-purple font-bold">TRENDING CATEGORIES</li>
            {categories
              ?.slice()
              ?.sort(() => Math.random() - Math.random())
              ?.slice(0, 3)
              ?.map((item) => (
                <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                  <a href={`/category/${item?.slug}`}>{item.name}</a>
                </li>
              ))}
          </ul>
          <ul className="py-4 text-left">
            <li className="text-sm pl-12 py-1.5 text-purple font-bold">TRENDING BRANDS</li>
            {brands
              ?.slice()
              ?.sort(() => Math.random() - Math.random())
              ?.slice(0, 3)
              ?.map((item: any) => (
                <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                  <a href="">{item.name}</a>
                </li>
              ))}
          </ul>
        </div>

        <div className="w-full  sm:w-4/5 pb-12 text-left">
          <div className={styles.features}>
            {concerns &&
              concerns?.map((concern: any) => (
                <div>
                  <a href={`/concern/${concern.slug}`}>
                    <Image alt="logo" src={concern?.banner || ''} className={styles.icon} width={55} height={55} />
                    <p className={styles.iconDescription}>{concern?.name}</p>
                  </a>
                </div>
              ))}
          </div>

          <hr className="mx-14" />
          <div className="flex mt-6 flex-wrap lg:flex-nowrap pl-14">
            {categories?.map((item) => (
              <MegaDropDownCategoryItem key={item.id} category={item} />
            ))}
          </div>
          <div className="flex mt-6 flex-wrap lg:flex-nowrap pl-14"></div>
        </div>
      </div>
    </div>
  );
};

export default MegaDropDown;
