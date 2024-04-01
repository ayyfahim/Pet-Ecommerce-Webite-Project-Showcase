export type IFilter = Record<string, string | number | boolean | string[] | number[] | boolean[]>;


export type IPaginator<S = IFilter> = Omit<
  Partial<S & IFilter>,
  'search' | 'sortBy' | 'sortOrder' | 'page' | 'limit' | 'excludes'
  > & {
  search: string;
  sortBy: string;
  sortOrder: 'ASC' | 'DESC';
  page: number;
  limit: number;
  excludes?: string[];
};

const x = {} as unknown as IPaginator;
x.page.currency()
