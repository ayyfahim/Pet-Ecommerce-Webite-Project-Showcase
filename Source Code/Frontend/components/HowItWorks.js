import styles from '../styles/HowItWorks.module.css';
import bgImage from 'public/img/how-it-works/how-it-works-bg@2x.webp';
import textBubble from 'public/img/how-it-works/bg-image-2@2x.png';
import arrowLine1 from 'public/img/how-it-works/arrow-line-1.svg';
import arrowLine2 from 'public/img/how-it-works/arrow-line-2.svg';
import Image from 'next/image';

export default function HowItWorks({ width, homepageData }) {
  return (
    <div className={styles.wrapper}>
      <div className="container mx-auto flex flex-col sm:flex-row-reverse">
        <div className="text-center hidden md:flex md:text-left md:w-1/2 md:pl-10 md:relative">
          <div className={styles.image}>
            <Image
              alt="logo"
              src={homepageData?.how_it_works_section_main_image ?? bgImage}
              // layout="fill"
              width={409}
              height={624}
            />
          </div>
          <div className={styles.image2}>
            <Image
              alt="logo"
              src={homepageData?.how_it_works_section_bubble_image ?? textBubble}
              // layout="fill"
              width={278}
              height={157}
            />
          </div>
        </div>

        <div className="md:w-1/2">
          <h2 className={styles.heading}>{homepageData?.how_it_works_section_header ?? 'How it Works'}</h2>
          <p className={styles.description}>
            {homepageData?.how_it_works_section_description ??
              'Any parent will tell you that colic is one of the most excruciating experiences of early parenthood. The baby cries as if in dire pain.'}
          </p>

          <div className={styles.features}>
            <div className={styles.feature}>
              <div className="sm:mr-4 sm:relative">
                <div className={styles.featureNumber}>1</div>
                {width && width > 768 && (
                  <div className={styles.arrow1}>
                    <Image alt="logo" src={arrowLine1} className="h-full" />
                  </div>
                )}
              </div>
              <div>
                <h3 className={styles.featureTitle}>{homepageData?.how_it_works_1_header ?? 'Register your Pet'}</h3>
                <p className={styles.featureText}>
                  {homepageData?.how_it_works_1_description ??
                    'The UK’s best selling grain free ancestral diet. A top seller for good reason. The UK’s best selling grain free ancestral diet. A top seller for good reason.'}
                </p>
              </div>
            </div>

            <div className={styles.feature}>
              <div className="sm:mr-4 sm:relative">
                <div className={styles.featureNumber}>2</div>
                {width && width > 768 && (
                  <div className={styles.arrow2}>
                    <Image alt="logo" src={arrowLine2} className="h-full" />
                  </div>
                )}
              </div>
              <div>
                <h3 className={styles.featureTitle}>{homepageData?.how_it_works_2_header ?? 'Order Now'}</h3>
                <p className={styles.featureText}>
                  {homepageData?.how_it_works_2_description ??
                    'The UK’s best selling grain free ancestral diet. A top seller for good reason. The UK’s best selling grain free ancestral diet. A top seller for good reason.'}
                </p>
              </div>
            </div>

            <div className={styles.feature}>
              <div className="sm:mr-4">
                <div className={styles.featureNumber}>3</div>
              </div>
              <div>
                <h3 className={styles.featureTitle}>{homepageData?.how_it_works_3_header ?? 'Find Best Products'}</h3>
                <p className={styles.featureText}>
                  {homepageData?.how_it_works_3_description ??
                    'The UK’s best selling grain free ancestral diet. A top seller for good reason. The UK’s best selling grain free ancestral diet. A top seller for good reason.'}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
