import { IBaseDBSchema } from 'schemas/baseSchema';

export type ICategorySchema = IBaseDBSchema<{
  name: string;
  slug: string;
  description?: string;
  badge?: {
    img: string;
    alt: string;
  };
  icon?: {
    img: string;
    alt: string;
  };
}>;
