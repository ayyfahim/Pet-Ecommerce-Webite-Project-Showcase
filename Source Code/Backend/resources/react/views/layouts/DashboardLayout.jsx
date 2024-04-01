import React from "react";
import { Switch, Route, Redirect } from "react-router-dom";
import { connect } from "react-redux";

import RootHeader from "../sections/RootHeader";
import NewsLetterSection from "../sections/NewsLetterSection";

function DashboardLayout(props) {
    const {
        routes,
        basePath,
        redirectTo,
        auth: { isAuthenticated }
    } = props;

    return (
        <>
            <RootHeader />
            <main className="root-main root-main--dashboard" id="main-content" role="main">
                <Switch>
                    {routes.map((route, k) => {
                        const { routePath: path, component: Component, pageTitle, isExact, isProtected } = route;
                        return (
                            <Route key={k} path={basePath + path} exact={isExact}>
                                {props => {
                                    if (isAuthenticated || !isProtected) {
                                        return <Component {...props} pageTitle={pageTitle} />;
                                    } else {
                                        return <Redirect to="/login" />;
                                    }
                                }}
                            </Route>
                        );
                    })}
                    <Redirect to={redirectTo} />
                </Switch>
                <NewsLetterSection />
            </main>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(DashboardLayout);
