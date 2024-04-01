import * as types from "./uiTypes";

const initState = {
    breakpointType: "web",
    isCategoriesMenuOpen: false
};

const reducer = (state = initState, { type, payload }) => {
    switch (type) {
        case types.CHANGE_CATEGORIES_MENU_STATE:
            return { ...state, isCategoriesMenuOpen: payload };
        case types.CHANGE_BREAKPOINT_TYPE:
            return { ...state, breakpointType: payload?.breakpointType };
        default:
            return state;
    }
};

export default reducer;
