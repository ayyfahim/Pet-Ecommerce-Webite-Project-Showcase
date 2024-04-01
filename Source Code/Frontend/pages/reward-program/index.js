import React, { useState } from 'react';
import MainLayout from 'layouts/MainLayout';
import Banner from 'components/Banner';
import style from 'styles/RewardProgram.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import Image from 'next/image';
import dogImg from 'public/img/hero-section/bitmap@3x.webp';
import shopIcon from 'public/img/reward-program/shop.webp';
import trophyIcon from 'public/img/reward-program/trophy.webp';
import { getRequest } from 'requests/api';

import MyFaq from 'components/MyFaq';

const title = 'Rewards Program';
const description =
  'For some of our most common questions about Pet Hemp Company products and business practices please read through our frequently asked questions below';

const faqItems = [
  {
    title: 'Will Pet Hemp Company products conflict with any other pet medications?',
    description:
      'If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect with each class and be able to continue following the proper training principles at home. The Petco-certified Positive Dog Trainers at Petco abide by a science-based, positive reinforcement dog-training philosophy. This means that training classes follow rewards-based, fun and effective methods to instill positive behaviors and that appeal to your dog. Training focuses on rewarding dogs for doing things correctly, making them more likely to repeat those behaviors, while dissuading negative behaviors through management and refocusing tactics. Positive reinforcement training has been proven effective in not only training any type learner but also in building a strong bond between pet parents and their dogs.',
  },
  {
    title: 'Will my pet experience any negative side effects from using CBD?',
    description:
      'If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect with each class and be able to continue following the proper training principles at home. The Petco-certified Positive Dog Trainers at Petco abide by a science-based, positive reinforcement dog-training philosophy. This means that training classes follow rewards-based, fun and effective methods to instill positive behaviors and that appeal to your dog. Training focuses on rewarding dogs for doing things correctly, making them more likely to repeat those behaviors, while dissuading negative behaviors through management and refocusing tactics. Positive reinforcement training has been proven effective in not only training any type learner but also in building a strong bond between pet parents and their dogs.',
  },
  {
    title: 'Will Pet Hemp Company products conflict with any other pet medications?',
    description:
      'If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect with each class and be able to continue following the proper training principles at home. The Petco-certified Positive Dog Trainers at Petco abide by a science-based, positive reinforcement dog-training philosophy. This means that training classes follow rewards-based, fun and effective methods to instill positive behaviors and that appeal to your dog. Training focuses on rewarding dogs for doing things correctly, making them more likely to repeat those behaviors, while dissuading negative behaviors through management and refocusing tactics. Positive reinforcement training has been proven effective in not only training any type learner but also in building a strong bond between pet parents and their dogs.',
  },
  {
    title: 'Will Pet Hemp Company products conflict with any other pet?',
    description:
      'If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect with each class and be able to continue following the proper training principles at home. The Petco-certified Positive Dog Trainers at Petco abide by a science-based, positive reinforcement dog-training philosophy. This means that training classes follow rewards-based, fun and effective methods to instill positive behaviors and that appeal to your dog. Training focuses on rewarding dogs for doing things correctly, making them more likely to repeat those behaviors, while dissuading negative behaviors through management and refocusing tactics. Positive reinforcement training has been proven effective in not only training any type learner but also in building a strong bond between pet parents and their dogs.',
  },
  {
    title: 'Will my pet experience any negative side effects from using CBD?',
    description:
      'If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect with each class and be able to continue following the proper training principles at home. The Petco-certified Positive Dog Trainers at Petco abide by a science-based, positive reinforcement dog-training philosophy. This means that training classes follow rewards-based, fun and effective methods to instill positive behaviors and that appeal to your dog. Training focuses on rewarding dogs for doing things correctly, making them more likely to repeat those behaviors, while dissuading negative behaviors through management and refocusing tactics. Positive reinforcement training has been proven effective in not only training any type learner but also in building a strong bond between pet parents and their dogs.',
  },
];

