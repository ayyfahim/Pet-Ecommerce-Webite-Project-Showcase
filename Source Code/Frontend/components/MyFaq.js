import React, { useState, useEffect } from 'react';
import style from 'styles/MyFaq.module.scss';
import { Disclosure, Transition } from '@headlessui/react';
import { BsPlayFill } from 'react-icons/bs';
import { IoIosArrowUp } from 'react-icons/io';
// import useWindowDimensions from 'app/hooks/useWindowDimensions';

const MyFaq = ({ items, heading_title, uniqueClass }) => {
  const [expandFaq, setExpandFaq] = useState(true);
  // const { width } = useWindowDimensions();

  const expandAll = () => {
    if (!uniqueClass) return;
    const btns = document.getElementsByClassName(uniqueClass);
    for (var i = 0; i < btns.length; i++) {
      if (!expandFaq && btns[i].getAttribute('aria-expanded') == 'false') {
        btns[i].click();
      }

      if (expandFaq && btns[i].getAttribute('aria-expanded') == 'true') {
        btns[i].click();
      }
    }
    setExpandFaq((prevState) => !prevState);
  };

  // useEffect(() => {
  //   if (width > 425) {
  //     expandAll();
  //   }
  // }, [width]);

  return (
    <>
      <div className="flex flex-row flex-wrap justify-between pb-[40px]">
        <h4 className={`${style.section_title}`}>{heading_title}</h4>
        <div>
          <button className={`${style.expandBtn}`} onClick={() => expandAll()}>
            <BsPlayFill />
            {expandFaq ? 'Close All' : 'Expand all'}
          </button>
        </div>
      </div>
      <div className={style.faqBox}>
        {items?.map((item, index) => (
          <Disclosure as="div" className={style.faqItem} defaultOpen={true}>
            {({ open }) => (
              <>
                <Disclosure.Button className={`${style.disclosureButton} ${uniqueClass}`}>
                  <span>{item?.question}</span>
                  <IoIosArrowUp className={`${open ? style.active : ''} ${style.arrow}`} />
                </Disclosure.Button>
                <Transition
                  enter="transition duration-100 ease-out"
                  enterFrom="transform scale-95 opacity-0"
                  enterTo="transform scale-100 opacity-100"
                  leave="transition duration-75 ease-out"
                  leaveFrom="transform scale-100 opacity-100"
                  leaveTo="transform scale-95 opacity-0"
                >
                  <Disclosure.Panel className={style.disclosurePanel}>{item?.answer}</Disclosure.Panel>
                </Transition>
              </>
            )}
          </Disclosure>
        ))}
      </div>
    </>
  );
};

export default MyFaq;
