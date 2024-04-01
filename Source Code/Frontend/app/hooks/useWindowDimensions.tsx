import { useLayoutEffect } from 'react';
import { useEffect, useState } from 'react';

type WindowDimentions = {
  width: number | undefined;
  height: number | undefined;
};

const useWindowDimensions = (): WindowDimentions => {
  const [windowDimensions, setWindowDimensions] = useState<WindowDimentions>({
    width: undefined,
    height: undefined,
  });
  useEffect(() => {
    function handleResize(): void {
      setWindowDimensions({
        width: window.innerWidth,
        height: window.innerHeight,
      });
    }
    handleResize();
    window.addEventListener('resize', handleResize);
    return (): void => window.removeEventListener('resize', handleResize);
  }, []); // Empty array ensures that effect is only run on mount

  return windowDimensions;
};

export default useWindowDimensions;

export const isElementVisible = (element: React.MutableRefObject<null> | any, rootMargin: string = '0px'): boolean => {
  const [isElementVisible, setIsElementVisible] = useState(false);

  useLayoutEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        setIsElementVisible(entry.isIntersecting);
      },
      { rootMargin }
    );

    element.current && observer.observe(element.current);

    return () => observer.unobserve(element.current);
  }, []);

  return isElementVisible;
};