const Blogs = ({ rewardProgramData, faqs }) => {
  const rewardFaq = faqs?.find((item) => item?.category == 'Reward FAQ');
  return (
    <div className={style.main}>
      <Banner
        title={rewardProgramData?.reward_program_banner_title ?? title}
        image={rewardProgramData?.banner_image ?? dogImg}
        description={rewardProgramData?.reward_program_banner_description ?? description}
      />
      <div className={style.wrapper}>
        <div className={style.content}>
          <div className="py-80px">
            <div className="text-center mx-auto md:w-2/4">
              <h4 className={`${style.section_title} pb-7px`}>
                {rewardProgramData?.how_it_works_section_title ?? 'How it works?'}
              </h4>
              <p className={style.section_desc2}>
                {rewardProgramData?.how_it_works_section_description ??
                  'Any parent will tell you that colic is one of the most excruciating experiences of early parenthood. The baby cries as if in dire pain.'}
              </p>
            </div>

            <div className="pt-50px grid grid-cols-3 xl:gap-20 lg:gap-14 gap-10">
              <div className="md:col-span-1 col-span-3">
                <div className="w-50px mx-auto pb-21px">
                  <Image
                    src={rewardProgramData?.how_it_works_1_icon ?? shopIcon}
                    objectFit="contain"
                    layout="responsive"
                  />
                </div>
                <div className="text-center">
                  <h4 className={style.section_sub_title}>
                    {rewardProgramData?.how_it_works_1_title ?? 'Shop from VitalPawz'}
                  </h4>
                  <p className={style.section_desc}>
                    {rewardProgramData?.how_it_works_1_description ??
                      'If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect.'}
                  </p>
                </div>
              </div>
              <div className="md:col-span-1 col-span-3">
                <div className="w-50px mx-auto pb-21px">
                  <Image
                    src={rewardProgramData?.how_it_works_2_icon ?? trophyIcon}
                    objectFit="contain"
                    layout="responsive"
                  />
                </div>
                <div className="text-center">
                  <h4 className={style.section_sub_title}>
                    {rewardProgramData?.how_it_works_2_title ?? 'Earn from VitalPawz'}{' '}
                  </h4>
                  <p className={style.section_desc}>
                    {rewardProgramData?.how_it_works_2_description ??
                      'If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect.'}
                  </p>
                </div>
              </div>
              <div className="md:col-span-1 col-span-3">
                <div className="w-50px mx-auto pb-21px">
                  <Image
                    src={rewardProgramData?.how_it_works_3_icon ?? shopIcon}
                    objectFit="contain"
                    layout="responsive"
                  />
                </div>
                <div className="text-center">
                  <h4 className={style.section_sub_title}>
                    {rewardProgramData?.how_it_works_3_title ?? 'Redeem Points'}
                  </h4>
                  <p className={style.section_desc}>
                    {rewardProgramData?.how_it_works_3_description ??
                      'If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect.'}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="flex flex-row flex-wrap w-full">
        <div
          className={`w-2/5 ${style.dogImgBg} hidden md:block`}
          style={{
            backgroundImage: `url("${rewardProgramData?.how_to_collect_image ?? '/img/reward-program/dog.webp'}")`,
          }}
        >
          {/* <Image src={dogImg2} objectFit="contain" layout="responsive" /> */}
        </div>
        <div className="flex-1 xl:py-80px xl:px-[90px] lg:py-[60px] lg:px-[70px] md:py-[30px] md:px-[40px] py-[45px] px-[20px] bg-light-purple">
          <h4 className={`${style.section_sub_title} mb-10px`}>
            {rewardProgramData?.how_to_collect_title ?? 'How to collect'}
          </h4>
          <p className={`${style.section_desc} xl:w-3/4 mb-19px`}>
            {rewardProgramData?.how_to_collect_description ??
              'Access existing perks, savings and rewards just by shopping with us! Earn more Points for completing different actions with our rewards program.If you’ve never been through dog training, it’s helpful to know how it works before you sign up. You’ll learn what to expect.'}
          </p>
          <div className="xl:w-4/6 lg:w-5/6">
            <table className={style.pointsTable}>
              <tbody>
                <tr>
                  <td>{rewardProgramData?.how_to_collect_1_title ?? 'Make a Purchase'}</td>
                  <td className={style.points}>{rewardProgramData?.how_to_collect_1_point ?? '1 Point'}</td>
                </tr>
                <tr>
                  <td>{rewardProgramData?.how_to_collect_2_title ?? 'Create an Account'}</td>
                  <td className={style.points}>{rewardProgramData?.how_to_collect_2_point ?? '10 Point'}</td>
                </tr>
                <tr>
                  <td>{rewardProgramData?.how_to_collect_3_title ?? 'Instagram Follow'}</td>
                  <td className={style.points}>{rewardProgramData?.how_to_collect_3_description ?? '20 Point'}</td>
                </tr>
                <tr>
                  <td>{rewardProgramData?.how_to_collect_4_title ?? 'Facebook Share'}</td>
                  <td className={style.points}>{rewardProgramData?.how_to_collect_4_description ?? '30 Point'}</td>
                </tr>
                <tr>
                  <td>{rewardProgramData?.how_to_collect_5_title ?? 'Facebook Follow'}</td>
                  <td className={style.points}>{rewardProgramData?.how_to_collect_5_description ?? '40 Point'}</td>
                </tr>
                <tr>
                  <td>{rewardProgramData?.how_to_collect_6_title ?? 'Celebrate Birthday'}</td>
                  <td className={style.points}>{rewardProgramData?.how_to_collect_6_description ?? '50 Point'}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div className={style.wrapper}>
        <div className={style.content}>
          <div className="md:py-[130px] py-50px">
            <MyFaq uniqueClass={rewardFaq?.category} heading_title={rewardFaq?.category} items={rewardFaq?.questions} />
          </div>
        </div>
      </div>
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Blogs, async () => {
  const response = await getRequest('/frontend/reward-program');
  const faqResponse = await getRequest('/faq');

  return {
    props: {
      rewardProgramData: response?.reward_program ?? [],
      faqs: faqResponse ?? [],
    },
  };
});

Blogs.Layout = MainLayout;

export default Blogs;
