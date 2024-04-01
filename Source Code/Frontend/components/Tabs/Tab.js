import classNames from 'classnames';

import styles from './tabs.module.css';

function Tab(props) {
  const { name, onChange, value, index } = props;

  return (
    <button
      onClick={() => onChange(index)}
      className={classNames(
        styles.tabRoot,
        value === index && styles.tabActive
      )}
    >
      {name}
    </button>
  );
}

export default Tab;
