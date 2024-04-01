import axios from "axios";
import { APP_API_BASE_URL, APP_TOKEN_LOCAL_STORAGE_NAME, APP_LANG_LOCAL_STORAGE_NAME } from "./globals";
import { readFromLocalStorage } from "../helpers/utilities";

const axiosInstance = axios.create({
	baseURL: APP_API_BASE_URL || "",
	headers: {
		Accept: "application/json",
		"Content-Type": "application/json",
		"Access-Control-Allow-Origin": "*",
		"Access-Control-Allow-Credentials": "true",
		"Access-Control-Allow-Methods": "GET,PUT,POST,DELETE,PATCH,OPTIONS",
		"Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept",
	},
});

axiosInstance.interceptors.request.use(
	(config) => {
		const token = readFromLocalStorage(APP_TOKEN_LOCAL_STORAGE_NAME);
		const lang = readFromLocalStorage(APP_LANG_LOCAL_STORAGE_NAME);
		config.headers["Authorization"] = token ? `Bearer ${token}` : null;
		config.headers["Accept-Language"] = lang;
		return config;
	},
	(error) => Promise.reject(error)
);

export default axiosInstance;
