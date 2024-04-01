import React from "react";
import { Switch, Route, Redirect } from "react-router-dom";
import { connect } from "react-redux";

import RootHeader from "../sections/RootHeader";
import NewsLetterSection from "../sections/NewsLetterSection";

function IndexLayout(props) {
    const {
        routes,
        basePath,
        redirectTo,
        auth: { isAuthenticated }
    } = props;

    return (
        <>
            <RootHeader />
            <main className="root-main root-main--index" id="main-content" role="main">
                <Switch>
                    {routes.map((route, k) => {
                        const { routePath: path, component: Component, pageTitle, isExact, isProtected } = route;
                        return (
                            <Route key={k} path={basePath + path} exact={isExact}>
                                {props =>
                                    isAuthenticated || !isProtected ? <Component {...props} pageTitle={pageTitle} /> : <Redirect to="/" />
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

export default connect(mapStateToProps, mapDispatchToProps)(IndexLayout);
