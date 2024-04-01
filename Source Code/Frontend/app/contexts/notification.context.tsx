import React, { createContext, FC, ReactNode, useContext, useRef, useState } from 'react';
import { toast, ToastContainer } from 'react-toastify';
import { ToastContent, ToastOptions } from 'react-toastify/dist/types';
import successIcon from '@/public/img/logo/icon-12-tick-green.svg';
import errorIcon from '@/public/img/logo/icon-12-exclamation.svg';
import closeIcon from '@/public/img/logo/icon-16-cross-largr.svg';
import Image from 'next/image';

type INotifier = (content: ToastContent, options?: ToastOptions) => React.ReactText;
type INotificationContext = {
  notifyError: INotifier;
  notifySuccess: INotifier;
  warn: INotifier;
  notify: INotifier;
  confirm: (title: string, message: string, _okBtn?: ReactNode, _cancelBtn?: ReactNode) => Promise<boolean>;
};

const notificationContext = createContext<INotificationContext>({
  confirm: (_title: string, _message: string) => Promise.resolve(true),
  notify(_content: ToastContent, _options: ToastOptions | undefined): React.ReactText {
    return '';
  },
  notifyError(_content: ToastContent, _options: ToastOptions | undefined): React.ReactText {
    return '';
  },
  notifySuccess(_content: ToastContent, _options: ToastOptions | undefined): React.ReactText {
    return '';
  },
  warn(_content: ToastContent, _options: ToastOptions | undefined): React.ReactText {
    return '';
  },
});
const NotificationProvider = notificationContext.Provider;
notificationContext.displayName = 'Notification';

export default function useNotificationContext() {
  return useContext(notificationContext);
}

type IConfirmation = {
  title: string;
  message: string;
  okBtn?: ReactNode;
  cancelBtn?: ReactNode;
};

const defaultOptions: ToastOptions = {
  pauseOnFocusLoss: false,
  position: 'top-right',
  toastId: 'notification',
  autoClose: 3000,
};

function getToastOptions(options?: ToastOptions, customOptions: ToastOptions = {}): ToastOptions {
  toast.clearWaitingQueue();
  return { ...defaultOptions, ...customOptions, ...(options || {}) };
}

type INotificationContextProps = {
  children: ReactNode;
};

export const NotificationContext: FC<INotificationContextProps> = ({ children }) => {
  const notifySuccess: INotificationContext['notifySuccess'] = (content, options) => {
    return toast.success(content, getToastOptions(options, { pauseOnHover: false }));
  };

  const notifyError: INotificationContext['notifyError'] = (content, options) => {
    return toast.error(
      content,
      getToastOptions(options, {
        autoClose: 6000,
        pauseOnFocusLoss: true,
        toastId: 'notification',
      })
    );
  };

  const notify: INotificationContext['notify'] = (content, options) => {
    return toast.info(content, getToastOptions(options, { pauseOnHover: false }));
  };

  const warn: INotificationContext['warn'] = (content, options) => {
    return toast.warn(content, getToastOptions(options, { pauseOnHover: false }));
  };

  const [_confirmation, setConfirmation] = useState<IConfirmation | null>(null);

  const resolve = useRef<null | ((value: boolean | PromiseLike<boolean>) => void)>(null);

  const confirm: INotificationContext['confirm'] = async (title, message, okBtn, cancelBtn) => {
    setConfirmation({
      title,
      message,
      okBtn,
      cancelBtn,
    });
    return new Promise((_resolve) => {
      resolve.current = _resolve;
    });
  };

  function _handleConfirmation(resolved: boolean) {
    setConfirmation(null);
    resolve.current && resolve.current(resolved);
  }

  return (
    <NotificationProvider
      value={{
        notify,
        notifyError,
        notifySuccess,
        warn,
        confirm,
      }}
    >
      <ToastContainer
        limit={3}
        pauseOnFocusLoss={true}
        autoClose={5000}
        newestOnTop={true}
        icon={({ type }) => (type === 'error' ? <Image src={errorIcon} /> : <Image src={successIcon} />)}
        closeButton={() => (
          <div className="Toastify__close-button">
            <Image src={closeIcon} />
          </div>
        )}
      />
      {children}
    </NotificationProvider>
  );
};
