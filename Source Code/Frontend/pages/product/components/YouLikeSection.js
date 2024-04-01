/* eslint-disable react/jsx-key */
import { useContext } from 'react';
import styles from '../../../styles/product/YouLikeSection.module.css';
import Link from 'next/link';
import { UserContext } from 'contexts/user.context';
import Image from 'next/image';
import Product from '@/components/Product';
import { useCartState } from '@/app/atom/cart.atom';

export default function YouLikeSection({ related_products }) {
  const userContext = useContext(UserContext);

  const [cart, setCart] = useCartState();

  return (
    <div className={styles.wrapper}>
      <div className={styles.title}>You may also like</div>
      <div className={styles.body}>
        {related_products?.map((item, i) => (
          <div key={i} className={styles.product}>
            <Product item={item} classname="" cart={cart} setCart={setCart} />
          </div>
        ))}
      </div>
    </div>
  );
}
