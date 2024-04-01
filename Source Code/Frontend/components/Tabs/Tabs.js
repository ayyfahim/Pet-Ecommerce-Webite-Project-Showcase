import { Children, cloneElement } from 'react';

import styles from './tabs.module.css';

function Tabs(props) {
  const { children, onChange, value } = props;

  return (
    <div className={styles.tabsRoot}>
      {Children.map(children, (child, index) =>
        cloneElement(child, { onChange, value, index })
      )}
    </div>
  );
}

export default Tabs;
