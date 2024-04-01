import styles from '../styles/Features.module.scss';
import Image from 'next/image';
import fastShippingIcon from '../public/img/features/fast-shipping.svg';
import naturalIngredientsIcon from '../public/img/features/natural-ingredients.svg';
import securePaymentsIcon from '../public/img/features/secure-payments.svg';
import madeInUsaIcon from 'public/img/features/made-in-usa.svg';

export default function Features({ homepageData }) {
  return (
    <div className={styles.wrapper}>
      <div className={styles.features}>
        <div className={styles.feature}>
          <Image
            alt="logo"
            src={homepageData?.sub_banner_1_icon ?? fastShippingIcon}
            height={25}
            width={25}
            className={styles.icon}
          />
          <p className={styles.description}>{homepageData?.sub_banner_1_text ?? 'Fast shipping'}</p>
        </div>
        <div className={styles.feature}>
          <Image
            alt="logo"
            src={homepageData?.sub_banner_2_icon ?? securePaymentsIcon}
            height={25}
            width={25}
            className={styles.icon}
          />
          <p className={styles.description}>{homepageData?.sub_banner_2_text ?? 'Secure payments'}</p>
        </div>
        <div className={styles.feature}>
          <Image
            alt="logo"
            src={homepageData?.sub_banner_3_icon ?? naturalIngredientsIcon}
            height={25}
            width={25}
            className={styles.icon}
          />
          <p className={styles.description}>{homepageData?.sub_banner_3_text ?? 'Natural ingredients'}</p>
        </div>
        <div className={styles.feature}>
          <Image
            alt="logo"
            src={homepageData?.sub_banner_4_icon ?? madeInUsaIcon}
            width={25}
            height={25}
            className={styles.icon}
          />
          <p className={styles.description}>{homepageData?.sub_banner_4_text ?? 'Made in USA'}</p>
        </div>
      </div>
    </div>
  );
}
