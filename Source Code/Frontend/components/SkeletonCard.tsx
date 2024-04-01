import styles from 'styles/TopSellingProducts.module.scss';
import classNames from 'classnames';

type ISkeletonCardProps = {
  index: number;
};

export default function SkeletonCard(props: ISkeletonCardProps) {
  return (
    <div className={styles.product}>
      <div className={classNames(styles.ProductImg)}>
        <div className="sm:w-[188px] sm:h-[196px] w-[110px] h-[110px] animate-pulse bg-gradient-to-r from-gray-400 to-gray-500"></div>
      </div>
      <div className={`w-[70px] h-[20px] animate-pulse rounded-md bg-gray-400 ${styles.priceMedia}`}></div>
      <div
        className={`sm:h-[40px] sm:w-full w-[55px] h-[25px] animate-pulse rounded-md bg-gray-300 sm:mt-[23px] mt-[8px] ${styles.title}`}
      ></div>
      <div
        className={`sm:h-[70px] sm:w-full w-[130px] h-[60px] animate-pulse rounded-md bg-gray-200 mt-[10px] ${styles.productDescription}`}
      ></div>
      <div className={styles.PriceAndAddButton}>
        <div className={`w-[55px] h-[25px] animate-pulse rounded-md bg-gray-400 sm:block hidden ${styles.price}`}></div>
        <div className={`w-[136px] h-[45px] animate-pulse rounded-md bg-orange ${styles.addToCart}`}></div>
      </div>
    </div>
  );
}
