import * as types from "./uiTypes";

export const changeBreakpointType = payload => ({
    type: types.CHANGE_BREAKPOINT_TYPE,
    payload
});

export const changeCategoriesMenuState = payload => ({
    type: types.CHANGE_CATEGORIES_MENU_STATE,
    payload
});
