import { smartSearchAtomState } from '@/app/atom/smartSearchAtom';
import { smartSearchStrAtom } from '@/app/atom/SmartSearchStrAtom';
import { FC, InputHTMLAttributes, useEffect, useRef, useState } from 'react';
import { useRecoilState } from 'recoil';
import styles from 'styles/Search.module.scss';
import { useDebouncedCallback } from 'use-debounce';
import { getRequestSwr } from 'requests/api';

import dynamic from 'next/dynamic';
const SearchTips = dynamic(() => import('./SearchTips'), {
  ssr: false,
});

const mainPlaceholder = 'Search your Products';

interface SearchProps {
  placeholder?: string;
}

const Search: FC<SearchProps> = ({ placeholder }) => {
  const [updatedKey, setUpdatedKey] = useState(1);

  const [SmartSearchStr, setSmartSearchStr] = useRecoilState(smartSearchStrAtom);

  const [smartSearchState, setSmartSearchState] = useRecoilState(smartSearchAtomState);

  const debounced = useDebouncedCallback((e) => {
    if (!SmartSearchStr || !smartSearchState) setSmartSearchState(true);
    setSmartSearchStr(e.target.value);
  }, 300);

  useEffect(() => {
    if (SmartSearchStr === '') setSmartSearchState(false);
  }, [SmartSearchStr]);

  const searchResult = getRequestSwr<any>(`/products?q=${SmartSearchStr}`);

  const onClickTips = (value: any) => {
    const input: any = document?.getElementById('searchInputBox');
    // @ts-ignore
    const nativeInputValueSetter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, 'value').set;
    nativeInputValueSetter?.call(input, value);

    const ev2 = new Event('input', { bubbles: true });
    input.dispatchEvent(ev2);
  };

  return (
    <div className={styles.formWrapper}>
      <form className={styles.form}>
        <input
          className={styles.input}
          id="searchInputBox"
          type="text"
          onChange={debounced}
          placeholder={placeholder || mainPlaceholder}
          key={updatedKey}
        />
        {smartSearchState && (
          <SearchTips
            SmartSearchStr={SmartSearchStr}
            products={searchResult?.data ?? []}
            brands={searchResult?.meta?.brands || []}
            onClickTips={onClickTips}
          />
        )}
      </form>
    </div>
  );
};

export default Search;
