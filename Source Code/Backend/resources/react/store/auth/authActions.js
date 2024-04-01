import * as types from "./authTypes";

export const changeAuthenticationState = (payload) => ({
	type: types.CHANGE_AUTHENTICATION_STATE,
	payload,
});

export const changeUserState = (payload) => ({
	type: types.CHANGE_USER_STATE,
	payload,
});

export const loginUserData = (payload) => ({
	type: types.LOGIN_USER_DATA,
	payload,
});

export const logoutUserData = (payload) => ({
	type: types.LOGOUT_USER_DATA,
	payload,
});
