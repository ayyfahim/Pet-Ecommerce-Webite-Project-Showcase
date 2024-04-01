import React, { useLayoutEffect, useState, useEffect, useRef } from 'react';
import styles from '../../styles/product/Home.module.css';
import MainLayout from 'layouts/MainLayoutWoFooter';
import Navbar from '@/components/Navbar';
import Footer from '@/components/Footer';
import SurityPro from './components/SurityPro';
import Description from './components/Description';
import IconSection from './components/IconSection';
import ReviewSection from './components/ReviewSection';
import YouLikeSection from './components/YouLikeSection';
import FooterModal from './components/FooterModal';
import FooterBottom from '../../components/FooterBottom';
import CookieConsent from 'react-cookie-consent';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import { useRouter } from 'next/router';
import { getRequest } from 'requests/api';
import { useCartState } from '../../app/atom/cart.atom';
import { useWishListState } from '../../app/atom/wishlist.atom';
import { addToCart } from '../../features/cart/useCartService';
import { addToWishList } from '../../features/wishlist/useWishListService';
import { useAuthValue } from '@/app/atom/auth.atom';
import { toast } from 'react-toastify';
import useWindowDimensions from 'app/hooks/useWindowDimensions';
import Link from 'next/link';
import { AiOutlineCheckCircle } from 'react-icons/ai';

const Home = ({ singleProductData, variations }) => {
  const { width } = useWindowDimensions();
  const [scrollFooter, setScroll] = useState(false);
  const [footerModalActive, setFooterModalActive] = useState(false);
  const { product, related_products } = singleProductData;
  const [countState, setCount] = useState(1);
  const [cart, setCart] = useCartState();
  const [wishList, setWishList] = useWishListState();
  const user = useAuthValue();
  const [addonState, setAddonState] = useState([]);

  const cartSuccessRef = useRef(null);
  const cartSuccess = useRef(false);

  const decrease = () => {
    countState = Math.max(1, countState - 1);
    setCount(countState);
  };
  const increase = () => {
    countState = countState + 1;
    setCount(countState);
  };

  // useEffect(() => {
  //   const handleScroll = () => {
  //     let height = document.body.scrollHeight - window.innerHeight;
  //     // console.log('height', height - window.pageYOffset);
  //     if (height <= window.pageYOffset + 2100) {
  //       setScroll(true);
  //     } else if (height - window.pageYOffset > 2100) {
  //       setScroll(false);
  //     }
  //   };
  //   window.addEventListener('scroll', handleScroll, true);
  //   return () => window.removeEventListener('scroll', handleScroll, true);
  // }, []);

  const handleAddToCart = () => {
    const newCart = addToCart(cart, product, countState, addonState);
    setCart(newCart);
    setCount(1);

    cartSuccess.current = true;
    cartSuccessRef?.current?.scrollIntoView({
      behavior: 'smooth',
      // block: 'center',
    });

    // toast.clearWaitingQueue();
    // toast.success('Added to Cart.', { toastId: 'notification' });
  };

  const handleAddToWishlist = () => {
    // Redirect to Login
    if (!Object.keys(user?.user)?.length) {
      window.location = '/auth/login';
      return;
    }
    const newCart = addToWishList(wishList, product);
    setWishList(newCart);
  };

  const handleSetAddonState = (id, config) => {
    let result = addonState?.find((addonId) => addonId == id);

    let newData = [];

    if (result) {
      newData = addonState?.filter((addonId) => addonId != id);
      setAddonState([...newData]);
    } else {
      newData = addonState?.filter((addonId) => {
        let result = config?.filter((opt) => opt?.id == addonId);

        if (result?.length == 0) {
          return true;
        }
      });
      setAddonState([...newData, id]);
    }
  };

  // console.log('singleProductData', singleProductData);
  // console.log('variations::::::::::::::::::::::::::::', variations);

  return (
    <div className={styles.home}>
      <div
        ref={cartSuccessRef}
        className="flex container mx-auto"
        style={{ padding: cartSuccess?.current ? '2.5rem 20px 0 20px' : '0' }}
      >
        {cartSuccess?.current ? (
          <div
            className={`border-2 rounded-lg border-dark-green bg-dark-green bg-opacity-10 flex  items-center px-2 my-6 w-full`}
          >
            <div className={`flex justify-center items-center mx-3 my-3`}>
              <AiOutlineCheckCircle className=" text-4xl" />
            </div>
            <p className={`text-base font-bold text-medium_black`}>
              Added to Cart Successfully.{' '}
              <Link href={'/product-list'}>
                <span className="underline cursor-pointer">Continue Shopping</span>
              </Link>
              {'  '}
              or{'  '}
              <Link href={'/cart-checkout/checkout'}>
                <span className="underline cursor-pointer">Go To Checkout</span>
              </Link>
            </p>
          </div>
        ) : (
          // <span className="bg-[#51ac5c] text-base font-normal text-white p-[28px] w-full rounded-[20px] flex items-center">
          //   <AiOutlineCheckCircle className="mr-3 text-2xl" />
          //   <div>
          //     Added to Cart Successfully.{' '}
          //     <Link href={'/product-list'}>
          //       <span className="underline cursor-pointer">Continue Shopping</span>
          //     </Link>{' '}
          //     or{' '}
          //     <Link href={'/cart-checkout/checkout'}>
          //       <span className="underline cursor-pointer">Go To Checkout</span>
          //     </Link>
          //   </div>
          // </span>
          <></>
        )}
      </div>

      <SurityPro
        product={product}
        countState={countState}
        increase={increase}
        decrease={decrease}
        handleAddToCart={handleAddToCart}
        addonState={addonState}
        setAddonState={setAddonState}
        handleSetAddonState={handleSetAddonState}
        width={width}
        setScroll={setScroll}
        wishList={wishList}
        handleAddToWishlist={handleAddToWishlist}
      />
      <Description product={product} />
      <IconSection icons={product?.icons} />
      <ReviewSection />
      <YouLikeSection related_products={related_products} />
      <Footer />
      {scrollFooter && width > 1280 && (
        <FooterModal
          active={footerModalActive}
          setActive={setFooterModalActive}
          product={product}
          countState={countState}
          increase={increase}
          decrease={decrease}
          handleAddToCart={handleAddToCart}
          addonState={addonState}
          setAddonState={setAddonState}
          handleSetAddonState={handleSetAddonState}
        />
      )}
      {scrollFooter && width > 1280 && (
        <div
          className="fixed w-full bottom-0 left-0 bg-white"
          style={{
            boxShadow: scrollFooter ? '0 2px 16px 0 rgba(0, 0, 0, 0.06)' : 'none',
          }}
        >
          <FooterBottom
            setActive={setFooterModalActive}
            product={product}
            countState={countState}
            increase={increase}
            decrease={decrease}
            handleAddToCart={handleAddToCart}
          />
        </div>
      )}
    </div>
  );
};

Home.Layout = MainLayout;

// export const getServerSideProps = createGetServerSidePropsFn(Home);

export const getServerSideProps = createGetServerSidePropsFn(Home, async ({ params }) => {
  const response = await getRequest(`/products/${params?.slug}`);
  const variations = await getRequest(`/products/variations/price/${response?.product?.id}`);
  return {
    props: {
      singleProductData: response || [],
      variations: variations || [],
    },
  };
});

export default Home;
