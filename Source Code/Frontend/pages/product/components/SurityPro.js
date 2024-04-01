import { useState, useContext, useEffect, useRef } from 'react';
import styles from '../../../styles/product/SurityPro.module.css';
import Image from 'next/image';
import canopy from '../../../public/img/HomePage/bitmap.png';
import facebookIcon from '../../../public/img/HomePage/045-facebook.png';
import tweetIcon from '../../../public/img/HomePage/013-twitter-1.png';
import pinIcon from '../../../public/img/HomePage/026-pinterest.png';
import ReviewIcon from '../../../public/img/HomePage/path.png';
import { BiMinus, BiPlus } from 'react-icons/bi';
import { UserContext } from 'contexts/user.context';
import MySelect from '@/components/CartItems/componentsCartItem/MySelect';
import classNames from 'classnames';
import useWindowDimensions from 'app/hooks/useWindowDimensions';
import heartIcon from 'public/img/account/icons/wishlist.svg';
import heartIconActive from 'public/img/account/icons/wishlist_active.webp';
// eslint-disable-next-line react-hooks/rules-of-hooks
// const imgs = [
//   { id: 0, url: '/img/HomePage/rectangle.png' },
//   { id: 1, url: '/img/HomePage/rectangle.png' },
//   { id: 2, url: '/img/HomePage/rectangle.png' },
//   { id: 3, url: '/img/HomePage/rectangle.png' },
// ];

const selectValues = [
  { value: '1 month', label: '1 month' },
  { value: '2 month', label: '2 month' },
  { value: '3 month', label: '3 month' },
  { value: '4 month', label: '4 month' },
  { value: '5 month', label: '5 month' },
  { value: '6 month', label: '6 month' },
];

export default function SurityPro({
  product,
  countState,
  increase,
  decrease,
  handleAddToCart,
  addonState,
  setAddonState,
  handleSetAddonState,
  width,
  setScroll,
  wishList,
  handleAddToWishlist,
}) {
  const imgs = [{ id: 0, url: product?.cover }, ...(product?.gallery?.data ?? [])];
  // const userContext = useContext(UserContext);
  // imgs[0].url = userContext.url;
  const description = {
    price: product?.sale_price,
    regular_price: product?.regular_price,
    text: product?.excerpt,
    comment: 'Free Shipping on orders above $20',
    review: 42,
    discount: { ...(product?.discount ?? []) },
  };

  return (
    <div className={styles.wrapper}>
      <span className={styles.urlText}>Home{product?.categories.map((cat) => ` / ${cat?.name}`)}</span>
      <div className={styles.body}>
        <h4 className={styles.title}>{product?.title}</h4>
        <div className={styles.brand}>
          <div className={styles.brand_body}>
            <span>
              <span className={styles.boldText}>Brand</span>
              <span className="">: {product?.brand?.name} </span>
            </span>
            <img alt="img" src="/img/HomePage/bitmap.png" className={styles.brand_logo} />
          </div>
        </div>
        <MainBody
          description={description}
          imgs={imgs}
          countState={countState}
          increase={increase}
          decrease={decrease}
          handleAddToCart={handleAddToCart}
          configurations={product?.configurations}
          addonState={addonState}
          setAddonState={setAddonState}
          handleSetAddonState={handleSetAddonState}
          width={width}
          setScroll={setScroll}
          wishList={wishList}
          handleAddToWishlist={handleAddToWishlist}
          productId={product?.id}
        />
      </div>
    </div>
  );
}

function MainBody({
  description,
  imgs,
  countState,
  increase,
  decrease,
  handleAddToCart,
  configurations,
  addonState,
  setAddonState,
  handleSetAddonState,
  width,
  setScroll,
  wishList,
  handleAddToWishlist,
  productId,
}) {
  const [imgState, setImg] = useState(0);

  return (
    <div className={`${styles.flexRow} ${styles.mt_32} ${styles.flexWrap}`}>
      <div className={`${styles.width55} ${styles.surity_imgField}`}>
        {width > 770 ? (
          <>
            {imgs.map((img, i) => (
              <div className={`${styles.width}`} key={i}>
                {imgState == img.id ? (
                  <div className={imgState == 0 ? styles.ImgSection0 : styles.ImgSection}>
                    <div className={styles.bigImg_item}>
                      <img alt="img" src={img.url} />

                      <div className={styles.favorite} onClick={() => handleAddToWishlist()}>
                        {wishList?.find((x) => x.id === productId) ? (
                          <Image alt="favorite" src={heartIconActive} width={20} height={20} />
                        ) : (
                          <Image alt="favorite" src={heartIcon} width={20} height={20} />
                        )}
                      </div>
                    </div>
                    <div className={styles.imgSliderDotsWrapper}>
                      {imgs.map((img, i) => (
                        <div
                          className={`${styles.imgSliderDot} ${imgState == img.id ? styles.imgSliderDotActive : ''}`}
                          onClick={() => setImg(img?.id)}
                        ></div>
                      ))}
                    </div>
                  </div>
                ) : (
                  ''
                )}
              </div>
            ))}
            <div className={styles.MenuSection}>
              {imgs.map((img, i) => (
                <div
                  className={imgState == img?.id ? styles.active_border_img : styles.border_img}
                  key={img?.id}
                  onClick={() => setImg(img?.id)}
                >
                  <img alt="img" className={styles.menuImg} src={img.url} />
                </div>
              ))}
            </div>
          </>
        ) : (
          <>
            <div className={styles.MenuSection}>
              {imgs.map((img, i) => (
                <div
                  className={imgState == img?.id ? styles.active_border_img : styles.border_img}
                  key={img?.id}
                  onClick={() => setImg(img?.id)}
                >
                  <img alt="img" className={styles.menuImg} src={img.url} />
                </div>
              ))}
            </div>
            {imgs.map((img, i) => (
              <div className={`${styles.width}`} key={i}>
                {imgState == img.id ? (
                  <div className={imgState == 0 ? styles.ImgSection0 : styles.ImgSection}>
                    <img alt="img" className={styles.bigImg_item} src={img.url} />
                    <div className={styles.imgSliderDotsWrapper}>
                      {imgs.map((img, i) => (
                        <div
                          className={`${styles.imgSliderDot} ${imgState == img.id ? styles.imgSliderDotActive : ''}`}
                          onClick={() => setImg(img?.id)}
                        ></div>
                      ))}
                    </div>
                  </div>
                ) : (
                  ''
                )}
              </div>
            ))}
          </>
        )}
      </div>
      <div className={styles.DecSection}>
        <Description
          imgState={imgState}
          description={description}
          countState={countState}
          increase={increase}
          decrease={decrease}
          handleAddToCart={handleAddToCart}
          configurations={configurations}
          addonState={addonState}
          setAddonState={setAddonState}
          handleSetAddonState={handleSetAddonState}
          setScroll={setScroll}
        />
      </div>
    </div>
  );
}

