import React, { Fragment } from 'react';
import MainLayout from 'layouts/MainLayout';
import Banner from 'components/Banner';
import style from 'styles/Faq.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import Image from 'next/image';
import MyFaq from 'components/MyFaq';
import dogImg from 'public/img/hero-section/bitmap@3x.webp';
import { Tab } from '@headlessui/react';
import { getRequest } from 'requests/api';

const title = 'FAQ';
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

const Blogs = ({ faqs }) => {
  return (
    <div className={style.main}>
      <Banner title={title} image={dogImg} description={description} />
      <div className={style.wrapper}>
        <div className={style.content}>
          <Tab.Group>
            <div className="py-80px flex flex-row flex-wrap">
              <Tab.List className={style.tabList}>
                <h4>FAQs</h4>
                {faqs?.map((item) => (
                  <Tab as={Fragment}>
                    {({ selected }) => <button className={selected ? style.active : ''}>{item?.category}s</button>}
                  </Tab>
                ))}
              </Tab.List>
              <Tab.Panels className={style.tabPanels}>
                {faqs?.map((item) => (
                  <Tab.Panel>
                    <MyFaq uniqueClass={item?.category} heading_title={item?.category} items={item?.questions} />
                  </Tab.Panel>
                ))}
              </Tab.Panels>
            </div>
          </Tab.Group>
        </div>
      </div>
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Blogs, async () => {
  const response = await getRequest('/faq');

  return {
    props: {
      faqs: response ?? [],
    },
  };
});

Blogs.Layout = MainLayout;

export default Blogs;
