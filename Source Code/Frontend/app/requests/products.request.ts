import { getRequest } from 'requests/api';
import { IProductSchema } from 'schemas/product.schema';

export async function getAllProducts(categories: Array<String> = [], brands: Array<String> = []) {
  return getRequest<IProductSchema>(`/products?categories=${categories.join(',')}&brands=${brands.join(',')}`);
}
