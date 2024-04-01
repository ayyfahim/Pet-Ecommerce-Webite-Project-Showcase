import React, { useEffect } from "react";
import styles from "./style.module.scss";

const Select = ({ name = "", options, defaultValue, value = "", onChange }) => {
  useEffect(() => {
    onChange(value);
  }, []);
  return (
    <div className={styles.customSelect}>
      <select
        id={name}
        name={name}
        value={value}
        defaultValue={defaultValue}
        className={styles.inputStyle}
        onChange={(e) => onChange(e.target.value)}
      >
        <option value="" className="">
          {" "}
        </option>
        {options.map((item) => (
          <option className={styles.option} value={item.value} key={item.value}>
            {item.text}
          </option>
        ))}
      </select>
    </div>
  );
};

export default Select;
