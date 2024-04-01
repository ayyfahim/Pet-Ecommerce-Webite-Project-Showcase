/* eslint-disable no-restricted-imports */
import React, { FC, useEffect, useState } from 'react';
import styles from './CartItem.module.scss';
import Image from 'next/image';
import CartItemPreview from './images/cartItemPreview.png';
import MySelect from './componentsCartItem/MySelect';
import MyButton from './componentsCartItem/MyButton';
import { ICartSchema } from 'schemas/cart.schema';

interface ICartItemProps {
  subscription?: string;
  data: ICartSchema;
  setCart: any;
  cart: any;
  setToCart: any;
}

interface AddonStateType {
  label: string;
  value: string;
  config: {
    label: string;
    type: string;
    options: {
      id: string;
      value: string;
      color_name: string;
    }[];
  };
}

const CartItem: FC<ICartItemProps> = ({
  subscription = 'subscription: every month X 3',
  data: { id, product, quantity, options } = { product: null, id: '', quantity: 1, options: [''] },
  setCart,
  cart,
  setToCart,
}) => {
  const getProdOptions = (): [] => {
    let mainArr: any = [];
    if (product?.configurations) {
      product?.configurations?.map((opt, index) => {
        let newArr: any = [];

        opt?.options?.map((val) => {
          const newArrObj = { value: val?.value, label: val?.id, config: opt };
          newArr = [...newArr, newArrObj];
        });

        mainArr = [...mainArr, { label: opt?.label, options: newArr }];
      });
    }
    return mainArr;
  };

  const getAddonState = (): [] => {
    let mainArr: any = [];
    if (product?.configurations) {
      product?.configurations?.map((opt, index) => {
        let newArr: any = [];
        opt?.options?.map((val) => {
          const newArrObj = { value: val?.value, label: val?.id, config: opt };
          if (options?.includes(val?.id) && !addonState?.some((addon) => addon?.label == val?.id)) {
            newArr = [...newArr, newArrObj];
          }
        });

        mainArr = [...mainArr, ...newArr];
      });
    }
    return mainArr;
  };

  const [productsToBuy, setProductsToBuy] = useState<number>(quantity);
  // const [productSelect, setProductSelect] = useState(null);
  const [productOptions, _setProductOptions] = useState(getProdOptions() || []);
  const [addonState, setAddonState] = useState<AddonStateType[]>(getAddonState() || []);
  const handleIncrease = () => {
    setProductsToBuy((prev) => (prev + 1 > 99 ? 99 : prev + 1));
  };
  const handleChangeProducts = (e: any) => {
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

  const handleAddToCart = () => {
    let options: string[] = [];
    addonState?.map((addon) => {
      options = [...options, addon?.label];
    });
    const newCart = setToCart(cart, product?.id, productsToBuy, options);
    setCart(newCart);
  };

  const handleSetAddonState = (propsData: any) => {
    if (!propsData?.length || !propsData) {
      setAddonState([]);
      return;
    }

    const data = propsData?.length ? propsData[propsData?.length - 1] : [];
    let result = addonState?.find((addon: any) => addon?.label == data?.label);

    let newData = [];

    if (result) {
      newData = addonState?.filter((addon: any) => addon?.label == data?.label);
      setAddonState([...newData]);
    } else {
      newData = addonState?.filter((addon: any) => {
        let result = data?.config?.options?.filter((opt: any) => opt?.id == addon?.label);

        if (result?.length == 0) {
          return true;
        }
      });
      setAddonState([...newData, data]);
    }
  };

  useEffect(() => {
    handleAddToCart();
  }, [addonState, productsToBuy]);

  return (
    <div className={styles.CartItem}>
      <div className={styles.imgWrapper}>
        <Image src={product?.cover ?? CartItemPreview} alt="arrow down" width={88} height={88} />
      </div>
      <div className={styles.contentWrapper}>
        <div className={styles.contentSelectAndH2}>
          <h2>{product?.title}</h2>
          {subscription ? <span className={styles.contentSelectAndH2Subscription}>{subscription}</span> : null}
          {product?.configurations?.length ? (
            <div className={styles.contentSelect}>
              <MySelect
                defaultValue={null}
                optionsArr={productOptions}
                handleChange={handleSetAddonState}
                isMulti={true}
                state={addonState}
              />
            </div>
          ) : (
            <div className="h-[38px]"></div>
          )}
        </div>
        <div className={styles.contentWrapperCounterAndPrice}>
          <div className={styles.contentCounter}>
            <MyButton handle={handleDecrease} mode="minus" />
            <div className={styles.counter}>
              <input value={productsToBuy} onChange={handleChangeProducts} />
            </div>
            <MyButton handle={handleIncrease} mode="plus" />
            <div className={styles.ContentCounterPrice}>
              <span>${Math.abs(product?.sale_price || 0).toFixed(2)}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CartItem;
