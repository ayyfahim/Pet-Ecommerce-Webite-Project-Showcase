import React, { useContext } from 'react';
import Link from 'next/link';
import { UserContext } from 'contexts/user.context';
// import styles from "styles/Product.module.css";
import styles from 'styles/Product.module.scss';
import classNames from 'classnames';
import { addToCart, shortHandleAddToCart } from '@/features/cart/useCartService';

const Product = ({ item, classname, cart, setCart }) => {
  // eslint-disable-next-line react-hooks/rules-of-hooks
  const userContext = useContext(UserContext);
  return (
    <div className={classNames(styles.wrapper, classname)}>
      <Link
        href={`/product/${item?.slug}`}
        passHref
        onClick={(e) => {
          if (!item?.is_configured && e?.target?.nodeName == 'BUTTON') {
            e?.preventDefault();
            e?.stopPropagation();
            e?.nativeEvent?.preventDefault();
          }
        }}
      >
        <a
          type="submit"
          onClick={(e) => {
            userContext.setUrl(item.cover);

            if (!item?.is_configured && e?.target?.nodeName == 'BUTTON') {
              e?.preventDefault();
              e?.stopPropagation();
              e?.nativeEvent?.preventDefault();
            }
          }}
          className={styles.item}
        >
          <img alt="img" src={item.cover} className={styles.item_img} />
          <div className={styles.textWrapper}>
            <p className={styles.item_title}>{item.title}</p>
            <p className={styles.item_text}>{item.excerpt}</p>
          </div>
          <div className={styles.addCart_field}>
            <div className={styles.price}>${Math.abs(item.sale_price).toFixed(2)}</div>
            <button
              className={styles.addcart}
              onClick={(event) => {
                // event.stopPropagation();
                if (!item?.is_configured) {
                  shortHandleAddToCart(item, cart, setCart);
                }
              }}
            >
              Add to Cart
            </button>
          </div>
          {item.type === 'popular' && (
            <div>
              <div className={styles.popular}>Popular</div>
            </div>
          )}
          {item.type === 'new' && (
            <div>
              <div className={styles.popular}>New</div>
            </div>
          )}
          {item.type === 'featured' ||
            (item.type === 'Featured' && (
              <div>
                <div className={styles.popular}>Featured</div>
              </div>
            ))}
        </a>
      </Link>
    </div>
  );
};

export default Product;
