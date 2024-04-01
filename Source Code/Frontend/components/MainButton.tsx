import React, { FC, MouseEventHandler, ReactNode } from 'react';
import styles from 'styles/MainButton.module.css';
import classnames from 'classnames';

interface PropsMainButton {
  children: ReactNode;
  rounded?: boolean;
  style?: object;
  onClick?: MouseEventHandler<HTMLButtonElement>;
  reversed?: boolean;
  big?: boolean;
  classButton?: string | number | symbol | any;
}

const MainButton: FC<PropsMainButton> = ({ children, rounded, style, onClick, reversed, big, classButton }) => {
  return (
    <button
      onClick={onClick ? onClick : undefined}
      style={style ? style : {}}
      className={classnames(styles.mainButton, {
        [styles.rounded]: rounded,
        [styles.reversed]: reversed,
        [styles.big]: big,
        [classButton]: classButton,
      })}
    >
      {children}
    </button>
  );
};

export default MainButton;
