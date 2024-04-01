import EmailLayout, { useHeader, useFooter, Footer } from 'layouts/Email.layout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import logo from 'public/img/header/logo-horizontal.svg';
import Image from 'next/image';
import style from 'styles/email/OrderReceived.module.scss';
import CartItemPreview from '@/components/CartItems/images/cartItemPreview.png';

const OrderReceived = () => {
  useHeader(false);
  useFooter(false);

  return (
    <div>
      <div className="w-[150px] mb-[27px]">
        <Image src={logo} />
      </div>
      <p className={`${style.textBold} pb-[14px]`}>Hello Deepak,</p>
      <p className={`${style.textPara} pb-[20px]`}>
        We thought you'd like to know that we've dispatched your item(s). Your order is on the way. If you need to
        return an item from this shipment or manage other orders, please visit Your Orders on Amazon.in.
      </p>
      <div className="grid grid-cols-2 pb-25px">
        <div className="sm:col-span-1 col-span-2">
          <p className={`${style.textPara}`}>Arriving:</p>
          <p className={`${style.textPinkL}`}>Wednesday, September 29</p>
        </div>
        <div className="sm:col-span-1 col-span-2">
          <p className={`${style.textPara}`}>Your package was sent to:</p>
          <p className={`${style.textPinkL}`}>San Francisco, California</p>
        </div>
      </div>
      <div className="pb-[20px]">
        <PrimarySmall className="w-[200px] h-[44px]" text="Track you Package" />
      </div>
      <p className={`${style.textGray}`}>Order summary</p>
      <div className="py-[20px] flex flex-row flex-wrap">
        <div className="sm:w-2/5 w-3/5">
          <p className={`${style.textGray2}`}>Item Subtotal:</p>
          <p className={`${style.textGray2}`}>Shipping & Handling:</p>
          <p className={`${style.textGray2}`}>POD Convenience Fee:</p>
          <p className={`${style.textPurple}`}>Shipment Total:</p>
          <p className={`${style.textGray2}`}>Paid by Visa:</p>
        </div>
        <div className="flex-1">
          <p className={`${style.textGray2}`}>Rs.1,195.08</p>
          <p className={`${style.textGray2}`}>Rs.0.00</p>
          <p className={`${style.textGray2}`}>Rs.0.00</p>
          <p className={`${style.textPurple}`}>Rs.1,195.08</p>
          <p className={`${style.textGray2}`}>Rs.1,195.08</p>
        </div>
      </div>
      <div className={style.grayBorder}></div>
      <div className={`${style.textItalic} py-25px`}>
        Track your order with the VitalPawz. <br /> We hope to see you again soon,
      </div>
      <div className={style.grayBorder}></div>
      <div className={`py-25px`}>
        <p className={`${style.textPurpleL} pb-[15px]`}>Recommended Products</p>
        <div className="grid sm:grid-cols-3 grid-cols-2 gap-8">
          <div className="col-span-1 text-center">
            <div className="w-80px mx-auto">
              <Image src={CartItemPreview} />
            </div>
            <h4 className={`${style.textBoldL} py-10px`}>$25.56</h4>
            <p className={style.textPara2}> Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews</p>
          </div>
          <div className="col-span-1 text-center">
            <div className="w-80px mx-auto">
              <Image src={CartItemPreview} />
            </div>
            <h4 className={`${style.textBoldL} py-10px`}>$25.56</h4>
            <p className={style.textPara2}> Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews</p>
          </div>
          <div className="col-span-1 hidden sm:block text-center">
            <div className="w-80px mx-auto">
              <Image src={CartItemPreview} />
            </div>
            <h4 className={`${style.textBoldL} py-10px`}>$25.56</h4>
            <p className={style.textPara2}> Martha Stewart CBD Calm Chicken and Cranberry Flavor Soft Baked Chews</p>
          </div>
        </div>
      </div>
      <div className={style.grayBorder}></div>
      <Footer className="!w-full" />
    </div>
  );
};

OrderReceived.Layout = EmailLayout;

export const getServerSideProps = createGetServerSidePropsFn(OrderReceived);

export default OrderReceived;
