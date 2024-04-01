import styles from 'styles/cart-checkout/checkout/style.module.scss';
import { useState, useEffect, useRef } from 'react';
import Link from 'next/link';
import GooglePlacesAutocomplete from 'react-google-places-autocomplete';
import { getEnv } from '@/bootstrap/app.config';
import formatAddress from '@/shared/formatAddress';

const ADDRESS_NAME_ERROR = 'Please type a name for your address.';

const DeliveryAddress = ({
  addresses,
  handleDeliveryAddress,
  isLoggedIn,
  deliveryAdresses,
  setDeliveryAdresses,
  geoAddressValue,
  errors,
}) => {
  const [addNewAddress, setAddNewAddress] = useState(false);
  const [addressName, setAddressName] = useState('');
  const [addressNameError, setAddressNameError] = useState('');

  const addNewBillingAddressRef = useRef(null);
  const addNewAddressRef = useRef(null);
  const googleMapKey = getEnv('googleMapKey', '');

  useEffect(() => {
    if (addNewAddress) {
      addNewAddressRef?.current?.scrollIntoView({
        behavior: 'smooth',
        block: 'center',
      });

      setDeliveryAdresses(null);
    }
  }, [addNewAddress]);

  useEffect(() => {
    if (addresses?.length && addresses?.length == 0) {
      setAddNewAddress(true);
      setDeliveryAdresses(null);
    } else if (!deliveryAdresses && !addNewAddress && addresses?.length > 0) {
      const getDefaultAddress = addresses?.find((val) => val?.default == true);
      setDeliveryAdresses(getDefaultAddress?.address_info_id);
      setAddNewAddress(false);
    }
  }, [addresses]);

  const handleAddressName = (event) => {
    const { value } = event.target;
    setAddressName(value);
  };

  return (
    <>
      <div id="address_block" className={`${styles.flexRow} ${styles.mt_14} ${styles.flexWrap} ${styles.checkoutBox}`}>
        <div className={`${styles.width100}`}>
          {/* <form className="" action="/" method="POST"> */}
          <div className="">
            <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} mb-0 sm:mb-[24px]`}>
              <h4 className={`${styles.checkoutBoxHeader} ${styles.sm_w_100} ${styles.sm_m_0}`}>Delivery Address</h4>
            </div>
            {errors && errors?.address_info_id && (
              <p className="text-red-500 mt-2 text-[12px]">{errors?.address_info_id[0]}</p>
            )}

            {isLoggedIn ? (
              <>
                <div
                  className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter} ${styles.mt_24} ${styles.deliveryAddressBox}`}
                >
                  {addresses?.map((address) => (
                    <div className={`${styles.deliveryAddressItem}`}>
                      <label>
                        <input
                          type="checkbox"
                          className={`cursor-pointer`}
                          checked={deliveryAdresses == address?.address_info_id}
                          onChange={() => {
                            deliveryAdresses == address?.id
                              ? setDeliveryAdresses(null)
                              : setDeliveryAdresses(address?.address_info_id);
                            setAddNewAddress(false);
                          }}
                        />
                        <p className="max-w-[380px]">
                          {`${address?.name}`}{' '}
                          {address?.default ? (
                            <span className="text-xs text-white font-medium py-[2px] px-[6px] rounded-md bg-pink">
                              Default Address
                            </span>
                          ) : (
                            <></>
                          )}
                          <br />
                          <span className="font-normal">{formatAddress(address)}</span>{' '}
                        </p>
                      </label>
                      {/* <Link href={`/`}>Edit</Link> */}
                    </div>
                  ))}

                  {addresses && addresses?.length !== 0 ? (
                    <div className={`${styles.deliveryAddressItem}`}>
                      <label>
                        <input
                          onChange={() => {
                            setAddNewAddress((prev) => !prev);
                            setDeliveryAdresses(null);
                          }}
                          type="checkbox"
                          className={`cursor-pointer`}
                          checked={addNewAddress && !deliveryAdresses}
                        />
                        <p>Add New Address</p>
                      </label>
                    </div>
                  ) : (
                    <></>
                  )}
                </div>
                {(addNewAddress && !deliveryAdresses) | !addresses | (addresses?.length == 0) ? (
                  <div className="mt-4">
                    <div className="mb-4">
                      <label htmlFor="addressName" className={styles.formLabel}>
                        Full Name
                      </label>
                      <input
                        id="addressName"
                        name="addressName"
                        type="text"
                        autoComplete="addressName"
                        placeholder="Name"
                        required
                        className={styles.formInput}
                        value={addressName}
                        onChange={handleAddressName}
                      />
                      {addressNameError || addressNameError?.length ? (
                        <p className="text-red-500 mt-2 text-[12px]">{addressNameError}</p>
                      ) : (
                        <></>
                      )}
                    </div>
                    <GooglePlacesAutocomplete
                      apiKey={googleMapKey}
                      selectProps={{
                        isClearable: true,
                        placeholder: 'Type Address',
                        value: geoAddressValue,
                        onChange: (val) => {
                          if (!addressName || !addressName?.length) {
                            setAddressNameError(ADDRESS_NAME_ERROR);
                            return;
                          }

                          handleDeliveryAddress(val, addressName);
                          setAddNewAddress(false);
                        },
                        styles: {
                          textInputContainer: {
                            borderColor: '#c2c2c2',
                          },
                          textInput: {
                            fontFamily: 'PlusJakartaSans',
                            fontSize: 16,
                            fontWeight: 500,
                            lineHeight: 24,
                          },
                          predefinedPlacesDescription: {
                            color: '#1faadb',
                          },
                          control: (provided) => ({
                            ...provided,
                            padding: '9px 11px',
                            border: 0,
                            backgroundColor: 'rgb(245 245 245)',
                            color: 'rgb(38 38 38)',
                            borderColor: 'transparent',
                            boxShadow: 'none',
                          }),
                          placeholder: (provided) => ({
                            ...provided,
                            color: 'rgb(38 38 38)',
                          }),
                        },
                      }}
                      autocompletionRequest={{
                        componentRestrictions: {
                          country: ['us'],
                        },
                        types: ['geocode', 'establishment'],
                      }}
                      styles={{
                        textInputContainer: {
                          borderColor: '#c2c2c2',
                        },
                        textInput: {
                          fontFamily: 'PlusJakartaSans',
                          fontSize: 16,
                          fontWeight: 500,
                        },
                        predefinedPlacesDescription: {
                          color: '#1faadb',
                        },
                      }}
                    />
                  </div>
                ) : (
                  <></>
                )}
              </>
            ) : (
              <div className="mt-4">
                <div className="mb-4">
                  <label htmlFor="addressName" className={styles.formLabel}>
                    Full Name
                  </label>
                  <input
                    id="addressName"
                    name="addressName"
                    type="text"
                    autoComplete="addressName"
                    placeholder="Name"
                    required
                    className={styles.formInput}
                    value={addressName}
                    onChange={handleAddressName}
                  />
                  {addressNameError || addressNameError?.length ? (
                    <p className="text-red-500 mt-2 text-[12px]">{addressNameError}</p>
                  ) : (
                    <></>
                  )}
                </div>
                <GooglePlacesAutocomplete
                  apiKey={googleMapKey}
                  selectProps={{
                    isClearable: true,
                    placeholder: 'Type Address',
                    value: geoAddressValue,
                    onChange: (val) => {
                      if (!addressName || !addressName?.length) {
                        setAddressNameError(ADDRESS_NAME_ERROR);
                        return;
                      }

                      handleDeliveryAddress(val, addressName);
                    },
                    styles: {
                      textInputContainer: {
                        borderColor: '#c2c2c2',
                      },
                      textInput: {
                        fontFamily: 'PlusJakartaSans',
                        fontSize: 16,
                        fontWeight: 500,
                        lineHeight: 24,
                      },
                      predefinedPlacesDescription: {
                        color: '#1faadb',
                      },
                      control: (provided) => ({
                        ...provided,
                        padding: '9px 11px',
                        border: 0,
                        backgroundColor: 'rgb(245 245 245)',
                        color: 'rgb(38 38 38)',
                        borderColor: 'transparent',
                        boxShadow: 'none',
                      }),
                      placeholder: (provided) => ({
                        ...provided,
                        color: 'rgb(38 38 38)',
                      }),
                      input: (provided) => ({
                        ...provided,
                        boxShadow: 'none',
                      }),
                    },
                  }}
                  autocompletionRequest={{
                    componentRestrictions: {
                      country: ['us'],
                    },
                    types: ['geocode', 'establishment'],
                  }}
                  styles={{
                    textInputContainer: {
                      borderColor: '#c2c2c2',
                    },
                    textInput: {
                      fontFamily: 'PlusJakartaSans',
                      fontSize: 16,
                      fontWeight: 500,
                    },
                    predefinedPlacesDescription: {
                      color: '#1faadb',
                    },
                  }}
                />
              </div>
            )}
          </div>
          {/* </form> */}
        </div>
      </div>
    </>
  );
};

export default DeliveryAddress;
