import * as types from "./categoriesTypes";

const initState = [];

const reducer = (state = initState, { type, payload }) => {
    switch (type) {
        case types.CHANGE_CATEGORIES:
            return payload;
        default:
            return state;
    }
};

export default reducer;
