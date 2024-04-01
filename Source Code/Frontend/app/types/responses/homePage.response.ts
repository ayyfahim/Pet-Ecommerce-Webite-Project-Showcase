import { IProductSchema } from 'schemas/product.schema';

export type IHomePageResponse = {
  today_deals: [];
  top_selling_products: IProductSchema[];
  featured_products: IProductSchema[];
  most_popular_products: IProductSchema[];
  recent_blogs: IProductSchema[];
};
