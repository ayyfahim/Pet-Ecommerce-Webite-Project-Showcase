export type IBaseDBSchema<T> = IUndefinedCanBeNullable<
  T & {
    id: string;
    created_at: Date;
    updated_at: Date;
    deleted_at?: Date;
  }
>;

export type IUndefinedCanBeNullable<T> = {
  [K in keyof T]: Extract<T[K], undefined> extends never ? T[K] : null | T[K];
};
