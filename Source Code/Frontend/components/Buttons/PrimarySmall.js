import React from 'react';
import styles from 'styles/btnPrimarySmall.module.scss';

const PrimarySmall = ({ className, text, ...props }) => {
  return (
    <button className={`${styles.btnPrimarySmall} ${className}`} {...props}>
      {text}
    </button>
  );
};

export default PrimarySmall;
