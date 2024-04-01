import * as types from "./globalsTypes";

const initState = {};

const reducer = (state = initState, { type, payload }) => {
    switch (type) {
        case types.CHANGE_GLOBALS:
            return { ...state, ...payload };
        default:
            return state;
    }
};

export default reducer;
