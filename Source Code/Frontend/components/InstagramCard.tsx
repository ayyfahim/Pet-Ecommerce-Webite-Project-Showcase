import React, { FC } from 'react';
import styles from 'styles/InstagramCard.module.css';
import igIcon from 'public/img/follow-instagram/instagram.webp';
import Image from 'next/image';

interface PropsInstagramCard {
  img: string;
  link: string;
}

const InstagramCard: FC<PropsInstagramCard> = ({ img, link }) => {
  return (
    <a href={link}>
      <div className={styles.photo}>
        <img className="object-cover relative w-full h-full" alt="Img instagram" src={img} />
        <span className={styles.icon}>
          <Image alt="" src={igIcon} width={29} height={29} />
        </span>
      </div>
    </a>
  );
};

export default InstagramCard;
