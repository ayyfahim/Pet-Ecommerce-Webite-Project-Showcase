import axios from "../config/axios";

export const baseUrl = "/reviews";

class ReviewsService {
    constructor(axios) {
        this.axios = axios;
    }

    store(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/store`, body, options);
    }

    update(body = {}, params = {}, options = null) {
        return this.axios.patch(`${baseUrl}/update/${params?.id}`, body, options);
    }
}

export default new ReviewsService(axios);
