import { getRequest } from 'requests/api';
import { ICategorySchema } from 'schemas/category.schema';
import { ISiteConfigArray, ISiteConfigState } from 'app/atom/siteConfig.atom';

export type ISiteConfig = {
  googleAnalytics: string;
  address: string;
  title: string;
  metaTitle: string;
  facebook: string;
  metaKeywords: string;
  contactNumbers: string;
  facebookPixel: string;
  instagram: string;
  emails: string;
  twitter: string;
  metaDescription: string;
  logo: string;
  googleTagManager: string;
  favicon: string;
  linkedin: string;
};

type IGenericResponse = {
  categories: ICategorySchema[];
  pages: [
    {
      category: 'About';
      pages: [
        {
          slug: 'about';
          title: 'About';
        }
      ];
    },
    {
      category: 'Help & Support';
      pages: [
        {
          slug: 'terms-and-conditions';
          title: 'Terms and Conditions';
        },
        {
          slug: 'privacy-policy';
          title: 'Privacy Policy';
        },
        {
          slug: 'refund-policy';
          title: 'Refund Policy';
        }
      ];
    },
    {
      category: '';
      pages: [
        {
          slug: 'contact-us';
          title: 'Contact Us';
        }
      ];
    }
  ];
  order: {
    shipping_methods: [
      {
        id: 19;
        color: 'Takes 3-5 business days';
        title: 'Standard Shipping';
      },
      {
        id: 20;
        color: 'Takes 1 business days';
        title: 'Express Shipping';
      }
    ];
    payment_methods: [
      {
        id: 18;
        color: null;
        title: 'Online Payment';
      }
    ];
  };
  config: ISiteConfigArray;
};

export function getGenericAppData() {
  return getRequest<ISiteConfigState>(`/global-data`);
}
