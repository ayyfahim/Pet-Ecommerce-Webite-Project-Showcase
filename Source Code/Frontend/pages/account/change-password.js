import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';

import PrimarySmall from 'components/Buttons/PrimarySmall';
import InputLabel from 'components/InputLabel';
import MyAccountLayout from 'layouts/MyAccountLayout';
import styles from 'styles/account/edit.module.scss';
import { FormProvider } from 'react-hook-form';
import useReactForm from 'hooks/useReactForm';
import { object, string, ref } from 'yup';

const formSchema = object().shape({
  password: string().required('Please enter your password.').min(8, 'Your password is too short.'),
  password_confirmation: string()
    .required('Please retype your password.')
    .oneOf([ref('password')], 'Your passwords do not match.'),
});

const EditAccount = () => {
  const { methods, submitHandler, isLoading } = useReactForm(
    'post',
    '/address',
    formSchema,
    {
      mobile: '',
      name: '',
    },
    {
      onSuccess: () => {
        toast.clearWaitingQueue();
        toast.success('Address added successfully', { toastId: 'notification' });
        router.push('/account/delivery-address');
      },
    }
  );

  return (
    <>
      <FormProvider {...methods}>
        <form onSubmit={submitHandler}>
          <h4 className={styles.title}>Change Password</h4>

          <div className={styles.editProfile}>
            <div className="w-full xl:w-2/4 lg:w-4/6 mb-[30px] lg:mb-0">
              <InputLabel name="password" label="New Password" inputType={'text'} inputPlaceholder="New Password" />
            </div>
            <div className="w-full"></div>
            <div className="w-full xl:w-2/4 lg:w-4/6 mb-[30px] mt-[25px]">
              <InputLabel
                name="password_confirmation"
                label="Confirm Password"
                inputType={'text'}
                inputPlaceholder="Confirm Password"
              />
            </div>

            <div className="w-full mt-[28px]">
              <PrimarySmall className="w-[168px] h-[44px] mr-10px mb-11px md:mb-0" text="Update Password" />
            </div>
          </div>
        </form>
      </FormProvider>
    </>
  );
};

EditAccount.Layout = MyAccountLayout;

export const getServerSideProps = createGetServerSidePropsFn(EditAccount);

export default EditAccount;
