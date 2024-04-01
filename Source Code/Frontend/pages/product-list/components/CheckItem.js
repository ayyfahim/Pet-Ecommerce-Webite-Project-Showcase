import React from 'react';
import style from 'styles/productList/components/CheckItem.module.scss';
const CheckItem = ({ index, selected, title, count, Categories, setCategories }) => {
  const changeCategories = () => {
    const CategoriesTemp = [...Categories];
    CategoriesTemp[index].selected = CategoriesTemp[index].selected === true ? false : true;
    setCategories(CategoriesTemp);
  };
  return (
    <div className={style.wrapper}>
      <input
        type="checkbox"
        className={style.checkbox}
        checked={selected ? true : false}
        onChange={() => {
          changeCategories();
        }}
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
