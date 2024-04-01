import * as types from "./authTypes";
import { APP_TOKEN_LOCAL_STORAGE_NAME, APP_USER_LOCAL_STORAGE_NAME } from "../../config/globals";
import { readFromLocalStorage, addToLocalStorage, removeFromLocalStorage } from "../../helpers/utilities";

const initState = {
	isAuthenticated: !!readFromLocalStorage(APP_TOKEN_LOCAL_STORAGE_NAME),
	user: readFromLocalStorage(APP_USER_LOCAL_STORAGE_NAME) ? readFromLocalStorage(APP_USER_LOCAL_STORAGE_NAME) : {},
};

const reducer = (state = initState, { type, payload }) => {
	switch (type) {
		case types.CHANGE_AUTHENTICATION_STATE:
			return { ...state, isAuthenticated: payload?.isAuthenticated };
		case types.CHANGE_USER_STATE:
			addToLocalStorage(APP_USER_LOCAL_STORAGE_NAME, payload?.user);
			return { ...state, user: payload?.user };
		case types.LOGIN_USER_DATA:
			addToLocalStorage(APP_TOKEN_LOCAL_STORAGE_NAME, payload?.token);
			addToLocalStorage(APP_USER_LOCAL_STORAGE_NAME, payload?.user);
			return { ...state, isAuthenticated: true, user: payload?.user };
		case types.LOGOUT_USER_DATA:
			removeFromLocalStorage(APP_TOKEN_LOCAL_STORAGE_NAME);
			removeFromLocalStorage(APP_USER_LOCAL_STORAGE_NAME);
			return { ...state, isAuthenticated: false, user: {} };
		default:
			return state;
	}
};

export default reducer;
