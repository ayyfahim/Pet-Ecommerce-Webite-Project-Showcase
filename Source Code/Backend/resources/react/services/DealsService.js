import axios from "../config/axios";
import qs from "qs";

export const baseUrl = "/deals";

class DealsService {
    constructor(axios) {
        this.axios = axios;
    }

    listing(query = {}, options = null) {
        return this.axios.get(`${baseUrl}?${qs.stringify(query)}`, options);
    }
}

export default new DealsService(axios);
