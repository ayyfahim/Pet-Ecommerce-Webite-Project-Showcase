import Link from 'next/link';
import React from 'react';
import styles from 'styles/RewardsPopup.module.css';
import { useAuthState } from 'app/atom/auth.atom';

const LogoutPopup = () => {
  const [_authState, setAuthState] = useAuthState();

  const logoutUser = () => {
    // console.log('worked');
    localStorage?.clear();
    setAuthState({
      token: '',
      user: {},
    });
    // @ts-ignore
    logout();
  };

  return (
    <div className={styles.rewardsPopup}>
      <div className={`${styles.cnt} !min-w-[130px]`}>
        <div className="flex justify-center">
          <p className={`${styles.title} !text-center`}>
            <Link href="/account/edit">
              <a
                className={`${styles.history} !mb-0 !mt-0`}
                style={{ display: 'block' }}
                onClick={(e) => {
                  e.preventDefault();
                  logoutUser();
                }}
              >
                Logout
              </a>
            </Link>
          </p>
        </div>
      </div>
    </div>
  );
};

export default LogoutPopup;
