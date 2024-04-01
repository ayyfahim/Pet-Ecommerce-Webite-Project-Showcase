import axios from "../config/axios";

export const baseUrl = "/auth";

class AuthService {
	constructor(axios) {
		this.axios = axios;
	}

	register(body = {}, options = null) {
		return this.axios.post(`${baseUrl}/register`, body, options);
	}

	social(body = {}, options = null) {
		return this.axios.post(`${baseUrl}/social`, body, options);
	}

	login(body = {}, options = null) {
		return this.axios.post(`${baseUrl}/login`, body, options);
	}

	logout(body = {}, options = null) {
		return this.axios.post(`${baseUrl}/logout`, body, options);
	}

	me(body = {}, options = null) {
		return this.axios.post(`${baseUrl}/me`, body, options);
	}

	resetPasswordSendEmail(body = {}, options = null) {
		return this.axios.post(`${baseUrl}/password/email`, body, options);
	}

	resetPassword(body = {}, options = null) {
		return this.axios.post(`${baseUrl}/password/reset`, body, options);
	}
}

export default new AuthService(axios);
