import styles from 'styles/account/manageSubscription.module.scss';
import { Label } from 'components/InputLabel';
import MyAccountLayout from 'layouts/MyAccountLayout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import SecondarySmall from 'components/Buttons/SecondarySmall';
import CartItemPreview from '@/components/CartItems/images/cartItemPreview.png';
import MySelect from '@/components/CartItems/componentsCartItem/MySelect';
import { BiPlus, BiMinus } from 'react-icons/bi';
import Image from 'next/image';
import { useState, useCallback } from 'react';
import { Transition } from '@headlessui/react';

const ManageSubscription = () => {
  const [showSubDetail, setShowSubDetail] = useState([]);
  const [productsToBuy, setProductsToBuy] = useState(1);
  const handleIncrease = () => {
    setProductsToBuy((prev) => (prev + 1 > 99 ? 99 : prev + 1));
  };
  const handleChangeProducts = (e) => {
    setProductsToBuy(() => {
      if (e.target.value > 99) {
        return 99;
      }
      if (e.target.value < 1) {
        return 1;
      }
      return e.target.value;
    });
  };
  const handleDecrease = () => {
    setProductsToBuy((prev) => (prev - 1 < 1 ? 1 : prev - 1));
  };

  const handleSubDetail = (e, id) => {
    // console.log('handleSubDetail');
    e.preventDefault();
    let newId = Number(id);
    if (showSubDetail.includes(newId)) {
      setShowSubDetail(showSubDetail.filter((item) => item !== newId));
    } else {
      setShowSubDetail((oldArray) => [newId, ...oldArray]);
    }
  };

  const checkSubDetail = useCallback(
    (id) => {
      let newId = Number(id);

      // console.log('checkSubDetail');

      if (!showSubDetail.includes(newId)) {
        return false;
      }

      return true;
    },
    [showSubDetail]
  );

  return (
    <>
      <h4 className={styles.title}>Manage Subscription</h4>

      <div className={styles.subscriptionBox}>
        <div className={`${styles.subscriptionItem} ${checkSubDetail(1234156) ? styles.active : ''}`}>
          <div className="py-25px px-19px">
            <div className={`text-lg`}>
              Subscription ID <b className="lg:ml-11px myOrderNumber">#1234156</b>
            </div>
          </div>
          <div className="grid lg:grid-cols-5 grid-cols-2 py-17px px-19px bg-darker-white items-center">
            <div className="pl-10px lg:pl-0 lg:text-base">
              <div>Start Date</div>
              <div>
                <b>Mar 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px lg:text-base">
              <div>End Date</div>
              <div>
                <b>Sep 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px pt-10px lg:pt-0 lg:text-base">
              <div>Last Delivery</div>
              <div>
                <b>Apr 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px pt-10px lg:pt-0 col-span-1 lg:col-span-2 text-left lg:text-right underline lg:text-base">
              <a onClick={(e) => handleSubDetail(e, 1234156)} href="#" className="text-base font-medium text-pink">
                {checkSubDetail(1234156) ? 'Hide Details' : 'View Details'}
              </a>
            </div>
          </div>
          <Transition
            show={checkSubDetail(1234156)}
            enter="transition-opacity duration-75"
            enterFrom="opacity-0"
            enterTo="opacity-100"
            leave="transition-opacity duration-150"
            leaveFrom="opacity-100"
            leaveTo="opacity-0"
          >
            <div className={`p-19px pt-0`}>
              <div className="grid grid-cols-7 items-center py-25px border-b-[1px] border-more-lighter-gray border-solid">
                <div className="col-span-2 lg:col-span-1 md:col-span-2 xl:w-[100px] xl:h-[100px] lg:w-[80px] lg:h-[80px] text-center">
                  <Image layout="responsive" objectFit="cover" src={CartItemPreview} alt="arrow down" />
                </div>
                <div className="col-span-5 lg:col-span-6 md:col-span-5 flex flex-col flex-wrap">
                  <div className="mb-17px">
                    <h4 className="text-lg font-medium text-full-black">
                      Suritypro Calm Smoky Bacon Flavor Soft Chews
                    </h4>
                  </div>
                  <div className="flex flex-row flex-wrap items-center">
                    <div className={`xl:w-2/4 lg:w-3/5 w-full pr-9px mb-11px lg:mb-0 ${styles.mySelect}`}>
                      <MySelect
                        optionsArr={[
                          { label: 'Medium (26-50 lbs), 28 mg, 30…', value: 'Medium (26-50 lbs), 28 mg, 30…' },
                        ]}
                        placeholder={'Medium (26-50 lbs), 28 mg, 30…'}
                        classNamePrefix={'manageSubscription'}
                      />
                    </div>
                    <div className={`${styles.incDecBtn}`}>
                      <button className={styles.button} onClick={handleIncrease}>
                        <BiPlus width={25} height={25} />
                      </button>
                      <input
                        className={styles.incDecNumber}
                        type="number"
                        inputmode="numeric"
                        value={productsToBuy}
                        onChange={handleChangeProducts}
                      />
                      <button className={styles.button} onClick={handleDecrease}>
                        <BiMinus width={25} height={25} />
                      </button>
                    </div>
                    <div className="flex-1 text-right">
                      <b>$44.99</b>
                    </div>
                  </div>
                </div>
              </div>
              <div className="grid grid-cols-7 items-center py-25px border-b-[1px] border-more-lighter-gray border-solid">
                <div className="col-span-2 lg:col-span-1 md:col-span-2 xl:w-[100px] xl:h-[100px] lg:w-[80px] lg:h-[80px] text-center">
                  <Image layout="responsive" objectFit="cover" src={CartItemPreview} alt="arrow down" />
                </div>
                <div className="col-span-5 lg:col-span-6 md:col-span-5 flex flex-col flex-wrap">
                  <div className="mb-17px">
                    <h4 className="text-lg font-medium text-full-black">
                      Suritypro Calm Smoky Bacon Flavor Soft Chews
                    </h4>
                  </div>
                  <div className="flex flex-row flex-wrap items-center">
                    <div className={`xl:w-2/4 lg:w-3/5 w-full pr-9px mb-11px lg:mb-0 ${styles.mySelect}`}>
                      <MySelect
                        optionsArr={[
                          { label: 'Medium (26-50 lbs), 28 mg, 30…', value: 'Medium (26-50 lbs), 28 mg, 30…' },
                        ]}
                        placeholder={'Medium (26-50 lbs), 28 mg, 30…'}
                        classNamePrefix={'manageSubscription'}
                      />
                    </div>
                    <div className={`${styles.incDecBtn}`}>
                      <button className={styles.button} onClick={handleIncrease}>
                        <BiPlus width={25} height={25} />
                      </button>
                      <input
                        className={styles.incDecNumber}
                        type="number"
                        inputmode="numeric"
                        value={productsToBuy}
                        onChange={handleChangeProducts}
                      />
                      <button className={styles.button} onClick={handleDecrease}>
                        <BiMinus width={25} height={25} />
                      </button>
                    </div>
                    <div className="flex-1 text-right">
                      <b>$44.99</b>
                    </div>
                  </div>
                </div>
              </div>

              <div className="flex flex-col items-end py-25px border-b-[1px] border-more-lighter-gray border-solid text-lg font-bold text-full-black">
                <h4>
                  <span className="pr-55px">Subtotal</span> $23.00
                </h4>
                <h4>
                  <span className="pr-55px">Delivery</span> $0.00
                </h4>
              </div>
              <div className="flex flex-row flex-wrap py-25px pt-[42px] border-b-[1px] border-more-lighter-gray border-solid text-lg font-bold text-full-black">
                <div className="w-full">
                  <Label label="Address" />
                  <MySelect
                    optionsArr={[
                      {
                        label: '801 Trouser Leg Road, Greenfield, Massachusetts, 01301',
                        value: '801 Trouser Leg Road, Greenfield, Massachusetts, 01301',
                      },
                    ]}
                    placeholder={'801 Trouser Leg Road, Greenfield, Massachusetts, 01301'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-2/4 w-full">
                  <Label label="Payment by" />
                  <MySelect
                    optionsArr={[
                      {
                        label: 'Credit card ending with 8457',
                        value: 'Credit card ending with 8457',
                      },
                    ]}
                    placeholder={'Credit card ending with 8457'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-1/4 w-2/4 lg:pl-11px">
                  <Label label="Deliver every" />
                  <MySelect
                    optionsArr={[
                      {
                        label: 'Month',
                        value: 'Month',
                      },
                    ]}
                    placeholder={'Month'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-1/4 w-2/4 pl-11px">
                  <Label label="Delivery Date" />
                  <MySelect
                    optionsArr={[
                      {
                        label: '12',
                        value: '12',
                      },
                    ]}
                    placeholder={'12'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="w-full flex flex-row flex-wrap mt-[20px] mb-11px md:mb-0">
                  <PrimarySmall className="lg:w-[224px] h-[44px] lg:flex-none flex-1" text="Update Subscription" />
                  <div className="w-10px"></div>
                  <SecondarySmall className="lg:w-[224px] h-[44px] lg:flex-none flex-1" text="Cancel subscription" />
                </div>
              </div>
              <div className="py-21px flex flex-row flex-wrap">
                <SecondarySmall
                  className="xl:w-[300px] lg:w-[250px] h-[44px] lg:flex-none flex-1"
                  text="Skip delivery of Jan 2021"
                />
                <div className="w-10px"></div>
                <SecondarySmall
                  className="xl:w-[300px] lg:w-[250px] h-[44px] lg:flex-none flex-1"
                  text="View order history"
                />
              </div>
            </div>
          </Transition>
        </div>
        <div className={`${styles.subscriptionItem} ${checkSubDetail(547574) ? styles.active : ''}`}>
          <div className="py-25px px-19px">
            <div className={`text-lg`}>
              Subscription ID <b className="lg:ml-11px myOrderNumber">#547574</b>
            </div>
          </div>
          <div className="grid lg:grid-cols-5 grid-cols-2 py-17px px-19px bg-darker-white items-center">
            <div className="pl-10px lg:pl-0 lg:text-base">
              <div>Start Date</div>
              <div>
                <b>Mar 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px lg:text-base">
              <div>End Date</div>
              <div>
                <b>Sep 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px pt-10px lg:pt-0 lg:text-base">
              <div>Last Delivery</div>
              <div>
                <b>Apr 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px pt-10px lg:pt-0 col-span-1 lg:col-span-2 text-left lg:text-right underline lg:text-base">
              <a onClick={(e) => handleSubDetail(e, 547574)} href="#" className="text-base font-medium text-pink">
                {checkSubDetail(547574) ? 'Hide Details' : 'View Details'}
              </a>
            </div>
          </div>
          <Transition
            show={checkSubDetail(547574)}
            enter="transition-opacity duration-75"
            enterFrom="opacity-0"
            enterTo="opacity-100"
            leave="transition-opacity duration-150"
            leaveFrom="opacity-100"
            leaveTo="opacity-0"
          >
            <div className={`p-19px pt-0`}>
              <div className="grid grid-cols-7 items-center py-25px border-b-[1px] border-more-lighter-gray border-solid">
                <div className="col-span-2 lg:col-span-1 md:col-span-2 xl:w-[100px] xl:h-[100px] lg:w-[80px] lg:h-[80px] text-center">
                  <Image layout="responsive" objectFit="cover" src={CartItemPreview} alt="arrow down" />
                </div>
                <div className="col-span-5 lg:col-span-6 md:col-span-5 flex flex-col flex-wrap">
                  <div className="mb-17px">
                    <h4 className="text-lg font-medium text-full-black">
                      Suritypro Calm Smoky Bacon Flavor Soft Chews
                    </h4>
                  </div>
                  <div className="flex flex-row flex-wrap items-center">
                    <div className={`xl:w-2/4 lg:w-3/5 w-full pr-9px mb-11px lg:mb-0 ${styles.mySelect}`}>
                      <MySelect
                        optionsArr={[
                          { label: 'Medium (26-50 lbs), 28 mg, 30…', value: 'Medium (26-50 lbs), 28 mg, 30…' },
                        ]}
                        placeholder={'Medium (26-50 lbs), 28 mg, 30…'}
                        classNamePrefix={'manageSubscription'}
                      />
                    </div>
                    <div className={`${styles.incDecBtn}`}>
                      <button className={styles.button} onClick={handleIncrease}>
                        <BiPlus width={25} height={25} />
                      </button>
                      <input
                        className={styles.incDecNumber}
                        type="number"
                        inputmode="numeric"
                        value={productsToBuy}
                        onChange={handleChangeProducts}
                      />
                      <button className={styles.button} onClick={handleDecrease}>
                        <BiMinus width={25} height={25} />
                      </button>
                    </div>
                    <div className="flex-1 text-right">
                      <b>$44.99</b>
                    </div>
                  </div>
                </div>
              </div>
              <div className="grid grid-cols-7 items-center py-25px border-b-[1px] border-more-lighter-gray border-solid">
                <div className="col-span-2 lg:col-span-1 md:col-span-2 xl:w-[100px] xl:h-[100px] lg:w-[80px] lg:h-[80px] text-center">
                  <Image layout="responsive" objectFit="cover" src={CartItemPreview} alt="arrow down" />
                </div>
                <div className="col-span-5 lg:col-span-6 md:col-span-5 flex flex-col flex-wrap">
                  <div className="mb-17px">
                    <h4 className="text-lg font-medium text-full-black">
                      Suritypro Calm Smoky Bacon Flavor Soft Chews
                    </h4>
                  </div>
                  <div className="flex flex-row flex-wrap items-center">
                    <div className={`xl:w-2/4 lg:w-3/5 w-full pr-9px mb-11px lg:mb-0 ${styles.mySelect}`}>
                      <MySelect
                        optionsArr={[
                          { label: 'Medium (26-50 lbs), 28 mg, 30…', value: 'Medium (26-50 lbs), 28 mg, 30…' },
                        ]}
                        placeholder={'Medium (26-50 lbs), 28 mg, 30…'}
                        classNamePrefix={'manageSubscription'}
                      />
                    </div>
                    <div className={`${styles.incDecBtn}`}>
                      <button className={styles.button} onClick={handleIncrease}>
                        <BiPlus width={25} height={25} />
                      </button>
                      <input
                        className={styles.incDecNumber}
                        type="number"
                        inputmode="numeric"
                        value={productsToBuy}
                        onChange={handleChangeProducts}
                      />
                      <button className={styles.button} onClick={handleDecrease}>
                        <BiMinus width={25} height={25} />
                      </button>
                    </div>
                    <div className="flex-1 text-right">
                      <b>$44.99</b>
                    </div>
                  </div>
                </div>
              </div>

              <div className="flex flex-col items-end py-25px border-b-[1px] border-more-lighter-gray border-solid text-lg font-bold text-full-black">
                <h4>
                  <span className="pr-55px">Subtotal</span> $23.00
                </h4>
                <h4>
                  <span className="pr-55px">Delivery</span> $0.00
                </h4>
              </div>
              <div className="flex flex-row flex-wrap py-25px pt-[42px] border-b-[1px] border-more-lighter-gray border-solid text-lg font-bold text-full-black">
                <div className="w-full">
                  <Label label="Address" />
                  <MySelect
                    optionsArr={[
                      {
                        label: '801 Trouser Leg Road, Greenfield, Massachusetts, 01301',
                        value: '801 Trouser Leg Road, Greenfield, Massachusetts, 01301',
                      },
                    ]}
                    placeholder={'801 Trouser Leg Road, Greenfield, Massachusetts, 01301'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-2/4 w-full">
                  <Label label="Payment by" />
                  <MySelect
                    optionsArr={[
                      {
                        label: 'Credit card ending with 8457',
                        value: 'Credit card ending with 8457',
                      },
                    ]}
                    placeholder={'Credit card ending with 8457'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-1/4 w-2/4 lg:pl-11px">
                  <Label label="Deliver every" />
                  <MySelect
                    optionsArr={[
                      {
                        label: 'Month',
                        value: 'Month',
                      },
                    ]}
                    placeholder={'Month'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-1/4 w-2/4 pl-11px">
                  <Label label="Delivery Date" />
                  <MySelect
                    optionsArr={[
                      {
                        label: '12',
                        value: '12',
                      },
                    ]}
                    placeholder={'12'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="w-full flex flex-row flex-wrap mt-[20px] mb-11px md:mb-0">
                  <PrimarySmall className="lg:w-[224px] h-[44px] lg:flex-none flex-1" text="Update Subscription" />
                  <div className="w-10px"></div>
                  <SecondarySmall className="lg:w-[224px] h-[44px] lg:flex-none flex-1" text="Cancel subscription" />
                </div>
              </div>
              <div className="py-21px flex flex-row flex-wrap">
                <SecondarySmall
                  className="xl:w-[300px] lg:w-[250px] h-[44px] lg:flex-none flex-1"
                  text="Skip delivery of Jan 2021"
                />
                <div className="w-10px"></div>
                <SecondarySmall
                  className="xl:w-[300px] lg:w-[250px] h-[44px] lg:flex-none flex-1"
                  text="View order history"
                />
              </div>
            </div>
          </Transition>
        </div>
        <div className={`${styles.subscriptionItem} ${checkSubDetail(8054627) ? styles.active : ''}`}>
          <div className="py-25px px-19px">
            <div className={`text-lg`}>
              Subscription ID <b className="lg:ml-11px myOrderNumber">#8054627</b>
            </div>
          </div>
          <div className="grid lg:grid-cols-5 grid-cols-2 py-17px px-19px bg-darker-white items-center">
            <div className="pl-10px lg:pl-0 lg:text-base">
              <div>Start Date</div>
              <div>
                <b>Mar 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px lg:text-base">
              <div>End Date</div>
              <div>
                <b>Sep 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px pt-10px lg:pt-0 lg:text-base">
              <div>Last Delivery</div>
              <div>
                <b>Apr 12, 2020</b>
              </div>
            </div>
            <div className="pl-10px pt-10px lg:pt-0 col-span-1 lg:col-span-2 text-left lg:text-right underline lg:text-base">
              <a onClick={(e) => handleSubDetail(e, 8054627)} href="#" className="text-base font-medium text-pink">
                {checkSubDetail(8054627) ? 'Hide Details' : 'View Details'}
              </a>
            </div>
          </div>
          <Transition
            show={checkSubDetail(8054627)}
            enter="transition-opacity duration-75"
            enterFrom="opacity-0"
            enterTo="opacity-100"
            leave="transition-opacity duration-150"
            leaveFrom="opacity-100"
            leaveTo="opacity-0"
          >
            <div className={`p-19px pt-0`}>
              <div className="grid grid-cols-7 items-center py-25px border-b-[1px] border-more-lighter-gray border-solid">
                <div className="col-span-2 lg:col-span-1 md:col-span-2 xl:w-[100px] xl:h-[100px] lg:w-[80px] lg:h-[80px] text-center">
                  <Image layout="responsive" objectFit="cover" src={CartItemPreview} alt="arrow down" />
                </div>
                <div className="col-span-5 lg:col-span-6 md:col-span-5 flex flex-col flex-wrap">
                  <div className="mb-17px">
                    <h4 className="text-lg font-medium text-full-black">
                      Suritypro Calm Smoky Bacon Flavor Soft Chews
                    </h4>
                  </div>
                  <div className="flex flex-row flex-wrap items-center">
                    <div className={`xl:w-2/4 lg:w-3/5 w-full pr-9px mb-11px lg:mb-0 ${styles.mySelect}`}>
                      <MySelect
                        optionsArr={[
                          { label: 'Medium (26-50 lbs), 28 mg, 30…', value: 'Medium (26-50 lbs), 28 mg, 30…' },
                        ]}
                        placeholder={'Medium (26-50 lbs), 28 mg, 30…'}
                        classNamePrefix={'manageSubscription'}
                      />
                    </div>
                    <div className={`${styles.incDecBtn}`}>
                      <button className={styles.button} onClick={handleIncrease}>
                        <BiPlus width={25} height={25} />
                      </button>
                      <input
                        className={styles.incDecNumber}
                        type="number"
                        inputmode="numeric"
                        value={productsToBuy}
                        onChange={handleChangeProducts}
                      />
                      <button className={styles.button} onClick={handleDecrease}>
                        <BiMinus width={25} height={25} />
                      </button>
                    </div>
                    <div className="flex-1 text-right">
                      <b>$44.99</b>
                    </div>
                  </div>
                </div>
              </div>
              <div className="grid grid-cols-7 items-center py-25px border-b-[1px] border-more-lighter-gray border-solid">
                <div className="col-span-2 lg:col-span-1 md:col-span-2 xl:w-[100px] xl:h-[100px] lg:w-[80px] lg:h-[80px] text-center">
                  <Image layout="responsive" objectFit="cover" src={CartItemPreview} alt="arrow down" />
                </div>
                <div className="col-span-5 lg:col-span-6 md:col-span-5 flex flex-col flex-wrap">
                  <div className="mb-17px">
                    <h4 className="text-lg font-medium text-full-black">
                      Suritypro Calm Smoky Bacon Flavor Soft Chews
                    </h4>
                  </div>
                  <div className="flex flex-row flex-wrap items-center">
                    <div className={`xl:w-2/4 lg:w-3/5 w-full pr-9px mb-11px lg:mb-0 ${styles.mySelect}`}>
                      <MySelect
                        optionsArr={[
                          { label: 'Medium (26-50 lbs), 28 mg, 30…', value: 'Medium (26-50 lbs), 28 mg, 30…' },
                        ]}
                        placeholder={'Medium (26-50 lbs), 28 mg, 30…'}
                        classNamePrefix={'manageSubscription'}
                      />
                    </div>
                    <div className={`${styles.incDecBtn}`}>
                      <button className={styles.button} onClick={handleIncrease}>
                        <BiPlus width={25} height={25} />
                      </button>
                      <input
                        className={styles.incDecNumber}
                        type="number"
                        inputmode="numeric"
                        value={productsToBuy}
                        onChange={handleChangeProducts}
                      />
                      <button className={styles.button} onClick={handleDecrease}>
                        <BiMinus width={25} height={25} />
                      </button>
                    </div>
                    <div className="flex-1 text-right">
                      <b>$44.99</b>
                    </div>
                  </div>
                </div>
              </div>

              <div className="flex flex-col items-end py-25px border-b-[1px] border-more-lighter-gray border-solid text-lg font-bold text-full-black">
                <h4>
                  <span className="pr-55px">Subtotal</span> $23.00
                </h4>
                <h4>
                  <span className="pr-55px">Delivery</span> $0.00
                </h4>
              </div>
              <div className="flex flex-row flex-wrap py-25px pt-[42px] border-b-[1px] border-more-lighter-gray border-solid text-lg font-bold text-full-black">
                <div className="w-full">
                  <Label label="Address" />
                  <MySelect
                    optionsArr={[
                      {
                        label: '801 Trouser Leg Road, Greenfield, Massachusetts, 01301',
                        value: '801 Trouser Leg Road, Greenfield, Massachusetts, 01301',
                      },
                    ]}
                    placeholder={'801 Trouser Leg Road, Greenfield, Massachusetts, 01301'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-2/4 w-full">
                  <Label label="Payment by" />
                  <MySelect
                    optionsArr={[
                      {
                        label: 'Credit card ending with 8457',
                        value: 'Credit card ending with 8457',
                      },
                    ]}
                    placeholder={'Credit card ending with 8457'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-1/4 w-2/4 lg:pl-11px">
                  <Label label="Deliver every" />
                  <MySelect
                    optionsArr={[
                      {
                        label: 'Month',
                        value: 'Month',
                      },
                    ]}
                    placeholder={'Month'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="mt-25px lg:w-1/4 w-2/4 pl-11px">
                  <Label label="Delivery Date" />
                  <MySelect
                    optionsArr={[
                      {
                        label: '12',
                        value: '12',
                      },
                    ]}
                    placeholder={'12'}
                    classNamePrefix={'mySelect2'}
                  />
                </div>
                <div className="w-full flex flex-row flex-wrap mt-[20px] mb-11px md:mb-0">
                  <PrimarySmall className="lg:w-[224px] h-[44px] lg:flex-none flex-1" text="Update Subscription" />
                  <div className="w-10px"></div>
                  <SecondarySmall className="lg:w-[224px] h-[44px] lg:flex-none flex-1" text="Cancel subscription" />
                </div>
              </div>
              <div className="py-21px flex flex-row flex-wrap">
                <SecondarySmall
                  className="xl:w-[300px] lg:w-[250px] h-[44px] lg:flex-none flex-1"
                  text="Skip delivery of Jan 2021"
                />
                <div className="w-10px"></div>
                <SecondarySmall
                  className="xl:w-[300px] lg:w-[250px] h-[44px] lg:flex-none flex-1"
                  text="View order history"
                />
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </>
  );
};

ManageSubscription.Layout = MyAccountLayout;

// export const getServerSideProps = createGetServerSidePropsFn(ManageSubscription);

export default ManageSubscription;
