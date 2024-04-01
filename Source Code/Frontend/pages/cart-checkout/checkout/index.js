import React, { useState, useRef, useEffect, useCallback, useMemo, Fragment } from 'react';

import styles from 'styles/cart-checkout/checkout/style.module.scss';
import sheldImg from '@/public/img/logo/icon-40-shield.svg';
import Image from 'next/image';
import CartItemPreview from '@/components/CartItems/images/cartItemPreview.png';
import MainLayout from 'layouts/MainLayout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import Link from 'next/link';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import { useCartValue, getCartTotal, useCartState } from '../../../app/atom/cart.atom';
import dynamic from 'next/dynamic';
import { useRecoilValue } from 'recoil';
import { postRequest, getRequestSwr, getRequest } from 'requests/api';
import { geocodeByPlaceId } from 'react-google-places-autocomplete';
import useAuthService from 'features/auth/hooks/useAuthService';
import { useAuthValue } from '@/app/atom/auth.atom';
import { toast } from 'react-toastify';
import { useRouter } from 'next/router';
import LoadingState from '@/components/LoadingState';
import MySelect from '@/components/CartItems/componentsCartItem/MySelect';
import { addToCart, setToCart, deleteItemFromCart } from '@/features/cart/useCartService';

import { IoMdWarning } from 'react-icons/io';
import { RiFileEditFill, RiDeleteBin5Fill } from 'react-icons/ri';
import { mutate } from 'swr';
import { Dialog, Transition } from '@headlessui/react';
import surityProStyles from '@/styles/product/SurityPro.module.css';

