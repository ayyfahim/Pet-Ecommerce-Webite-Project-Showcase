import Image from "next/image";

import facebook from "public/img/social-icons/facebook.svg";
import twitter from "public/img/social-icons/twitter.svg";
import pinterest from "public/img/social-icons/pinterest.svg";

const spanStyle = {
  marginLeft: "4px",
  fontSize: "14px",
};

export default function SocialButtons() {
  return (
    <>
      <div className="flex items-center cursor-pointer">
        <Image alt="logo" src={facebook} width={16} height={16} />
        <span style={spanStyle}>Share</span>
      </div>
      <div className="flex items-center ml-6 cursor-pointer">
        <Image alt="logo" src={twitter} width={16} height={16} />
        <span style={spanStyle}>Tweet</span>
      </div>
      <div className="flex items-center ml-6 cursor-pointer">
        <Image alt="logo" src={pinterest} width={16} height={16} />
        <span style={spanStyle}>Pin it</span>
      </div>
    </>
  );
}
