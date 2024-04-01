import styles from "../../../styles/product/ReviewSection.module.css";
import { BiChevronLeft, BiChevronRight } from "react-icons/bi";
import { useState } from "react";

const reviews = [
  {
    title: "Elsie Carpenter",
    date: "09 May, 2021",
    text: "I have an older dog and these CBD oil soft chews have really made a difference. My dog is up and running and playing, for a short time, again.",
  },
  {
    title: "Johanna Paul",
    date: "09 May, 2021",
    text: "My dog loves these cookies and everyone has noticed how much calmer and better behaved she is. I’m on auto delivery now.",
  },
  {
    title: "Barbara Walsh",
    date: "09 May, 2021",
    text: "My picky pups love the taste of these chews. It also calms them down and they sleep well at night.",
  },
  {
    title: "Ollie Erickson",
    date: "09 May, 2021",
    text: "Our dog Macee is petrified of fireworks so, while we were at camp, I gave her half of the recommended dose suggested. My dog loves these cookies and everyone has noticed how much calmer and better behaved she is. I’m on auto delivery now.She has never taken any kind of…",
  },
];

export default function ReviewSection() {
  const [pagination, setPagination] = useState(0);
  return (
    <div className={styles.reviewSection}>
      <div className={styles.title}>Customer Reviews</div>
      <div className={styles.review_top}>
        <div className={styles.review_header}>
          <div className={styles.flexStart}>
            <div className={styles.reviewNum}>4.6</div>
            <div className={styles.reviewIconField}>
              {[...Array(5)].map((x, i) => (
                <img
                  alt="img"
                  src="/img/HomePage/path.png"
                  className={styles.reviewImg}
                  key={i}
                />
              ))}
            </div>
          </div>
          <div className={styles.review_dec}>based on 32 Reviews</div>
        </div>
        <button className={styles.reveiwBtn}>Write a review</button>
      </div>
      {reviews.map((review) => (
        <div key={review.title} className={styles.flexCol}>
          <div className={styles.border_bottom}></div>
          <div className="">
            <span className={styles.review_title}>{review.title}</span>
            <span className={styles.review_date}>{review.date}</span>
          </div>
          <div className={styles.reviewIconField}>
            {[...Array(5)].map((x, i) => (
              <img
                alt="img"
                src="/img/HomePage/path.png"
                className={styles.reviewImg}
                key={i}
              />
            ))}
          </div>
          <div className={styles.review_text}>{review.text}</div>
          {/* <div className={styles.border_bottom}></div> */}
        </div>
      ))}
      <div className={styles.pagination}>
        <div className={styles.pagination_icons}>
          <div className={`${styles.pagination_item} ${styles.pointer}`}>
            <BiChevronLeft size={20} />
          </div>
          {[...Array(5)].map((x, i) => (
            <div
              onClick={() => setPagination(i)}
              className={
                pagination == i
                  ? `${styles.acitive_pagination_item} ${styles.pointer}`
                  : `${styles.pagination_item} ${styles.pointer}`
              }
              key={i}
            >
              {i + 1}
            </div>
          ))}
          <div className={`${styles.pagination_item} ${styles.pointer}`}>
            <BiChevronRight size={20} />
          </div>
        </div>

        <div className={styles.pagination_icons2}>
          <div className={`${styles.pagination_item} ${styles.pointer}`}>
            <BiChevronLeft size={20} />
          </div>
          {[...Array(3)].map((x, i) => (
            <div
              onClick={() => setPagination(i)}
              className={
                pagination == i
                  ? `${styles.acitive_pagination_item} ${styles.pointer}`
                  : `${styles.pagination_item} ${styles.pointer}`
              }
              key={i}
            >
              {i + 1}
            </div>
          ))}
          <div className={`${styles.pagination_item} ${styles.pointer}`}>
            <BiChevronRight size={20} />
          </div>
        </div>
      </div>
    </div>
  );
}
