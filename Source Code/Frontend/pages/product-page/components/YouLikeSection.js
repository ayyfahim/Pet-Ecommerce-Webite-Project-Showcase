/* eslint-disable react/jsx-key */
import { useContext } from "react";
import styles from "../../../styles/product/YouLikeSection.module.css";
import Link from "next/link";
import { UserContext } from "contexts/user.context";
import Image from "next/image";
import Product from "@/components/Product";

const items = [
  {
    img: "/img/HomePage/item2.png",
    title:
      "Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews",
    text: "Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews",
    price: "24.34",
    type: "featured",
    description:
      "From the industry leader in CBD science for pets – Recommended to support joint health and flexibility in dogs. The highest-quality CBD from broad spectrum hemp extract blended with Boswellia serrata in a smoky bacon-flavored soft chew.",
  },
  {
    img: "/img/HomePage/item3.png",
    title: "CBD Wellness Chicken And Blueberry Flavor Soft Baked Chews",
    text: "Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews",
    price: "25.56",
    type: "",
    description:
      "From the industry leader in CBD science for pets – Recommended to support joint health and flexibility in dogs. The highest-quality CBD from broad spectrum hemp extract blended with Boswellia serrata in a smoky bacon-flavored soft chew.",
  },
  {
    img: "/img/HomePage/item4.png",
    title:
      " Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews",
    text: "Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews",
    price: "23.25",
    type: "",
    description:
      "From the industry leader in CBD science for pets – Recommended to support joint health and flexibility in dogs. The highest-quality CBD from broad spectrum hemp extract blended with Boswellia serrata in a smoky bacon-flavored soft chew.",
  },
  {
    img: "/img/HomePage/item1.png",
    title:
      " Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews",
    text: "Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews",
    price: "23.53",
    type: "new",
    description:
      "From the industry leader in CBD science for pets – Recommended to support joint health and flexibility in dogs. The highest-quality CBD from broad spectrum hemp extract blended with Boswellia serrata in a smoky bacon-flavored soft chew.",
  },
];

export default function YouLikeSection() {
  const userContext = useContext(UserContext);

  return (
    <div className={styles.wrapper}>
      <div className={styles.title}>You may also like</div>
      <div className={styles.body}>
        {items.map((item, i) => (
          // <Link href="/productPage">
          //   <a
          //     key={item.title}
          //     className={styles.item}
          //     type="submit"
          //     onClick={() => {
          //       userContext.setUrl(item.img);
          //     }}
          //   >
          //     <img alt="img" src={item.img} className={styles.item_img} />
          //     <div className={styles.item_title}>{item.title}</div>
          //     <div className={styles.item_text}>{item.text}</div>
          //     <div className={styles.addCart_field}>
          //       <div className={styles.price}>${item.price}</div>
          //       <button className={styles.addcart}>Add to Cart</button>
          //     </div>
          //     {i == 1 ? (
          //       <div>
          //         <div className={styles.popular}>Popular</div>
          //         {/* <div className={styles.popular_after}></div> */}
          //       </div>
          //     ) : (
          //       ""
          //     )}
          //   </a>
          // </Link>
          <div key={i} className={styles.product}>
            <Product item={item} />
          </div>
        ))}
      </div>
    </div>
  );
}
