import { IBaseDBSchema } from 'schemas/baseSchema';

export type IProductSchema = IBaseDBSchema<{
  slug: string;
  title: string;
  excerpt: string;
  regular_price: number;
  sale_price: number;
  deal: [];
  discount?: {
    percentage: number | false;
    amount: false;
  };
  icons: [];
  cover: string;
  is_configured: boolean;
  is_one_option: boolean;
  in_wishlist: boolean;
  wishlist_id?: string;
  product_info_id: string;
  quantity: number;
  description: string;
  sku: string;
  delivery_information: string;
  warranty_information: string;
  faq: { question: string; answer: string }[];
  video_url?: string;
  brand: {
    name: string;
    badge: string;
  };
  configurations: {
    label: string;
    type: string;
    options: {
      id: string;
      value: string;
      color_name: string;
    }[];
  }[];
  gallery: {
    data: {
      id: number;
      name: string;
      url: string;
    }[];
  };
}>;
