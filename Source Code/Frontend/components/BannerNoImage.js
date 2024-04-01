import React from 'react';
// import Image from 'next/image';
// import dogImg from 'public/img/hero-section/hero-bg-desktop@3x.webp';
import style from 'styles/Banner.module.scss';

const headText = 'Vitamins & Supplements';
const descriptionText = ` It is a good idea to provide a supplementary vitamin and mineral supplement, and definitely a probiotic to balance the nutrient  depletion in the body`;

const Banner = ({ title, description, image }) => {
  return (
    <div className={`${style.wrapper} -z-10`}>
      <div className={style.content}>
        <h1 className={style.heading}>{title || headText}</h1>
        <p className={style.description}>{description || descriptionText}</p>
      </div>
      <div className={style.imageWrapper}>
        <div className={style.leftImage} />
        <div className={style.rightImage}>{/* <Image src={image || dogImg} alt="dog" /> */}</div>
      </div>
    </div>
  );
};

export default Banner;
