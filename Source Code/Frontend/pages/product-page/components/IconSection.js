import styles from "../../../styles/product/IconSection.module.css";

export default function IconSection() {
  return (
    <>
      <div className={styles.iconSection}>
        <div className={styles.iconSection_item1}>
          <img alt="img" src="/img/HomePage/icon-64-lab-tested.png" />
          <div className={styles.text}>Lab Tested</div>
        </div>
        <div className={styles.iconSection_item1}>
          <img alt="img" src="/img/HomePage/icon-64-thc-free.png" />
          <div className={styles.text}>THC Free</div>
        </div>
        <div className={styles.iconSection_item1}>
          <img alt="img" src="/img/HomePage/icon-64-gmp-certified.png" />
          <div className={styles.text}>GMP Certified</div>
        </div>
        <div className={styles.iconSection_item1}>
          <img alt="img" src="/img/HomePage/icon-64-natural.png" />
          <div className={styles.text}>Natural</div>
        </div>
      </div>

      <div className={styles.iconSection2}>
        <div className={styles.flexRow}>
          <div className={styles.iconSection_item1}>
            <img
              alt="img"
              className={styles.icon_img}
              src="/img/HomePage/icon-64-lab-tested.png"
            />
            <div className={styles.text}>Lab Tested</div>
          </div>
          <div className={styles.iconSection_item2}>
            <img
              alt="img"
              className={styles.icon_img}
              src="/img/HomePage/icon-64-thc-free.png"
            />
            <div className={styles.text}>THC Free</div>
          </div>
        </div>
        <div className={styles.flexRow}>
          <div className={styles.iconSection_item1}>
            <img
              alt="img"
              className={styles.icon_img}
              src="/img/HomePage/icon-64-gmp-certified.png"
            />
            <div className={styles.text}>GMP Certified</div>
          </div>
          <div className={styles.iconSection_item2}>
            <img
              alt="img"
              className={styles.icon_img}
              src="/img/HomePage/icon-64-natural.png"
            />
            <div className={styles.text}>Natural</div>
          </div>
        </div>
      </div>
    </>
  );
}
