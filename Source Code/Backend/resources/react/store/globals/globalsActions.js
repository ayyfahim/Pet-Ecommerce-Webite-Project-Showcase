import * as types from "./globalsTypes";

export const changeGlobals = payload => ({
    type: types.CHANGE_GLOBALS,
    payload
});
