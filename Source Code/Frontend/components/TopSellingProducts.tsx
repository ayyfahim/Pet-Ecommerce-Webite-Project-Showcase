import styles from 'styles/TopSellingProducts.module.scss';
import get from 'lodash/get';
import Image from 'next/image';
import { IProductSchema } from 'schemas/product.schema';
import classNames from 'classnames';
import productOne from 'public/img/products/product-1@2x.webp';
import productSellingImg from 'public/img/productSellingImg.png';
import Link from 'next/link';

import { useCartState } from '../app/atom/cart.atom';
import { addToCart, shortHandleAddToCart } from '../features/cart/useCartService';
import { toast } from 'react-toastify';

type ITopSellingProductsProps = {
  products: IProductSchema[];
  homepageData: any;
};

type ISkeletonCardProps = {
  index: number;
};

const skeletonCards = Array(4).fill(0);

export default function TopSellingProducts({ products, homepageData }: ITopSellingProductsProps) {
  const [cart, setCart] = useCartState();
  const handleAddToCart = (product: IProductSchema) => {
    const newCart = addToCart(cart, product, 1);
    setCart(newCart);

    toast.clearWaitingQueue();
    toast.success('Added to Cart.', { toastId: 'notification' });
  };
  return (
    <div className={styles.wrapper}>
      <h2 className={styles.heading}>{homepageData?.top_selling_section_header ?? 'Top Selling Products'}</h2>
      <p className={styles.description}>
        {homepageData?.top_selling_section_description ??
          'Any parent will tell you that colic is one of the most excruciating experiences of early parenthood. The baby cries as if in dire pain.'}
      </p>
      <div className={styles.products}>
        {products
          ? products.map((product, index) => (
              <div className={styles.product} key={product.id}>
                <div className={classNames(styles.ProductImg)}>
                  <Link href={`/product/${product?.slug}`}>
                    <Image
                      alt="logo"
                      placeholder={'blur'}
                      blurDataURL={productOne.blurDataURL}
                      src={get(product.gallery, 'data[0].url') || product.cover || productSellingImg}
                      height={'196'}
                      width={'188'}
                      className="cursor-pointer"
                    />
                  </Link>
                </div>
                <span className={styles.priceMedia}>${product.sale_price}</span>
                <Link href={`/product/${product?.slug}`}>
                  <h4 className={`${styles.title} cursor-pointer`}>
                    {product.title || 'Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews'}
                  </h4>
                </Link>
                <p className={styles.productDescription}>
                  {product.excerpt || 'Small/Medium (5-35 lbs), 9 mg, 30 Soft Baked Chews'}
                </p>
                <div className={styles.PriceAndAddButton}>
                  <span className={styles.price}>${product.sale_price}</span>
                  <button
                    onClick={(event) => {
                      if (!product?.is_configured) {
                        shortHandleAddToCart(product, cart, setCart);
                      } else {
                        //@ts-ignore
                        window.location = `/product/${product?.slug}`;
                      }
                    }}
                    className={styles.addToCart}
                  >
                    Add to cart
                  </button>
                </div>
              </div>
            ))
          : skeletonCards.map((product, index) => <SkeletonCard index={index} />)}
      </div>
    </div>
  );
}

const SkeletonCard: React.FC<ISkeletonCardProps> = (props) => {
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
};
