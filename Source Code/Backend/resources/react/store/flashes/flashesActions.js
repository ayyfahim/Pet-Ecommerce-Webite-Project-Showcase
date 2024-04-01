import * as types from "./flashesTypes";

export const addFlashMessage = (payload) => ({
	type: types.ADD_FLASH_MESSAGE,
	payload,
});

export const removeFlashMessage = (payload) => ({
	type: types.REMOVE_FLASH_MESSAGE,
	payload,
});

export const removeAllFlashMessages = (payload) => ({
	type: types.REMOVE_ALL_FLASH_MESSAGES,
	payload,
});
