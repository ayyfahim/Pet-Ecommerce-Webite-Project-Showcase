import EmailLayout from 'layouts/Email.layout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import style from 'styles/email/OrderReceived.module.scss';

const OrderReceived = () => {
  return (
    <div>
      <p className={`${style.textPara} ${style.lineHeightL}`}>
        Hello, <br />
        Thank you for shopping with us. We've received your order. <br />
        You can add items to your Pay-On-Delivery orders until we start packing closer to your delivery slot time.{' '}
        <br />
        Please ensure someone is present at the address to receive the delivery. <br />
      </p>
      <p className={`${style.textPara} ${style.lineHeight} mt-3`}>
        Details <br />
        Order <span className={style.textPink}>#402-6827799-6509154</span> <br />
        Tracking code <span className={style.textPink}> #402-6827799-6509154</span> <br />
      </p>
      <div className="grid grid-cols-6 py-20px">
        <div className="col-span-6 sm:col-span-3">
          <p className={`${style.textGray}`}>Delivery time:</p>
          <p className={`${style.textPara}`}>
            Friday, October 22, 2021 <br />
            12:00 PM - 2:00 PM (Attended Delivery)
          </p>
        </div>
        <div className="col-span-6 sm:col-span-3 sm:mt-0 mt-3 sm:justify-self-end">
          <p className={`${style.textGray}`}>Deliver to:</p>
          <p className={`${style.textPara}`}>San Francisco, California</p>
        </div>
      </div>
      <div className={style.grayBorder}></div>
      <div className="grid grid-cols-6 py-20px pb-0">
        <div className="col-span-6 sm:col-span-3">
          <p className={`${style.textPara}`}>
            Order total: <b>$434.00</b> <br />
            We hope to see you again soon,
          </p>
        </div>
        <div className="col-span-6 sm:col-span-3 sm:mt-0 mt-3 sm:justify-self-end">
          <PrimarySmall className="w-[200px] h-[44px] ml-auto" text="View Order" />
        </div>
      </div>
    </div>
  );
};

OrderReceived.Layout = EmailLayout;

export const getServerSideProps = createGetServerSidePropsFn(OrderReceived);

export default OrderReceived;
