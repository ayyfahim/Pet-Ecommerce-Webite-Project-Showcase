import react, { Fragment } from 'react';
import { Dialog, Transition } from '@headlessui/react';
import Image from 'next/image';
import leftArror from '@/public/img/logo/icon-16-arrow-with-point-left.svg';
import Filter from './Filter';
import style from 'styles/productList/components/SlideOver.module.scss';

const SlideOver = ({
  open = false,
  setOpen,
  categories,
  setCategories,
  brands,
  setBrands,
  clearFilter,
  totalProducts,
}) => {
  return (
    <Transition.Root show={open} as={Fragment}>
      <Dialog as="div" auto-reopen="true" className={style.wrapper} onClose={setOpen}>
        <div className={style.contentWrapper}>
          <Transition.Child
            as={Fragment}
            enter="transform transition ease-out-in duration-500 sm:duration-700"
            enterFrom="-translate-x-full"
            enterTo="-translate-x-0"
            leave="transform transition ease-out-in duration-500 sm:duration-700"
            leaveFrom="-translate-x-0"
            leaveTo="-translate-x-full"
          >
            <div className={style.content}>
              <div className={style.bottomFixed}>
                <div className={style.main}>
                  <button
                    className={style.closeButton}
                    onClick={() => {
                      setOpen(false);
                    }}
                  >
                    <Image src={leftArror} alt="close" />
                  </button>
                  <Filter
                    categories={categories}
                    setCategories={setCategories}
                    brands={brands}
                    setBrands={setBrands}
                    clearFilter={clearFilter}
                  />
                </div>

                <div className={style.bottomWrapper}>
                  <div className={style.bottom}>
                    <div className={style.filterCount}>{totalProducts} Products Found</div>
                    <button className={style.applyButton} onClick={() => setOpen(false)}>
                      Apply
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </Transition.Child>
        </div>
      </Dialog>
    </Transition.Root>
  );
};

export default SlideOver;
