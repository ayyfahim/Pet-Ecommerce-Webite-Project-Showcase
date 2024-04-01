import { IProductSchema } from 'schemas/product.schema';

export type ICartSchema = {
  id: string;
  product: IProductSchema;
  quantity: number;
  options?: string[];
};
