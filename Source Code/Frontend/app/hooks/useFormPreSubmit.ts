import { useFormContext } from 'react-hook-form';
import { useRef } from 'react';

export default function useFormPreSubmit(key: string, msg: string) {
  const { setValue, getValues, register, unregister } = useFormContext();

  const fieldName = useRef(getPromiseFieldName(key));
  const isRegistered = useRef(false);

  function createPromise() {
    !isRegistered.current && register(fieldName.current);
    isRegistered.current = true;
    const promises = getValues('promise') || {};
    promises[key] = msg;
    setValue('promise', { ...promises });
  }

  function resolvePromise() {
    const promises = getValues('promise') || {};
    if (promises[key]) {
      delete promises[key];
      unregister(fieldName.current);
      isRegistered.current = false;
      setValue('promise', { ...promises });
    }
  }

  return {
    createPromise,
    resolvePromise,
  };
}

export function getPromiseFieldName(name: string) {
  return `promises-${name}`;
}
