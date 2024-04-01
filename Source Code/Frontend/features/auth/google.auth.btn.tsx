import { ButtonHTMLAttributes, useCallback, useEffect, useRef } from 'react';
import Image from 'next/image';
import google_icon from 'public/img/logo/icon-24-google.svg';
import { ISocialAuthUser } from 'types/auth.types';
import { getEnv } from '@/bootstrap/app.config';

type IAuthBtnProps = ButtonHTMLAttributes<HTMLButtonElement> & {
  // onSuccess: (user: ISocialAuthUser) => void;
};
export default function GoogleAuthBtn({ ...btnProps }: IAuthBtnProps) {
  // const initGApi = useCallback(() => {
  //   gapi.load('auth2', () => {
  //     gapi.auth2.init({
  //       client_id: getEnv('googleAppId'),
  //       fetch_basic_profile: true,
  //     });
  //     attachSignin(authBtn.current as HTMLElement, onSuccess);
  //   });
  // }, []);
  // useEffect(() => {
  //   if (!globalThis.document) {
  //     return;
  //   }

  //   // @ts-ignore
  //   if (!globalThis.initGApi) {
  //     // @ts-ignore
  //     globalThis.initGApi = initGApi;
  //   }
  //   const existingScript = document.getElementById('google-auth-script');
  //   if (existingScript) {
  //     existingScript.setAttribute('data-loaded', `` + (existingScript.getAttribute('data-loaded') || 1) + 1);
  //   }
  //   const script = document.createElement('script');
  //   script.src = 'https://apis.google.com/js/platform.js?onload=initGApi';
  //   script.async = true;
  //   script.defer = true;
  //   script.id = 'google-auth-script';
  //   document.body.appendChild(script);

  //   return () => {
  //     const script = document.getElementById('google-auth-script');
  //     if (!script) {
  //       return;
  //     }
  //     const count = parseInt(script.getAttribute('data-loaded') || '0');
  //     if (count > 0) {
  //       script.setAttribute('data-loaded', `` + (count - 1));
  //     } else {
  //       // @ts-ignore
  //       delete globalThis.initGApi;
  //       document.body.removeChild(script);
  //     }
  //   };
  // }, []);

  return (
    <>
      <button
        type="button"
        className="w-full border border-middle-white rounded-lg pt-17px pb-19px mb-4 flex justify-center"
        {...btnProps}
      >
        <Image src={google_icon} alt="logo" className="h-6 w-6" />
        <p className="ml-11px  text-sm">Continue with Google</p>
      </button>
    </>
  );
}

// function attachSignin(element: HTMLElement, onSuccess: IAuthBtnProps['onSuccess']) {
//   gapi.auth2.getAuthInstance().attachClickHandler(
//     element,
//     {},
//     function (googleUser) {
//       onSuccess({
//         id: googleUser.getBasicProfile().getId(),
//         name: googleUser.getBasicProfile().getName(),
//         email: googleUser.getBasicProfile().getEmail(),
//         imageUrl: googleUser.getBasicProfile().getImageUrl(),
//       });
//     },
//     function (_error) {
//       // alert(JSON.stringify(error, undefined, 2));
//     }
//   );
// }
