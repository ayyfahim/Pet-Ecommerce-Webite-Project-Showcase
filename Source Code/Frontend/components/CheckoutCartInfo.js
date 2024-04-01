import { useState } from 'react';
import styles from 'styles/cart-checkout/checkout/style.module.scss';

const CheckoutCartInfo = ({
  cartData,
  CartInfoDynamic,
  CartTotalDynamic,
  couponCode,
  setCouponCode,
  applyCouponCode,
  loading = false,
  couponInfo,
  CartSubTotalDynamic,
  totalRewardPoint,
  couponErrorMessage,
}) => {
  const [seed, setSeed] = useState(Math.random());

  const reset = () => {
    setSeed(Math.random());
  };

  return (
    <div
      id="cart_info_block"
      className={`${styles.flexRow} ${styles.mt_14} ${styles.flexWrap} ${styles.checkoutBox} ${styles.order_summary}`}
    >
      <div className={`${styles.width100}`}>
        <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter}`}>
          <h4 className={`${styles.checkoutBoxHeader} ${styles.sm_w_100} ${styles.sm_m_0}`}>Order Summary</h4>
        </div>
      </div>

      {cartData && cartData?.length == 0 ? (
        <>
          <h1>No products added to cart.</h1>
        </>
      ) : (
        cartData?.map((singleCartData, key) => <CartInfoDynamic data={singleCartData} key={key + seed} reset={reset} />)
      )}

      {cartData && cartData?.length ? (
        <>
          <div className={`${styles.width100} ${styles.mt_24} ${styles.order_item}`}>
            <div className={`${styles.flexRow} ${styles.flexWrap}`}>
              <div className={`${styles.width50} `}>
                <span className={`${styles.order_price}`}>Subtotal</span>
              </div>
              <div className={`${styles.width50} text-right`}>
                <span className={`${styles.order_price}`}>
                  $<CartTotalDynamic />
                </span>
              </div>
            </div>
            <div className={`${styles.flexRow} ${styles.flexWrap}`}>
              <div className={`${styles.width50} `}>
                <span className={`${styles.order_price}`}>Shipping</span>
              </div>
              <div className={`${styles.width50} text-right`}>
                <span className={`${styles.order_price}`}>Free</span>
              </div>
            </div>
            {couponInfo ? (
              couponInfo?.map((item) => (
                <div className={`${styles.flexRow} ${styles.flexWrap}`}>
                  <div className={`${styles.width50} `}>
                    <span className={`${styles.order_price}`}>{item?.label}</span>
                  </div>
                  <div className={`${styles.width50} text-right`}>
                    <span className={`${styles.order_price}`}>- ${Math.abs(item.amount).toFixed(2)}</span>
                  </div>
                </div>
              ))
            ) : (
              <></>
            )}
          </div>

          <div className={`border-none ${styles.width100} ${styles.mt_24} ${styles.pb_24} `}>
            <div className={`${styles.flexRow} ${styles.flexWrap}`}>
              <div className={`${styles.width50} `}>
                <span className={`${styles.order_price}`}>Total</span>
              </div>
              <div className={`${styles.width50} text-right`}>
                <span className={`${styles.order_price_total}`}>
                  $<CartSubTotalDynamic couponInfo={couponInfo || []} />
                </span>
              </div>
            </div>
          </div>

          <div className={`border-none ${styles.width100} ${styles.discount_box} ${styles.sm_text_center}`}>
            <input
              id="text"
              name="username"
              type="text"
              autoComplete="username"
              placeholder="Discount Code or Points"
              required
              className={styles.discount_input}
              value={couponCode}
              onChange={(e) => setCouponCode(e?.target?.value)}
            />
            <button
              className={styles.ContinueButton}
              onClick={(e) => {
                e?.preventDefault;
                applyCouponCode();
              }}
            >
              {`${loading ? 'Loading' : 'Apply'}`}
            </button>
            {couponErrorMessage ? <span className="mt-1 block text-sm text-pink">{couponErrorMessage}</span> : <></>}
          </div>

          <div className={styles.rewards}>
            You will earn:{' '}
            <CartSubTotalDynamic
              couponInfo={couponInfo || []}
              getRewardPoint={true}
              totalRewardPoint={totalRewardPoint}
            />{' '}
            points
          </div>
        </>
      ) : (
        <></>
      )}
    </div>
  );
};

export default CheckoutCartInfo;
