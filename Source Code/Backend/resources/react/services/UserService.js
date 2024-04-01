import axios from "../config/axios";

export const baseUrl = "/user";

class AuthService {
    constructor(axios) {
        this.axios = axios;
    }

    resendEmailVerificationCode(options = null) {
        return this.axios.get(`${baseUrl}/email/resend`, options);
    }

    verifyEmailToken(params = {}, options = null) {
        return this.axios.get(`${baseUrl}/email/verify/${params?.token}`, options);
    }

    resendMobileVerificationCode(body = {}, options = null) {
        return this.axios.patch(`${baseUrl}/mobile/resend`, body, options);
    }

    verifyMobileToken(body = {}, options = null) {
        return this.axios.post(`${baseUrl}/mobile/verify`, body, options);
    }

    userUpdate(params = {}, body = {}, options = null) {
        return this.axios.patch(`${baseUrl}s/update/${params?.id}`, body, options);
    }
}

export default new AuthService(axios);
