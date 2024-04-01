export default function getObjectProperties<T = Record<string, unknown>>(data: T, ...keys: (keyof T)[]) {
  if (!data) {
    return data;
  }
  const obj = {} as T;
  // @ts-ignore
  if (data.id) {
    // @ts-ignore
    obj.id = data.id;
  }

  keys.forEach((key) => {
    obj[key] = data[key];
  });

  return obj;
}

export function filterOutEmptyProperties<T = Record<string, unknown>>(data: T) {
  const obj = {} as T;
  // @ts-ignore

  (Object.keys(data) as (keyof typeof data)[]).forEach((key) => {
    if (data[key]) {
      obj[key] = data[key];
    }
  });

  return obj;
}
