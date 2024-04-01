import Image from "next/image";

import starSvg from "public/img/review-stars/full.svg";
import styles from "styles/ReviewStars.module.css";

function stars(rating) {
  const result = [];

  for (let i = 0; i < rating; i++) {
    result.push(
      <div
        key={`star-${i}`}
        style={{ marginRight: i === rating - 1 ? "0" : "4px" }}
      >
        <Image alt="logo" src={starSvg} height={20} width={22} />
      </div>
    );
  }

  return result;
}

export default function ReviewStars(props) {
  const { rating, subTitle } = props;

  if (subTitle) {
    return (
      <div className="flex flex-col">
        <div className="flex flex-row">{stars(rating)}</div>
        <span className={styles.subTitle}>{subTitle}</span>
      </div>
    );
  }

  return <div className="flex flex-row">{stars(rating)}</div>;
}
