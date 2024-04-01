import React from "react";
import Image from "next/image";
import { Fragment, useState } from "react";
import { Dialog, Transition } from "@headlessui/react";
import group from "@/public/img/logo/group.svg";
import crossIcon from "@/public/img/logo/icon-20-cross-thick.svg";
import style from "styles/modal.module.scss";

const Modal = ({ open, setOpen }) => {
  return (
    <Transition.Root show={open} as={Fragment}>
      <Dialog
        as="div"
        auto-reopen="true"
        className={style.wrapper}
        onClose={setOpen}
      >
        <div className={style.contentWrapper}>
          <Transition.Child
            as={Fragment}
            enter="ease-out duration-300"
            enterFrom="opacity-0"
            enterTo="opacity-100"
            leave="ease-in duration-200"
            leaveFrom="opacity-100"
            leaveTo="opacity-0"
          >
            <Dialog.Overlay className={style.transition} />
          </Transition.Child>

          <Transition.Child
            as={Fragment}
            enter="ease-out duration-300"
            enterFrom="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enterTo="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leaveFrom="opacity-100 translate-y-0 sm:scale-100"
            leaveTo="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <div className={style.content}>
              <div className={style.closeWrapper}>
                <button
                  type="button"
                  className={style.close}
                  onClick={() => setOpen(false)}
                >
                  <span className="sr-only">Close</span>
                  <Image src={crossIcon} className="w-5 h-5" alt="close" />
                </button>
              </div>
              <div>
                <div className={style.logo}>
                  <Image src={group} className="w-20 h-20" alt="group" />
                </div>
                <div className="mt-8 text-center ">
                  <Dialog.Title as="h3" className={style.text}>
                    Please check your email for password recovery instructions
                  </Dialog.Title>
                </div>
              </div>
            </div>
          </Transition.Child>
        </div>
      </Dialog>
    </Transition.Root>
  );
};

export default Modal;
