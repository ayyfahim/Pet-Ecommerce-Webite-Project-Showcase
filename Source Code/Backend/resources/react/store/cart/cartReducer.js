import * as types from "./cartTypes";

const initState = {};

const reducer = (state = initState, { type, payload }) => {
    switch (type) {
        case types.CHANGE_CART:
            return { ...state, ...payload };
        default:
            return state;
    }
};

export default reducer;
