import { useState, SetStateAction, Dispatch, createContext, useEffect } from 'react';
import { ILayout } from 'types/next.types';
import MainLayout from './MainLayout';

import { BiChevronLeft } from 'react-icons/bi';
import classNames from 'classnames';
import useWindowDimensions from 'app/hooks/useWindowDimensions';
import styles from 'styles/myAccountLayout.module.scss';
import dynamic from 'next/dynamic';
const Sidebar = dynamic(() => import('pages/account/components/Sidebar'), {
  ssr: false,
});
import useAppRouteContext from 'contexts/app.route.context';

const SideBarMenu = [
  {
    title: 'My Profile',
    url: '/account/edit',
    icon_url: '/img/account/icons/my_profile.svg',
    active_icon_url: '/img/account/icons/my_profile_active.webp',
  },
  {
    title: 'Delivery Address',
    url: '/account/delivery-address',
    icon_url: '/img/account/icons/address.svg',
    active_icon_url: '/img/account/icons/address_active.webp',
  },
  {
    title: 'My Rewards',
    url: '/account/my-rewards',
    icon_url: '/img/account/icons/myRewards.svg',
    active_icon_url: '/img/account/icons/myRewards_active.webp',
  },
  {
    title: 'My Orders',
    url: '/account/my-orders',
    icon_url: '/img/account/icons/myOrders.svg',
    active_icon_url: '/img/account/icons/myOrders_active.webp',
  },
  {
    title: 'Wishlist',
    url: '/account/wishlist',
    icon_url: '/img/account/icons/wishlist.svg',
    active_icon_url: '/img/account/icons/wishlist_active.webp',
  },
  {
    title: 'Manage Subscription',
    url: '/account/manage-subscription',
    icon_url: '/img/account/icons/subscription.svg',
    active_icon_url: '/img/account/icons/subscription_active.webp',
  },
  {
    title: 'Change Password',
    url: '/account/change-password',
    icon_url: '/img/account/icons/password.svg',
    active_icon_url: '/img/account/icons/password_active.webp',
  },
  {
    title: 'Sign-out',
    url: '/account/signout',
    icon_url: '/img/account/icons/logout.svg',
    active_icon_url: '/img/account/icons/logout_active.webp',
    signout: true,
  },
];

const MyAccountLayout: ILayout = ({ children }) => {
  const { isLoading } = useAppRouteContext();
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const { width }: any = useWindowDimensions();

  useEffect(() => {
    if (isLoading == false) {
      setSidebarOpen(false);
    }
  }, [isLoading]);

  const mainBodyClass = classNames({
    [`${styles.mainBody}`]: true,
    [`${styles.opened}`]: sidebarOpen && width <= 768,
  });

  const btnClass = classNames({
    [`${styles.backButton}`]: true,
    [`${styles.opened}`]: sidebarOpen && width <= 768,
  });

  const contentWrapperClass = classNames({
    [`${styles.contentWrapper}`]: true,
    [`${styles.opened}`]: sidebarOpen && width <= 768,
  });

  const wrapperClass = classNames({
    [`${styles.wrapper}`]: true,
    [`${styles.opened}`]: sidebarOpen && width <= 768,
  });

  return (
    <MainLayout>
      <div className={mainBodyClass}>
        <div className={wrapperClass}>
          <button
            type="button"
            className={btnClass}
            onClick={() => {
              setSidebarOpen((prev) => !prev);
            }}
          >
            <BiChevronLeft size={30} color="#525252" /> Back
          </button>
          <Sidebar sideBarMenu={SideBarMenu} open={sidebarOpen} width={width} setSidebarOpen={setSidebarOpen} />
          <div className={contentWrapperClass}>{children}</div>
        </div>
      </div>
    </MainLayout>
  );
};

export default MyAccountLayout;
