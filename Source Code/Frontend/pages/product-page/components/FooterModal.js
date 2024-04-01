import styles from '../../../styles/product/FooterModal.module.css';
import style from '../../../styles/product/SurityPro.module.css';

import { useState } from 'react';
import MySelect from '@/components/CartItems/componentsCartItem/MySelect';
import classNames from 'classnames';
import { divide } from 'lodash';

const selectValues = [
  { value: '1 month', label: '1 month' },
  { value: '2 month', label: '2 month' },
  { value: '3 month', label: '3 month' },
  { value: '4 month', label: '4 month' },
  { value: '5 month', label: '5 month' },
  { value: '6 month', label: '6 month' },
];

const FooterModal = ({ active, setActive }) => {
  const [packState, setPack] = useState(1);
  const [buyOptionState, setBuyOption] = useState(1);
  const [selectSubscriptionTime, setSelectSubscriptionTime] = useState('1 moth');
  return (
    <div
      onClick={() => setActive(false)}
      className={classNames(active ? styles.FooterModalWrapper : styles.FooterModalWrapperDisplayNone)}
    >
      <div onClick={(e) => e.stopPropagation()} className={styles.footerModal_field}>
        <div className={styles.footerModal}>
          <div className={styles.packSize}>Pack Size</div>
          <div className={styles.packField}>
            <div
              onClick={() => setPack(1)}
              className={
                packState == 1
                  ? `${styles.pack_active_border} ${styles.width50}`
                  : `${styles.pack_border} ${styles.width50}`
              }
            >
              <span className={packState == 1 ? styles.active_smallFont : styles.smallFont}>
                Medium (26-50 lbs), 28 mg, 30 Soft Chews
              </span>
            </div>
            <div
              onClick={() => setPack(2)}
              className={
                packState == 2
                  ? `${styles.pack_active_border} ${styles.width50}`
                  : `${styles.pack_border} ${styles.width50}`
              }
            >
              <span className={packState == 2 ? styles.active_smallFont : styles.smallFont}>
                Large (36-110 lbs), 26 mg, 7 Soft Baked Chews
              </span>
            </div>
          </div>
          <div className={classNames(styles.packSize, styles.packSizeMT)}>Buy Option</div>
          <div className={styles.buySection}>
            <div
              onClick={() => setBuyOption(1)}
              className={
                buyOptionState == 1
                  ? `${styles.buy_left_border} ${styles.width40} ${styles.active_border}`
                  : `${styles.buy_left_border} ${styles.width40}`
              }
            >
              <span className={styles.price}>$99.99</span> <br></br>
              <span className={styles.smallFont}>One-time purchase</span>
            </div>
            <div
              onClick={() => setBuyOption(2)}
              className={
                buyOptionState == 2
                  ? `${style.buy_right_border} ${style.width60} ${style.active_border}`
                  : `${style.buy_right_border} ${style.width60}`
              }
            >
              <span>
                <span className={style.price}>$99.99</span>
                <span className={style.smallFont}>Subscribe and </span>
                <span className={style.redFont}>Save 10%</span>
              </span>
              <br />
              <span className={classNames(style.smallFont, style.smallFontDisplayFlex, style.smallFontDisplayFlexMT)}>
                <span>Deliver every</span>
                <MySelect
                  classNamePrefix="productMonthSelect"
                  state={selectSubscriptionTime}
                  setState={setSelectSubscriptionTime}
                  optionsArr={selectValues}
                />
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default FooterModal;
