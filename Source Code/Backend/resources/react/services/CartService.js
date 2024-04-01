import axios from "../config/axios";
import qs from "qs";

export const baseUrl = "/cart";

class CartService {
    constructor(axios) {
        this.axios = axios;
    }

    listing(query = {}, options = null) {
        return this.axios.get(`${baseUrl}?${qs.stringify(query)}`, options);
    }

    store(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/store`, body, options);
    }

    update(params = {}, body = {}, options = null) {
        return this.axios.patch(`${baseUrl}/update/${params.id}`, body, options);
    }

    delete(params = {}, options = null) {
        return this.axios.delete(`${baseUrl}/destroy/${params.id}`, options);
    }

    clear(options = null) {
        return this.axios.delete(`${baseUrl}/clear`, options);
    }

    move(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/clinic/move`, body, options);
    }

    getShippingMethods(params = {}, options = null) {
        return this.axios.get(`${baseUrl}/shipping_methods/${params?.address_info}`, options);
    }

    setShippingMethods(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/set_shipping_method`, body, options);
    }

    setPaymentMethods(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/set_payment_method`, body, options);
    }

    setAdditional(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/set_additional`, body, options);
    }
}

export default new CartService(axios);
