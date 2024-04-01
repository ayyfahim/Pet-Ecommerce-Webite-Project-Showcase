import * as types from "./categoriesTypes";

export const changeCategories = payload => ({
    type: types.CHANGE_CATEGORIES,
    payload
});
