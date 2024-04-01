import React from 'react';
import styles from 'styles/InputLabel.module.scss';
import RHookFormControl from 'components/forms/RHookFormControl';
import { useFormContext } from 'react-hook-form';
import classNames from 'classnames';

const _InputLabel = ({ label, inputType, inputPlaceholder, inputValue, name = '' }) => {
  return (
    <div className={styles.editLabelInput}>
      {Label({ label })}
      {Input({ inputType, inputPlaceholder, inputValue })}
    </div>
  );
};

const InputLabel = ({ label, inputType, inputPlaceholder, inputValue, name = '' }) => {
  return (
    <RHookFormControl
      className={styles.editLabelInput}
      name={name}
      type={inputType}
      autoComplete={name}
      placeholder={inputPlaceholder}
      inputClassName={styles.input}
      label={() => <Label label={label} />}
    />
  );
};

export default InputLabel;

export const Label = ({ label }) => {
  return <label className={styles.label}>{label}</label>;
};

export const Input = ({ inputType, inputPlaceholder, inputValue }) => {
  return (
    <input
      className={styles.input}
      type={inputType}
      placeholder={inputPlaceholder}
      defaultValue={inputValue ? inputValue : ''}
    />
  );
};

export const TextArea = ({ name, rows, cols, inputValue, ...props }) => {
  const {
    register,
    formState: { errors },
  } = useFormContext();

  return (
    <>
      <RHookFormControl>
        <textarea
          {...register(name)}
          rows={rows}
          cols={cols}
          id={`field-${name}`}
          name={name}
          className={classNames(
            styles.input,
            'peer',
            errors[name]?.message ? 'invalid' : '',
            errors[name]?.message ? 'text-red-300 border-red-400' : ''
          )}
          aria-invalid={!!errors[name]?.message}
          {...props}
        >
          {inputValue}
        </textarea>
        {errors && errors[name] && errors[name]?.message && (
          <p className="text-red-700 font-light">{String(errors[name]?.message) || ''}</p>
        )}
      </RHookFormControl>
      {/* <textarea className={styles.input} rows={rows} cols={cols}>
        {inputValue}
      </textarea> */}
    </>
  );
};
