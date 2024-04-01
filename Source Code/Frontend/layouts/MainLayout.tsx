import React from 'react';
import Head from 'next/head';
import Navbar from 'components/Navbar';
import Footer from 'components/Footer';
import style from 'styles/mainLayout.module.scss';
import { ILayout } from 'types/next.types';

const MainLayout: ILayout = ({ children }) => {
  return (
    <div className={style.wrapper}>
      <Head>
        <title>VitalPawz</title>
        <meta name="robots" content="noindex,nofollow" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      </Head>
      <Navbar />
      <main>{children}</main>
      <Footer />
    </div>
  );
};

export default MainLayout;
