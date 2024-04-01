import { createContext, ReactNode, useContext, useState } from 'react';

type IFormContext = {
  hasPendingChanges: boolean;
  setHasPendingChanges: (hasPendingChanges: boolean) => void;
};

const formContext = createContext<IFormContext>({
  hasPendingChanges: false,
  setHasPendingChanges: () => {},
});

formContext.displayName = 'FormContext';
const FormContextProvider = formContext.Provider;

export function FormContext({ children }: { children: ReactNode }) {
  const [hasPendingChanges, setHasPendingChanges] = useState(false);

  return (
    <FormContextProvider
      value={{
        hasPendingChanges,
        setHasPendingChanges,
      }}
    >
      {children}
    </FormContextProvider>
  );
}

export default function useFormContainerContext() {
  return useContext(formContext);
}
