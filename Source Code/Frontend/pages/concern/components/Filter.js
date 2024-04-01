import { UserContext } from 'contexts/user.context';
import React, { useContext, useState } from 'react';
import style from 'styles/productList/components/Filter.module.scss';
import FilterObject from './FilterObject';

const Filter = ({
  categories,
  setCategories,
  brands,
  setBrands,
  concerns,
  setConcerns,
  clearFilter,
  category_id = '',
}) => {
  return (
    <div className={style.wrapper}>
      <div className={style.titleWrapper}>
        <div className={style.title}>Filter</div>
        <div className={`${style.clear} cursor-pointer`} onClick={() => clearFilter()}>
          CLEAR ALL
        </div>
      </div>
      <FilterObject title={'CATEGORIES'} filter={categories} onChange={setCategories} />
      <FilterObject title={'BRAND'} filter={brands} onChange={setBrands} />
      <FilterObject title={'CONCERNS'} filter={concerns} onChange={setConcerns} category_id={category_id} />
      {/* <FilterObject title={'LIFESTAGE'} filter={lifestage} onChange={setLifestage} /> */}
    </div>
  );
};

export default Filter;
