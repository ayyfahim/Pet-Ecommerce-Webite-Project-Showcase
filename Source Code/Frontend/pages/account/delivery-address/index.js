import styles from 'styles/account/deliveryAddress.module.scss';
import MyAccountLayout from 'layouts/MyAccountLayout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import { BiPlus } from 'react-icons/bi';
import Link from 'next/link';
import { withAuth } from '@/app/middleware/auth';
import LoadingState from '@/components/LoadingState';
import { getRequestSwr, postRequest, apiRequest, patchRequest } from 'requests/api';
import { useEffect, useState } from 'react';
import { useAuthValue } from '@/app/atom/auth.atom';
import MyPagination from '@/components/MyPagination/MyPagination';
import { useRouter } from 'next/router';

const DeliveryAddress = () => {
  const { user } = useAuthValue();
  const [isLoading, setIsLoading] = useState(true);
  const [isFirstLoading, setIsFirstLoading] = useState(true);

  const router = useRouter();

  useEffect(() => {
    setIsFirstLoading(false);
  }, []);

  const getAllAddress = getRequestSwr(!isFirstLoading ? `/address` : null, {}, true);
  const addresses = (getAllAddress && getAllAddress?.data?.data) || [];
  let isValidating = getAllAddress?.isValidating;

  useEffect(() => {
    if (isLoading !== isValidating) {
      setIsLoading(isValidating);
    }
  }, [isValidating]);

  const [items, setItems] = useState([]);
  const [currentItems, setCurrentItems] = useState(items);
  const [pageCount, setPageCount] = useState(0);
  const [itemOffset, setItemOffset] = useState(0);
  const itemsPerPage = 3;

  useEffect(() => {
    setItems(addresses);
  }, [addresses]);

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(items.slice(itemOffset, endOffset));
    setPageCount(Math.ceil(items.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, items]);

  const deleteAddress = (id) => {
    if (!id) {
      return;
    }
    setIsLoading(true);

    apiRequest('delete', `/address/destroy/${id}`, {})
      .then((res) => {
        setIsLoading(false);
        console.log('res', res);
        if (res?.status) {
          router.reload(window.location.pathname);
        }
      })
      .catch(() => {
        setIsLoading(false);
      });
  };

  const makeDefaultAddress = (id) => {
    if (!id) {
      return;
    }
    setIsLoading(true);

    patchRequest(`/address/update/${id}`, { default: 'true' })
      .then((res) => {
        setIsLoading(false);
        console.log('res', res);
        if (res?.status) {
          router.reload(window.location.pathname);
        }
      })
      .catch(() => {
        setIsLoading(false);
      });
  };

  return (
    <>
      {isLoading && <LoadingState />}
      <h4 className={styles.title}>Delivery Address</h4>
      <div className={styles.deliveryAddressBox}>
        <div className={`${styles.item} cursor-pointer`} onClick={() => router.push('/account/delivery-address/add')}>
          <div className={`${styles.addressItem} ${styles.createAddressItem}`}>
            <div className={styles.icon}>
              <BiPlus width="30" height="30" />
            </div>
            <h4>Add New Address</h4>
          </div>
        </div>

        {currentItems?.map((data) => (
          <div className={styles.item}>
            <div className={`${styles.addressItem}`}>
              {(data?.name || user?.full_name) && <h4>{data?.name || user?.full_name}</h4>}
              <p>
                {`${data?.street_address ?? ''}${data?.city ? ', ' + data?.city : ''}${
                  data?.country ? ', ' + data?.country : ''
                }${data?.postal_code ? ', ' + data?.postal_code : ''}`}
              </p>
              {(data?.phone || user?.mobile) && <p>Phone: {data?.phone || user?.mobile}</p>}
              <ul className={`${styles.actions}`}>
                <li>
                  <Link href={`/account/delivery-address/edit/${data?.id}`}>Edit</Link>
                </li>
                <li onClick={() => deleteAddress(data?.id)} className="cursor-pointer">
                  Remove
                </li>
                {data?.default ? (
                  <li className={styles.default}>
                    <Link href={'#'}>Default Address</Link>
                  </li>
                ) : (
                  <li onClick={() => makeDefaultAddress(data?.id)} className="cursor-pointer">
                    Set As Default
                  </li>
                )}
              </ul>
            </div>
          </div>
        ))}
      </div>
      <div className={styles.MyPagination}>
        <MyPagination
          items={addresses}
          pageCount={pageCount}
          setItemOffset={setItemOffset}
          itemsPerPage={itemsPerPage}
        />
      </div>
    </>
  );
};

DeliveryAddress.Layout = MyAccountLayout;
DeliveryAddress.middleWares = [withAuth];

export const getServerSideProps = createGetServerSidePropsFn(DeliveryAddress);

export default DeliveryAddress;
