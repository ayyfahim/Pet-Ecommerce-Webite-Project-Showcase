import { combineReducers } from "redux";

import authReducer from "./auth/authReducer";
import flashesReducer from "./flashes/flashesReducer";
import globalsReducer from "./globals/globalsReducer";
import categoriesReducer from "./categories/categoriesReducers";
import cartReducer from "./cart/cartReducer";
import uiReducer from "./ui/uiReducer";

const rootReducer = combineReducers({
    auth: authReducer,
    flashes: flashesReducer,
    globals: globalsReducer,
    categories: categoriesReducer,
    cart: cartReducer,
    ui: uiReducer
});

export default rootReducer;
