import React from 'react';
import Slider from 'react-rangeslider';

const MyRangeSlider = React.forwardRef(({ ...props }, ref) => {
  const { field, setState, min = 0, max = 100, orientation = 'horizontal' } = props;
  // console.log('value RangeSlider', field.value);
  const { value } = field || {};
  const handleChangeRangeSlider = (value) => {
    setState(value);
  };

  return <Slider {...props} min={min} max={max} value={value} orientation="horizontal" {...field} />;
});

export default MyRangeSlider;
