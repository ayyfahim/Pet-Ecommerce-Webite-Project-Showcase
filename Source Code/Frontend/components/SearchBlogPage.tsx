import { FC, useState } from 'react';
import styles from 'styles/Search.module.scss';
import { useDebouncedCallback } from 'use-debounce';

const mainPlaceholder = 'Search your Products';

interface SearchProps {
  placeholder?: string;
  setSearchStr?: React.Dispatch<React.SetStateAction<string>>;
}

const Search: FC<SearchProps> = ({ placeholder, setSearchStr }) => {
  const [str, setStr] = useState('');
  const debounced = useDebouncedCallback((e) => {
    if (setSearchStr) {
      setSearchStr(e.target.value);
    } else {
      setStr(e.target.value);
    }
  }, 300);
  return (
    <div className={styles.formWrapper}>
      <form className={styles.form}>
        <input className={styles.input} type="text" onChange={debounced} placeholder={placeholder || mainPlaceholder} />
      </form>
    </div>
  );
};

export default Search;