const _CartInfo = ({ data: { product, options, quantity }, reset }) => {
  const [cart, setCart] = useCartState();
  const cartData = useCartValue();
  const getCartData = cartData?.find((item) => item?.id == product?.id);
  const getCartDataOptions = getCartData?.options;
  const getAddonState = () => {
    let mainArr = [];
    if (product?.configurations) {
      product?.configurations?.map((opt, index) => {
        let newArr = [];
        opt?.options?.map((val) => {
          const newArrObj = { value: val?.value, label: val?.id, config: opt };
          if (getCartDataOptions?.includes(val?.id) && !addonState?.some((addon) => addon?.label == val?.id)) {
            newArr = [...newArr, newArrObj];
          }
        });

        mainArr = [...mainArr, ...newArr];
      });
    }
    return mainArr;
  };

  const getProdOptions = () => {
    let mainArr = [];
    if (product?.configurations) {
      product?.configurations?.map((opt, index) => {
        let newArr = [];

        opt?.options?.map((val) => {
          // const newArrObj = { value: val?.value, label: val?.id, config: opt };
          // val?.map((i) => (newArr = [...newArr, val]));
          mainArr = [...mainArr, val];
        });

        // mainArr = [...mainArr, newArr];
      });
    }
    return mainArr;
  };

  const [addonState, setAddonState] = useState(options || []);
  const [productOptions, _setProductOptions] = useState(getProdOptions() || []);
  const [moreAddonState, setMoreAddonState] = useState([]);
  const [showCustomization, setShowCustomization] = useState(false);

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

  const handleAddToCart = () => {
    // let options = [];
    // addonState?.map((addon) => {
    //   options = [...options, addon?.label];
    // });
    const newCart = setToCart(cart, product?.id, quantity, addonState);
    setCart(newCart);

    let mainArr = [];
    if (product?.configurations) {
      product?.configurations?.map((opt, index) => {
        let newArr = [];

        opt?.options?.map((val) => {
          if (addonState?.includes(val?.id)) {
            mainArr = [...mainArr, { label: opt?.label, value: val?.value }];
          }
        });
      });
    }
    setMoreAddonState(mainArr);
  };

  useEffect(() => {
    handleAddToCart();
  }, [addonState]);

  const deleteItem = () => {
    const newCart = deleteItemFromCart(cart, product?.id);
    setCart(newCart);
    reset();
  };

  return (
    <div className={`${styles.width100} ${styles.mt_24} ${styles.order_item}`}>
      <div className={`${styles.flexRow} ${styles.flexWrap}`}>
        <div
          data-quantity={quantity ?? 1}
          className={`${styles.width20} ${styles.order_img} ${styles.sm_w_100} ${styles.sm_text_center} flex-0`}
        >
          <Image src={product?.cover} alt="arrow down" width={88} height={88} />
        </div>
        <div className={`${styles.width50} ${styles.sm_w_100} ${styles.sm_text_center} flex-0`}>
          <h4 className={`${styles.order_title}`}>{product?.title}</h4>
          <span className={`${styles.order_desc}`}>
            {moreAddonState?.map(
              (addon, index, array) => `${addon?.label}: ${addon?.value}${index !== array.length - 1 ? ', ' : ''}`
            )}
          </span>
          {product?.configurations && addonState?.length != product?.configurations?.length ? (
            <span
              className="w-full flex items-center text-sm text-pink cursor-pointer"
              onClick={() => setShowCustomization((prev) => !prev)}
            >
              <IoMdWarning className="mr-1" />
              Please select all options!
            </span>
          ) : (
            <></>
          )}
          <div className="w-full flex items-center text-base cursor-pointer mt-2 text-[#6b6b6b]">
            {product?.configurations?.length ? (
              showCustomization ? (
                <RiFileEditFill
                  className={`mr-1 text-dark-green`}
                  onClick={() => setShowCustomization((prev) => !prev)}
                />
              ) : (
                <RiFileEditFill
                  className={`mr-1 text-dark-green`}
                  onClick={() => setShowCustomization((prev) => !prev)}
                />
              )
            ) : (
              <></>
            )}
            <RiDeleteBin5Fill className="text-pink" onClick={() => deleteItem()} />
          </div>
        </div>
        <div className={`${styles.width20} ${styles.sm_w_100} ${styles.sm_text_center} text-right flex-0`}>
          <span className={`${styles.order_price} text-right`}>${Math.abs(product?.sale_price).toFixed(2)}</span>
        </div>
        <Transition appear show={showCustomization} as={Fragment}>
          <Dialog
            as="div"
            className="fixed inset-0 z-[35] overflow-y-auto"
            onClose={() => setShowCustomization(false)}
            open={showCustomization}
          >
            <div className="fixed inset-0 bg-black/30 z-[35]" aria-hidden="true" />
            <div className="min-h-screen px-4 text-center">
              <Transition.Child
                as={Fragment}
                enter="ease-out duration-300"
                enterFrom="opacity-0"
                enterTo="opacity-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100"
                leaveTo="opacity-0"
              >
                <Dialog.Overlay className="fixed inset-0" />
              </Transition.Child>

              {/* This element is to trick the browser into centering the modal contents. */}
              <span className="inline-block h-screen align-middle" aria-hidden="true">
                &#8203;
              </span>
              <Transition.Child
                as={Fragment}
                enter="ease-out duration-300"
                enterFrom="opacity-0 scale-95"
                enterTo="opacity-100 scale-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100 scale-100"
                leaveTo="opacity-0 scale-95"
              >
                <div className="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl z-[40] relative">
                  <Dialog.Title as="h3" className="text-lg font-medium leading-6 text-gray-900">
                    Select All Options
                  </Dialog.Title>
                  <div className="mt-2">
                    {product?.configurations?.map((config) => (
                      <>
                        <div className={surityProStyles.packSize}>{config?.label}</div>
                        <div className={surityProStyles.packField}>
                          {config?.options?.map((opt, index) => (
                            <div
                              onClick={() => handleSetAddonState(opt?.id, config?.options)}
                              className={`${
                                addonState?.includes(opt?.id)
                                  ? `${surityProStyles.pack_active_border}`
                                  : `${surityProStyles.pack_border}`
                              } ${index !== 0 ? 'ml-3' : ''}`}
                            >
                              <span
                                className={`${
                                  addonState?.includes(opt?.id)
                                    ? surityProStyles.active_smallFont
                                    : surityProStyles.smallFont
                                }`}
                              >
                                {opt?.value}
                              </span>
                            </div>
                          ))}
                        </div>
                      </>
                    ))}
                  </div>

                  <div className="mt-4">
                    <button
                      type="button"
                      className="inline-flex justify-center px-4 py-2 text-sm text-red-900 bg-red-100 border border-transparent rounded-md hover:bg-red-200 duration-300"
                      onClick={() => setShowCustomization(false)}
                    >
                      Close
                    </button>
                  </div>
                </div>
              </Transition.Child>
            </div>
          </Dialog>
        </Transition>
      </div>
    </div>
  );
};

const CartTotal = () => {
  const cartTotal = useRecoilValue(getCartTotal);

  return Math.abs(cartTotal).toFixed(2);
};

