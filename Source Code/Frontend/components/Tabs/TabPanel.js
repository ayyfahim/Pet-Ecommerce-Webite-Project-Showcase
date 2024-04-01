function TabPanel(props) {
  const { children, value, index } = props;

  if (value === index) {
    return children;
  }

  return null;
}

export default TabPanel;
