import { IBaseDBSchema } from 'schemas/baseSchema';

export enum USER_TYPE {
  ADMIN = 'admin',
  CUSTOMER = 'customer',
  MANAGER = 'manager',
}

export type IUserSchema = IBaseDBSchema<{
  id: string;
  first_name: string;
  last_name?: string;
  full_name: string;
  country_code?: string;
  mobile?: string;
  email: string;
  role: USER_TYPE;
  status: {
    active: boolean;
    email_verified: boolean;
  };
  addresses: string[];
  total_reward_points: number;
  total_reward_points_exchange: number;
  created_at: string;
}>;
