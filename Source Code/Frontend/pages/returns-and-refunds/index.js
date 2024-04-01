import React, { Fragment } from 'react';
import MainLayout from 'layouts/MainLayout';
import Banner from 'components/Banner';
import style from 'styles/Faq.module.scss';
import createGetServerSidePropsFn from 'shared/createGetServerSidePropsFn';
import Image from 'next/image';
import MyFaq from 'components/MyFaq';
import dogImg from 'public/img/hero-section/bitmap@3x.webp';
import { Tab } from '@headlessui/react';

const title = 'Returns and Refunds';
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

const Blogs = () => {
  return (
    <div className={style.main}>
      <Banner title={title} image={dogImg} description={description} />
      <div className={style.wrapper}>
        <div className={style.content}>
          <Tab.Group>
            <div className="py-80px flex flex-row flex-wrap">
              <Tab.List className={style.tabList}>
                <h4>FAQs</h4>
                <Tab as={Fragment}>
                  {({ selected }) => <button className={selected ? style.active : ''}>CBD FAQs</button>}
                </Tab>
                <Tab as={Fragment}>
                  {({ selected }) => <button className={selected ? style.active : ''}>Product FAQs</button>}
                </Tab>
                <Tab as={Fragment}>
                  {({ selected }) => (
                    <button className={selected ? style.active : ''}>Ordering / Purchasing FAQs</button>
                  )}
                </Tab>
                <Tab as={Fragment}>
                  {({ selected }) => <button className={selected ? style.active : ''}>Customer Support FAQs</button>}
                </Tab>
                <Tab as={Fragment}>
                  {({ selected }) => <button className={selected ? style.active : ''}>Reward FAQs</button>}
                </Tab>
                <Tab as={Fragment}>
                  {({ selected }) => <button className={selected ? style.active : ''}>Shopping FAQs</button>}
                </Tab>
              </Tab.List>
              <Tab.Panels className={style.tabPanels}>
                <Tab.Panel>
                  <MyFaq uniqueClass="cbdFaq" heading_title="CBD FAQs" items={faqItems} />
                </Tab.Panel>
                <Tab.Panel>
                  <MyFaq uniqueClass="prodFaq" heading_title="Product FAQs" items={faqItems} />
                </Tab.Panel>
                <Tab.Panel>
                  <MyFaq uniqueClass="orderFaq" heading_title="Ordering / Purchasing FAQs" items={faqItems} />
                </Tab.Panel>
                <Tab.Panel>
                  <MyFaq uniqueClass="customerFaq" heading_title="Customer Support FAQs" items={faqItems} />
                </Tab.Panel>
                <Tab.Panel>
                  <MyFaq uniqueClass="rewardFaq" heading_title="Reward FAQs" items={faqItems} />
                </Tab.Panel>
                <Tab.Panel>
                  <MyFaq uniqueClass="shopFaq" heading_title="Shopping FAQs" items={faqItems} />
                </Tab.Panel>
              </Tab.Panels>
            </div>
          </Tab.Group>
        </div>
      </div>
    </div>
  );
};

export const getServerSideProps = createGetServerSidePropsFn(Blogs);

Blogs.Layout = MainLayout;

export default Blogs;
