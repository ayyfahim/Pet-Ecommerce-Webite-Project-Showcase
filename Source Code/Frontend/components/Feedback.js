import styles from '../styles/Feedback.module.css';
import star from '../public/img/feedbacks/star.svg';
import Image from 'next/image';
import { AiFillStar, AiOutlineStar } from 'react-icons/ai';
import { useEffect, useState } from 'react';

export default function Feedback({ homepageData }) {
  // const [filledStars, setFilledStars] = useState(5);
  // const [emptyStars, setEmptyStars] = useState(0);

  // useEffect(() => {
  //   const getEmptyStars =
  // }, [])

  return (
    <div className={styles.wrapper}>
      <div className="container mx-auto">
        <h2 className={styles.heading}>{homepageData?.review_section_header ?? 'Pet Parent Reviews'}</h2>
        <p className={styles.description}>
          {homepageData?.review_section_description ??
            'Any parent will tell you that colic is one of the most excruciating experiences of early parenthood. The baby cries as if in dire pain.'}
        </p>
        <div className={styles.feedbacks}>
          <div className={styles.feedback}>
            <div className={styles.feedbackAvatar}>
              <Image
                alt="logo"
                src={homepageData?.review_1_image ?? '/img/feedbacks/avatar-1@2x.webp'}
                width={69}
                height={69}
              />
            </div>
            <div className={styles.rating}>
              {homepageData?.review_1_star
                ? [...Array(homepageData?.review_1_star)].map((e, i) => (
                    // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                    <AiFillStar
                      className={`${styles.star}`}
                      style={{
                        width: 32,
                        height: 32,
                        color: '#FFC72C',
                      }}
                    />
                  ))
                : [...Array(5)].map((e, i) => (
                    // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                    <AiFillStar
                      className={`${styles.star}`}
                      style={{
                        width: 32,
                        height: 32,
                        color: '#FFC72C',
                      }}
                    />
                  ))}
              {homepageData?.review_1_star ? (
                [...Array(5 - homepageData?.review_1_star)].map((e, i) => (
                  // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                  <AiOutlineStar
                    className={`${styles.star}`}
                    style={{
                      width: 32,
                      height: 32,
                      color: '#FFC72C',
                    }}
                  />
                ))
              ) : (
                <></>
              )}
            </div>
            <h4 className={styles.feedbackTitle}>{homepageData?.review_1_header ?? 'It is Great! Amazing Products'}</h4>
            <p className={styles.feedbackText}>
              {homepageData?.review_1_description ??
                'I bought all three I love them and would buy again. They grey one I think is made out of better Material. But overall I would buy again'}
            </p>
            <p className={styles.feedbackAuthor}>{homepageData?.review_1_author_name ?? '- Julia Sandoval'}</p>
          </div>

          <div className={styles.feedback}>
            <div className={styles.feedbackAvatar}>
              <Image
                alt="logo"
                src={homepageData?.review_2_image ?? '/img/feedbacks/avatar-2@2x.webp'}
                width={69}
                height={69}
              />
            </div>
            <div className={styles.rating}>
              {homepageData?.review_2_star ? (
                [...Array(homepageData?.review_2_star)].map((e, i) => (
                  // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                  <AiFillStar
                    className={`${styles.star}`}
                    style={{
                      width: 32,
                      height: 32,
                      color: '#FFC72C',
                    }}
                  />
                ))
              ) : (
                <></>
              )}
              {homepageData?.review_2_star
                ? [...Array(5 - homepageData?.review_2_star)].map((e, i) => (
                    // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                    <AiOutlineStar
                      className={`${styles.star}`}
                      style={{
                        width: 32,
                        height: 32,
                        color: '#FFC72C',
                      }}
                    />
                  ))
                : [...Array(5)].map((e, i) => (
                    // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                    <AiFillStar
                      className={`${styles.star}`}
                      style={{
                        width: 32,
                        height: 32,
                        color: '#FFC72C',
                      }}
                    />
                  ))}
            </div>
            <h4 className={styles.feedbackTitle}>{homepageData?.review_2_header ?? 'It is Great! Amazing Products'}</h4>
            <p className={styles.feedbackText}>
              {homepageData?.review_2_description ??
                'I bought all three I love them and would buy again. They grey one I think is made out of better Material. But overall I would buy again'}
            </p>
            <p className={styles.feedbackAuthor}>{homepageData?.review_2_author_name ?? '-Harvey Carter'}</p>
          </div>

          <div className={styles.feedback}>
            <div className={styles.feedbackAvatar}>
              <Image
                alt="logo"
                src={homepageData?.review_3_image ?? '/img/feedbacks/avatar-3@2x.webp'}
                width={69}
                height={69}
              />
            </div>
            <div className={styles.rating}>
              {homepageData?.review_3_star
                ? [...Array(homepageData?.review_3_star)].map((e, i) => (
                    // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                    <AiFillStar
                      className={`${styles.star}`}
                      style={{
                        width: 32,
                        height: 32,
                        color: '#FFC72C',
                      }}
                    />
                  ))
                : [...Array(5)].map((e, i) => (
                    // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                    <AiFillStar
                      className={`${styles.star}`}
                      style={{
                        width: 32,
                        height: 32,
                        color: '#FFC72C',
                      }}
                    />
                  ))}
              {homepageData?.review_3_star ? (
                [...Array(5 - homepageData?.review_3_star)].map((e, i) => (
                  // <Image alt="logo" className={styles.star} src={star} width={27} height={27} />
                  <AiOutlineStar
                    className={`${styles.star}`}
                    style={{
                      width: 32,
                      height: 32,
                      color: '#FFC72C',
                    }}
                  />
                ))
              ) : (
                <></>
              )}
            </div>
            <h4 className={styles.feedbackTitle}>{homepageData?.review_3_header ?? 'It is Great! Amazing Products'}</h4>
            <p className={styles.feedbackText}>
              {homepageData?.review_3_description ??
                'I bought all three I love them and would buy again. They grey one I think is made out of better Material. But overall I would buy again'}
            </p>
            <p className={styles.feedbackAuthor}>{homepageData?.review_3_author_name ?? '-Francisco Soto'}</p>
          </div>
        </div>
      </div>
    </div>
  );
}
