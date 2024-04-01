import styles from 'styles/cart-checkout/checkout/style.module.scss';
import sheldImg from '@/public/img/logo/icon-40-shield.svg';
import { useEffect, useMemo, useState } from 'react';
import Image from 'next/image';
import { Disclosure } from '@headlessui/react';

import { Elements, PaymentElement, useStripe, useElements } from '@stripe/react-stripe-js';
import { loadStripe } from '@stripe/stripe-js';
import { toast } from 'react-toastify';
import { useRecoilValue } from 'recoil';
import { getCartTotal } from '../app/atom/cart.atom';
import { getEnv } from '@/bootstrap/app.config';

const CheckoutPayment = ({
  CartTotalDynamic,
  paymentMethod,
  setPaymentMethod,
  postRequest,
  handlePaymentButton,
  checkoutData: { email, fullName },
  clientSecret,
  setClientSecret,
  loading = false,
  setIsLoading,
  couponInfo,
}) => {
  // const [clientSecret, setClientSecret] = useState('');
  const [stripePromiseKey, setstripePromiseKey] = useState(null);
  const [seed, setSeed] = useState(1);
  const Total = useRecoilValue(getCartTotal);

  useEffect(() => {
    const stripePromise = loadStripe(getEnv('stripeKey', 'test'));
    setstripePromiseKey(stripePromise);
  }, []);

  useEffect(() => {
    createPaymentIntent();
  }, [Total]);

  const createPaymentIntent = () => {
    if (loading) {
      return;
    }
    setIsLoading(true);
    postRequest(`/create-payment-intent`, { total: Total }).then((data) => {
      setIsLoading(false);
      setClientSecret(data?.client_secret);
    });
    reset();
  };

  const options = useMemo(() => {
    return {
      appearance: {
        theme: 'stripe',
      },
      clientSecret,
    };
  }, [clientSecret]);

  const handleDisclosure = (open, method) => {
    // console.log('method', method, open);
    if (open) {
      setPaymentMethod(method);
    } else if (!open && paymentMethod == method) {
      setPaymentMethod(null);
    }
  };

  const handlePayment = async (e) => {
    if (loading) {
      return;
    }
    setIsLoading(true);
    e?.preventDefault();
    switch (paymentMethod) {
      case 'stripe':
        if (!stripe || !elements) {
          // Stripe.js has not yet loaded.
          // Make sure to disable form submission until Stripe.js has loaded.
          setIsLoading(false);
          return;
        }
        const result = await stripe?.confirmPayment({
          elements,
          confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: 'http://stage.vitalpawz.com/cart-checkout/checkout',
            payment_method_data: {
              billing_details: {
                name: fullName,
                email: email,
              },
            },
          },
          redirect: 'if_required',
        });

        if (result && result?.error) {
          toast.clearWaitingQueue();
          toast.error(result?.error?.message, { toastId: 'notification' });
          createPaymentIntent();
        } else {
          // console.log('result?.paymentIntent?.id', result?.paymentIntent?.id, result);
          handlePaymentButton('card', result?.paymentIntent?.id).catch(() => createPaymentIntent());
        }
        break;

      default:
        break;
    }
  };

  let stripe;
  let elements;

  const loadStripeAndElements = () => {
    stripe = useStripe();
    elements = useElements();
  };

  const reset = () => {
    setSeed(Math.random());
  };

  useEffect(() => {
    handleDisclosure(true, 'stripe');
  }, []);

  return (
    <div className={`${styles.flexRow} ${styles.mt_14} ${styles.flexWrap} ${styles.checkoutBox}`}>
      <div className={`${styles.width100}`}>
        <form className="" action="/" method="POST">
          <div className="">
            <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter}`}>
              <h4 className={`${styles.width100} ${styles.checkoutBoxHeader} ${styles.sm_w_100} ${styles.sm_m_0}`}>
                Select Payment Type
              </h4>
            </div>

            <div className={styles.payment}>
              <div className={styles.image}>
                <Image src={sheldImg} alt="sheld" className="w-10 h-10" />
              </div>
              <p className={styles.description}>Safe and secure Payments.</p>
            </div>

            <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} ${styles.mt_24}`}>
              <div className={`${styles.width100}`}>
                <Disclosure className={`${styles.width100} text-left`} defaultOpen={true}>
                  {({ open }) => (
                    <Disclosure.Button onClick={() => () => handleDisclosure(open, 'stripe')}>
                      <div className={`${styles.payment_method_box} ${open ? styles.payment_method_box_active : ''}`}>
                        <h4>Credit or Debit Card</h4>
                        {clientSecret && typeof options?.clientSecret == 'string' && !!options?.clientSecret && (
                          <Elements options={options} stripe={stripePromiseKey} key={seed}>
                            <Disclosure.Panel>
                              {({ close }) =>
                                paymentMethod && paymentMethod !== 'stripe' ? (
                                  close()
                                ) : (
                                  <>
                                    {loadStripeAndElements()}
                                    <div className={`${styles.width100} ${styles.mt_14}`}>
                                      <div className="payment_blk_in">
                                        <PaymentElement id="payment-element" />
                                      </div>
                                    </div>
                                  </>
                                )
                              }
                            </Disclosure.Panel>
                          </Elements>
                        )}
                      </div>
                    </Disclosure.Button>
                  )}
                </Disclosure>
              </div>

              <div className={`${styles.width100}`}>
                <Disclosure className={`${styles.width100} text-left mt-[14px]`}>
                  {({ open }) => (
                    <Disclosure.Button onClick={() => handleDisclosure(open, 'paypal')}>
                      <div className={`${styles.payment_method_box} ${open ? styles.payment_method_box_active : ''}`}>
                        <h4>Paypal</h4>
                        <Disclosure.Panel>
                          {({ close }) =>
                            paymentMethod && paymentMethod !== 'paypal' ? (
                              close()
                            ) : (
                              <div className={`${styles.width100} ${styles.mt_14}`}>
                                <label htmlFor="username" className={styles.formLabel}>
                                  Paypal
                                </label>
                                <div>
                                  <input
                                    id="text"
                                    name="username"
                                    type="text"
                                    autoComplete="username"
                                    placeholder="Number"
                                    required
                                    className={styles.formInput}
                                  />
                                </div>
                              </div>
                            )
                          }
                        </Disclosure.Panel>
                      </div>
                    </Disclosure.Button>
                  )}
                </Disclosure>
              </div>
            </div>

            <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} ${styles.mt_24}`}>
              <div className={`${styles.TotalOrder} ${styles.width50} ${styles.md_w_100}`}>
                Order Total $<CartTotalDynamic couponInfo={couponInfo || []} />
              </div>
              <div
                className={`${styles.width50} ${styles.text_right} ${styles.md_w_100} ${styles.md_text_left} ${styles.sm_text_center}`}
              >
                <button
                  className={`${styles.ContinueButton} ${styles.md_mt_12} ${styles.sm_text_center}`}
                  onClick={async (e) => await handlePayment(e)}
                  disabled={loading}
                >
                  {`${loading ? 'Loading' : 'Pay & Continue'}`}
                </button>
              </div>
            </div>

            <span className={styles.urlText3}>
              By clicking on Pay & Confirm you agree to VitalPawz T&C and Privacy Policy.
            </span>
          </div>
        </form>
      </div>
    </div>
  );
};

export default CheckoutPayment;
