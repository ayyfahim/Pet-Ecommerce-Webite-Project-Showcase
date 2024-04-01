import React from 'react';
import style from 'styles/AddPet.module.scss';
import Image from 'next/image';

const ImgOption = React.forwardRef(({ item, field, width, handleNextStepButton, ...props }, ref) => {
  const { onChange, value = '' } = field || {};
  return (
    <div
      className={`${value == item?.value ? style.active : ''} ${style.VisualOption}`}
      onClick={() => {
        onChange(item?.value);
        // handleNextStepButton();
      }}
      {...props}
      {...field}
    >
      <div className={`${value == item?.value ? 'block' : ''}`}>
        <Image
          src={item?.cover}
          alt={item?.name}
          layout="fixed"
          width={width > 1280 ? 72 : 50}
          height={width > 1280 ? 72 : 50}
          priority
        />
      </div>
    </div>
  );
});

export default ImgOption;
