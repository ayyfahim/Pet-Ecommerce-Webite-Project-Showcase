import { toast } from 'react-toastify';
import { ICartSchema } from 'schemas/cart.schema';
import { IProductSchema } from 'schemas/product.schema';

export const addToCart = (
  cart: ICartSchema[],
  item: IProductSchema,
  quantity: number = 1,
  options: string[] = [],
  redirect = false
) => {
  if (redirect && item?.configurations?.length) {
    // @ts-ignore
    window.location = `/product/${item?.slug}`;
    const newCart = [...cart];
    return newCart;
  }
  const newCart = [...cart];
  const foundIndex = cart.findIndex((x) => x.id === item.id);

  // Increase quantity if existing
  if (foundIndex >= 0) {
    newCart[foundIndex] = {
      ...cart[foundIndex],
      quantity: cart[foundIndex].quantity + quantity,
      options: options,
    };
    return newCart;
  }

  // Add new item
  newCart.push({
    id: item.id,
    product: item,
    quantity: quantity,
    options: options,
  });

  return newCart;
};

export const setToCart = (cart: ICartSchema[], product_id: string, quantity: number, options: [] = []) => {
  const newCart = [...cart];
  const foundIndex = cart.findIndex((x) => x.id === product_id);

  // Increase quantity if existing
  if (foundIndex >= 0) {
    newCart[foundIndex] = {
      ...cart[foundIndex],
      quantity: quantity,
      options: options,
    };
    return newCart;
  }

  return newCart;
};

export const deleteItemFromCart = (cart: ICartSchema[], product_id: string) => {
  const newCart = cart.filter((x) => x.id !== product_id);

  return newCart;
};

export const reOrderToCart = (order: any) => {
  const newCart: any = [];

  if (order?.products) {
    // console.log('order?.products', order?.products);
    order?.products?.map((item: any) => {
      // console.log('product', item);
      let options: any = [];

      if (item?.variation_options) {
        item?.variation_options?.map((opt: any) => {
          options.push(opt?.id);
        });
      }

      // Add new item
      newCart.push({
        id: item?.product?.id,
        product: item?.product,
        quantity: item?.quantity,
        options: options,
      });
    });
  }

  return newCart;
};

export const shortHandleAddToCart = (product: IProductSchema, cart: ICartSchema[], setCart: any) => {
  if (product?.configurations?.length || product?.is_configured) {
    // @ts-ignore
    // window.location = `/product/${product?.slug}`;
    return;
  }
  const newCart = addToCart(cart, product);
  setCart(newCart);

  toast.clearWaitingQueue();
  toast.success('Added to Cart.', { toastId: 'notification' });
};
