export default function debounce<TFunction = CallableFunction>(
  fn: TFunction,
  wait: number,
  immediate = false
): TFunction {
  let timeout: number | null;

  const func = (...args: unknown[]) => {
    const later = () => {
      timeout = null;
      if (!immediate) {
        (fn as unknown as CallableFunction)(...args);
      }
    };
    const callNow = immediate && !timeout;
    timeout && clearTimeout(timeout);
    timeout = window.setTimeout(later, wait);
    if (callNow) {
      (fn as unknown as CallableFunction)(...args);
    }
  };

  return func as unknown as TFunction;
}
