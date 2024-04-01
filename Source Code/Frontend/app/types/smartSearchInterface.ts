
interface IDiscount {
  percentage: number, 
  amount: number
}

 export interface IData {
  cover: string;
  discount?: IDiscount;
  excerpt?: string;
  id?: string;
  in_wishlist?: boolean;
  is_configured?: boolean;
  is_one_option?: boolean;
  regular_price?: number;
  sale_price?: number;
  slug?: string;
  title?: string;
  wishlist_id?: string;
}

export interface ISmartSearch {
  data: IData[],
  meta?: any
}

export interface ISmartSearchBrands {
  id: string,
  name: string,
  badge: string;
}