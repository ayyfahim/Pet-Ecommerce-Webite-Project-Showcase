import { useState, useEffect, useRef } from 'react';
import classNames from 'classnames';
import MainLayout from 'layouts/MainLayout';
import ShopByConcern from '../../components/ShopByConcern';
import Breadcrumbs from 'nextjs-breadcrumbs';
import { Level } from 'shared/GameData';
import Image from 'next/image';
import sort from '@/public/img/logo/group-17.svg';
import Filter from './components/Filter';
import SlideOver from './components/SlideOver';
import Product from '@/components/Product';
import ProductFeatured from '@/components/ProductFeatured';
import Banner from '@/components/Banner';
import style from 'styles/productList/style.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import MyPagination from '@/components/MyPagination/ProductsPagination';
import MySelect from '@/components/CartItems/componentsCartItem/MySelect';
import MySelectModal from '@/components/CartItems/componentsCartItem/MySelectModal';
import useWindowDimensions from 'app/hooks/useWindowDimensions.tsx';

import { getRequestSwr, getRequest } from 'requests/api';
import SkeletonCard from '@/components/SkeletonCard';
import { useRecoilValue } from 'recoil';
import { concernsAtom } from '@/app/atom/concernsAtom';

const ProductList = ({ slug, frontendData, concernData }) => {
  let category_id = concernData?.id;

  const [concerns, setConcerns] = useState([]);
  const [filterConcerns, setFilterConcerns] = useState([]);
  const [categories, setCategories] = useState([]);
  const [brands, setBrands] = useState([]);
  const [filterCategories, setFilterCategories] = useState([]);
  const [filterBrands, setFilterBrands] = useState([]);

  const [pageNumber, setPageNumber] = useState(1);
  const [modalActive, setModalActive] = useState(false);
  const [sortItem, setSortItem] = useState(null);
  const { width } = useWindowDimensions();
  const [open, setOpen] = useState(false);

  const setModalActiveSelect = () => {
    setModalActive(true);
  };
  const topOfProductsRef = useRef(null);

  const scrollToTopPaginate = () => {
    topOfProductsRef.current.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    });
  };

  const filterConcernIds =
    (filterConcerns &&
      filterConcerns.length &&
      filterConcerns?.filter((data) => data?.selected == true)?.map(({ id }) => id)) ||
    [];
  const filterCategoryIds =
    (filterCategories &&
      filterCategories.length &&
      filterCategories?.filter((data) => data?.selected == true)?.map(({ id }) => id)) ||
    [];
  const filterBrandIds =
    (filterBrands &&
      filterBrands.length &&
      filterBrands?.filter((data) => data?.selected == true)?.map(({ id }) => id)) ||
    [];

  let getProducts = [];
  let products = [];
  let isValidating;

  const productsUrl1 = `?page=${pageNumber}${
    sortItem ? '&sort_by=' + sortItem?.sort_by + '&sort_dir=' + sortItem?.sort_dir : ''
  }${'&concerns[]=' + category_id}`;
  let productsUrl2 = ``;
  if (filterCategoryIds && filterCategoryIds.length) {
    productsUrl2 = productsUrl2 + `&categories[]=${filterCategoryIds.join('&categories[]=')}`;
  }
  if (filterBrandIds && filterBrandIds.length) {
    productsUrl2 = productsUrl2 + `&brands[]=${filterBrandIds.join('&brands[]=')}`;
  }
  if (filterConcernIds && filterConcernIds.length) {
    productsUrl2 = productsUrl2 + `&concerns[]=${filterConcernIds.join('&concerns[]=')}`;
  }
  const productsUrl = productsUrl1 + productsUrl2;

  getProducts = getRequestSwr(`/products${productsUrl}`, {}, true);
  products = getProducts?.data?.data || [];
  isValidating = getProducts?.isValidating;

  useEffect(() => {
    if (categories && !categories.length) {
      setCategories(products?.meta?.categories || []);
    }
    if (brands && !brands.length) {
      setBrands(products?.meta?.brands || []);
    }
    if (concerns && !concerns.length) {
      setConcerns(products?.meta?.concerns || []);
    }
    if (filterCategories && !filterCategories.length) {
      const categories = products?.meta?.categories?.map((data) => ({
        ...data,
        selected: filterCategoryIds?.includes(data?.id),
      }));

      setFilterCategories(categories || []);
    }
    if (filterBrands && !filterBrands.length) {
      const brands = products?.meta?.brands?.map((data) => ({
        ...data,
        selected: filterBrandIds?.includes(data?.id),
      }));

      setFilterBrands(brands || []);
    }
    if (filterConcerns && !filterConcerns.length) {
      const brands = products?.meta?.concerns?.map((data) => ({
        ...data,
        selected: filterConcernIds?.includes(data?.id),
      }));

      setFilterConcerns(brands || []);
    }
  }, [products]);

  const handlePageChange = (page_count) => {
    const page_number = page_count?.selected + 1;
    setPageNumber(page_number);
    scrollToTopPaginate();
  };

  const clearFilter = () => {
    if (categories && categories?.length) {
      const newCategories = categories?.map((data) => ({
        ...data,
        selected: false,
      }));

      setCategories(newCategories || []);

      const newFilterCategories = filterCategories?.map((data) => ({
        ...data,
        selected: false,
      }));

      setFilterCategories(newFilterCategories || []);

      filterCategoryIds = [];
    }
    if (brands && brands?.length) {
      const newBrands = brands?.map((data) => ({
        ...data,
        selected: false,
      }));

      setBrands(newBrands || []);

      const newFilterBrands = filterBrands?.map((data) => ({
        ...data,
        selected: false,
      }));

      setFilterBrands(newFilterBrands || []);
      filterBrandIds = [];
    }
    if (concerns && concerns?.length) {
      const newConcerns = concerns?.map((data) => ({
        ...data,
        selected: false,
      }));

      setConcerns(newConcerns || []);

      const newFilterConcerns = filterConcerns?.map((data) => ({
        ...data,
        selected: false,
      }));

      setFilterConcerns(newFilterConcerns || []);
      filterConcernIds = [];
    }
  };

  let sortItems = products?.meta?.sorting
    ?.filter((data) => data?.sort_by != 'orders_number')
    ?.filter((data) => data?.sort_by != 'orders_amount')
    ?.map((item) => {
      return {
        value: item?.title,
        text: item?.sort_by,
        sort_by: item?.sort_by,
        sort_dir: item?.sort_dir,
      };
    });

  if (pageNumber > products?.meta?.pagination?.total_pages) {
    setPageNumber(1);
  }

  const productsPerPage =
    getProducts?.data?.meta?.pagination?.per_page * getProducts?.data?.meta?.pagination?.current_page || 0;
  const productsPerPageStarting = productsPerPage - getProducts?.data?.meta?.pagination?.per_page + 1 || 0;
  const totalProducts = getProducts?.data?.meta?.pagination?.total || 0;

  const skeletonCards = Array(12).fill(0);

  return (
    <div className={style.wrapper}>
      <Banner
        title={concernData?.banner_title || 'Concern'}
        description={concernData?.banner_description || null}
        image={frontendData?.banner_image || null}
      />
      <div className={style.breadcrumb}>
        <div className="px-5 sm:px-0">
          <Breadcrumbs
            rootLabel="Home"
            containerClassName={style.breadcrumbsWrapper}
            listClassName={style.listWrapper}
          />
        </div>
      </div>
      <ShopByConcern />
      <div className={style.productsWrapper} ref={topOfProductsRef}>
        <div className="px-5 mb-6 sm:px-0">
          <div className={style.header}>
            <div className={style.titleWrapper}>
              {/* <div className={style.title}>{title}</div> */}
              <div className={style.select}>{`Showing ${productsPerPageStarting}–${productsPerPage} of ${
                getProducts?.data?.meta?.pagination?.total || 0
              } products`}</div>
            </div>
            <div className={style.sortWrapper}>
              <div className={style.filterWrapper}>
                <button
                  type="button"
                  className={style.button}
                  onClick={() => {
                    setOpen((prev) => !prev);
                  }}
                >
                  Filter by
                </button>
              </div>
              <div className={style.sort}>
                <div className={style.contentWrapper}>
                  <div className={style.logoWrapper}>
                    <Image src={sort} alt="sort-logo" />
                  </div>
                  <label className={style.label}>Sort by: </label>
                  {width > 500 ? (
                    <MySelect
                      optionsArr={sortItems}
                      state={sortItem}
                      setState={setSortItem}
                      classNamePrefix={'mySelectPref'}
                    />
                  ) : (
                    <span className={style.ModalSelectSort} onClick={setModalActiveSelect}>
                      {sortItem}
                    </span>
                  )}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className={style.contentWrapper}>
          <div className={style.filter}>
            <Filter
              categories={categories}
              setCategories={setFilterCategories}
              brands={brands}
              setBrands={setFilterBrands}
              concerns={concerns}
              setConcerns={setFilterConcerns}
              clearFilter={clearFilter}
              category_id={category_id}
            />
          </div>
          <div className={style.products}>
            {!isValidating && products?.length == 0 ? <h4>No products found.</h4> : <></>}
            <div className={style.productWrapper}>
              {isValidating
                ? skeletonCards.map((product, index) => <SkeletonCard index={index} />)
                : products?.map((e, index) =>
                    e.type === 'Featured' ? (
                      <div
                        key={index}
                        className={classNames(style.product, {
                          [style.featured]: e.type === 'Featured',
                        })}
                      >
                        <ProductFeatured item={e} classname={'hidden lg:block'} />
                        <Product item={e} classname={'block lg:hidden'} />
                      </div>
                    ) : (
                      <div key={index} className={style.product}>
                        <Product item={e} />
                      </div>
                    )
                  )}
            </div>
            <div className={style.MyPagination}>
              <MyPagination {...products?.meta?.pagination} handlePageChange={handlePageChange} />
            </div>
          </div>
        </div>
      </div>
      <SlideOver
        open={open}
        setOpen={setOpen}
        categories={categories}
        setCategories={setFilterCategories}
        brands={brands}
        setBrands={setFilterBrands}
        clearFilter={clearFilter}
        totalProducts={totalProducts}
      />
      <MySelectModal active={modalActive} setActive={setModalActive}>
        <h3>Sort By</h3>
        {Level.map((item) => (
          <div
            onClick={() => {
              setSortItem(item.value);
              setModalActive(false);
            }}
            className="SortItem"
            key={item.text}
          >
            {item.text}
          </div>
        ))}
      </MySelectModal>
    </div>
  );
};

ProductList.Layout = MainLayout;

export const getServerSideProps = createGetServerSidePropsFn(ProductList, async ({ params }) => {
  const response = await getRequest('/page/shop');
  const response2 = await getRequest(`/concerns/${params?.slug}`);

  return {
    props: {
      slug: params?.slug || '',
      frontendData: response?.page ?? [],
      concernData: response2?.concern ?? [],
    },
  };
});

export default ProductList;
