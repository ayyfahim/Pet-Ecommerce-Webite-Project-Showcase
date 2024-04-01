import React from 'react';
import style from 'styles/AddPet.module.scss';

const MyInputL = React.forwardRef(
  ({ inputType = 'text', placeholder = 'Type...', subLabelText, field, ...props }, ref) => {
    const { value, onChange } = field || {};
    const handleNumberValue = (e) => {
      let val = parseInt(e.target.value, 10);
      if (isNaN(val)) {
        return 0;
      } else {
        // is A Number
        val = val >= 0 ? val : 0;
        return val;
      }
    };
    return (
      <div className={style.MyInputLWrapper}>
        <input
          type={inputType}
          placeholder={placeholder}
          className={style.MyInputL}
          value={value}
          {...field}
          {...props}
          onChange={(e) => {
            if (inputType == 'number') {
              onChange(handleNumberValue(e));
            } else {
              onChange(e);
            }
          }}
        />
        {subLabelText && <span className={style.MyInputLSubLabel}>in Kg</span>}
      </div>
    );
  }
);

export default MyInputL;