const CartSubTotal = ({ couponInfo = [], getRewardPoint = false, totalRewardPoint = null }) => {
  const cartTotal = useRecoilValue(getCartTotal);
  let cartSubTotal = Math.abs(cartTotal).toFixed(2);

  if (couponInfo?.length) {
    couponInfo.forEach((element) => {
      cartSubTotal = cartSubTotal - Math.abs(element?.amount).toFixed(2);
    });
  }
  if (getRewardPoint && totalRewardPoint !== null) {
    return cartSubTotal < 0 ? 0 : cartSubTotal * totalRewardPoint;
  }
  // const cartSubTotal = Math.abs(cartTotal).toFixed(2) - Math.abs(couponAmount).toFixed(2);=

  return cartSubTotal < 0 ? Math.abs(0).toFixed(2) : Math.abs(cartSubTotal).toFixed(2);
};

const CartInfoDynamic = dynamic(() => Promise.resolve(_CartInfo), { ssr: false });
const CartTotalDynamic = dynamic(() => Promise.resolve(CartTotal), { ssr: false });
const CartSubTotalDynamic = dynamic(() => Promise.resolve(CartSubTotal), { ssr: false });

const CustomerDetailsDynamic = dynamic(() => import('./components/CustomerDetails'), { ssr: false });
const CustomerDetails = React.memo(CustomerDetailsDynamic);
const DeliveryAddressDynamic = dynamic(() => import('./components/DeliveryAddress'), { ssr: false });
const DeliveryAddress = React.memo(DeliveryAddressDynamic);

const PaymentDynamic = dynamic(() => import('components/CheckoutPayment'), { ssr: false });
const Payment = React.memo(PaymentDynamic);

const CartInfosDynamic = dynamic(() => import('components/CheckoutCartInfo'), { ssr: false });
const CartInfo = React.memo(CartInfosDynamic);

