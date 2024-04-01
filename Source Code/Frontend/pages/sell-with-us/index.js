import React from 'react';
import MainLayout from 'layouts/MainLayout';
import Banner from 'components/Banner';
import dogImg from 'public/img/hero-section/bitmap@3x.webp';
import missionImg from 'public/img/about-us/mission.webp';
import optionsImg from 'public/img/about-us/options.webp';
import offerImg from 'public/img/about-us/offer.webp';
import storyImg from 'public/img/about-us/story.webp';
import style from 'styles/AboutUs.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import Image from 'next/image';
import useWindowDimensions from 'app/hooks/useWindowDimensions';

const title = 'Sell with us';
const description =
  'Vitalpawz is a certified Australian retailer of broad-spectrum cannabidiol (CBD) products for dogs, cats and other companion animals. We provide all-natural, holistic health supplements for those seeking an alternative approach to their pet’s wellbeing. We are based in Melbourne, Victoria and deliver our products Australia-wide.';

const Blogs = () => {
  const { width } = useWindowDimensions();

  return (
    <div className={style.main}>
      <Banner title={title} image={dogImg} description={description} />
      {width > 640 ? (
        <>
          <div className={style.wrapper}>
            <div className={style.content}>
              <div className="flex flex-row flex-wrap items-center py-80px">
                <div className="w-2/4 max-w-[500px] min-h-[330px] lg:block hidden">
                  <Image src={missionImg} />
                </div>
                <div className="lg:w-2/4 lg:pl-31px">
                  <h4 className={`${style.section_title}`}>Our mission</h4>
                  <p className={`${style.section_desc} py-18px`}>
                    We believe in the healing power of CBD as a treatment for arthritis, hair and skin issues, anxiety,
                    pain and a variety of other health or wellbeing concerns your pet may face. Thanks to its wide range
                    of nutritional and cognitive benefits, we recognise that CBD is also a useful dietary supplement for
                    even the healthiest of pets.
                  </p>
                  <p className={style.section_desc}>
                    It is our mission to support the health and wellness of pets around Australia with the very best,
                    all-natural CBD products designed with their unique needs in mind. Our goal is to make CBD
                    affordable and accessible with competitive prices and prompt delivery around the country. Whether
                    you are using CBD as an alternative to traditional treatments or an addition to them, we offer a
                    range of premium CBD products to suit you and your pet’s needs.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div className={`${style.wrapper} bg-light-purple`}>
            <div className={`${style.content} text-center pt-80px`}>
              <h4 className={`${style.section_title}`}>Customised options for every need</h4>
              <p className={`${style.section_desc} pt-18px pb-50px`}>
                At Vitalpawz, we specialise in customised CBD recommendations specific to your pet. When you shop with
                us, you’ll receive access to curated collections of CBD products designed with your animal’s unique
                needs in mind. All you need to do is make an account for your pet and complete a brief quiz on their
                characteristics and health considerations to start shopping our tailor-made product range.
              </p>
              <div>
                <Image src={optionsImg} objectFit="contain" layout="responsive" />
              </div>
            </div>
          </div>

          <div className={`${style.wrapper} ${style.whySection}`}>
            <div className={`${style.content} text-center py-80px`}>
              <div className="md:w-[682px] mx-auto">
                <h4 className={`${style.section_title_white} pb-18px`}>Why CBD?</h4>
                <p className={style.section_desc_white}>
                  There are many benefits to CBD nutritionally, physically and psychologically. Derived from hemp
                  plants, CBD is proven to be a safe and effective dietary supplement for animals and their owners
                  alike. Unlike other derivatives of hemp, CBD is non-psychoactive and suitable for pets of all breeds,
                  ages and sizes.
                </p>
              </div>
            </div>
          </div>

          <div className={`${style.wrapper} ${style.offerSection}`}>
            <div className={`${style.content} py-57px`}>
              <div className="flex flex-row flex-wrap items-center justify-between">
                <div className="md:w-2/4">
                  <h4 className={`${style.section_title_white} pb-11px`}>What products do we offer?</h4>
                  <p className={`${style.section_desc_white} pb-17px`}>
                    We stock a wide range of all-natural, broad-spectrum CBD products sourced from the top CBD retailers
                    in Australia and around the globe. Broad-spectrum means that our products are free from THC,
                    guaranteeing all the wonderful benefits of CBD without any of the unwanted side effects.
                  </p>
                  <p className={style.section_desc_white}>
                    Our extensive product selection includes edible CBD oil, CBD-infused dog and cat treats, topical CBD
                    ointments and balms, and plenty more. For more information about our broad-spectrum CBD products,
                    you can browse our full range here [link].
                  </p>
                </div>
                <div className={style.offerImg}>
                  <Image src={offerImg} objectFit="contain" layout="responsive" />
                </div>
              </div>
            </div>
          </div>
        </>
      ) : (
        <>
          <div className={style.wrapper}>
            <div className={style.content}>
              <h4 className={`${style.section_title} py-[40px]`}>Our Story</h4>
              <div className="pb-25px ">
                <Image src={storyImg} />
              </div>
              <p className={`${style.section_desc} pb-25px font-bold`}>
                <b>
                  Petsupply is a category-defining health and wellness company focused on improving the lives of pets,
                  pet parents and our own Petsupply partners.
                </b>
              </p>
              <p className={`${style.section_desc} pb-18px`}>
                Our founder, Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to treat her
                medical issues. But when she looked for safe, vegan, non-GMO, full-spectrum CBD formulated specifically
                for her dogs, she realized something: There wasn’t any. Even worse: what few products she could find on
                the market contained industrialized hemp oil from other countries and lacked regulation or strict
                standards.
              </p>
              <p className={`${style.section_desc} pb-55px`}>
                Our founder, Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to treat her
                medical issues. But when she looked for safe, vegan, non-GMO, full-spectrum CBD formulated specifically
                for her dogs, she realized something: There wasn’t any. Even worse: what few products she could find on
                the market contained industrialized hemp oil from other countries and lacked regulation or strict
                standards. Our products contain Full Spectrum Hemp Extract (CBD), a wide range of cannabinoids, and
                terpenes the compounds in the plant that create therapeutic results.Our products are carefully
                formulated with all-natural ingredients and full spectrum cannabinoid blends, so there is something here
                to benefit every pet. In addition, we guarantee potency and purity through third-party lab testing.
              </p>
            </div>
          </div>

          <div className={`${style.wrapper} ${style.offerSection}`}>
            <div className={`${style.content} py-[65px]`}>
              <h4 className={`${style.section_title_white} pb-21px`}>About Our Company</h4>
              <p className={`${style.section_desc_white} pb-18px`}>
                Our founder, Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to treat her
                medical issues. But when she looked for safe, vegan, non-GMO, full-spectrum CBD formulated specifically
                for her dogs, she realized something: There wasn’t any. Even worse: what few products she could find on
                the market contained industrialized hemp oil from other countries and lacked regulation or strict
                standards. Our founder, Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to
                treat her medical issues. But when she looked for safe, vegan, non-GMO, full-spectrum CBD formulated
                specifically for her dogs, she realized something: There wasn’t any. Even worse: what few products she
                could find on the market contained industrialized hemp oil from other countries and lacked regulation or
                strict standards.
              </p>
              <p className={`${style.section_desc_white}`}>
                Our products contain Full Spectrum Hemp Extract (CBD), a wide range of cannabinoids, and terpenes the
                compounds in the plant that create therapeutic results.Our products are carefully formulated with
                all-natural ingredients and full spectrum cannabinoid blends, so there is something here to benefit
                every pet. In addition, we guarantee potency and purity through third-party lab testing. Our founder,
                Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to treat her medical issues.
                Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to treat her medical issues.
              </p>
            </div>
          </div>
        </>
      )}
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Blogs);

Blogs.Layout = MainLayout;

export default Blogs;
