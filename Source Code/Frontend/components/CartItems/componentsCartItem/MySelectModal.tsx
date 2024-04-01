import React, { FC } from 'react';
import exit from 'components/CartItems/images/X.png';
import Image from 'next/image';

interface IMySelectModalProps {
  active: boolean;
  setActive: (state: boolean) => void;
  children: any;
}

const MySelectModal: FC<IMySelectModalProps> = ({ active, setActive, children }) => {
  return (
    <div className={active ? 'modal active' : 'modal'} onClick={() => setActive(false)}>
      <div className={active ? 'modal__content active' : 'modal__content'} onClick={(e) => e.stopPropagation()}>
        <div className="exit">
          <Image onClick={() => setActive(false)} src={exit} alt="qwe" />
        </div>
        {children}
      </div>
    </div>
  );
};

export default MySelectModal;
