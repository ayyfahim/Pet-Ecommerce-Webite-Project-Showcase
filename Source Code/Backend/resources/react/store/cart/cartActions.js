import * as types from "./cartTypes";

export const changeCart = payload => ({
    type: types.CHANGE_CART,
    payload
});
