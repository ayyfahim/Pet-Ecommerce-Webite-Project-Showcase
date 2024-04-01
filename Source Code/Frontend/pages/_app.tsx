import 'styles/globals.scss';
import { AppPropsWithLayout, ILayout } from 'types/next.types';
import '@/bootstrap/app.config';
import '@/components/CartItems/componentsCartItem/MySelect.scss';
import '@/components/CartItems/componentsCartItem/MySelectModal.scss';
import 'react-toastify/dist/ReactToastify.min.css';
import 'styles/toastify/ReactToastifyCustom.css';
import 'react-rangeslider/lib/index.css';
import '@/pages/add-pet/components/MyRangeSlider.scss';
import '@/components/Select/googlePlaceStyle.module.scss';
import { AppWrapper } from 'layouts/AppWrapper.layout';

import { FormContext } from 'contexts/form.context';
import { useRouter } from 'next/router';
import useLogoutService from 'hooks/useLogoutService';
import { useEffect, useState, StrictMode } from 'react';

import LoadingState from 'components/LoadingState';
import { RecoilRoot } from 'recoil';
import { isLocal } from '@/bootstrap/app.config';

const EmptyLayout: ILayout = ({ children }) => children;

function MyApp({ Component, pageProps }: AppPropsWithLayout) {
  const router = useRouter();

  const logoutService = useLogoutService();

  const CustomToastMessage = () => (
    <>
      <h4 className="Toastify__toast-customHeader">Success</h4>
      <div>This is success toast component</div>
    </>
  );
  useEffect(() => {
    if (isLocal()) {
      (globalThis as Record<string, unknown>).APP_URL = pageProps.appUrl;
    }
    // @ts-ignore
    globalThis.logout = logoutService;
  }, []);

  const [authCheckStatus, setAuthCheckStatus] = useState(!!(pageProps.user?.id || pageProps.isServerRendered));

  const [loading, setLoadingStatus] = useState(true);

  const PageLayout = Component.Layout || EmptyLayout;

  useEffect(() => {
    if (authCheckStatus) {
      setLoadingStatus(false);
    }
  }, [authCheckStatus, router.asPath]);

  return (
    <StrictMode>
      <RecoilRoot>
        <FormContext>
          <AppWrapper
            user={pageProps.user}
            token={pageProps.token}
            redirectedFrom={pageProps.redirectedFrom}
            isServerRendered={pageProps.isServerRendered}
            authCheckStatus={authCheckStatus}
            setAuthCheckStatus={setAuthCheckStatus}
          >
            {loading && <LoadingState />}
            <PageLayout>
              <Component {...pageProps} />
            </PageLayout>
          </AppWrapper>
        </FormContext>
      </RecoilRoot>
    </StrictMode>
  );
}

export default MyApp;
