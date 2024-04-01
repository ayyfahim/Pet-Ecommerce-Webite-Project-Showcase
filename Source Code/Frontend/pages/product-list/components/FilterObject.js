import React, { useState } from 'react';
import classNames from 'classnames';
import Image from 'next/image';
import arrowDown from '@/public/img/logo/arrow-down.svg';
import arrowRight from '@/public/img/logo/arrow-right.svg';
import style from 'styles/productList/components/FilterObject.module.scss';
import CheckItem from './CheckItem';

const FilterObject = ({ title, filter, onChange }) => {
  const [show, setShow] = useState(true);
  return (
    <div className={style.wrapper}>
      <div className={style.product}>
        <div className={style.title}>{title}</div>
        <button
          type="button"
          onClick={() => {
            setShow((prev) => !prev);
          }}
          className={style.hiddenButton}
        >
          {show === true ? <Image src={arrowDown} alt="arrowDown" /> : <Image src={arrowRight} alt="arrowRight" />}
        </button>
      </div>
      <div
        className={classNames(style.checkWrapper, {
          [style.true]: show === true,
          [style.false]: show === false,
        })}
      >
        {filter?.length == 0 ? (
          <span>No items</span>
        ) : (
          filter?.map((e, index) => {
            return (
              <CheckItem
                key={index}
                index={index}
                selected={e.selected}
                title={e.name}
                count={e.count}
                Categories={filter}
                setCategories={onChange}
              />
            );
          })
        )}
      </div>
    </div>
  );
};

export default FilterObject;
