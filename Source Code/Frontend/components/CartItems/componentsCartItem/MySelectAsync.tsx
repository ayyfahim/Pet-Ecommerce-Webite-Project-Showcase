import React, { FC } from 'react';
import { components } from 'react-select';
import Select from 'react-select/async';

const options = [
  { value: 'chocolate', label: 'Chocolate' },
  { value: 'strawberry', label: 'Strawberry' },
  { value: 'vanilla', label: 'Vanilla' },
];

interface IMySelectProps {
  state?: any;
  setState?: any;
  optionsArr?: any;
  classNamePrefix?: string;
  placeholder?: string;
  isMulti?: boolean;
  loadOptions: () => Promise<any>;
}

const MultiValue = ({ index, getValue, children, ...props }: any) => {
  const maxToShow = 2;
  const overflow = getValue()
    .slice(maxToShow)
    .map((x: any) => x.label);

  return index < maxToShow ? (
    <components.MultiValue children={children.length > 6 ? children.slice(0, 3).concat('…') : children} {...props} />
  ) : index === maxToShow ? (
    <MoreSelectedBadge items={overflow} />
  ) : null;
};

const MoreSelectedBadge = ({ items }: any) => {
  const style = {
    // marginLeft: 'auto',
    background: 'hsl(0, 0%, 90%)',
    borderRadius: '2px',
    // fontSize: '11px',
    // padding: '3px',
    padding: '3px',
    paddingLeft: '6px',
    order: 99,
  };

  const title = items.join(', ');
  const length = items.length;
  // const label = `+ ${length} item${length !== 1 ? 's' : ''} selected`;
  const label = `+ ${length}`;

  return (
    <div style={style} title={title}>
      {label}
    </div>
  );
};

const MySelect: FC<IMySelectProps> = ({
  state,
  setState,
  optionsArr = options,
  classNamePrefix,
  placeholder,
  isMulti = false,
  loadOptions,
}) => {
  const handleChange = (selectedOption: any) => {
    setState(selectedOption);
  };
  return (
    <Select
      hideSelectedOptions={true}
      value={state}
      placeholder={placeholder}
      className="mySelect"
      onChange={handleChange}
      options={optionsArr}
      getOptionLabel={(option) => option.value}
      classNamePrefix={classNamePrefix}
      isSearchable={false}
      isMulti={isMulti}
      components={{
        IndicatorSeparator: () => null,
        MultiValue,
      }}
      loadOptions={loadOptions}
    />
  );
};

export default MySelect;
