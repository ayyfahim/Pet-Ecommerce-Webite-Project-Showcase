import React, { useEffect, useState } from 'react';
import MainLayout from 'layouts/MainLayout';
import style from 'styles/Recommendation.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import Link from 'next/link';
import Product from '@/components/Product';
import ProductFeatured from '@/components/ProductFeatured';
import classNames from 'classnames';
import { useRcmValue } from 'app/atom/recommendProducts.atom';
import { getRequestSwr, getRequest } from 'requests/api';
import LoadingState from '@/components/LoadingState';
import { useCartState } from '@/app/atom/cart.atom';

const Recommendation = () => {
  // const [items, _setItems] = useState([
  //   {
  //     img: '/img/HomePage/item2.png',
  //     title: '1Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews',
  //     text: 'Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews',
  //     price: '24.34',
  //     type: 'Featured',
  //     description:
  //       'From the industry leader in CBD science for pets – Recommended to support joint health and flexibility in dogs. The highest-quality CBD from broad spectrum hemp extract blended with Boswellia serrata in a smoky bacon-flavored soft chew.',
  //   },
  //   {
  //     img: '/img/HomePage/item3.png',
  //     title:
  //       'CBD Wellness Chicken And Blueberry Flavor Soft Baked Chews CBD Wellness Chicken And Blueberry Flavor Soft Baked ChewsCBD Wellness Chicken And Blueberry Flavor Soft Baked Chews',
  //     text: 'Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews',
  //     price: '25.56',
  //     type: '',
  //     description:
  //       'From the industry leader in CBD science for pets – Recommended to support joint health and flexibility in dogs. The highest-quality CBD from broad spectrum hemp extract blended with Boswellia serrata in a smoky bacon-flavored soft chew.',
  //   },
  //   {
  //     img: '/img/HomePage/item3.png',
  //     title: 'CBD Wellness Chicken And Blueberry Flavor Soft Baked Chews',
  //     text: 'Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews',
  //     price: '25.56',
  //     type: '',
  //     description:
  //       'From the industry leader in CBD science for pets – Recommended to support joint health and flexibility in dogs. The highest-quality CBD from broad spectrum hemp extract blended with Boswellia serrata in a smoky bacon-flavored soft chew.',
  //   },
  // ]);

  const [isFirstLoading, setIsFirstLoading] = useState(true);
  useEffect(() => {
    setIsFirstLoading(false);
  }, []);
  const recommendData = useRcmValue();
  // console.log('recommendData', recommendData);

  const getProducts = getRequestSwr(
    `/product_recomeendation?breed_id=${recommendData?.breedId}&age=${
      recommendData?.petAge
    }&concerns[]=${recommendData?.concern?.join('&concerns[]=')}`,
    {},
    true,
    { doNotHandleError: true }
  );
  const items = getProducts?.data?.data || [];
  const isValidating = getProducts?.isValidating || false;

  // console.log('items', items);

  const [cart, setCart] = useCartState();

  return (
    <div className={style.main}>
      {(isFirstLoading || isValidating) && <LoadingState />}
      <div className={style.wrapper}>
        <div className={style.header}>
          <span>
            <Link href={`#`}>Home / Add Pet / Recommendation</Link>
          </span>
          <h4>Great to meet {recommendData?.petName}</h4>
          <p>Based on your answers we recommend below products for Kenny</p>
        </div>

        <div className="flex flex-wrap flex-row justify-center pt-50px pb-[70px]">
          {items?.length ? (
            items.map((item, index) =>
              item.type === 'Featured' ? (
                <div
                  key={index}
                  className={classNames(style.product, {
                    [style.featured]: item.type === 'Featured',
                  })}
                >
                  <ProductFeatured item={item} classname={'hidden lg:block'} cart={cart} setCart={setCart} />
                  <Product item={item} classname={'block lg:hidden'} cart={cart} setCart={setCart} />
                </div>
              ) : (
                <div key={index} className={style.product}>
                  <Product item={item} cart={cart} setCart={setCart} />
                </div>
              )
            )
          ) : (
            <h4>No products found.</h4>
          )}
        </div>
      </div>
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Recommendation);

Recommendation.Layout = MainLayout;

export default Recommendation;
