import styles from "styles/product-listings/ProductsList.module.css";
import Image from "next/image";
import productOne from "@/public/img/products/product-1@2x.webp";

export default function ProductsList() {
  return (
    <div className={styles.wrapper}>
      <div className={styles.products}>
        <div className={styles.products}>
          <div className={styles.product}>
            <div className={styles.image}>
              <Image alt="logo" src={productOne} />
            </div>
            <span className={styles.price}>$25.56</span>
            <h4 className={styles.title}>
              Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked
              Chews
            </h4>
            <p className={styles.productDescription}>
              Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews
            </p>
            <button className={styles.addToCart}>Add to cart</button>
          </div>
        </div>
      </div>
    </div>
  );
}
