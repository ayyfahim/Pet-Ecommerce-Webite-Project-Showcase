import Link from 'next/link';
import React from 'react';
import styles from 'styles/RewardsPopup.module.css';

const RewardsPopup = ({ balance, exchange }: { balance: string; exchange: string }) => {
  return (
    <div className={styles.rewardsPopup}>
      <div className={styles.cnt}>
        <div className="flex justify-between">
          <p className={styles.title}>
            My Rewards
            <Link href="/account/my-rewards">
              <a className={styles.history} style={{ display: 'block' }}>
                See history
              </a>
            </Link>
          </p>
          <p className={styles.balance}>
            {balance} <br /> (${exchange})
          </p>
        </div>
        <p className={styles.downText}>
          Shop and earn points on purchases, social interactions, & more!
          <Link href="/reward-program">
            <a>Know more</a>
          </Link>
        </p>
      </div>
    </div>
  );
};

export default RewardsPopup;
