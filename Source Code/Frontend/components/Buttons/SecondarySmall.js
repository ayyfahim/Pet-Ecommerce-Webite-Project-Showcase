import React from 'react';
import styles from 'styles/btnSecondarySmall.module.scss';

const SecondarySmall = ({ ...props }) => {
  return (
    <button {...props} className={`${styles.btnSecondarySmall} ${props.className}`}>
      {props.text}
    </button>
  );
};

export default SecondarySmall;
