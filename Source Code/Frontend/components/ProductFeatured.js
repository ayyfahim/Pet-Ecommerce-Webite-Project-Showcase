import React, { useContext } from "react";
import Link from "next/link";
import { UserContext } from "contexts/user.context";
// import styles from "styles/Product.module.css";
import styles from "styles/ProductFeatured.module.scss";
import classNames from "classnames";

const ProductFeatured = ({ item, classname }) => {
  // eslint-disable-next-line react-hooks/rules-of-hooks
  const userContext = useContext(UserContext);
  return (
    <div className={classNames(styles.wrapper, classname)}>
      <Link href="/productPage">
        <a
          type="submit"
          onClick={() => {
            userContext.setUrl(item.img);
          }}
          className={styles.item}
        >
          <div className={styles.descriptionWrapper}>
            <div>
              <div className={styles.popular}>{item.type}</div>
            </div>
            <div className={styles.textWrapper}>
              <p className={styles.item_title}>{item.title}</p>
              <p className={styles.item_text}>{item.text}</p>
              <p className={styles.item_description}>{item.description}</p>
            </div>
          </div>
          <div className={styles.viewWrapper}>
            <img alt="img" src={item.img} className={styles.item_img} />
            <div className={styles.addCart_field}>
              <div className={styles.price}>${item.price}</div>
              <button className={styles.addcart}>Add to Cart</button>
            </div>
          </div>
        </a>
      </Link>
    </div>
  );
};

export default ProductFeatured;
