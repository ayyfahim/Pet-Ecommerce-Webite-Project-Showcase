import EmailLayout, { useFooter } from 'layouts/Email.layout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import style from 'styles/email/OrderReceived.module.scss';

const OrderReceived = () => {
  useFooter(false);
  return (
    <div>
      <p className={`${style.textPara} ${style.lineHeightL}`}>
        Hello, <br />
        You have requested to reset password for your VitalPawz Account.
      </p>
      <p className={`${style.textPara} ${style.lineHeightL} mt-3`}>
        Please click on reset button below to reset your password.
      </p>
      <PrimarySmall className="w-[230px] h-[44px] mt-6 mb-10" text="Reset my Password" />
      <p className={`${style.textPara}`}>
        Thank you, <br />
        <span className="font-bold">
          <span className="text-purple">Vital</span>
          <span className="text-pink">Pawz</span>
        </span>
      </p>
    </div>
  );
};

OrderReceived.Layout = EmailLayout;

export const getServerSideProps = createGetServerSidePropsFn(OrderReceived);

export default OrderReceived;
