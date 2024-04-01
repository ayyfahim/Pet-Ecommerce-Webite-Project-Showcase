import { useCallback, useState } from 'react';
import useIsMounted from 'hooks/useIsMounted';

// type IRequests = Pick<typeof axios, 'put' | 'patch' | 'delete' | 'post' | 'get'>;
//
// export type IRequestType = keyof IRequests;

export default function usePromise<TFunction = CallableFunction>(request: TFunction) {
  const [isPending, setIsPending] = useState(false);
  const [hasCompletedOnce, setHasCompletedOnce] = useState(false);
  const isMounted = useIsMounted();

  const callApi = useCallback((...args: unknown[]) => {
    setIsPending(true);
    return (request as unknown as CallableFunction)(...args).finally(() => {
      isMounted && setIsPending(false);
      isMounted && setHasCompletedOnce(true);
    });
  }, []);

  return {
    isPending,
    hasCompletedOnce,
    callApi: callApi as unknown as TFunction,
  };
}
