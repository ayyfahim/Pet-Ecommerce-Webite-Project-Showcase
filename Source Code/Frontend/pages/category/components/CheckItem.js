import React, { useEffect, useRef, useState } from 'react';
import style from 'styles/productList/components/CheckItem.module.scss';
const CheckItem = ({ index, selected, title, count, Categories, setCategories, category_id, item_id }) => {
  const changeCategories = () => {
    const CategoriesTemp = [...Categories];
    CategoriesTemp[index].selected = CategoriesTemp[index].selected === true ? false : true;
    setCategories(CategoriesTemp);
  };

  const inputRef = useRef(null);
  const mounted = useRef(false);

  useEffect(() => {
    if (category_id == item_id && !selected && !inputRef?.current?.checked && !mounted.current) {
      inputRef?.current?.click();
    }
    mounted.current = true;
  }, []);

  return (
    <div className={style.wrapper}>
      <input
        type="checkbox"
        className={style.checkbox}
        checked={selected ? true : false}
        onChange={() => {
          changeCategories();
        }}
        ref={inputRef}
      />
      <div
        onClick={() => {
          changeCategories();
        }}
        className={style.title}
      >{`${title}`}</div>
    </div>
  );
};

export default CheckItem;
