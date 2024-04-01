import styles from 'styles/account/editAddress.module.scss';
import InputLabel from 'components/InputLabel';
import MainLayout from 'layouts/MainLayout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import SecondarySmall from 'components/Buttons/SecondarySmall';
import { Label } from 'components/InputLabel';
import MySelect from '@/components/CartItems/componentsCartItem/MySelect';
import useReactForm from 'hooks/useReactForm';
import { object, string } from 'yup';
import { withAuth } from '@/app/middleware/auth';

import Link from 'next/link';
import { FormProvider } from 'react-hook-form';
import GooglePlacesAutocomplete from 'react-google-places-autocomplete';
import { geocodeByPlaceId } from 'react-google-places-autocomplete';
import { getEnv } from '@/bootstrap/app.config';
import { useEffect, useRef, useState } from 'react';
import { useRouter } from 'next/router';
import { toast } from 'react-toastify';
import { getRequest } from 'requests/api';
import formatAddress from '@/shared/formatAddress';

const phoneRegExp = /^((\+[1-9]{1,4}[ -]?)|(\([0-9]{2,3}\)[ -]?)|([0-9]{2,4})[ -]?)*?[0-9]{3,4}[ -]?[0-9]{3,4}$/;
const formSchema = object().shape({
  name: string().label('Full Name').required(),
  phone: string('Please put your Phone Number')
    .matches(phoneRegExp, 'Phone number is not valid')
    .label('Phone Number')
    .required(),
  geoAddressValue: object().required('Please select an address'),

  area: string().label('Area'),
  city: string().label('city'),
  country: string().label('country'),
  postal_code: string().label('postal_code'),
  street_address: string().label('street_address'),
  place_id: string(),
});

const EditAccount = ({ address }) => {
  const [addressChanged, setAddressChanged] = useState(false);
  // useEffect(() => {
  //   try {
  //     const getGeocodeByPlaceId = geocodeByPlaceId(address?.place_id);
  //     setAddressByPlaceId(getGeocodeByPlaceId);
  //   } catch (error) {
  //     console.log('error', error);
  //   }
  // }, []);

  // console.log('address', address);
  const googleMapKey = getEnv('googleMapKey', '');

  const router = useRouter();

  const { postal_code, street_address, city, country, address_info_id, area } = address;
  let newAddress = formatAddress(address);

  const { methods, submitHandler, isLoading } = useReactForm(
    'patch',
    `/address/updateInfo/${address_info_id}`,
    formSchema,
    {
      phone: address?.phone,
      name: address?.name,
      geoAddressValue: { label: newAddress },
      area: area,
      city: city,
      country: country,
      postal_code: postal_code,
      street_address: street_address,
    },
    {
      onSuccess: () => {
        toast.clearWaitingQueue();
        toast.success('Address updated successfully', { toastId: 'notification' });
        window.location = '/account/delivery-address';
      },
    }
  );

  const {
    reset,
    formState: { errors },
    getValues,
    setValue,
  } = methods;

  const resetForm = (e) => {
    e.preventDefault();
    reset();
  };

  const handleDeliveryAddress = async (val) => {
    // if (isLoading) {
    //   return;
    // }

    setValue('geoAddressValue', val);

    if (val) {
      const geoCodeObj = val && val.value && (await geocodeByPlaceId(val.value.place_id));

      setValue('place_id', val?.value?.place_id);
      setAddressChanged(true);

      let addressObject =
        geoCodeObj && getAddressObject(geoCodeObj[0].formatted_address, geoCodeObj[0].address_components);

      Object.keys(addressObject).forEach((key) => {
        setValue(key, addressObject[key]);
      });
    }

    // console.log('getValues', getValues());

    // formRef.current.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
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

  const formRef = useRef(null);

  // console.log('getValues(geoAddressValue)', getValues('geoAddressValue'));
  // console.log('errors', errors);

  // console.log('isLoading', isLoading);
  // console.log(
  //   'isLoading || newAddress == getValues(geoAddressValue)?.label',
  //   isLoading || newAddress == getValues('geoAddressValue')?.label
  // );
  // console.log('getValues(geoAddressValue)', getValues('geoAddressValue'));

  // console.log('isDirty', isDirty);

  return (
    <FormProvider {...methods}>
      <form ref={formRef} onSubmit={submitHandler}>
        <div className={styles.mainBody}>
          <div className={styles.wrapper}>
            <div className={styles.contentWrapper}>
              <div className={styles.editAdressBox}>
                <div className={styles.box}>
                  <span className={styles.shortUrl}>
                    <span>
                      <Link href={'/account/edit'}>My Account</Link> /{' '}
                      <Link href={'/account/delivery-address'}>Delivery Address</Link> / Edit Address
                    </span>
                  </span>
                  <h4 className={styles.title}>Edit Address</h4>
                </div>
                <div className={`${styles.box} flex flex-row flex-wrap`}>
                  <div className="w-2/4 mb-[30px] pr-11px">
                    <InputLabel name="name" label="Full Name" inputType={'text'} inputPlaceholder="Elizabeth Collins" />
                  </div>
                  <div className="w-2/4 mb-[30px]">
                    <InputLabel name="phone" label="Phone Number" inputType={'text'} inputPlaceholder="116-30-9372" />
                  </div>
                  <div className="w-full mb-[30px]">
                    <GooglePlacesAutocomplete
                      apiKey={googleMapKey}
                      selectProps={{
                        isClearable: true,
                        placeholder: 'Type Address',
                        // value: getValues('geoAddressValue')?.label || '',
                        defaultInputValue: getValues('geoAddressValue')?.label || '',
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
                            boxShadow: 'none !important',
                            borderColor: 'transparent !important',
                            outline: 'none !important',
                          }),
                        },
                        // instanceId: '1',
                        onChange: (val) => {
                          handleDeliveryAddress(val);
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
                    {errors && errors?.geoAddressValue && errors?.geoAddressValue?.message && (
                      <p className="text-red-700 font-light">{String(errors?.geoAddressValue?.message) || ''}</p>
                    )}
                  </div>
                  <div className="w-full mt-10px">
                    <PrimarySmall
                      type="submit"
                      className="w-[168px] h-[44px] mr-10px mb-11px md:mb-0"
                      text="Save Changes"
                      disabled={!addressChanged}
                    />
                    <SecondarySmall type="button" onClick={resetForm} className="w-[168px] h-[44px]" text="Cancel" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </FormProvider>
  );
};

EditAccount.Layout = MainLayout;
EditAccount.middleWares = [withAuth];

// export const getServerSideProps = createGetServerSidePropsFn(EditAccount);

export const getServerSideProps = createGetServerSidePropsFn(EditAccount, async ({ params }) => {
  const response = await getRequest(`/address/show/${params?.slug}`);
  return {
    props: {
      address: response?.data?.address || [],
    },
  };
});

export default EditAccount;
