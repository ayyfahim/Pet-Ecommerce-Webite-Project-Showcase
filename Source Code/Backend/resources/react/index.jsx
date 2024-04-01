import React from "react";
import ReactDOM from "react-dom";
import "react-app-polyfill/ie11";
import "react-app-polyfill/stable";
import reportWebVitals from "./reportWebVitals";
// Importing application providers.
import { BrowserRouter as RouterProvider } from "react-router-dom";
import { createBrowserHistory } from "history";
import { Provider as ReduxProvider } from "react-redux";
import { ParallaxProvider } from "react-scroll-parallax";
// Importing redux store.
import store from "./store/store";
// Importing application main component.
import App from "./views/App";
// Stylesheet with .SCSS extension
import "./styles/style.scss";
// Creating browser history
const history = createBrowserHistory();
// rendering application
ReactDOM.render(
	<ReduxProvider store={store}>
		<RouterProvider history={history} forceRefresh={false}>
			<ParallaxProvider>
				<App />
			</ParallaxProvider>
		</RouterProvider>
	</ReduxProvider>,
	document.getElementById("root")
);
// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
