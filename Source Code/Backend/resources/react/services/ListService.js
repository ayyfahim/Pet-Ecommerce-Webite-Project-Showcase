import axios from "../config/axios";
import qs from "qs";

export const baseUrl = "/lists";

class ListService {
    constructor(axios) {
        this.axios = axios;
    }

    index(params = {}, query = {}, options = null) {
        return this.axios.get(`${baseUrl}/${params.type}?${qs.stringify(query)}`, options);
    }

    store(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/store`, body, options);
    }

    delete(params = {}, options = null) {
        return this.axios.delete(`${baseUrl}/destroy/${params.id}`, options);
    }
}

export default new ListService(axios);
