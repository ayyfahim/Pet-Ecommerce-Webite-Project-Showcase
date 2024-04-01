import { useState } from 'react';
import Image from 'next/image';
import Link from 'next/link';
import classNames from 'classnames';

import iconMenu from 'public/img/header/icon-hamburder-menu.svg';
import logo from 'public/img/header/logo-horizontal.svg';
import cartIcon from 'public/img/header/icon-cart.svg';
import heartIcon from 'public/img/account/icons/wishlist.svg';
import crossIcon from 'public/img/header/icon-cross.svg';
import styles from 'styles/Navbar.module.css';
import { getSiteConfig } from 'atom/siteConfig.atom';
import { useRecoilValue } from 'recoil';
// import RewardsPopup from 'components/RewardsPopup';
import { categoriesAtom } from '@/app/atom/catsAtom';
import { useCartValue } from '@/app/atom/cart.atom';
import { useWishListValue } from '@/app/atom/wishlist.atom';
import { useAuthValue } from '@/app/atom/auth.atom';
import dynamic from 'next/dynamic';

import useWindowDimensions from '@/app/hooks/useWindowDimensions';
import { smartSearchBrandsAtom } from '@/app/atom/smartSearchAtom';
import { concernsAtom } from '@/app/atom/concernsAtom';

export default function Navbar() {
  const { width } = useWindowDimensions();
  const [visibility, setVisibility] = useState(false);
  const siteConfig = useRecoilValue(getSiteConfig);
  const categories = useRecoilValue(categoriesAtom);
  const brands = useRecoilValue(smartSearchBrandsAtom);
  const concerns = useRecoilValue(concernsAtom);
  const [rewardsVisible, setRewardsVisible] = useState(false);
  const [logoutVisible, setLogoutVisible] = useState(false);
  const changeVisibleRewards = (value: boolean) => () => setRewardsVisible(value);
  const changeVisibleLogout = (value: boolean) => () => setLogoutVisible(value);

  const [megaDropDownVisible, setMegaDropDownVisible] = useState(false);
  const changeVisibleMegaDropDown = (value: boolean) => () => {
    // @ts-ignore
    if (!categories?.length | !brands?.length | !concerns?.length) {
      return;
    }
    setMegaDropDownVisible(value);
  };

  const navClass = classNames({
    [`${styles.navLinks}`]: true,
  });

  const navWrapperClass = classNames({
    [`${styles.navWrapper}`]: true,
    hidden: !visibility,
  });

  const mobileLogoClass = classNames({
    [`${styles.mobileLogo}`]: true,
    hidden: !visibility,
    'xl:hidden': true,
  });

  const mobileClose = classNames({
    [`${styles.mobileClose}`]: true,
    hidden: !visibility,
    'xl:hidden': true,
  });

  const MegaDropDown = dynamic(() => import('components/MegaDropDown'), {
    ssr: false,
  });
  const RewardsPopup = dynamic(() => import('components/RewardsPopup'), {
    ssr: false,
  });
  const LogoutPopup = dynamic(() => import('components/LogoutPopup'), {
    ssr: false,
  });

  const cart = useCartValue();
  const wishlist = useWishListValue();
  const user = useAuthValue();

  // @ts-ignore
  const userName = Object.keys(user?.user)?.length ? user?.user?.full_name : '';
  const userNameToFirstLetter = userName
    ? userName
        ?.split(' ')
        ?.slice(0, 2)
        ?.map((i: any) => i.charAt(0))
        ?.toString()
        ?.toUpperCase()
        .split(',')
    : '';
  // @ts-ignore
  const totalRewardPoints = Object.keys(user?.user)?.length ? user?.user?.total_reward_points : 0;
  // @ts-ignore
  const totalRewardPointsExchange = Object.keys(user?.user)?.length ? user?.user?.total_reward_points_exchange : 0;

  return (
    <nav className={styles.nav}>
      <div className={styles.nav_body}>
        {width && width < 1280 && (
          <button className={`${styles.menuButton} flex items-center`} onClick={() => setVisibility(!visibility)}>
            <Image alt="logo" src={iconMenu} width={25} height={25} />
          </button>
        )}
        <div className={styles.logo}>
          <Link href="/">
            <a className="flex flex-col justify-center">
              <Image alt="logo" src={logo} />
            </a>
          </Link>
        </div>
        <div className={navWrapperClass}>
          {width && width < 1280 && (
            <>
              <div className={mobileClose}>
                <button className="cursor-pointer" onClick={() => setVisibility(!visibility)}>
                  <Image alt="logo" src={crossIcon} width={20} height={20} />
                </button>
              </div>

              <div className={mobileLogoClass}>
                <Image alt="logo" src={logo} width={129} height={34} />
              </div>
            </>
          )}

          <ul className={navClass}>
            <li
              onMouseEnter={changeVisibleMegaDropDown(true)}
              onMouseLeave={changeVisibleMegaDropDown(false)}
              className={styles.megaLink}
            >
              <Link href="/product-list">
                <a href="">Shop</a>
              </Link>
              {megaDropDownVisible && <MegaDropDown categories={categories} brands={brands} concerns={concerns} />}
            </li>

            <li>
              <Link href="/blogs">
                <a>Blog</a>
              </Link>
            </li>
            <li>
              <Link href="/about-us">
                <a>About Us</a>
              </Link>
            </li>
            {!Object.keys(user?.user)?.length && (
              <li>
                <Link href="/login">
                  <a>Login</a>
                </Link>
              </li>
            )}
          </ul>
          {Object.keys(user?.user)?.length ? (
            <>
              <div className="flex flex-col mt-5 xl:flex-row lg:mt-0 lg:items-center">
                <div
                  onMouseEnter={changeVisibleRewards(true)}
                  onMouseLeave={changeVisibleRewards(false)}
                  className="relative mb-16 text-center lg:mb-0 lg:px-8"
                >
                  <Link href="/account/my-rewards">
                    <a className={styles.rewards}>Rewards</a>
                  </Link>
                  {rewardsVisible && <RewardsPopup balance={totalRewardPoints} exchange={totalRewardPointsExchange} />}
                </div>
                {!!siteConfig.contactNumbers && (
                  <div className="pb-12 text-center lg:pb-0 lg:px-8">
                    <a href="" className={styles.call}>
                      {siteConfig.contactNumbers}
                    </a>
                  </div>
                )}
              </div>
            </>
          ) : (
            <></>
          )}
        </div>
        {Object.keys(user?.user)?.length ? (
          <>
            {cart?.length == 0 ? (
              <div className={`${styles.cartButtonB}`}>
                <a href="#" className={`leading-none`} data-quantity={cart?.length}>
                  <Image alt="cartButton" src={cartIcon} className="align-middle" width={24} height={24} />
                </a>
              </div>
            ) : (
              <Link href="/cart-checkout/checkout">
                <div className={`${styles.cartButton}`}>
                  <a href="/cart-checkout/checkout" className={`leading-none`} data-quantity={cart?.length}>
                    <Image alt="cartButton" src={cartIcon} className="align-middle" width={24} height={24} />
                  </a>
                </div>
              </Link>
            )}
            {wishlist?.length == 0 ? (
              <div className={`${styles.cartButtonB}  ml-4`}>
                <a href="#" className={`leading-none`} data-quantity={wishlist?.length}>
                  <Image alt="wishlistButton" src={heartIcon} className="align-middle" width={24} height={24} />
                </a>
              </div>
            ) : (
              <Link href="/account/wishlist">
                <div className={`${styles.cartButton}  ml-4`}>
                  <a href="/account/wishlist" className={`leading-none`} data-quantity={wishlist?.length}>
                    <Image alt="wishlistButton" src={heartIcon} className="align-middle" width={24} height={24} />
                  </a>
                </div>
              </Link>
            )}

            <div
              className="hidden xl:flex xl:order-4 xl:items-center xl:ml-6 cursor-pointer relative"
              onMouseEnter={changeVisibleLogout(true)}
              onMouseLeave={changeVisibleLogout(false)}
            >
              <Link href="/account/edit">
                <span className={styles.avatar}>{userNameToFirstLetter}</span>
              </Link>
              {logoutVisible && <LogoutPopup />}
            </div>
          </>
        ) : (
          <>
            {cart?.length == 0 ? (
              <div className={`${styles.cartButtonB}`}>
                <a href="#" className={`leading-none`} data-quantity={cart?.length}>
                  <Image alt="cartButton" src={cartIcon} className="align-middle" width={24} height={24} />
                </a>
              </div>
            ) : (
              <Link href="/cart-checkout/checkout">
                <div className={`${styles.cartButton}`}>
                  <a href="/cart-checkout/checkout" className={`leading-none`} data-quantity={cart?.length}>
                    <Image alt="cartButton" src={cartIcon} className="align-middle" width={24} height={24} />
                  </a>
                </div>
              </Link>
            )}

            {wishlist?.length == 0 ? (
              <div className={`${styles.cartButtonB}  ml-4`}>
                <a href="#" className={`leading-none`} data-quantity={wishlist?.length}>
                  <Image alt="wishlistButton" src={heartIcon} className="align-middle" width={24} height={24} />
                </a>
              </div>
            ) : (
              <Link href="/account/wishlist">
                <div className={`${styles.cartButton}  ml-4`}>
                  <a href="/account/wishlist" className={`leading-none`} data-quantity={wishlist?.length}>
                    <Image alt="wishlistButton" src={heartIcon} className="align-middle" width={24} height={24} />
                  </a>
                </div>
              </Link>
            )}
          </>
        )}
      </div>
    </nav>
  );
}
