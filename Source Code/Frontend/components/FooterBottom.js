import { useState } from 'react';
import { BiMinus, BiPlus } from 'react-icons/bi';
import styles from 'styles/product/FooterBottom.module.css';

const FooterBottom = ({ setActive, product, countState, increase, decrease, handleAddToCart }) => {
  const [packState, setPack] = useState(1);
  const [buyOptionState, setBuyOption] = useState(1);
  return (
    <div className={styles.footerBottom}>
      <div className={styles.left}>
        <img alt="img" className={styles.img} src={product?.cover} />
        <div className={styles.title}>SurityPro Active Smoky Bacon Flavor Soft Chews</div>
      </div>
      <div className={styles.right}>
        <div className={styles.amount_field}>
          <button onClick={() => setActive(true)} className={styles.select}>
            Select Pack Size and Buy Option
          </button>
          <div className={styles.addCart_count}>
            <div onClick={decrease} className={countState == 1 ? styles.dis_minus : styles.act_minus}>
              <BiMinus />
            </div>
            <div className={styles.addCart_count_num}>{countState}</div>
            <div onClick={increase} className={styles.plus}>
              <BiPlus />
            </div>
          </div>
        </div>
        <button className={styles.addCartField} onClick={() => handleAddToCart()}>
          Add to cart{'  '} ${product?.sale_price}
        </button>
      </div>
    </div>
  );
};
export default FooterBottom;
