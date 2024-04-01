import React from "react";
import Image from "next/image";

const SocialButton = ({ title, url }) => {
  return (
    <button
      type="button"
      className="w-full border border-middle-white rounded-lg pt-17px pb-19px mb-4 flex justify-center"
    >
      <Image src={url} alt="logo" className="h-6 w-6" />
      <p className="ml-11px  text-sm">{title}</p>
    </button>
  );
};

export default SocialButton;
