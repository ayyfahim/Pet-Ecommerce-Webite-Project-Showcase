import shortid from "shortid";
import { findIndex } from "lodash";
import * as types from "./flashesTypes";

const initState = {
    info: [],
    danger: [],
    success: [],
    warning: []
};

const reducer = (state = initState, { type, payload }) => {
    switch (type) {
        case types.REMOVE_ALL_FLASH_MESSAGES:
            return { ...state, ...initState };
        case types.ADD_FLASH_MESSAGE:
            return {
                ...state,
                [payload.type]: [
                    ...state[payload.type],
                    {
                        id: shortid.generate(),
                        message: payload.message,
                        created_at: new Date()
                    }
                ]
            };
        case types.REMOVE_FLASH_MESSAGE:
            let index = findIndex(state[payload.type], {
                ...(payload?.message?.id && { id: payload.message.id }),
                ...(payload?.message?.message && { message: payload.message.message })
            });
            if (index >= 0) {
                return {
                    ...state,
                    [payload.type]: [...state[payload.type].slice(0, index), ...state[payload.type].slice(index + 1)]
                };
            }
            return state;
        default:
            return state;
    }
};

export default reducer;
