import axios from "../config/axios";

export const baseUrl = "";

class HomeService {
    constructor(axios) {
        this.axios = axios;
    }

    home(options = null) {
        return this.axios.get(`${baseUrl}/home`, options);
    }

    globals(options = null) {
        return this.axios.get(`${baseUrl}/global-data`, options);
    }

    support(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/support`, body, options);
    }
}

export default new HomeService(axios);
