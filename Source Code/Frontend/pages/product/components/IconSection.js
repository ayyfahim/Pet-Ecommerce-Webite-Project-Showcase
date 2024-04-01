import styles from '../../../styles/product/IconSection.module.css';

export default function IconSection({ icons }) {
  const rows = icons?.reduce(function (rows, key, index) {
    return (index % 2 == 0 ? rows.push([key]) : rows[rows.length - 1].push(key)) && rows;
  }, []);

  return (
    <>
      <div className={styles.iconSection}>
        {icons?.map((icon) => (
          <div className={styles.iconSection_item1}>
            <img alt="img" src={icon?.badge} />
            <div className={styles.text}>{icon?.label}</div>
          </div>
        ))}
      </div>

      <div className={styles.iconSection2}>
        {rows?.map((row) => (
          <div className={styles.flexRow}>
            {row?.map((icon, index) => (
              <div className={index == 0 ? styles.iconSection_item1 : styles.iconSection_item2}>
                <img alt="img" className={styles.icon_img} src={icon?.badge} />
                <div className={styles.text}>{icon?.label}</div>
              </div>
            ))}
          </div>
        ))}
      </div>
    </>
  );
}
