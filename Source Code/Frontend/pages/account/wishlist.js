import { useState, useEffect } from 'react';

import styles from 'styles/account/wishlist.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import MyPagination from '@/components/MyPagination/MyPagination';
import MyAccountLayout from 'layouts/MyAccountLayout';
import Image from 'next/image';
import CartItemPreview from '@/components/CartItems/images/cartItemPreview.png';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import { withAuth } from '@/app/middleware/auth';
import { useWishListValue } from '@/app/atom/wishlist.atom';
import { useWishListState } from '@/app/atom/wishlist.atom';
import { addToWishList } from '@/features/wishlist/useWishListService';
import { toast } from 'react-toastify';
import { useCartState } from '@/app/atom/cart.atom';
import { addToCart, shortHandleAddToCart } from '@/features/cart/useCartService';

const EditAccount = () => {
  const [wishlist, setWishList] = useWishListState();
  const [cart, setCart] = useCartState();

  const [items, setItems] = useState([]);

  const [currentItems, setCurrentItems] = useState(items);
  const [pageCount, setPageCount] = useState(0);
  const [itemOffset, setItemOffset] = useState(0);
  const itemsPerPage = 5;

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(items.slice(itemOffset, endOffset));
    setPageCount(Math.ceil(items.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, items]);

  useEffect(() => {
    setItems(wishlist);
  }, [wishlist]);

  const handleAddToWishlist = (product) => {
    const newCart = addToWishList(wishlist, product);
    setWishList(newCart);
  };

  return (
    <>
      <div className="">
        <h4 className={styles.title}>Wishlist</h4>
      </div>

      <div className={styles.wishlistBox}>
        {currentItems?.length > 0 ? (
          currentItems.map((e, index) => (
            <div className={styles.wishlistItem}>
              <div className={styles.wishlistImg}>
                <Image src={e?.product?.cover} alt="sheld" layout="fill" objectFit="contain" />
              </div>
              <div className={styles.wishListInfo}>
                <h4>{e?.product?.title}</h4>
                <p>{e?.product?.excerpt}</p>
                <div className={styles.wishListAction}>
                  <a
                    href="#"
                    onClick={(event) => {
                      event?.preventDefault();
                      handleAddToWishlist(e?.product);
                    }}
                  >
                    Remove
                  </a>
                  <div>
                    <b>{e?.product?.sale_price?.toFixed(2)}</b>
                    <PrimarySmall
                      className="w-[137px] h-[44px] ml-21px"
                      text="Add to Cart"
                      onClick={() => {
                        if (e?.product?.configurations?.length || e?.product?.is_configured) {
                          window.location = `/product/${e?.product?.slug}`;
                          return;
                        }
                        shortHandleAddToCart(e?.product, cart, setCart);
                      }}
                    />
                  </div>
                </div>
              </div>
            </div>
          ))
        ) : (
          <h4>No products found.</h4>
        )}
      </div>

      <div className={styles.MyPagination}>
        <MyPagination items={items} pageCount={pageCount} setItemOffset={setItemOffset} itemsPerPage={itemsPerPage} />
      </div>
    </>
  );
};

EditAccount.Layout = MyAccountLayout;
EditAccount.middleWares = [withAuth];

export const getServerSideProps = createGetServerSidePropsFn(EditAccount);

export default EditAccount;
