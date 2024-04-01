import React, { useLayoutEffect, useState, useEffect } from 'react';
import styles from '../../styles/product/Home.module.css';
import MainLayout from 'layouts/MainLayoutWoFooter';
import Navbar from '@/components/Navbar';
import Footer from '@/components/Footer';
import SurityPro from './components/SurityPro';
import Description from './components/Description';
import IconSection from './components/IconSection';
import ReviewSection from './components/ReviewSection';
import YouLikeSection from './components/YouLikeSection';
import FooterModal from './components/FooterModal';
import FooterBottom from '../../components/FooterBottom';
import CookieConsent from 'react-cookie-consent';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
const Home = () => {
  const [scrollFooter, setScroll] = useState(false);
  const [footerModalActive, setFooterModalActive] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      let height = document.body.scrollHeight - window.innerHeight;
      // console.log('height', height - window.pageYOffset);
      if (height <= window.pageYOffset + 2100) {
        setScroll(true);
      } else if (height - window.pageYOffset > 2100) {
        setScroll(false);
      }
    };
    window.addEventListener('scroll', handleScroll, true);
    return () => window.removeEventListener('scroll', handleScroll, true);
  }, []);

  return (
    <div className={styles.home}>
      <SurityPro />
      <Description />
      <IconSection />
      <ReviewSection />
      <YouLikeSection />
      <Footer />
      {scrollFooter && <FooterModal active={footerModalActive} setActive={setFooterModalActive} />}
      {scrollFooter && (
        <div
          className="fixed w-full bottom-0 left-0 bg-white"
          style={{
            boxShadow: scrollFooter ? '0 2px 16px 0 rgba(0, 0, 0, 0.06)' : 'none',
          }}
        >
          <FooterBottom setActive={setFooterModalActive} />
        </div>
      )}
      {/* 
      <FooterModal active={footerModalActive} setActive={setFooterModalActive} />
      <FooterBottom setActive={setFooterModalActive} /> 
      */}
    </div>
  );
};

Home.Layout = MainLayout;

export const getServerSideProps = createGetServerSidePropsFn(Home);

export default Home;
