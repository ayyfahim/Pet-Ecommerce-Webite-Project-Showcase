/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import to from "await-to-js";

import * as actions from "../../store/rootActions";
import HomeService from "../../services/HomeService";

import ProductShowCaseSection from "../sections/ProductShowCaseSection";
import CategoriesSection from "../sections/CategoriesSection";

function IndexPage(props) {
    const { onAddFlashMessage } = props;

    // Component State.
    const [featuredCategoriesState, setFeaturedCategoriesState] = useState([]);
    const [featuredProductsState, setFeaturedProductsState] = useState([]);
    const [hotDealsProductsState, setHotDealsProductsState] = useState([]);
    const [homeLoadingState, setHomeLoadingState] = useState(false);

    // API Calls.
    const fetchHomeData = async () => {
        const [homeDataErrors, homeDataResponse] = await to(HomeService.home());
        if (homeDataErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = homeDataErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setHomeLoadingState(false);
            return;
        }
        const {
            data: { featured_categories, featured_products, hot_deals_products }
        } = homeDataResponse;

        setFeaturedCategoriesState([...featured_categories]);
        setFeaturedProductsState([...featured_products]);
        setHotDealsProductsState([...hot_deals_products]);
        setHomeLoadingState(false);
    };

    // Component Hooks.
    useEffect(() => {
        setHomeLoadingState(true);
        fetchHomeData();
        return () => false;
    }, []);

    return (
        <>
            {homeLoadingState || (!homeLoadingState && hotDealsProductsState?.length) ? (
                <ProductShowCaseSection className="products-showcase-section section bg-light py-5" showExpiryDate products={hotDealsProductsState} isLoading={homeLoadingState} />
            ) : (
                <></>
            )}
            <article className="root-article" id="root-article">
                {homeLoadingState || (!homeLoadingState && featuredCategoriesState?.length) ? <CategoriesSection categories={featuredCategoriesState} isLoading={homeLoadingState} /> : <></>}
                {homeLoadingState || (!homeLoadingState && featuredProductsState?.length) ? (
                    <ProductShowCaseSection
                        title="Trending Now"
                        className="products-showcase-section trending-now-section section bg-white py-5"
                        products={featuredProductsState}
                        isLoading={homeLoadingState}
                        cardLoaderCount={5}
                        clampLines={2}
                        deals={false}
                        productsInViewBreakPoints={{
                            // when window width is >= 1200px  ------ extra large
                            1200: { slidesPerView: 4 }
                        }}
                    />
                ) : (
                    <></>
                )}
            </article>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(IndexPage);
