import React, { useRef } from 'react';
import MainLayout from 'layouts/MainLayout';
import Banner from 'components/BannerNoImage';
import style from 'styles/ContactUs.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import Image from 'next/image';
import dogImg from 'public/img/hero-section/bitmap@3x.webp';
import mailIcon from 'public/img/contact-us/mail.webp';
import phoneIcon from 'public/img/contact-us/phone.webp';
import locationIcon from 'public/img/contact-us/location.webp';

import InputLabel from 'components/InputLabel';
import { TextArea, Label } from 'components/InputLabel';
import PrimarySmall from 'components/Buttons/PrimarySmall';

import useReactForm from 'hooks/useReactForm';
import { object, string } from 'yup';
import { FormProvider } from 'react-hook-form';

import siteConfig from 'atom/siteConfig.atom';
import { useRecoilValue } from 'recoil';

import Link from 'next/link';
import ReCAPTCHA from 'react-google-recaptcha';
import { toast } from 'react-toastify';
import { getEnv } from '@/bootstrap/app.config';

const title = 'Contact Us';
const description = 'We would love to hear from you!';

const phoneRegExp = /^((\+[1-9]{1,4}[ -]?)|(\([0-9]{2,3}\)[ -]?)|([0-9]{2,4})[ -]?)*?[0-9]{3,4}[ -]?[0-9]{3,4}$/;

const formSchema = object().shape({
  full_name: string().label('Full Name').required(),
  message: string().label('Message').required(),
  email: string().label('Email').required().email(),
  contact_number: string('Please put your Contact Number')
    .matches(phoneRegExp, 'Contact number is not valid')
    .label('Contact Number')
    .required(),
  token: string().required('Please verify captcha.'),
});

const Blogs = () => {
  const siteConfigValue = useRecoilValue(siteConfig);
  const { methods, submitHandler } = useReactForm(
    'post',
    `/contact-api`,
    formSchema,
    {
      email: '',
      mobile: '',
      full_name: '',
      message: '',
      token: '',
    },
    {
      onSuccess: ({ message }) => {
        toast.clearWaitingQueue();
        toast.success(message, { toastId: 'notification' });
      },
      baseUrl: '/api',
    }
  );

  const getSiteConfig = (key) => {
    return siteConfigValue?.config?.find((item) => item?.type == key)?.value ?? null;
  };

  const captchaRef = useRef(null);

  const {
    formState: { errors },
    setValue,
  } = methods;

  const onCaptchaChange = (e) => {
    setValue('token', captchaRef.current.getValue());
  };

  return (
    <div className={style.main}>
      <Banner title={title} image={dogImg} description={description} />

      <div className={style.wrapper}>
        <div className={style.content}>
          <div className="flex md:flex-row flex-col-reverse flex-wrap justify-between">
            <div className="md:py-80px py-31px lg:w-2/4 md:w-3/5 w-full lg:pr-0 pr-17px">
              <div className={style.contactUsItems}>
                <div className={style.item}>
                  <div className={style.icon}>
                    <Image src={phoneIcon} objectFit="contain" layout="responsive" />
                  </div>
                  <div>
                    <span>Call us(Toll Free)</span>
                    <h4>{getSiteConfig('contact_numbers') ?? ''}</h4>
                  </div>
                </div>
                <div className={style.item}>
                  <div className={style.icon}>
                    <Image src={mailIcon} objectFit="contain" layout="responsive" />
                  </div>
                  <div>
                    <span>Email</span>
                    <h4>{getSiteConfig('emails') ?? ''}</h4>
                  </div>
                </div>
                <div className={style.item}>
                  <div className={style.icon}>
                    <Image src={locationIcon} objectFit="contain" layout="responsive" />
                  </div>
                  <div>
                    <span>Address</span>
                    <h4>{getSiteConfig('address') ?? ''}</h4>
                  </div>
                </div>
              </div>

              <div className={style.socials}>
                <div className="md:w-3/5 w-full">
                  <h4>Keep in touch, follow us on:</h4>
                </div>
                <div className="md:w-2/5 w-full">
                  <div className={style.icons}>
                    {getSiteConfig('facebook') ? (
                      <div className={`${style.icon}`}>
                        <Link href={getSiteConfig('facebook') ?? '#'}>
                          <img src="/img/contact-us/facebook.webp" alt="" />
                        </Link>
                      </div>
                    ) : (
                      <></>
                    )}
                    {getSiteConfig('instagram') ? (
                      <div className={`${style.icon}`}>
                        <Link href={getSiteConfig('instagram') ?? '#'}>
                          <img src="/img/contact-us/instagram.webp" alt="" />
                        </Link>
                      </div>
                    ) : (
                      <></>
                    )}
                    {getSiteConfig('pinterst') ? (
                      <div className={`${style.icon}`}>
                        <Link href={getSiteConfig('pinterst') ?? '#'}>
                          <img src="/img/contact-us/pinterst.webp" alt="" />
                        </Link>
                      </div>
                    ) : (
                      <></>
                    )}
                  </div>
                </div>
              </div>
            </div>
            <FormProvider {...methods}>
              <div className="md:w-2/5 w-full">
                <form onSubmit={submitHandler}>
                  <div className={`${style.contactUsForm} md:mt-[-140px]`}>
                    <p className={style.subHeading}>Submit your queries and we will get back to you.</p>
                    <div className="mb-25px">
                      <div className="w-full">
                        <InputLabel name="full_name" label="Full Name" inputType={'text'} inputPlaceholder="" />
                      </div>
                    </div>
                    <div className="mb-25px">
                      <div className="w-full">
                        <InputLabel
                          name="contact_number"
                          label="Contact Number"
                          inputType={'text'}
                          inputPlaceholder=""
                        />
                      </div>
                    </div>
                    <div className="mb-25px">
                      <div className="w-full">
                        <InputLabel name="email" label="Email" inputType={'text'} inputPlaceholder="" />
                      </div>
                    </div>
                    <div className="mb-25px">
                      <div className="w-full">
                        <Label label="Message" />
                        <TextArea name="message" rows="4" />
                      </div>
                    </div>
                    <div className="mb-25px">
                      <ReCAPTCHA
                        sitekey={getEnv('captchaSiteKey', '6Ld7jVQmAAAAAKdWTwaF7bguHS2OcQ_B7zmFesma')}
                        ref={captchaRef}
                        onChange={onCaptchaChange}
                      />
                      {errors && errors['token'] && errors['token']?.message && (
                        <p className="text-red-700 font-light">{String(errors['token']?.message) || ''}</p>
                      )}
                    </div>
                    <div className="w-full">
                      <PrimarySmall className="w-full h-[62px]" text="Send Message" type="submit" />
                    </div>
                  </div>
                </form>
              </div>
            </FormProvider>
          </div>
        </div>
      </div>
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Blogs);

Blogs.Layout = MainLayout;

export default Blogs;
