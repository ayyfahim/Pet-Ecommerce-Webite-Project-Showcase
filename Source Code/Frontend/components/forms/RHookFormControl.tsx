import { useFormContext } from 'react-hook-form';
import { InputHTMLAttributes, ReactNode } from 'react';
import classNames from 'classnames';

export type IFormControlProps = Omit<InputHTMLAttributes<HTMLInputElement>, 'name'> & {
  children?: ReactNode;
  helperText?: ReactNode;
  label?: React.ElementType | string;
  name: string;
  hidden?: boolean;
  inputClassName?: string;
};

const RHookFormControl = ({
  label: PropsLabel,
  name,
  children,
  helperText,
  hidden,
  className,
  inputClassName,
  ...props
}: IFormControlProps) => {
  const {
    register,
    formState: { errors },
  } = useFormContext();

  return (
    <div
      className={classNames(
        'form-controller',
        hidden ? 'hidden' : '',
        errors[name]?.message ? 'has-error' : '',
        className
      )}
    >
      <label className={classNames('block', errors[name]?.message ? 'text-red-300' : '')}>
        <>
          {!!PropsLabel && (typeof PropsLabel === 'string' ? <span>{PropsLabel}</span> : <PropsLabel />)}
          {children ? (
            children
          ) : (
            <div className="mt-1">
              <input
                {...register(name)}
                id={`field-${name}`}
                name={name}
                {...props}
                className={classNames(
                  inputClassName,
                  'peer',
                  errors[name]?.message ? 'invalid' : '',
                  errors[name]?.message ? 'text-red-300 border-red-400' : ''
                )}
                aria-invalid={!!errors[name]?.message}
                {...(helperText ? { 'aria-describedby': `helper-text-${name}` } : {})}
              />
              {helperText && (
                <p id={`helper-text-${name}`} className="mt-2 text-sm text-gray-500 dark:text-gray-400">
                  {helperText}
                </p>
              )}
              {errors && errors[name] && errors[name]?.message && (
                <p className="text-red-700 font-light">{String(errors[name]?.message) || ''}</p>
              )}
            </div>
          )}
        </>
      </label>
    </div>
  );
};

export default RHookFormControl;
