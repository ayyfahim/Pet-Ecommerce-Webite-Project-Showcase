import heroBg from 'public/img/hero-section/hero-bg_new3x.webp';
import styles from 'styles/HeroSection.module.scss';
import Image from 'next/image';
import MainButton from 'components/MainButton';
import classNames from 'classnames';
import { useRouter } from 'next/router';

interface IHeroSectionProps {
  width: number | undefined;
  homepageData: any;
}

export default function HeroSection({ width, homepageData }: IHeroSectionProps) {
  const { push } = useRouter();

  return (
    <div className={styles.wrapper}>
      {width && width > 639 ? (
        <Image
          alt="logo"
          layout="fill"
          className={classNames(styles.BackgroundImg, 'object-top object-cover pointer-events-none bg-purple')}
          priority
          src={homepageData?.banner_section_image ?? heroBg}
        />
      ) : (
        <img
          alt="logo"
          className={styles.BackgroundImg}
          src={homepageData?.banner_section_mobile_image ?? 'img/hero-section/dogBG.png'}
        />
      )}
      <div className={styles.content}>
        {homepageData?.banner_section_header ? (
          <h1 className={styles.heading}>{homepageData?.banner_section_header}</h1>
        ) : (
          <h1 className={styles.heading}>
            Find your pet&#8217;s <span>perfect</span>
            <br /> product match.
          </h1>
        )}
        <p className={styles.description}>
          {homepageData?.banner_section_description ??
            'At VitalPawz we make it easy for you to search the right supplements for your pet.'}
        </p>
        <div className="flex items-center flex-col sm:flex-row">
          <MainButton
            onClick={() => push(homepageData?.banner_button_1_link ?? '/product-list')}
            big
            classButton={styles.cta}
          >
            {homepageData?.banner_button_1_text ?? 'Shop Now'}
          </MainButton>
          <span className="relative inline-block sm:ml-16">
            <MainButton onClick={() => push(homepageData?.banner_button_2_link ?? '/add-pet')} classButton={styles.alt}>
              {homepageData?.banner_button_2_text ?? 'Customized Recommendation'}
            </MainButton>
          </span>
        </div>
      </div>
    </div>
  );
}
