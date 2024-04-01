import styles from "styles/product/YouLikeSection.module.css";
import Image from "next/image";
import Product from "@/components/Product";

const items = [
  {
    img: "/img/HomePage/item2.png",
    title:
      "Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews",
    text: "Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews",
    price: "24.34",
  },
  {
    img: "/img/HomePage/item3.png",
    title: "CBD Wellness Chicken And Blueberry Flavor Soft Baked Chews",
    text: "Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews",
    price: "25.56",
  },
  {
    img: "/img/HomePage/item4.png",
    title:
      " Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews",
    text: "Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews",
    price: "23.25",
  },
  {
    img: "/img/HomePage/item1.png",
    title:
      " Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews",
    text: "Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews",
    price: "23.53",
  },
];

export default function YouLikeSection() {
  return (
    <div className={styles.wrapper}>
      <div className={styles.title}>You may also like</div>
      <div className={styles.body}>
        {items?.map((item, i) => (
          <div key={i} className={styles.product}>
            <Product item={item} />
          </div>
        ))}
      </div>
    </div>
  );
}
