import React, { useState } from 'react';
import Image from 'next/image';
import MainLayout from 'layouts/MainLayout';
import YouLikeSection from '@/components/YouLikeSection';
import sheldImg from '@/public/img/logo/icon-40-shield.svg';
import style from 'styles/cart-checkout/cart/style.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import RewardCodeInput from './RewardCodeInput.tsx';
import { useRouter } from 'next/router';
import { useCartValue, getCartTotal, useCartState } from '../../../app/atom/cart.atom';
import { setToCart } from '../../../features/cart/useCartService';
import dynamic from 'next/dynamic';
import { useRecoilValue } from 'recoil';

const CartItem = dynamic(() => import('components/CartItems/CartItem.tsx'), { ssr: false });

const CartTotal = () => {
  const cartTotal = useRecoilValue(getCartTotal);

  return <div className={style.TotalOrder}>Order Total ${Math.abs(cartTotal).toFixed(2)}</div>;
};

const CartTotalDynamic = dynamic(() => Promise.resolve(CartTotal), { ssr: false });

const Cart = () => {
  const { push } = useRouter();
  const cartData = useCartValue();
  const [cart, setCart] = useCartState();

  return (
    <div className={style.wrapper}>
      <div className={style.cartWrapper}>
        <div className={style.cart}>
          <h1 className={style.title}>Your cart</h1>
          <div className={style.payment}>
            <div className={style.image}>
              <Image src={sheldImg} alt="sheld" className="w-10 h-10" />
            </div>
            <p className={style.description}>Safe and secure Payments. 100% Authnetic products.</p>
          </div>
          {cartData?.map((singleCartData) => (
            <CartItem data={singleCartData} subscription={false} setCart={setCart} cart={cart} setToCart={setToCart} />
          ))}
          <CartTotalDynamic />
          <div className={style.RewardAndApply}>
            <RewardCodeInput />
            <button onClick={() => push('/cart-checkout/checkout')} className={style.ContinueButton}>
              Continue to buy
            </button>
          </div>
        </div>
      </div>
      <YouLikeSection />
    </div>
  );
};

Cart.Layout = MainLayout;

export const getServerSideProps = createGetServerSidePropsFn(Cart);

export default Cart;
