/* eslint-disable react-hooks/exhaustive-deps */
import React, { useEffect, useState } from "react";
import { Switch, Route, Redirect, useLocation } from "react-router-dom";
import { connect } from "react-redux";
import to from "await-to-js";

import routes from "../config/routes";
import * as actions from "../store/rootActions";
import HomeService from "../services/HomeService";
import AuthService from "../services/AuthService";
import CategoriesService from "../services/CategoriesService";
import CartService from "../services/CartService";

import MetaTags from "./sections/MetaTags";
import RootFooter from "./sections/RootFooter";

function App(props) {
    const {
        auth: { isAuthenticated, user },
        ui: { breakpointType },
        onAddFlashMessage,
        onChangeGlobals,
        onChangeUserState,
        onLogoutUserData,
        onChangeCategoriesState,
        onChangeBreakpointType,
        onChangeCart,
        onChangeCategoriesMenuState
    } = props;

    const location = useLocation();

    // Component State
    const [isPageLoadingState, setIsPageLoadingState] = useState(true);

    // API Functions.
    const getGlobalData = async () => {
        const [globalDataError, globalDataResponse] = await to(HomeService.globals());
        if (globalDataError) {
            const {
                response: {
                    data: { error, message }
                }
            } = globalDataError;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            return;
        }

        const { data: globals } = globalDataResponse;
        onChangeGlobals(globals);
    };
    const getUserData = async () => {
        const [userDataErrors, userDataResponse] = await to(AuthService.me());
        if (userDataErrors) {
            const {
                response: {
                    data: { error, message, auth }
                }
            } = userDataErrors;

            if (!auth) {
                onLogoutUserData();
                location.push("/");
            }

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            return;
        }

        const {
            data: { data: user }
        } = userDataResponse;
        onChangeUserState({ user });
    };
    const getCategoriesData = async () => {
        const [categoriesErrors, categoriesResponse] = await to(CategoriesService.listing());
        if (categoriesErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = categoriesErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            return false;
        }
        const {
            data: { categories }
        } = categoriesResponse;
        onChangeCategoriesState([...categories]);
    };
    const getCartData = async () => {
        const [cartErrors, cartResponse] = await to(CartService.listing());
        if (cartErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = cartErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            return;
        }

        const {
            data: { cart }
        } = cartResponse;
        onChangeCart({ ...cart });
    };

    // Component Hooks
    useEffect(() => {
        // Scroll to top, when route changes.
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        // Header Scroll Effect.
        let main = document.querySelector(".root-main");
        let header = document.querySelector(".root-header");
        let footer = document.querySelector(".root-footer");
        let lastScrollTop = header?.offsetTop;

        // onScroll function.
        const resizeHeaderOnScroll = () => {
            let doc = document.documentElement;
            let wScroll = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
            let headerHeight = header?.getBoundingClientRect().height || header?.clientHeight || 0;
            let footerHeight = footer?.getBoundingClientRect().height || footer?.clientHeight || 0;
            let headerChangePoint = headerHeight;

            if (main) main.style.paddingTop = `${headerHeight}px`;
            if (main) main.style.minHeight = `calc(100vh - ${footerHeight}px)`;

            if (wScroll > headerChangePoint) {
                if (header) header.classList.add("root-header--scrolling");
                if (wScroll < lastScrollTop || window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
                    if (header) header.classList.remove("root-header--scrolling-down");
                    if (header) header.classList.add("root-header--scrolling-up");
                } else {
                    header.classList.remove("root-header--scrolling-up");
                    header.classList.add("root-header--scrolling-down");
                }
            } else {
                if (header) header.classList.remove("root-header--scrolling", "root-header--scrolling-down", "root-header--scrolling-up");
            }
            lastScrollTop = wScroll;
        };
        resizeHeaderOnScroll();
        window.addEventListener("scroll", resizeHeaderOnScroll);
        window.addEventListener("resize", resizeHeaderOnScroll);
        return () => {
            window.removeEventListener("scroll", resizeHeaderOnScroll);
            window.removeEventListener("resize", resizeHeaderOnScroll);
        };
    }, [location.pathname, user]);

    useEffect(() => {
        if (isAuthenticated) getUserData();
        getGlobalData();
        getCategoriesData();
        getCartData();
        onChangeCategoriesMenuState(false);
        return () => false;
    }, [location.pathname]);

    useEffect(() => {
        if (isPageLoadingState) {
            setIsPageLoadingState(!isPageLoadingState);
            document.body.classList.remove("isPageLoading");
        }
        return () => false;
    }, []);

    useEffect(() => {
        function resizeCategoriesMenuHandler() {
            const breakpoint_lg_width = Number(
                getComputedStyle(document.documentElement)
                    .getPropertyValue("--breakpoint-lg")
                    .split("px")[0]
            );
            const w = window,
                d = document,
                documentElement = d.documentElement,
                body = d.getElementsByTagName("body")[0],
                window_width = w.innerWidth || documentElement.clientWidth || body.clientWidth;

            if (window_width <= breakpoint_lg_width) {
                return onChangeBreakpointType({ breakpointType: "mobile" });
            }
            onChangeBreakpointType({ breakpointType: "web" });
        }

        resizeCategoriesMenuHandler();
        window.addEventListener("resize", resizeCategoriesMenuHandler);
        return () => window.removeEventListener("resize", resizeCategoriesMenuHandler);
    }, []);

    return (
        <>
            <MetaTags />
            <Switch>
                {routes.map((route, k) => {
                    const { layoutPath: path, layout: LayoutComponent, routes: subRoutes, isExact, redirectTo = "/" } = route;
                    return (
                        <Route key={k} path={path} exact={isExact}>
                            {props => <LayoutComponent {...props} routes={subRoutes} basePath={path === "/" ? "" : path} redirectTo={redirectTo} />}
                        </Route>
                    );
                })}
                <Redirect to="/" />
            </Switch>
            <RootFooter />
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload)),
    onChangeGlobals: payload => dispatch(actions.changeGlobals(payload)),
    onChangeUserState: payload => dispatch(actions.changeUserState(payload)),
    onChangeCategoriesState: payload => dispatch(actions.changeCategories(payload)),
    onLogoutUserData: () => dispatch(actions.logoutUserData()),
    onChangeBreakpointType: payload => dispatch(actions.changeBreakpointType(payload)),
    onChangeCart: payload => dispatch(actions.changeCart(payload)),
    onChangeCategoriesMenuState: payload => dispatch(actions.changeCategoriesMenuState(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(App);
