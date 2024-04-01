import { IBaseDBSchema } from 'schemas/baseSchema';

export type IBlogSchema = IBaseDBSchema<{
  author: {
    name: string;
    bio: string;
    title: string;
  };
  slug: string;
  title: string;
  category: string;
  content: string;
  excerpt: string;
  cover: string;
  id: string;
  meta_title: string;
  meta_description: string;
  video_url: string;
  created_at: string;
}>;
