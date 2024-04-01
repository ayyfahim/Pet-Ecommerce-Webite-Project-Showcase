import { createStore, applyMiddleware, compose } from "redux";
import logger from "redux-logger";
import rootReducer from "./rootReducer";

const composeEnhancer = (typeof window != "undefined" && window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__) || compose;

const middleware = process.env.NODE_ENV === "development" ? [logger] : [];

const store = createStore(rootReducer, composeEnhancer(applyMiddleware(...middleware)));

export default store;
