import { ICartSchema } from 'schemas/cart.schema';
import { IProductSchema } from 'schemas/product.schema';

export const addToCart = (cart: ICartSchema[], item: IProductSchema) => {
  const newCart = [...cart];
  const foundIndex = cart.findIndex((x) => x.id === item.id);

  // Increase quantity if existing
  if (foundIndex >= 0) {
    newCart[foundIndex] = {
      ...cart[foundIndex],
      quantity: cart[foundIndex].quantity + 1,
    };
    return newCart;
  }

  // Add new item
  newCart.push({
    id: item.id,
    product: item,
    quantity: 1,
  });
  
  return newCart;
};