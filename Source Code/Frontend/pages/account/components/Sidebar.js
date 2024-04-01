import styles from './Sidebar.module.scss';
import Image from 'next/image';
import Link from 'next/link';

import avatar from '@/public/img/account/avatar.png';
import classNames from 'classnames';
import { useRouter } from 'next/router';
import { useAuthValue } from '@/app/atom/auth.atom';
import { useAuthState } from 'app/atom/auth.atom';

const Sidebar = ({ ...props }) => {
  const { user } = useAuthValue();
  const { open } = props || false;
  const { width, active, sideBarMenu, setSidebarOpen } = props || null;
  const [_authState, setAuthState] = useAuthState();

  const { pathname } = useRouter();

  const sidebarClass = classNames({
    [`${styles.sidebar}`]: true,
    [`${styles.opened}`]: open && width <= 768,
  });

  if (!width) return <></>;

  if (width < 768) {
    if (!open) {
      return <></>;
    }
  }

  const logoutUser = () => {
    // console.log('worked');
    localStorage?.clear();
    setAuthState({
      token: '',
      user: {},
    });
    logout();
  };

  return (
    <div className={sidebarClass}>
      <div className={styles.accountInfo}>
        <div className={`${styles.avatarImg}`}>
          <Image src={avatar} alt="avatar" />
        </div>
        <h4>{user?.full_name}</h4>
      </div>
      <ul>
        {sideBarMenu &&
          sideBarMenu.map((item) => (
            <li className={`${pathname == item.url ? styles.active : ''} ${item.signout ? styles.signout : ''}`}>
              <div className={styles.sidebarIcon}>
                <div className={`${pathname != item.url ? 'block' : 'hidden'}`}>
                  <Image src={item.icon_url} alt="icon" width="100%" height="100%" layout="responsive" priority />
                </div>
                <div className={`${pathname == item.url ? 'block' : 'hidden'}`}>
                  <Image
                    src={item.active_icon_url}
                    alt="icon"
                    width="100%"
                    height="100%"
                    layout="responsive"
                    priority
                  />
                </div>
              </div>
              {item.url == '/account/signout' ? (
                <a
                  href={'#'}
                  onClick={(e) => {
                    e.preventDefault();
                    logoutUser();
                  }}
                >
                  {item.title}
                </a>
              ) : (
                <Link href={item.url} prefetch>
                  {item.title}
                </Link>
              )}
            </li>
          ))}
      </ul>
    </div>
  );
};

export default Sidebar;
