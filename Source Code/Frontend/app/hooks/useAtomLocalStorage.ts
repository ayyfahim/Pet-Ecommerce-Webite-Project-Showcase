const localStorageEffect =
  (key: any) =>
  ({ setSelf, onSet }: { setSelf: any; onSet: any }) => {
    if (typeof window !== 'undefined') {
      const savedValue = localStorage.getItem(key);
      if (savedValue && savedValue != null && typeof savedValue !== 'undefined' && savedValue != 'undefined') {
        // console.log('savedValue', savedValue, key);
        setSelf(JSON.parse(savedValue));
      }

      onSet((newValue: any, _: any, isReset: any) => {
        isReset ? localStorage.removeItem(key) : localStorage.setItem(key, JSON.stringify(newValue));
      });
    }
  };

export default localStorageEffect;
