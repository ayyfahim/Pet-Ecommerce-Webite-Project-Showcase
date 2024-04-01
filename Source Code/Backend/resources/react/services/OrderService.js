import axios from "../config/axios";
import qs from "qs";

export const baseUrl = "/orders";

class OrderService {
    constructor(axios) {
        this.axios = axios;
    }

    listing(query = {}, options = null) {
        return this.axios.get(`${baseUrl}?${qs.stringify(query)}`, options);
    }

    store(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/store`, body, options);
    }

    single(params = {}, options = null) {
        return this.axios.get(`${baseUrl}/${params?.id}`, options);
    }
}

export default new OrderService(axios);
