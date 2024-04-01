import styles from '../styles/ShopByConcern.module.css';
import Image from 'next/image';
import calmIcon from '../public/img/shop-by-concern/calm.svg';
import immunityIcon from '../public/img/shop-by-concern/immunity.svg';
import mobilityIcon from '../public/img/shop-by-concern/mobility.svg';
import petsIcon from '../public/img/shop-by-concern/pets.svg';
import reliefIcon from '../public/img/shop-by-concern/relief.svg';
import wellnessIcon from '../public/img/shop-by-concern/wellness.svg';
import { useRecoilValue } from 'recoil';
import { concernsAtom } from '@/app/atom/concernsAtom';

export default function ShopByConcern({ homepageData }) {
  const concerns = useRecoilValue(concernsAtom);
  return (
    <div className="container mx-auto lg:px-1">
      <div className={styles.wrapper}>
        <div className="md:flex md:justify-center md:flex-col md:w-1/4">
          <h2 className={styles.heading}>{homepageData?.concern_section_header ?? 'Shop by Concern'}</h2>
          <p className={styles.description}>
            {homepageData?.concern_section_description ??
              'The only cold pressed dog food made using fresh ingredients.'}
          </p>
        </div>
        <div className={styles.features}>
          {concerns &&
            concerns?.map((concern) => (
              <div>
                <a href={`/concern/${concern.slug}`}>
                  <Image alt="logo" src={concern?.banner || ''} className={styles.icon} width={55} height={55} />
                  <p className={styles.iconDescription}>{concern?.name}</p>
                </a>
              </div>
            ))}
        </div>
      </div>
    </div>
  );
}
