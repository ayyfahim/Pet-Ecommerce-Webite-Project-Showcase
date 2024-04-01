import React, { useEffect, useState } from 'react';

import styles from 'styles/cart-checkout/checkout/success/style.module.scss';
import sheldImg from '@/public/img/logo/icon-40-shield.svg';
import Image from 'next/image';
import CartItemPreview from '@/components/CartItems/images/cartItemPreview.png';
import MainLayout from 'layouts/MainLayout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import crown from 'public/img/cart-checkout/crown.svg';
import Link from 'next/link';
import { useRouter } from 'next/router';
import LoadingState from '@/components/LoadingState';
import formatAddress from '@/shared/formatAddress';
import { useAuthValue } from '@/app/atom/auth.atom';

const Checkout = () => {
  const user = useAuthValue();

  const [order, setOrder] = useState(null);
  const [orderUser, setOrderUser] = useState(null);
  const [recentlyViewed, setRecentlyViewed] = useState(null);
  const [points, setPoints] = useState(0);
  const [isLoading, setIsLoading] = useState(true);

  // @ts-ignore
  const token = Object.keys(user?.user)?.length ? user?.token : '';

  useEffect(() => {
    if (localStorage.getItem('order_success_data')) {
      try {
        const data = JSON.parse(localStorage.getItem('order_success_data'));
        if (data?.constructor?.name !== 'Object' || !data || data == null) {
          localStorage.removeItem('order_success_data');
          window.location = '/';
        }
        setOrder(data?.order);
        setOrderUser(data?.user);
        setRecentlyViewed(data?.recently_viewed);
        setPoints(data?.points);
        setIsLoading(false);
      } catch (error) {
        localStorage.removeItem('order_success_data');
        window.location = '/';
      }
    } else {
      try {
        localStorage.removeItem('order_success_data');
      } catch (e) {}

      window.location = '/';
    }
  }, []);

  const router = useRouter();

  const redirectContinueShopping = (e) => {
    e?.preventDefault();
    router?.push('/product-list');
  };

  return isLoading ? (
    <LoadingState />
  ) : (
    <div className={styles.mainBody}>
      <div className={styles.wrapper}>
        <div className={`${styles.width60} ${styles.md_w_100} pr-0 lg:pr-[64px]`}>
          <div>
            <div className={`${styles.flexRow} ${styles.mt_14} ${styles.flexWrap} ${styles.checkoutBox}`}>
              <div className={`${styles.width100}`}>
                <form className="" action="/" method="POST">
                  <div className="">
                    <div className={`${styles.reward_box}`}>
                      <h4 className={`${styles.checkoutBoxHeader2} ${styles.sm_m_0}`}>
                        Thank you {`${orderUser?.full_name}`}!
                      </h4>
                      <h4 className={`${styles.checkoutBoxHeader3}`}>
                        Your earned <b>{points || 0}</b> rewards points on this order
                      </h4>
                      <p className={`${styles.order_desc}`}>
                        We’ll email you an order confirmation with the details and tracking info.
                      </p>
                      <div className={`mt-[24px]`}>
                        <button className={`${styles.ContinueButton}`} onClick={(e) => redirectContinueShopping(e)}>
                          Continue shopping
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div>
            <div className={`${styles.flexRow} ${styles.mt_14} ${styles.flexWrap} ${styles.checkoutBox}`}>
              <div className={`${styles.width100}`}>
                <form className="" action="/" method="POST">
                  <div className={`${styles.order_summary2}`}>
                    <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter}`}>
                      <h4 className={`${styles.checkoutBoxHeader} ${styles.sm_w_100} ${styles.sm_m_0}`}>
                        Your Details
                      </h4>
                    </div>

                    <div
                      className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} ${styles.mt_24} ${styles.order_totals}`}
                    >
                      <div>
                        Order <b>{`#${order?.short_id}`}</b>
                      </div>
                      <div>
                        Total <b>${`${Math.abs(order?.totals?.total).toFixed(2)}`}</b>
                      </div>
                    </div>

                    <div
                      className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} ${styles.mt_24} ${styles.total_items}`}
                    >
                      <div>
                        Total items <br /> <b>{`${order?.products?.length ?? 0}`}</b>
                      </div>
                      <div>
                        Payment <br /> <b>Paid</b>
                      </div>
                      <div>
                        Rewards <br /> <b>{points || 0.0}</b>
                      </div>
                    </div>

                    <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} ${styles.order_items}`}>
                      {order?.products?.map(({ product, quantity }) => (
                        <div className={`${styles.order_img}`} data-quantity={quantity ?? 1}>
                          <div className={`${styles.order_img_inner}`} data-quantity={quantity ?? 1}>
                            <Image src={product?.cover} alt="arrow down" layout="fill" />
                          </div>
                        </div>
                      ))}
                    </div>

                    <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} mt-[16px]`}>
                      <button
                        className={`${styles.download_invoice_btn}`}
                        onClick={(e) => {
                          e.preventDefault();
                          window.open(`${order?.invoice_link}?token=${token}`, '_blank');
                        }}
                      >
                        Download Invoice
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div>
            <div className={`${styles.flexRow} ${styles.mt_14} ${styles.flexWrap} ${styles.checkoutBox}`}>
              <div className={`${styles.width100}`}>
                <form className="" action="/" method="POST">
                  <div className={`${styles.show_delivery_address}`}>
                    <div
                      className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} ${styles.show_delivery_address_box}`}
                    >
                      <h4 className={`${styles.checkoutBoxHeader} ${styles.sm_w_100} ${styles.sm_m_0}`}>
                        Delivery address
                      </h4>
                      <div className={`${styles.delivery_info}`}>
                        <b>{order?.address?.name ?? orderUser?.full_name},</b> {formatAddress(order?.address)}
                      </div>
                    </div>
                    <div
                      className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} ${styles.show_delivery_address_accountInfo}`}
                    >
                      <div>
                        <h4 className={`${styles.checkoutBoxHeader} ${styles.sm_w_100} ${styles.sm_m_0}`}>
                          Account information
                        </h4>
                      </div>
                      <div className={`${styles.show_delivery_address_accountInfo2}`}>
                        <div>Full Name:</div>
                        <div>{order?.address?.name ?? orderUser?.full_name}</div>
                      </div>
                      <div className={`${styles.show_delivery_address_accountInfo2}`}>
                        <div>Email:</div>
                        <div>{order?.address?.email ?? orderUser?.email}</div>
                      </div>
                      <div className={`${styles.show_delivery_address_accountInfo2}`}>
                        <div>Phone:</div>
                        <div>{order?.address?.phone ?? orderUser?.phone}</div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        {/* <div className={`${styles.width10} ${styles.md_w_100}`}></div> */}

        <div className={`${styles.width40} ${styles.md_w_100}`}>
          <div
            className={`${styles.flexRow} ${styles.mt_14} ${styles.flexWrap} ${styles.checkoutBox} ${styles.order_summary} ${styles.product_interested}`}
          >
            <div className={`${styles.width100}`}>
              <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter}`}>
                <h4 className={`${styles.checkoutBoxHeader} ${styles.sm_w_100} ${styles.sm_m_0}`}>
                  You may be intrested in
                </h4>
              </div>
            </div>

            {recentlyViewed?.map((product) => (
              <div
                className={`${styles.width100} ${styles.mt_24} ${styles.order_item} cursor-pointer`}
                onClick={() => router?.push(`/product/${product?.slug}`)}
              >
                <div className={`${styles.flexRow} ${styles.flexWrap}`}>
                  <div className={`${styles.width20} ${styles.sm_w_100} ${styles.sm_text_center} pr-4`}>
                    <Image src={product?.cover} alt="arrow down" width={82} height={82} />
                  </div>
                  <div className={`${styles.width80} ${styles.sm_w_100} ${styles.sm_text_center} flex-0`}>
                    <h4 className={`${styles.order_title}`}>{product?.title}</h4>
                    <span className={`${styles.order_desc}`}>{product?.excerpt}</span>

                    <div className={`${styles.price_addToCart}`}>
                      <div>
                        <span className={`${styles.order_price} text-right`}>${product?.sale_price}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

Checkout.Layout = MainLayout;

export const getServerSideProps = createGetServerSidePropsFn(Checkout);

export default Checkout;

// export default Checkout;
