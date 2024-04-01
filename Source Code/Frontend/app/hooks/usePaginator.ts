import { useState } from 'react';
import { IFilter, IPaginator } from 'types/pagination.types';
import debounce from 'shared/debounce';

export const getDefaultPagination = (): IPaginator => {
  return {
    search: '',
    sortBy: 'createdAt',
    sortOrder: 'DESC',
    page: 1 as number,
    limit: 24 as number,
    total: 0,
  };
};

export default function usePaginator<T = IFilter>(
  defaultOptions = {} as Partial<Omit<IPaginator<T>, 'total'>>
) {
  const [paginator, setPaginator] = useState({
    ...getDefaultPagination(),
    ...defaultOptions,
  } as IPaginator<T> & {
    total: number;
  });

  // lazy paginator
  const updatePaginator = debounce(
    (key: keyof Omit<IPaginator<T>, 'total'>, value: unknown, callback: CallableFunction) => {
      // @ts-ignore
      paginator[key as keyof IPaginator] = value;
      setPaginator(paginator);
      callback();
    },
    500
  );

  function changePaginator(options: Partial<IPaginator<T>> = {}, callback?: CallableFunction) {
    Object.assign(paginator, options);
    setPaginator({
      ...paginator,
    });
    callback && callback();
  }

  function setTotal(total: number) {
    paginator.total = total;
  }

  function resetPaginator(options: Partial<IPaginator<T>> = {}, callback: CallableFunction) {
    const searchEl = document.querySelector('input[name="search"]') as HTMLInputElement;
    if (searchEl) {
      searchEl.value = '';
    }
    const data = Object.assign(
      { ...getDefaultPagination(), ...defaultOptions } as IPaginator<T>,
      options
    ) as IPaginator<T>;
    (Object.keys(paginator) as (keyof IPaginator<T>)[]).forEach((key) => {
      delete paginator[key];
      // @ts-ignore
      paginator[key] = data[key];
    });
    setPaginator({ ...paginator });
    callback();
  }

  return { paginator, setPaginator, resetPaginator, updatePaginator, changePaginator, setTotal };
}
