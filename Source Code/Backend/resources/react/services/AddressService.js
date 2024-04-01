import axios from "../config/axios";

export const baseUrl = "/address";

class AddressService {
	constructor(axios) {
		this.axios = axios;
	}

	store(body = {}, options = null) {
		return this.axios.post(`${baseUrl}`, body, options);
	}

	update(params = {}, body = {}, options = null) {
		return this.axios.patch(`${baseUrl}/update/${params?.id}`, body, options);
	}
}

export default new AddressService(axios);
