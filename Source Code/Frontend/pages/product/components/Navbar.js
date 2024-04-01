import { useState } from "react";
import Image from "next/image";
import Link from "next/link";
import classNames from "classnames";

import { BiUser } from "react-icons/bi";
import iconMenu from "public/img/header/icon-hamburder-menu.svg";
import logo from "public/img/header/logo-horizontal.svg";
import cartIcon from "public/img/header/icon-cart.svg";
import crossIcon from "public/img/header/icon-cross.svg";
import styles from "../../../styles/Navbar.module.css";

import calmIcon from "public/img/shop-by-concern/calm.svg";
import immunityIcon from "public/img/shop-by-concern/immunity.svg";
import mobilityIcon from "public/img/shop-by-concern/mobility.svg";
import petsIcon from "public/img/shop-by-concern/pets.svg";
import reliefIcon from "public/img/shop-by-concern/relief.svg";
import wellnessIcon from "public/img/shop-by-concern/wellness.svg";

export default function Navbar() {
  const [visibility, setVisibility] = useState(false);

  let navClass = classNames({
    [`${styles.navLinks}`]: true,
  });

  let navWrapperClass = classNames({
    [`${styles.navWrapper}`]: true,
    hidden: visibility === false,
  });

  let mobileLogoClass = classNames({
    [`${styles.mobileLogo}`]: true,
    hidden: visibility === false,
    "xl:hidden": true,
  });

  let mobileClose = classNames({
    [`${styles.mobileClose}`]: true,
    hidden: visibility === false,
    "xl:hidden": true,
  });

  return (
    <nav className={styles.nav}>
      <div className={styles.nav_body}>
        <button
          className={styles.menuButton}
          onClick={() => setVisibility(!visibility)}
        >
          <Image alt="logo" src={iconMenu} width={20} height={20} />
        </button>
        <div className={styles.logo}>
          <Link href="/">
            <a className="flex flex-col justify-center">
              <Image alt="logo" src={logo} />
            </a>
          </Link>
        </div>
        <div className={navWrapperClass}>
          <div className={mobileClose}>
            <button
              className="cursor-pointer"
              onClick={() => setVisibility(!visibility)}
            >
              <Image alt="logo" src={crossIcon} width={20} height={20} />
            </button>
          </div>

          <div className={mobileLogoClass}>
            <Image alt="logo" src={logo} width={129} height={34} />
          </div>

          <ul className={navClass}>
            <li className={styles.megaLink}>
              <a href="">Shop</a>
              <div className={styles.megaWrapper}>
                <div className={styles.megaContainer}>
                  <div className="w-1/5 bg-light-purple flex flex-col pt-6">
                    <ul className="py-4 text-left">
                      <li className="text-sm pl-12 py-1.5 text-purple font-bold">
                        TRENDING CATEGORIES
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">Top Deals</a>
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">Dog Food</a>
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">Dog Flea & Tick</a>
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">Cat Litter</a>
                      </li>
                    </ul>
                    <ul className="py-4 text-left">
                      <li className="text-sm pl-12 py-1.5 text-purple font-bold">
                        TRENDING BRANDS
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">WholeHearted</a>
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">Blue Buffalo</a>
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">Merrick</a>
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">Science Diet</a>
                      </li>
                      <li className="font-15 hover:bg-active-purple transition-colors py-1.5 cursor-pointer pl-12">
                        <a href="">Royal Canin</a>
                      </li>
                    </ul>
                  </div>

                  <div className="w-4/5 text-left pb-12">
                    <div className={styles.features}>
                      <div>
                        <a href="">
                          <Image
                            alt="logo"
                            src={calmIcon}
                            className={styles.icon}
                          />
                          <p className={styles.iconDescription}>Calm</p>
                        </a>
                      </div>
                      <div>
                        <a href="">
                          <Image
                            alt="logo"
                            src={immunityIcon}
                            className={styles.icon}
                          />
                          <p className={styles.iconDescription}>Immunity</p>
                        </a>
                      </div>
                      <div>
                        <a href="">
                          <Image
                            alt="logo"
                            src={mobilityIcon}
                            className={styles.icon}
                          />
                          <p className={styles.iconDescription}>Mobility</p>
                        </a>
                      </div>
                      <div>
                        <a href="">
                          <Image
                            alt="logo"
                            src={reliefIcon}
                            className={styles.icon}
                          />
                          <p className={styles.iconDescription}>Relief</p>
                        </a>
                      </div>
                      <div>
                        <a href="">
                          <Image
                            alt="logo"
                            src={petsIcon}
                            className={styles.icon}
                          />
                          <p className={styles.iconDescription}>Skin & Coat</p>
                        </a>
                      </div>
                      <div>
                        <a href="">
                          <Image
                            alt="logo"
                            src={wellnessIcon}
                            className={styles.icon}
                          />
                          <p className={styles.iconDescription}>Wellness</p>
                        </a>
                      </div>
                    </div>

                    <hr className="mx-14" />

                    <div className="mt-6 pl-14 flex">
                      <ul className="mx-4">
                        <li className="font-bold font-15 pb-4">Food</li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Dry Food</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Wet Food</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Veterinary Diets</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Minimally Processed Dog Food</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Grain Free Food</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Human-Grade Food</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Puppy Food</a>
                        </li>
                      </ul>

                      <ul className="mx-4">
                        <li className="font-bold font-15 pb-4">Treats</li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Biscuits & Crunchy Treats</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Soft & Chewy Treats</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Dental Treats</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Jerky Treats</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Training Treats</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Bones & Chews</a>
                        </li>
                      </ul>

                      <ul className="mx-4">
                        <li className="font-bold font-15 pb-4">Supplies</li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Clothes & Accessories</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Beds</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Bowls & Feeders</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Collars, Leashes, and Harnesses</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Crates & Kennels</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Gates, Doors, and Pens</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Grooming</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Poop Bags & Cleaning Supplies</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Toys</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Training & Behavior</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Travel & Outdoor</a>
                        </li>
                      </ul>

                      <ul className="mx-4">
                        <li className="font-bold font-15 pb-4">
                          Health & Wellness
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Vitamins & Supplements</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Flea & Tick Prevention</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">First Aid</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Dog Calming Aids</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Dog Pharmacy</a>
                        </li>
                        <li className="font-15 py-1.5 ">
                          <a href="">Dog DNA Kits</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>

            <li>
              <a href="">Wellness</a>
            </li>
            <li>
              <a href="">Blog</a>
            </li>
            <li>
              <a href="">About us</a>
            </li>
            <li>
              <a href="">Profile</a>
            </li>
          </ul>

          <div className="flex flex-col mt-5 lg:flex-row lg:mt-0 lg:items-center">
            <div className="mb-16 text-center lg:mb-0 lg:px-8">
              <a href="" className={styles.rewards}>
                Rewards
              </a>
            </div>
            <div className="text-center pb-12 lg:pb-0 lg:px-8">
              <a href="" className={styles.call}>
                (555) 555-1234
              </a>
            </div>
          </div>
        </div>

        <div className={styles.cartButton}>
          <Image
            alt="logo"
            src={cartIcon}
            className="align-middle"
            width={24}
            height={24}
          />
        </div>

        <div className="hidden xl:flex xl:order-4 xl:items-center xl:ml-6">
          <span className={styles.avatar}>
            <BiUser />
          </span>
        </div>
      </div>
    </nav>
  );
}
