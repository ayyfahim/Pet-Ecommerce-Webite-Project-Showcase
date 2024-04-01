import React, { useEffect, useRef, useState } from 'react';
import Select, { components } from 'react-select';
import { FiChevronDown } from 'react-icons/fi';
import classNames from 'classnames';

const options = [
  { value: 'ocean', label: 'Ocean', color: '#00B8D9' },
  { value: 'blue', label: 'Blue', color: '#0052CC', disabled: true },
  { value: 'purple', label: 'Purple', color: '#5243AA' },
  { value: 'red', label: 'Red', color: '#FF5630' },
  { value: 'orange', label: 'Orange', color: '#FF8B00' },
  { value: 'yellow', label: 'Yellow', color: '#FFC400' },
  { value: 'green', label: 'Green', color: '#36B37E' },
  { value: 'forest', label: 'Forest', color: '#00875A' },
  { value: 'slate', label: 'Slate', color: '#253858' },
  { value: 'silver', label: 'Silver', color: '#666666' },
];

const { MenuList, ValueContainer, SingleValue, Placeholder, DropdownIndicator } = components;

const MySelectL = React.forwardRef(
  (
    {
      state,
      setState,
      optionsArr = options,
      className,
      classNamePrefix,
      placeholder,
      searchPlaceholder,
      field,
      handleNextStepButton,
      ...props
    },
    ref
  ) => {
    const { value } = field || {};
    // console.log('value MySelectL', value);
    const containerRef = useRef(null);
    const [isFocused, setIsFocused] = useState(false);
    const [inputValue, setInputValue] = useState('');

    const onDomClick = (e) => {
      let menu = containerRef.current.querySelector('.select__menu');

      if (!containerRef.current.contains(e.target) || !menu || !menu.contains(e.target)) {
        setIsFocused(false);
        setInputValue('');
      }
    };

    useEffect(() => {
      document.addEventListener('mousedown', onDomClick);

      return () => {
        document.removeEventListener('mousedown', onDomClick);
      };
    }, []);

    const handleChange = (selectedOption) => {
      setState(selectedOption);
      setIsFocused(false);
    };

    return (
      <div ref={containerRef}>
        <Select
          value={value}
          placeholder={placeholder}
          className={classNames('mySelectL', className)}
          classNamePrefix={classNamePrefix}
          options={optionsArr}
          getOptionLabel={(option) => option.value}
          components={{
            MenuList: CustomMenuList,
            ValueContainer: CustomValueContainer,
            DropdownIndicator: CustomDropdownIndicator,
            IndicatorSeparator: () => null,
          }}
          inputValue={inputValue}
          isSearchable={false}
          onMenuInputFocus={() => setIsFocused(true)}
          onInputChange={(val) => {
            setInputValue(val);
            // handleNextStepButton();
          }}
          {...{
            menuIsOpen: isFocused || undefined,
            isFocused: isFocused || undefined,
          }}
          searchPlaceholder={searchPlaceholder}
          {...props}
          {...field}
        />
      </div>
    );
  }
);

const CustomMenuList = ({ selectProps, ...props }) => {
  const { onInputChange, inputValue, onMenuInputFocus, searchPlaceholder } = selectProps;

  // Copied from source
  const ariaAttributes = {
    'aria-autocomplete': 'list',
    'aria-label': selectProps['aria-label'],
    'aria-labelledby': selectProps['aria-labelledby'],
  };

  return (
    <div>
      <input
        autoCorrect="off"
        autoComplete="off"
        spellCheck="false"
        type="text"
        value={inputValue}
        onChange={(e) =>
          onInputChange(e.currentTarget.value, {
            action: 'input-change',
          })
        }
        onMouseDown={(e) => {
          e.stopPropagation();
          e.target.focus();
        }}
        onTouchEnd={(e) => {
          e.stopPropagation();
          e.target.focus();
        }}
        onFocus={onMenuInputFocus}
        placeholder={searchPlaceholder}
        {...ariaAttributes}
      />
      <MenuList {...props} selectProps={selectProps} />
    </div>
  );
};

// Set custom `SingleValue` and `Placeholder` to keep them when searching
const CustomValueContainer = ({ children, selectProps, ...props }) => {
  const commonProps = {
    cx: props.cx,
    clearValue: props.clearValue,
    getStyles: props.getStyles,
    getValue: props.getValue,
    hasValue: props.hasValue,
    isMulti: props.isMulti,
    isRtl: props.isRtl,
    options: props.options,
    selectOption: props.selectOption,
    setValue: props.setValue,
    selectProps,
    theme: props.theme,
  };

  return (
    <ValueContainer {...props} selectProps={selectProps}>
      {React.Children.map(children, (child) => {
        return child ? (
          child
        ) : props.hasValue ? (
          <SingleValue {...commonProps} isFocused={selectProps.isFocused} isDisabled={selectProps.isDisabled}>
            {selectProps.getOptionLabel(props.getValue()[0])}
          </SingleValue>
        ) : (
          <Placeholder {...commonProps} key="placeholder" isDisabled={selectProps.isDisabled} data={props.getValue()}>
            {selectProps.placeholder}
          </Placeholder>
        );
      })}
    </ValueContainer>
  );
};

const CustomDropdownIndicator = ({ selectProps, ...props }) => {
  return (
    <DropdownIndicator {...props}>
      <FiChevronDown color="#262624" size={25} />
    </DropdownIndicator>
  );
};

const SingleSelect = () => {
  const containerRef = useRef(null);
  const [isFocused, setIsFocused] = useState(false);
  const [inputValue, setInputValue] = useState('');

  const onDomClick = (e) => {
    let menu = containerRef.current.querySelector('.select__menu');

    if (!containerRef.current.contains(e.target) || !menu || !menu.contains(e.target)) {
      setIsFocused(false);
      setInputValue('');
    }
  };

  useEffect(() => {
    document.addEventListener('mousedown', onDomClick);

    return () => {
      document.removeEventListener('mousedown', onDomClick);
    };
  }, []);

  return (
    <div ref={containerRef}>
      <Select
        className="basic-single"
        classNamePrefix="select"
        name="color"
        options={colourOptions}
        components={{
          MenuList: CustomMenuList,
          ValueContainer: CustomValueContainer,
        }}
        inputValue={inputValue}
        isSearchable={false}
        onMenuInputFocus={() => setIsFocused(true)}
        onChange={() => setIsFocused(false)}
        onInputChange={(val) => setInputValue(val)}
        {...{
          menuIsOpen: isFocused || undefined,
          isFocused: isFocused || undefined,
        }}
      />
    </div>
  );
};

export default MySelectL;
