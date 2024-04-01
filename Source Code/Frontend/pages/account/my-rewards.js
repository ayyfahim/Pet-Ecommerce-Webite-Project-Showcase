import { useState, useEffect } from 'react';

import styles from 'styles/account/myRewards.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import MyPagination from '@/components/MyPagination/MyPagination';
import MyAccountLayout from 'layouts/MyAccountLayout';

import { getRequestSwr } from 'requests/api';
import { useAuthValue } from '@/app/atom/auth.atom';
import { getRequest } from 'requests/api';

const EditAccount = ({ rewardPointExchange }) => {
  const [items, setItems] = useState([
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Redeemed for order #2415487',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 97.92,
      reward: 12.98,
      reward_postive: false,
    },
    {
      header_text: 'Reward received for order #3654877',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 79.92,
      reward: 12.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for Facebook Share',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: null,
      order_total: null,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #4785416',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Redeemed for order #9863478',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
    {
      header_text: 'Reward received for order #1457895',
      created_at: '25 Nov 2021, 01:00 PM',
      total_items: 12,
      order_total: 98.92,
      reward: 22.98,
      reward_postive: true,
    },
  ]);

  const [isFirstLoading, setIsFirstLoading] = useState(true);

  useEffect(() => {
    setIsFirstLoading(false);
  }, []);

  const getAllRewardItems = getRequestSwr(!isFirstLoading ? `/reward_points` : null, {}, true, {
    doNotHandleError: false,
  });
  const rewards = (getAllRewardItems && getAllRewardItems?.data?.data?.data) || [];

  useEffect(() => {
    setItems(rewards);
  }, [rewards]);

  const [currentItems, setCurrentItems] = useState(items);
  const [pageCount, setPageCount] = useState(0);
  const [itemOffset, setItemOffset] = useState(0);
  const [pageNumber, setPageNumber] = useState(0);
  const itemsPerPage = 10;

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(items.slice(itemOffset, endOffset));
    setPageCount(Math.ceil(items.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, items]);

  const user = useAuthValue();
  const totalRewardPoints = Object.keys(user?.user)?.length ? user?.user?.total_reward_points : 0;
  const token = Object.keys(user?.user)?.length ? user?.token : '';

  const goToInvoice = (link) => window.open(`${link}?token=${token}`, '_blank', 'noopener,noreferrer');

  return (
    <>
      <div className="flex flex-row flex-wrap md:justify-between">
        <h4 className={styles.title}>My Rewards</h4>
        <span className="text-xl font-bold text-dark-green lg:text-right lg:w-[unset] w-full flex flex-wrap">
          <b className="text-lighter-black pr-[6px]">Total available</b>{' '}
          <div>
            {' '}
            {totalRewardPoints} <br /> (${totalRewardPoints * rewardPointExchange || 0}){' '}
          </div>
        </span>
      </div>
      <span className="block lg:mt-[-22px] mb-[24px] text-base text-lighter-black">
        Shop and earn points on purchases, social interactions, & more!{' '}
        <a className="underline font-bold" href={`/reward-program`}>
          Know more
        </a>
      </span>

      <div className={styles.reward_box}>
        {currentItems?.length > 0 ? (
          currentItems.map((e, index) => (
            <div className={styles.reward_item}>
              <div>
                <div className={styles.reward_header}>
                  <h6>{e?.event}</h6>
                  <a href={`${e?.invoice_link}?token=${token}`}>View Invoice</a>
                </div>
                <div className={styles.reward_info}>
                  <span>{e.created_at}</span> {e.total_items && <span>Total items {e?.total_items}</span>}{' '}
                  {e.order_total && <span>Order total ${e.order_total}</span>}
                </div>
              </div>
              <div className={`${styles.total_reward} ${e.point > 0 ? '' : styles.total_reward_negative}`}>
                {e?.point} <br /> {e.point < 0 ? '-' : ''} ($
                {((e?.point * rewardPointExchange).toFixed(2) + '')?.replace('-', '') || 0})
              </div>
            </div>
          ))
        ) : (
          <h4>No items found.</h4>
        )}
      </div>

      <div className={styles.MyPagination}>
        <MyPagination items={items} pageCount={pageCount} setItemOffset={setItemOffset} itemsPerPage={itemsPerPage} />
      </div>
    </>
  );
};

EditAccount.Layout = MyAccountLayout;

export const getServerSideProps = createGetServerSidePropsFn(EditAccount, async () => {
  const response = await getRequest('/getTotalRewardPoint');

  return {
    props: {
      rewardPointExchange: response?.data?.exchange || null,
    },
  };
});

export default EditAccount;
