import React from 'react';
import MainLayout from 'layouts/MainLayout';
import Banner from 'components/Banner';
import dogImg from 'public/img/hero-section/bitmap@3x.webp';
import style from 'styles/PrivacyPolicy.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import { getRequest } from 'requests/api';

const title = 'Privacy Policy';
const description =
  'The terms and conditions regarding using Ra Foundation website www.rafoundation.in are mentioned below. By using the website, other than to read this page for the first time.';

const Blogs = ({ content, bannerData }) => {
  return (
    <div className={style.main}>
      <Banner
        title={bannerData?.title ?? title}
        image={bannerData?.banner_image ?? dogImg}
        description={bannerData?.banner_description ?? description}
      />
      <div className={style.wrapper}>
        <div className={style.content}>
          <div className={style.contentBlock} dangerouslySetInnerHTML={{ __html: content?.content }}></div>
        </div>
      </div>
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Blogs, async () => {
  const response = await getRequest('/content/privacy-policy');
  const response2 = await getRequest('/page/privacy-policy');

  return {
    props: {
      content: response?.page ?? [],
      bannerData: response2?.page ?? [],
    },
  };
});

Blogs.Layout = MainLayout;

export default Blogs;
