import axios from "../config/axios";
import qs from "qs";

export const baseUrl = "/products";

class ProductService {
    constructor(axios) {
        this.axios = axios;
    }

    listing(query = {}, options = null) {
        return this.axios.get(`${baseUrl}?${qs.stringify(query)}`, options);
    }

    single(params = {}, query = {}, options = null) {
        return this.axios.get(`${baseUrl}/${params.slug}?${qs.stringify(query)}`, options);
    }

    variationsPrice(params = {}, query = {}, options = null) {
        return this.axios.get(`${baseUrl}/variations/price/${params.id}?${qs.stringify(query)}`, options);
    }
}

export default new ProductService(axios);
