import React, { createContext, useContext, useEffect, useState } from 'react';
import { Controller, useFormContext } from 'react-hook-form';

const formControlContext = createContext({
  name: '',
  setName: () => {},
});

formControlContext.displayName = 'FormControlContext';
const FormControlContextProvider = formControlContext.Provider;

const FormControl = ({ children }) => {
  const { formState, control } = useFormContext() || {};

  const { errors } = formState || {};

  const [name, setName] = useState('');

  if (!control) {
    return;
  }

  return (
    <FormControlContextProvider value={{ name, setName }}>
      <Controller
        render={({ field }) =>
          React.Children.map(children, (el) => {
            return React.cloneElement(el, { field });
          })
        }
        name={name}
        control={control}
      />
      {errors?.[name]?.message && <p className="text-red-700 font-light">{String(errors?.[name]?.message) || ''}</p>}
    </FormControlContextProvider>
  );
};

export function FormControlName({ children }) {
  const { setName } = useContext(formControlContext);

  useEffect(() => {
    setName(children || null);
  }, [children]);

  return null;
}

export default FormControl;