function Description(props) {
  const {
    imgState,
    description,
    countState,
    increase,
    decrease,
    handleAddToCart,
    configurations,
    addonState,
    setAddonState,
    handleSetAddonState,
    setScroll,
  } = props;
  const [packState, setPack] = useState(null);
  const [buyOptionState, setBuyOption] = useState(1);
  const [selectSubscriptionTime, setSelectSubscriptionTime] = useState('1 moth');
  const buttonRef = useRef(null);

  useEffect(() => {
    window.addEventListener('scroll', (e) => {
      const bottom = window.scrollY > buttonRef?.current?.offsetTop + buttonRef?.current?.offsetHeight;
    });

    const handleScroll = () => {
      const bottom = window.scrollY > buttonRef?.current?.offsetTop + buttonRef?.current?.offsetHeight;
      if (bottom) {
        setScroll(true);
      } else {
        setScroll(false);
      }
    };
    window.addEventListener('scroll', handleScroll, true);
    return () => window.removeEventListener('scroll', handleScroll, true);
  }, []);

  return (
    <>
      <div>
        {
          <div className={styles.flexCol}>
            <div className={styles.price_review}>
              <div className={styles.flexCol}>
                <div className={styles.mainPrice}>
                  <div className={styles.mainPrice}>${Math.abs(description?.price).toFixed(2)}</div>
                  {description?.price < description?.regular_price && (
                    <>
                      <div className={styles.mainPrice_off}>${Math.abs(description?.regular_price).toFixed(2)}</div>
                      <div className={styles.percent_off}>{description?.discount?.percentage}% OFF</div>
                    </>
                  )}
                </div>
                <div className={styles.reviewDec_text}>{description.comment}</div>
              </div>
              <div className={styles.review_field}>
                <div className={styles.review}>
                  {[...Array(5)].map((x, i) => (
                    <div key={i} className={styles.reviewImg}>
                      <Image alt="logo" src={ReviewIcon} width={22} height={22} key={i} />
                    </div>
                  ))}
                </div>
                <div className={styles.reviewDec_count}>{description.review} reviews</div>
              </div>
            </div>
            <div className={styles.prodectDec}>{description.text}</div>
            {configurations?.map((config) => (
              <>
                <div className={styles.packSize}>{config?.label}</div>
                <div className={styles.packField}>
                  {config?.options?.map((opt, index) => (
                    <div
                      onClick={() => handleSetAddonState(opt?.id, config?.options)}
                      className={`${
                        addonState?.includes(opt?.id) ? `${styles.pack_active_border}` : `${styles.pack_border}`
                      } ${index !== 0 ? 'ml-3' : ''}`}
                    >
                      <span className={`${addonState?.includes(opt?.id) ? styles.active_smallFont : styles.smallFont}`}>
                        {opt?.value}
                      </span>
                    </div>
                  ))}
                </div>
              </>
            ))}
            <div className={styles.flexRow}>
              <div className={styles.addCart_count}>
                <div onClick={decrease} className={countState == 1 ? styles.dis_minus : styles.act_minus}>
                  <BiMinus />
                </div>
                <div className={styles.addCart_count_num}>{countState}</div>
                <div onClick={increase} className={styles.plus}>
                  <BiPlus />
                </div>
              </div>
              <button onClick={() => handleAddToCart()} className={styles.addCartField} ref={buttonRef}>
                Add to Cart
              </button>
            </div>
            <div className={`${styles.border} !mt-6`}></div>
          </div>
        }
      </div>
    </>
  );
}
