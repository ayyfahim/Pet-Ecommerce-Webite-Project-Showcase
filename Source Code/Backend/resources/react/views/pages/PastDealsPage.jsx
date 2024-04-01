/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { Container, Row, Col, Spinner } from "react-bootstrap";
import to from "await-to-js";
import qs from "qs";

import * as actions from "../../store/rootActions";
import DealsService from "../../services/DealsService";
import ListService from "../../services/ListService";

import NoDataSection from "../sections/NoDataSection";
import PaginationSection from "../sections/PaginationSection";
import ProductCard from "../components/ProductCard/ProductCard";

export const PastDealsPage = props => {
    const {
        pageTitle,
        history: {
            location: { pathname, search },
            push
        },
        onAddFlashMessage
    } = props;
    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    // Component State
    const initialQueryState = { ...queryParams };
    const initialProductsState = [];
    const initialListLoadingState = false;
    const initialPaginationState = {};
    const initialDisabledActionButtonState = "";
    const [productsState, setProductsState] = useState(initialProductsState);
    const [queryState, setQueryState] = useState(initialQueryState);
    const [listLoadingState, setListLoadingState] = useState(initialListLoadingState);
    const [paginationState, setPaginationState] = useState(initialPaginationState);
    const [disabledActionButtonState, setDisabledActionButtonState] = useState(initialDisabledActionButtonState);

    // API Calls.
    const fetchPastDealsProducts = async query => {
        const [productsErrors, productsResponse] = await to(DealsService.listing(query));
        if (productsErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = productsErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setListLoadingState(false);
            return;
        }

        const {
            data: {
                data: products,
                meta: { pagination }
            }
        } = productsResponse;

        setProductsState([...products]);
        setPaginationState({ ...pagination });
        setListLoadingState(false);
    };

    // Component Hooks.
    useEffect(() => {
        setListLoadingState(true);
        fetchPastDealsProducts(queryState);
        return () => false;
    }, [search]);

    useEffect(() => {
        push({ pathname, search: `?${qs.stringify(queryState)}` });
        return () => false;
    }, [queryState]);

    // Event Handlers
    const onChangePaginationHandler = (e, page) => setQueryState({ ...queryState, page });
    // Wishlist Events
    const onAddToWishlistClickHandler = async (e, { id, ...product }) => {
        setDisabledActionButtonState(id);
        const [listStoreErrors, listStoreResponse] = await to(ListService.store({ type: "wishlist", product_id: id }));
        if (listStoreErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = listStoreErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setDisabledActionButtonState(initialDisabledActionButtonState);
            return;
        }

        const {
            data: {
                data: { id: wishlist_id },
                message
            }
        } = listStoreResponse;

        setProductsState([...productsState?.map(product => (product?.id === id ? { ...product, in_wishlist: true, wishlist_id } : product))]);
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
    };
    const onRemoveFromWishlistClickHandler = async (e, { id, wishlist_id, ...product }) => {
        setDisabledActionButtonState(id);
        const [listDeleteErrors, listDeleteResponse] = await to(ListService.delete({ id: wishlist_id }));
        if (listDeleteErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = listDeleteErrors;

            if (message || error)
                onAddFlashMessage({
                    type: "danger",
                    message: message || error
                });
            setDisabledActionButtonState(initialDisabledActionButtonState);
            return;
        }

        const {
            data: { message }
        } = listDeleteResponse;

        setProductsState([
            ...productsState?.map(product =>
                product?.id === id
                    ? {
                          ...product,
                          in_wishlist: false,
                          wishlist_id: ""
                      }
                    : product
            )
        ]);
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({
            type: "success",
            message
        });
    };

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <h1 className="h3 font-weight-bold text-capitalize mb-0">{pageTitle}</h1>
                        </Col>
                        <Col xs={{ span: 12 }} className="mt-4">
                            <Row>
                                <Col xs={{ span: 12 }}>
                                    {listLoadingState ? (
                                        <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                            <Spinner animation="border" variant="primary" />
                                        </Col>
                                    ) : productsState?.length ? (
                                        <Row className="row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
                                            {productsState?.map(product => (
                                                <Col key={product?.id} className="mb-gutter">
                                                    <ProductCard
                                                        product={product}
                                                        clampLines={2}
                                                        deals={false}
                                                        expiredDeal={true}
                                                        disabledActionButton={disabledActionButtonState}
                                                        wishlistClickHandler={product?.in_wishlist ? onRemoveFromWishlistClickHandler : onAddToWishlistClickHandler}
                                                    />
                                                </Col>
                                            ))}
                                        </Row>
                                    ) : (
                                        <NoDataSection />
                                    )}
                                </Col>
                                {productsState?.length && paginationState?.total_pages > 1 && !listLoadingState ? (
                                    <Col xs={{ span: 12 }} className="mt-gutter">
                                        <PaginationSection paginatingData={paginationState} onClickHandler={onChangePaginationHandler} />
                                    </Col>
                                ) : (
                                    <></>
                                )}
                            </Row>
                        </Col>
                    </Row>
                </Container>
            </section>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(PastDealsPage);
