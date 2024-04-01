import React, { FC } from 'react';
import style from '@/styles/SmartSearchProductCart.module.scss';
import Image from 'next/image';
import productImg from '@/public/img/productSellingImg.png';
import { IData } from 'types/smartSearchInterface';
import Link from 'next/link';

interface SmartSearchProductCartProps {
  product: IData;
}

const SmartSearchProductCart: FC<SmartSearchProductCartProps> = ({ product }) => {
  return (
    <Link href={`/product/${product?.slug}`}>
      <li className={`${style.SmartSearchProductCartLi} cursor-pointer`}>
        <div className={style.SmartSearchProductCartImg}>
          <Image src={product?.cover ?? productImg} width={156} height={150} />
        </div>
        <div className={style.SmartSearchProductCartPriceAndDescription}>
          <div className={style.SmartSearchProductCartPrice}>${product.regular_price}</div>
          <div className={style.SmartSearchProductCartDescription}>{product.title}</div>
        </div>
      </li>
    </Link>
  );
};

export default SmartSearchProductCart;
