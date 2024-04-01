import { IProductSchema } from 'schemas/product.schema';

export const addToWishList = (wishlist: any[], item: IProductSchema) => {
  let newCart = [...wishlist];
  const foundIndex = wishlist.findIndex((x) => x.id === item.id);

  // Increase quantity if existing
  if (foundIndex >= 0) {
    newCart = newCart.filter((x) => x.id !== item.id);
    return newCart;
  }

  // Add new item
  newCart.push({
    id: item.id,
    product: item,
  });

  return newCart;
};
