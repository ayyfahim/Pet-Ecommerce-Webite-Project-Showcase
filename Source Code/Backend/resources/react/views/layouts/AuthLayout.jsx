import React from "react";
import { connect } from "react-redux";
import { Switch, Route, Redirect } from "react-router-dom";

import RootHeader from "../sections/RootHeader";
import NewsLetterSection from "../sections/NewsLetterSection";

function AuthLayout(props) {
    const {
        routes,
        basePath,
        redirectTo,
        auth: { isAuthenticated }
    } = props;

    return (
        <>
            <RootHeader />
            <main className="root-main root-main--auth" id="main-content" role="main">
                <Switch>
                    {routes.map((route, k) => {
                        const { routePath: path, component: Component, pageTitle, isExact, isProtected } = route;
                        return (
                            <Route key={k} path={basePath + path} exact={isExact}>
                                {props =>
                                    !isAuthenticated || (isAuthenticated && !isProtected) ? (
                                        <Component {...props} pageTitle={pageTitle} />
                                    ) : (
                                        <Redirect to="/" />
                                    )
                                }
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

export default connect(mapStateToProps, mapDispatchToProps)(AuthLayout);
