import styles from 'styles/account/edit.module.scss';
import InputLabel from 'components/InputLabel';
import MyAccountLayout from 'layouts/MyAccountLayout';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import PrimarySmall from 'components/Buttons/PrimarySmall';
import SecondarySmall from 'components/Buttons/SecondarySmall';
import useReactForm from 'hooks/useReactForm';
import { object, string } from 'yup';
import { FormProvider } from 'react-hook-form';
import useAuthService from 'features/auth/hooks/useAuthService';
import { sendVerificationEmail } from 'requests/profile.request';
import { withAuth } from '@/app/middleware/auth';
import LoadingState from '@/components/LoadingState';
import { useEffect, useState } from 'react';
import { toast } from 'react-toastify';

const phoneRegExp = /^((\+[1-9]{1,4}[ -]?)|(\([0-9]{2,3}\)[ -]?)|([0-9]{2,4})[ -]?)*?[0-9]{3,4}[ -]?[0-9]{3,4}$/;
// phoneNumber: Yup.string().matches(phoneRegExp, 'Phone number is not valid')

const formSchema = object().shape({
  full_name: string().label('Full Name').required(),
  email: string().label('Email').required().email(),
  mobile: string('Please put your Phone Number')
    .matches(phoneRegExp, 'Phone number is not valid')
    .label('Phone Number')
    .required('Please put your Phone Number')
    .nullable(),
});

const EditAccount = ({ user: { full_name, mobile, email, id }, token }) => {
  const setAuth = useAuthService();
  const [isFirstLoading, setIsFirstLoading] = useState(true);
  useEffect(() => {
    setIsFirstLoading(false);
  }, []);
  const { methods, submitHandler } = useReactForm(
    'patch',
    `/users/update/${id}`,
    formSchema,
    {
      email: email,
      mobile: mobile,
      full_name: full_name,
    },
    {
      onSuccess: ({ data: { user } }) => {
        setAuth(token, user, false);
        reset({ ...user });

        toast.clearWaitingQueue();
        toast.success('Profile updated successfully', { toastId: 'notification' });

        // if (user?.status?.email_verified == false) {
        //   sendVerificationEmail();
        // }
      },
    }
  );
  const { reset } = methods;
  const resetForm = (e) => {
    e.preventDefault();
    reset();
  };
  const {
    formState: { isSubmitting },
  } = methods;

  return (
    <>
      {isSubmitting && <LoadingState />}
      <FormProvider {...methods}>
        <h4 className={styles.title}>Personal Information</h4>
        <form onSubmit={submitHandler}>
          <div className={styles.editProfile}>
            <div className="w-full lg:w-2/4 pr-0 lg:pr-[20px] mb-[30px] lg:mb-0">
              <InputLabel name="full_name" label="Full Name" inputType={'text'} inputPlaceholder="Elizabeth Collins" />
            </div>
            <div className="w-full lg:w-2/4 mb-[30px]">
              <InputLabel name="mobile" label="Phone Number" inputType={'text'} inputPlaceholder="116-30-9372" />
            </div>
            <div className="w-full">
              <InputLabel
                name="email"
                label="Email"
                inputType={'email'}
                inputPlaceholder="elizabeth.collins@gmail.com"
              />

              <span className="text-base mt-1 block">
                To ensure security we will send a verification link to new email address
              </span>
            </div>
            <div className="w-full mt-[28px]">
              <PrimarySmall
                type="submit"
                className="w-[168px] h-[44px] mr-10px mb-11px md:mb-0"
                text="Save Changes"
                disabled={isSubmitting}
              />
              <SecondarySmall
                type="button"
                className="w-[168px] h-[44px]"
                text="Cancel"
                onClick={(e) => resetForm(e)}
              />
            </div>
          </div>
        </form>
      </FormProvider>
    </>
  );
};

EditAccount.Layout = MyAccountLayout;
EditAccount.middleWares = [withAuth];

export const getServerSideProps = createGetServerSidePropsFn(EditAccount);

export default EditAccount;