const Checkout = ({ totalRewardPoint }) => {
  const router = useRouter();
  const setAuth = useAuthService();
  const authUser = useAuthValue();
  const { user, token } = authUser;
  const [isLoading, setIsLoading] = useState(false);
  const [isLoadingAddress, setIsLoadingAddress] = useState(false);
  const [isFirstLoading, setIsFirstLoading] = useState(true);
  const [checkoutData, setCheckoutData] = useState({
    fullName: user ? user?.full_name : '',
    mobileNumber: user ? user?.mobile : '',
    email: user ? user?.email : '',
    updateOffersChecked: false,
    selectedDeliveryAddressId: null,
  });
  const [checkoutErrors, setCheckoutErrors] = useState([]);
  const [paymentMethod, setPaymentMethod] = useState(null);
  const [deliveryAdresses, setDeliveryAdresses] = useState(null);
  const [geoAddressValue, setGeoAddressValue] = useState(null);
  const [couponCode, setCouponCode] = useState('');
  const [couponErrorMessage, setCouponErrorMessage] = useState('');
  const [couponInfo, setCouponInfo] = useState([]);
  const [clientSecret, setClientSecret] = useState('');

  const handleCheckoutData = useCallback(
    (event) => {
      if (isLoading || isLoadingAddress) return;
      const { name, value, type } = event.target;
      setCheckoutData(() => {
        return {
          ...checkoutData,
          [name]: type == 'checkbox' ? event?.target?.checked : value,
        };
      });
    },
    [checkoutData, isLoading, isLoadingAddress]
  );

  const cartData = useCartValue();
  const [cart, setCart] = useCartState();

  const handlePaymentButton = async (p_type = 'card', paymentIntentId) => {
    if (isLoading || isLoadingAddress) {
      return;
    }
    setIsLoading(true);
    await postRequest('/orders/pay', {
      code: couponCode,
      products: cartData?.map((data) => {
        return { ...data?.product, quantity: data?.quantity, options: data?.options };
      }),

      email: checkoutData?.email,
      full_name: checkoutData?.fullName,
      mobile: checkoutData?.mobileNumber,

      address_info_id: deliveryAdresses,
      payment_type: p_type,

      clientSecret: paymentIntentId,
    })
      .then(({ data }) => {
        setIsLoading(false);
        toast.clearWaitingQueue();
        toast.success('Order placed successfully!', { toastId: 'notification' });
        if (localStorage.getItem('order_success_data')) {
          localStorage.removeItem('order_success_data');
          // return;
        }
        localStorage.setItem('order_success_data', JSON.stringify(data));
        setCart([]);
        setAuth(authUser?.token || '', data?.user || {}, false);
        window.location = '/cart-checkout/checkout/success';
        return Promise.resolve();
      })
      .catch(({ error }) => {
        if (error?.response?.data) {
          setCheckoutErrors(error?.response?.data?.errors || []);
        }
        setIsLoading(false);
        return Promise.reject();
      });
  };

  useEffect(() => {
    setIsFirstLoading(false);

    // if (cartData && cartData?.length == 0) {
    //   router.push('/product-list');
    // }
  }, []);

  const getAllAddress = getRequestSwr(!isFirstLoading ? `/address` : null, {}, true, { doNotHandleError: true });
  const addresses = (getAllAddress && getAllAddress?.data?.data) || [];
  let isValidating = getAllAddress?.isValidating;
  // let addressMutate = mutate('/address');

  // useEffect(() => {
  //   if (isLoading !== isValidating) {
  //     setIsLoading(isValidating);
  //   }
  // }, [isValidating]);

  const applyCouponCode = async () => {
    if (isLoading || isLoadingAddress) {
      return;
    }
    // setIsLoading(true);
    await postRequest(
      '/cart/apply/coupon',
      {
        code: couponCode,
        products: cartData?.map((data) => {
          return { ...data?.product, quantity: data?.quantity, options: data?.options };
        }),
      },
      { doNotHandleError: true }
    )
      .then(({ cart }) => {
        // console.log('cart', cart);
        setIsLoading(false);
        setCouponInfo(cart?.totals?.discounts);
        setCouponErrorMessage('');
        // toast.clearWaitingQueue();
        // toast.success('Coupon added successfully!', { toastId: 'notification' });
        return;
      })
      .catch(({ error }) => {
        setCouponCode('');
        setCouponErrorMessage(error?.response?.data?.message);
        setIsLoading(false);
      });
  };

  const handleDeliveryAddress = async (val, addressName = null) => {
    if (isLoadingAddress) {
      return;
    }
    let regiterUser;
    setIsLoadingAddress(true);
    if (!token) {
      regiterUser = await createOrderTemporary();
    } else {
      regiterUser = token;
    }

    if (regiterUser && val) {
      setGeoAddressValue(val);
      const geoCodeObj = val && val.value && (await geocodeByPlaceId(val.value.place_id));

      let addressObject =
        geoCodeObj && getAddressObject(geoCodeObj[0].formatted_address, geoCodeObj[0].address_components);

      if (checkoutData?.email) {
        addressObject.email = checkoutData?.email;
      }
      if (checkoutData?.fullName) {
        addressObject.name = addressName ? addressName : checkoutData?.fullName;
      }
      if (checkoutData?.mobileNumber) {
        addressObject.phone = checkoutData?.mobileNumber;
      }
      if (addressObject?.street_address === '') {
        delete addressObject?.street_address;
      }

      addressObject.place_id = val?.value?.place_id;

      postRequest('/address', addressObject, { doNotHandleError: true })
        .then((res) => {
          let address_info_id = res?.data?.address_info_id;
          setDeliveryAdresses(address_info_id);
          setGeoAddressValue(null);
          mutate('/address');
          setIsLoadingAddress(false);
          // toast.clearWaitingQueue();
          // toast.success('Address added successfully!', { toastId: 'notification' });
        })
        .catch(({ error }) => {
          setIsLoadingAddress(false);
          setGeoAddressValue(null);
          mutate('/address');
          if (error?.response?.data) {
            setCheckoutErrors(error?.response?.data?.errors || []);
          }
          toast.clearWaitingQueue();
          toast.error('Something went wrong. Try again!', { toastId: 'notification' });
        });
    }
  };

  const createOrderTemporary = async () => {
    return await postRequest(
      '/auth/register/cart',
      {
        email: checkoutData?.email,
        full_name: checkoutData?.fullName,
        mobile: checkoutData?.mobileNumber,
        products: cartData,
      },
      { doNotHandleError: true }
    )
      .then(({ data: { user, token } }) => {
        setAuth(token, user, false);
        setCheckoutErrors([]);
        return token;
      })
      .catch(({ error }) => {
        setGeoAddressValue(null);
        if (error?.response?.data) {
          setCheckoutErrors(error?.response?.data?.errors || []);
        }
        setIsLoading(false);
        return false;
      });
  };

  const onKeyPress = (event) => {
    const { name } = event.target;
    var code = event.keyCode || event.which;
    if (code === 9 || code === 13) {
      createOrderTemporary();
    }
  };

  const getAddressObject = (formattedAddress, address_components) => {
    const ShouldBeComponent = {
      street_number: ['street_number'],
      street: ['street_address', 'route'],
      province: [
        'administrative_area_level_1',
        'administrative_area_level_2',
        'administrative_area_level_3',
        'administrative_area_level_4',
        'administrative_area_level_5',
      ],
      suburb: ['political', 'sublocality', 'sublocality_level_1'],
      city: [
        'locality',
        'sublocality',
        'sublocality_level_1',
        'sublocality_level_2',
        'sublocality_level_3',
        'sublocality_level_4',
      ],
      country: ['country'],
      postal_code: ['postal_code'],
    };

    let address = {
      street: '',
      province: '',
      city: '',
      country: '',
      area: '',
      street_number: '',
    };

    address_components.forEach((component) => {
      for (var shouldBe in ShouldBeComponent) {
        if (ShouldBeComponent[shouldBe].indexOf(component.types[0]) !== -1) {
          if (shouldBe === 'country') {
            address[shouldBe] = component.short_name;
          } else {
            address[shouldBe] = component.long_name;
          }
        }
      }
    });

    // Fix the shape to match our schema

    let newAddress = {
      city: address.city,
      country: address.country,
      street_address: `${address?.street_number}  ${address.street}`,
      postal_code: address.postal_code,
      area: address.suburb,
    };
    return newAddress;
  };

  useEffect(() => {
    if (checkoutErrors && checkoutErrors?.constructor?.name === 'Object') {
      if (Object.keys(checkoutErrors).includes('address_info_id')) {
        router.push(`/cart-checkout/checkout#address_block`);
      } else if (
        Object.keys(checkoutErrors).includes('email') |
        Object.keys(checkoutErrors).includes('full_name') |
        Object.keys(checkoutErrors).includes('mobile') |
        Object.keys(checkoutErrors).includes('products')
      ) {
        router.push(`/cart-checkout/checkout#customer_details_block`);
      }
    }
  }, [checkoutErrors]);

  useEffect(() => {
    if (cartData?.length == 0) {
      window.location = '/product-list';
    }
  }, []);

  return (
    <div className={styles.mainBody}>
      {isLoading && <LoadingState />}
      <div className={styles.wrapper}>
        <span className={`${styles.urlText} ${styles.width100}`}>Back to cart</span>
        <div className={`${styles.width50} ${styles.md_w_100}`}>
          <div>
            <CustomerDetails
              {...checkoutData}
              handleCheckoutData={handleCheckoutData}
              errors={checkoutErrors}
              createOrderTemporary={createOrderTemporary}
              onKeyPress={onKeyPress}
            />
            <DeliveryAddress
              PrimarySmall={PrimarySmall}
              {...checkoutData}
              addresses={addresses}
              handleDeliveryAddress={handleDeliveryAddress}
              isLoggedIn={(user && token) || false}
              deliveryAdresses={deliveryAdresses}
              setDeliveryAdresses={setDeliveryAdresses}
              geoAddressValue={geoAddressValue}
              errors={checkoutErrors}
            />
            <Payment
              CartTotalDynamic={CartSubTotalDynamic}
              Total={CartTotal}
              paymentMethod={paymentMethod}
              setPaymentMethod={setPaymentMethod}
              postRequest={postRequest}
              handlePaymentButton={handlePaymentButton}
              checkoutData={checkoutData}
              clientSecret={clientSecret}
              setClientSecret={setClientSecret}
              loading={isLoading}
              setIsLoading={setIsLoading}
              couponInfo={couponInfo}
            />
          </div>
        </div>

        <div className={`${styles.width10} ${styles.md_w_100}`}></div>

        <div className={`${styles.width40} ${styles.md_w_100}`}>
          <div className={styles.payment}>
            <div className={styles.image}>
              <Image src={sheldImg} alt="sheld" className="w-10 h-10" />
            </div>
            <p className={styles.description}>Safe and secure Payments. 100% Authnetic products.</p>
          </div>

          <CartInfo
            cartData={cartData}
            CartInfoDynamic={CartInfoDynamic}
            CartTotalDynamic={CartTotalDynamic}
            couponCode={couponCode}
            setCouponCode={setCouponCode}
            applyCouponCode={applyCouponCode}
            loading={isLoading}
            couponInfo={couponInfo}
            CartSubTotalDynamic={CartSubTotalDynamic}
            totalRewardPoint={totalRewardPoint}
            couponErrorMessage={couponErrorMessage}
          />
        </div>
      </div>
    </div>
  );
};

Checkout.Layout = MainLayout;

export const getServerSideProps = createGetServerSidePropsFn(Checkout, async () => {
  await getRequest('/cart');
  const response = await getRequest('/getTotalRewardPoint');

  return {
    props: {
      totalRewardPoint: response?.data?.points || null,
    },
  };
});

export default Checkout;
