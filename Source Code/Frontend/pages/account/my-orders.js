import { useState, useEffect } from 'react';

import styles from 'styles/account/myOrders.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import MyPagination from '@/components/MyPagination/MyPagination';
import MyAccountLayout from 'layouts/MyAccountLayout';
import { BiSearch } from 'react-icons/bi';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import SecondarySmall from 'components/Buttons/SecondarySmall';
import { useDebouncedCallback } from 'use-debounce';
import { withAuth } from '@/app/middleware/auth';
import LoadingState from '@/components/LoadingState';
import { getRequestSwr, getRequest } from 'requests/api';
import Link from 'next/link';
import { reOrderToCart } from '@/features/cart/useCartService';
import { useCartState } from '@/app/atom/cart.atom';
import { toast } from 'react-toastify';
import { useAuthValue } from '@/app/atom/auth.atom';

const EditAccount = ({ orders }) => {
  const user = useAuthValue();

  const [cart, setCart] = useCartState();

  const [searchStr, setSearchStr] = useState(null);
  const [isFirstLoading, setIsFirstLoading] = useState(true);
  const [isLoading, setIsLoading] = useState(true);
  const [items, setItems] = useState([
    {
      order_number: '#1234156',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#1234156',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#1234156',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#1234156',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#1234156',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#7891011',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
    {
      order_number: '#69',
      order_total: '$96.98',
      order_status: 'Delivered',
      total_items: 12,
      payment_status: 'Paid',
      rewards: '$3.56',
      created_at: 'July 28, 2020',
    },
  ]);

  // @ts-ignore
  const token = Object.keys(user?.user)?.length ? user?.token : '';

  useEffect(() => {
    setIsFirstLoading(false);
  }, []);

  // const getAllOrders = getRequestSwr(!isFirstLoading ? `/orders` : null, {}, true);
  // const orders = (getAllOrders && getAllOrders?.data?.data) || [];
  // let isValidating = getAllOrders?.isValidating;

  // useEffect(() => {
  //   if (isLoading !== isValidating) {
  //     setIsLoading(isValidating);
  //   }
  // }, [isValidating]);

  useEffect(() => {
    const newItems = orders?.map((order) => {
      return {
        order_number: order?.short_id,
        order_total: order?.totals?.total,
        order_status: order?.status?.title,
        total_items: order?.products?.length,
        payment_status: order?.payment_status,
        rewards: '$0.0',
        created_at: order?.created_at,
        invoice_link: order?.invoice_link,
        products: order?.products,
        total_reward_points_earned: order?.total_reward_points_earned,
        total_reward_points_redeemed: order?.total_reward_points_redeemed,
        total_reward_points_exchange: order?.total_reward_points_exchange,
      };
    });
    setItems(newItems);
  }, [orders]);

  const [currentItems, setCurrentItems] = useState(items);
  const [pageCount, setPageCount] = useState(0);
  const [itemOffset, setItemOffset] = useState(0);
  const [pageNumber, setPageNumber] = useState(0);
  const itemsPerPage = 4;

  const [filteredItems, setFilteredItems] = useState([]);
  const [currentFilteredItems, setCurrentFilteredItems] = useState([]);
  const [searchPageCount, setSearchPageCount] = useState(0);
  const [searchItemOffset, setSearchItemOffset] = useState(0);
  const [searchPageNumber, setSearchPageNumber] = useState(0);
  const itemsPerPageSearch = 4;

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(items.slice(itemOffset, endOffset));
    setPageCount(Math.ceil(items.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, items]);

  useEffect(() => {
    const endOffset = searchItemOffset + itemsPerPageSearch;
    setCurrentFilteredItems(filteredItems.slice(searchItemOffset, endOffset));
    setSearchPageCount(Math.ceil(filteredItems.length / itemsPerPageSearch));
  }, [filteredItems, searchItemOffset, itemsPerPageSearch]);

  useEffect(() => {
    if (!searchStr) {
      setSearchPageNumber(0);
    } else {
      setFilteredItems(items.filter((item) => item.order_number.includes(searchStr)));
      setPageNumber(0);
    }
  }, [searchStr]);

  const searchItems = useDebouncedCallback((e) => {
    setSearchStr(e?.target?.value);
  }, 300);

  const goToInvoice = (link) => window.open(`${link}?token=${token}`, '_blank', 'noopener,noreferrer');
  // const goToInvoice = (link) => window.open(`${link}`, '_blank', 'noopener,noreferrer');

  const reOrder = (order) => {
    const newCart = reOrderToCart(order);
    setCart(newCart);

    toast.clearWaitingQueue();
    toast.success('Item Re-ordered', { toastId: 'notification' });

    window.location = '/cart-checkout/checkout';
  };

  return (
    <>
      <div className="flex flex-row flex-wrap lg:justify-between justify-center mb-31px">
        <h4 className={styles.title}>My Orders</h4>
        <div className={styles.searchBox}>
          <BiSearch size={23} color="#4a2072" />
          <input type="text" placeholder="Search your order" onKeyUp={(e) => searchItems(e)} />
        </div>
      </div>

      <div className={styles.order_box}>
        {!searchStr
          ? currentItems.map((e, index) => (
              <div className={styles.order_item}>
                <div className="grid lg:grid-cols-5 grid-cols-2 py-25px px-19px">
                  <div className={`${styles.order_header} lg:col-span-4`}>
                    Order<b className="lg:ml-11px myOrderNumber">#{e.order_number}</b>
                  </div>
                  <div className={`${styles.order_header} lg:col-span-1 pl-10px`}>
                    Total <b className="lg:ml-11px">${e.order_total}</b>
                  </div>
                </div>
                <div className="grid lg:grid-cols-6 grid-cols-2 py-17px px-19px bg-darker-white">
                  <div className="pl-10px lg:pl-0">
                    <div>Date</div>
                    <div>
                      <b>{e.created_at}</b>
                    </div>
                  </div>
                  <div className="pl-10px">
                    <div>Status</div>
                    <div>
                      <b>{e.order_status}</b>
                    </div>
                  </div>
                  <div className="pl-10px pt-10px lg:pt-0">
                    <div>Total items</div>
                    <div>
                      <b>{e.total_items}</b>
                    </div>
                  </div>
                  <div className="pl-10px pt-10px lg:pt-0">
                    <div>Payment</div>
                    <div>
                      <b>{e.payment_status}</b>
                    </div>
                  </div>
                  <div className="pl-10px pt-10px lg:pt-0 w-min">
                    <div className={`${styles.reward_icon} lg:text-center`}>Rewards Earned</div>
                    <div className="text-center">
                      <b className="block">{e.total_reward_points_earned || '-'}</b>
                      {e.total_reward_points_earned ? (
                        <b className="block">
                          ${(e.total_reward_points_earned * e.total_reward_points_exchange).toFixed(2)}
                        </b>
                      ) : (
                        <b className="block">-</b>
                      )}
                    </div>
                  </div>
                  <div className="pl-10px pt-10px lg:pt-0 w-min">
                    <div className={`${styles.reward_icon} lg:text-center`}>Rewards Redeemed</div>
                    <div className="text-center">
                      <b className="block">{e.total_reward_points_redeemed || '-'}</b>
                      {e.total_reward_points_redeemed ? (
                        <b className="block">
                          -${(e.total_reward_points_redeemed * e.total_reward_points_exchange + '')?.replace('-', '')}
                        </b>
                      ) : (
                        <b className="block">-</b>
                      )}
                    </div>
                  </div>
                </div>
                <div className="px-19px pb-21px flex sm:flex-row flex-col flex-wrap sm:items-center items-end pt-20px gap-3">
                  <PrimarySmall
                    className="lg:w-[168px] h-[44px] md:w-[134px] w-[168px] md:mb-0"
                    text="Re-order"
                    onClick={() => reOrder(e)}
                  />
                  <SecondarySmall
                    className="lg:w-[168px] h-[44px] md:w-[134px] w-[168px]"
                    text="Download Invoice"
                    onClick={() => goToInvoice(e?.invoice_link)}
                  />
                </div>
              </div>
            ))
          : currentFilteredItems.map((e, index) => (
              <div className={styles.order_item}>
                <div className="grid lg:grid-cols-5 grid-cols-2 py-25px px-19px">
                  <div className={`${styles.order_header} lg:col-span-4`}>
                    Order<b className="lg:ml-11px myOrderNumber">#{e.order_number}</b>
                  </div>
                  <div className={`${styles.order_header} lg:col-span-1 pl-10px`}>
                    Total <b className="lg:ml-11px">${e.order_total}</b>
                  </div>
                </div>
                <div className="grid lg:grid-cols-6 grid-cols-2 py-17px px-19px bg-darker-white">
                  <div className="pl-10px lg:pl-0">
                    <div>Date</div>
                    <div>
                      <b>{e.created_at}</b>
                    </div>
                  </div>
                  <div className="pl-10px">
                    <div>Status</div>
                    <div>
                      <b>{e.order_status}</b>
                    </div>
                  </div>
                  <div className="pl-10px pt-10px lg:pt-0">
                    <div>Total items</div>
                    <div>
                      <b>{e.total_items}</b>
                    </div>
                  </div>
                  <div className="pl-10px pt-10px lg:pt-0">
                    <div>Payment</div>
                    <div>
                      <b>{e.payment_status}</b>
                    </div>
                  </div>
                  <div className="pl-10px pt-10px lg:pt-0 w-min">
                    <div className={`${styles.reward_icon} lg:text-center`}>Rewards Earned</div>
                    <div className="text-center">
                      <b className="block">{e.total_reward_points_earned || '-'}</b>
                      {e.total_reward_points_earned ? (
                        <b className="block">
                          ${(e.total_reward_points_earned * e.total_reward_points_exchange).toFixed(2)}
                        </b>
                      ) : (
                        <b className="block">-</b>
                      )}
                    </div>
                  </div>
                  <div className="pl-10px pt-10px lg:pt-0 w-min">
                    <div className={`${styles.reward_icon} lg:text-center`}>Rewards Redeemed</div>
                    <div className="text-center">
                      <b className="block">{e.total_reward_points_redeemed || '-'}</b>
                      {e.total_reward_points_redeemed ? (
                        <b className="block">
                          -${(e.total_reward_points_redeemed * e.total_reward_points_exchange + '')?.replace('-', '')}
                        </b>
                      ) : (
                        <b className="block">-</b>
                      )}
                    </div>
                  </div>
                </div>
                <div className="px-19px pb-21px flex sm:flex-row flex-col flex-wrap sm:items-center items-end pt-20px gap-3">
                  <PrimarySmall
                    className="lg:w-[168px] h-[44px] md:w-[134px] w-[168px] md:mb-0"
                    text="Re-order"
                    onClick={() => reOrder(e)}
                  />
                  <SecondarySmall
                    className="lg:w-[168px] h-[44px] md:w-[134px] w-[168px]"
                    text="Download Invoice"
                    onClick={() => goToInvoice(e?.invoice_link)}
                  />
                </div>
              </div>
            ))}

        {currentItems?.length == 0 && currentFilteredItems?.length == 0 ? <h4>No orders found.</h4> : <></>}

        <div className={styles.MyPagination}>
          {!searchStr ? (
            <MyPagination
              items={items}
              pageCount={pageCount}
              setItemOffset={setItemOffset}
              itemsPerPage={itemsPerPage}
              forcePage={pageNumber}
              setItemPageNumber={setPageNumber}
            />
          ) : (
            <MyPagination
              items={filteredItems}
              pageCount={searchPageCount}
              setItemOffset={setSearchItemOffset}
              itemsPerPage={itemsPerPageSearch}
              forcePage={searchPageNumber}
              setItemPageNumber={setSearchPageNumber}
            />
          )}
        </div>
      </div>
    </>
  );
};

EditAccount.Layout = MyAccountLayout;
EditAccount.middleWares = [withAuth];

export const getServerSideProps = createGetServerSidePropsFn(EditAccount, async () => {
  const response = await getRequest(`/orders`);
  return {
    props: {
      orders: response?.data || [],
    },
  };
});

export default EditAccount;
