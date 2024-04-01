import React from 'react';
import style from 'styles/AddPet.module.scss';
import Image from 'next/image';

const ImgOption = React.forwardRef(({ item, field, width, handleNextStepButton, ...props }, ref) => {
  // console.log('field', field);
  const { onChange, value = [] } = field || {};

  const handleOnClick = (itemValue) => {
    let arr = value;
    if (!arr.includes(itemValue)) {
      arr?.push(itemValue);
    } else {
      arr?.splice(arr.indexOf(itemValue), 1);
    }
    onChange(arr);
    // handleNextStepButton();
  };

  return (
    <div
      onClick={(e) => handleOnClick(item?.value)}
      className={`${value?.includes(item?.value) ? style.active : ''} ${style.boxSelect}`}
    >
      {item?.title}
    </div>
  );
});

export default ImgOption;
