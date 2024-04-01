import styles from 'styles/cart-checkout/checkout/style.module.scss';
import { useDebouncedCallback } from 'use-debounce';

const CustomerDetails = ({
  fullName,
  mobileNumber,
  email,
  updateOffersChecked,
  handleCheckoutData,
  errors,
  createOrderTemporary,
  onKeyPress,
}) => {
  const debounced = useDebouncedCallback(() => {
    createOrderTemporary();
  }, 500);

  return (
    <div
      id="customer_details_block"
      className={`${styles.flexRow} ${styles.mt_14} ${styles.flexWrap} ${styles.checkoutBox}`}
    >
      <div className={`${styles.width100}`}>
        <form className="" action="/" method="POST">
          <div className="">
            <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.alignCenter}`}>
              <h4 className={`${styles.checkoutBoxHeader} ${styles.sm_w_100} ${styles.sm_m_0}`}>Your Details</h4>
              <span className={`${styles.urlText2} ${styles.sm_w_100} ${styles.sm_d_none}`}>
                Already have an account? <b>Log in</b>
              </span>
            </div>

            <div className={`${styles.flexRow} ${styles.flexWrap} ${styles.mt_24}`}>
              <div className={`${styles.pr_12} ${styles.width100} ${styles.sm_w_100} ${styles.sm_p_0}`}>
                <label htmlFor="username" className={styles.formLabel}>
                  Full Name
                </label>
                <div>
                  <input
                    id="fullName"
                    name="fullName"
                    type="text"
                    autoComplete="fullName"
                    placeholder="First & Last Name"
                    required
                    className={styles.formInput}
                    value={fullName}
                    onChange={(e) => {
                      handleCheckoutData(e);
                      debounced();
                    }}
                    onKeyDown={onKeyPress}
                  />
                  {errors && errors?.full_name && <p className="text-red-500 mt-2 text-[12px]">{errors?.full_name}</p>}
                </div>
              </div>
              <div className={`${styles.width100} ${styles.sm_w_100} ${styles.sm_mt_24} ${styles.mt_24}`}>
                <label htmlFor="username" className={styles.formLabel}>
                  Contact Number
                </label>
                <div>
                  <input
                    id="mobileNumber"
                    name="mobileNumber"
                    type="tel"
                    autoComplete="mobileNumber"
                    placeholder="Contact"
                    required
                    className={styles.formInput}
                    value={mobileNumber}
                    onChange={(e) => {
                      handleCheckoutData(e);
                      debounced();
                    }}
                    onKeyDown={onKeyPress}
                  />
                  {errors && errors?.mobile && <p className="text-red-500 mt-2 text-[12px]">{errors?.mobile}</p>}
                </div>
              </div>
              <div className={`${styles.width100} ${styles.mt_24}`}>
                <label htmlFor="username" className={styles.formLabel}>
                  Email
                </label>
                <div>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    autoComplete="email"
                    placeholder="Email"
                    required
                    className={styles.formInput}
                    value={email}
                    onChange={(e) => {
                      handleCheckoutData(e);
                      debounced();
                    }}
                    onKeyDown={onKeyPress}
                  />
                  {errors && errors?.email && <p className="text-red-500 mt-2 text-[12px]">{errors?.email}</p>}
                </div>
              </div>
              <div className={`${styles.width100} ${styles.mt_24} ${styles.checkoutCheckbox}`}>
                <label
                  className={`${styles.flexRow} ${styles.flexNoWrap} ${styles.alignCenter} ${styles.justifyStart} `}
                >
                  <input
                    name="updateOffersChecked"
                    type="checkbox"
                    className={`${styles.checkbox} mr-3`}
                    checked={updateOffersChecked}
                    onChange={(e) => {
                      handleCheckoutData(e);
                      debounced();
                    }}
                  />
                  <p className="text-sm text-medium_black">Keep me up to date on my orders and exclusive offers.</p>
                </label>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  );
};

export default CustomerDetails;
