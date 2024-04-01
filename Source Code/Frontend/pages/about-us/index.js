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
import { getRequest } from 'requests/api';

const title = 'About us';
const description =
  'Vitalpawz is a certified Australian retailer of broad-spectrum cannabidiol (CBD) products for dogs, cats and other companion animals. We provide all-natural, holistic health supplements for those seeking an alternative approach to their pet’s wellbeing. We are based in Melbourne, Victoria and deliver our products Australia-wide.';

const Blogs = ({ aboutUsData }) => {
  const { width } = useWindowDimensions();

  return (
    <div className={style.main}>
      <Banner
        title={aboutUsData?.banner_section_title ?? title}
        image={aboutUsData?.banner_section_image ?? dogImg}
        description={aboutUsData?.banner_section_description ?? description}
      />
      {width > 640 ? (
        <>
          <div className={style.wrapper}>
            <div className={style.content}>
              <div className="flex flex-row flex-wrap items-center py-80px">
                <div className="w-2/4 max-w-[500px] min-h-[330px] lg:block hidden">
                  <Image src={aboutUsData?.our_mission_image ?? missionImg} width={500} height={330} />
                </div>
                <div className="lg:w-2/4 lg:pl-31px">
                  <h4 className={`${style.section_title}`}>{aboutUsData?.our_mission_title ?? 'Our mission'}</h4>
                  <p className={`${style.section_desc} py-18px`}>
                    {aboutUsData?.our_mission_description ??
                      'We believe in the healing power of CBD as a treatment for arthritis, hair and skin issues, anxiety, pain and a variety of other health or wellbeing concerns your pet may face. Thanks to its wide range of nutritional and cognitive benefits, we recognise that CBD is also a useful dietary supplement for even the healthiest of pets.'}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div className={`${style.wrapper} bg-light-purple`}>
            <div className={`${style.content} text-center pt-80px`}>
              <h4 className={`${style.section_title}`}>
                {aboutUsData?.customised_options_section_title ?? 'Customised options for every need'}
              </h4>
              <p className={`${style.section_desc} pt-18px pb-50px`}>
                {aboutUsData?.customised_options_section_description ??
                  'At Vitalpawz, we specialise in customised CBD recommendations specific to your pet. When you shop with us, you’ll receive access to curated collections of CBD products designed with your animal’s unique needs in mind. All you need to do is make an account for your pet and complete a brief quiz on their characteristics and health considerations to start shopping our tailor-made product range.'}
              </p>
              <div>
                <Image
                  src={aboutUsData?.customised_options_section_description ?? optionsImg}
                  objectFit="contain"
                  layout="responsive"
                  width={1280}
                  height={478}
                />
              </div>
            </div>
          </div>

          <div
            className={`${style.wrapper} ${style.whySection}`}
            style={{ backgroundImage: `url(${aboutUsData?.why_section_image ?? '/img/about-us/why.webp'})` }}
          >
            <div className={`${style.content} text-center py-80px`}>
              <div className="md:w-[682px] mx-auto">
                <h4 className={`${style.section_title_white} pb-18px`}>
                  {aboutUsData?.why_section_title ?? 'Why CBD?'}
                </h4>
                <p className={style.section_desc_white}>
                  {aboutUsData?.why_section_description ??
                    'There are many benefits to CBD nutritionally, physically and psychologically. Derived from hemp plants, CBD is proven to be a safe and effective dietary supplement for animals and their owners alike. Unlike other derivatives of hemp, CBD is non-psychoactive and suitable for pets of all breeds, ages and sizes.'}
                </p>
              </div>
            </div>
          </div>

          <div className={`${style.wrapper} ${style.offerSection}`}>
            <div className={`${style.content} py-57px`}>
              <div className="flex flex-row flex-wrap items-center justify-between">
                <div className="md:w-2/4">
                  <h4 className={`${style.section_title_white} pb-11px`}>
                    {aboutUsData?.options_title ?? 'What products do we offer?'}
                  </h4>
                  <p className={`${style.section_desc_white} pb-17px`}>
                    {aboutUsData?.options_description ??
                      'We stock a wide range of all-natural, broad-spectrum CBD products sourced from the top CBD retailers in Australia and around the globe. Broad-spectrum means that our products are free from THC, guaranteeing all the wonderful benefits of CBD without any of the unwanted side effects.'}
                  </p>
                </div>
                <div className={style.offerImg}>
                  <Image
                    src={aboutUsData?.options_image ?? offerImg}
                    objectFit="contain"
                    layout="responsive"
                    width={409}
                    height={409}
                  />
                </div>
              </div>
            </div>
          </div>
        </>
      ) : (
        <>
          <div className={style.wrapper}>
            <div className={style.content}>
              <h4 className={`${style.section_title} py-[40px]`}>{aboutUsData?.our_story_title ?? 'Our Story'}</h4>
              <div className="pb-25px ">
                <Image src={aboutUsData?.our_story_image ?? storyImg} width={491} height={496} />
              </div>
              <p className={`${style.section_desc} pb-18px`}>
                {aboutUsData?.our_story_description ??
                  'Our founder, Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to treat her medical issues. But when she looked for safe, vegan, non-GMO, full-spectrum CBD formulated specifically for her dogs, she realized something: There wasn’t any. Even worse: what few products she could find on the market contained industrialized hemp oil from other countries and lacked regulation or strictstandards.'}
              </p>
            </div>
          </div>

          <div className={`${style.wrapper} ${style.offerSection}`}>
            <div className={`${style.content} py-[65px]`}>
              <h4 className={`${style.section_title_white} pb-21px`}>
                {aboutUsData?.about_company_title ?? 'About Our Company'}
              </h4>
              <p className={`${style.section_desc_white} pb-18px`}>
                {aboutUsData?.about_company_description ??
                  'Our founder, Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to treat her medical issues. But when she looked for safe, vegan, non-GMO, full-spectrum CBD formulated specifically for her dogs, she realized something: There wasn’t any. Even worse: what few products she could find on the market contained industrialized hemp oil from other countries and lacked regulation or strict standards. Our founder, Angela Ardolino, knew the profound benefits of using CBD enriched hemp oil to treat her medical issues. But when she looked for safe, vegan, non-GMO, full-spectrum CBD formulated specifically for her dogs, she realized something: There wasn’t any. Even worse: what few products she could find on the market contained industrialized hemp oil from other countries and lacked regulation or strict standards.'}
              </p>
            </div>
          </div>
        </>
      )}
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Blogs, async () => {
  const response = await getRequest('/frontend/about-us');

  return {
    props: {
      aboutUsData: response?.about_us ?? [],
    },
  };
});

Blogs.Layout = MainLayout;

export default Blogs;
