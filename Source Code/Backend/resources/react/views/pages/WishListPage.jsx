/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { Container, Row, Col, Spinner } from "react-bootstrap";
import to from "await-to-js";
import qs from "qs";

import ListService from "../../services/ListService";
import * as actions from "../../store/rootActions";

import NoDataSection from "../sections/NoDataSection";
import PaginationSection from "../sections/PaginationSection";
import ProductCard from "../components/ProductCard/ProductCard";

export const WishListPage = props => {
    const {
        pageTitle,
        history: {
            location: { search }
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
    const fetchListData = async () => {
        const [listErrors, listResponse] = await to(ListService.index({ type: "wishlist" }));
        if (listErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = listErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setListLoadingState(false);
            return;
        }

        const {
            data: {
                data: list,
                meta: { pagination }
            }
        } = listResponse;

        setProductsState([...list]);
        setPaginationState({ ...pagination });
        setListLoadingState(false);
    };

    // Component Hooks.
    useEffect(() => {
        setListLoadingState(true);
        fetchListData();
        return () => false;
    }, []);

    // Event Handlers
    const onChangePaginationHandler = (e, page) => setQueryState({ ...queryState, page });
    // Wishlist Events.
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

        setProductsState([...productsState?.filter(product => product?.id !== id)]);
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
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
                                                        disabledActionButton={disabledActionButtonState}
                                                        wishlistClickHandler={onRemoveFromWishlistClickHandler}
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

export default connect(mapStateToProps, mapDispatchToProps)(WishListPage);
