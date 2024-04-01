/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect, useMemo } from "react";
import { connect } from "react-redux";
import { Container, Row, Col, Card, Spinner } from "react-bootstrap";
import SwiperCore, { Pagination, Navigation, A11y, Controller, Parallax, EffectFade, Keyboard, Autoplay } from "swiper";
import { Swiper, SwiperSlide } from "swiper/react";
import to from "await-to-js";

import * as actions from "../../store/rootActions";
import ListService from "../../services/ListService";

import ProductCard from "../components/ProductCard/ProductCard";

SwiperCore.use([Pagination, Controller, Parallax, EffectFade, Keyboard, Autoplay, Navigation, A11y]);
function ProductShowCaseSection(props) {
    const {
        title = "",
        titleDirection = "center",
        products = [],
        isLoading = false,
        showExpiryDate,
        className = "",
        productsInViewBreakPoints,
        cardLoaderCount = 3,
        clampLines = 1,
        onAddFlashMessage
    } = props;

    // Component State.
    const initialDisabledActionButtonState = "";
    const initialProductsState = [];
    const [disabledActionButtonState, setDisabledActionButtonState] = useState(initialDisabledActionButtonState);
    const [productsState, setProductsState] = useState(initialProductsState);

    // Swiper Config.
    const swiperConfiguration = useMemo(
        () => ({
            direction: "horizontal",
            speed: 1000,
            loop: false,
            // autoplay: { delay: 10000 },
            watchOverflow: true,
            grabCursor: true,
            keyboard: { enabled: true, onlyInViewport: true },
            pagination: { clickable: true, el: ".swiper-controls .swiper-pagination" },
            updateOnWindowResize: true,
            spaceBetween: Number(
                getComputedStyle(document.documentElement)
                    .getPropertyValue("--grid-gutter-width")
                    .split("px")?.[0] || 0
            ),
            breakpoints: {
                // when window width is >= 0px ------ xs
                0: { slidesPerView: 1 },
                // when window width is >= 576px ------ small
                576: { slidesPerView: 2 },
                // when window width is >= 768px  ------ medium
                768: { slidesPerView: 2 },
                // when window width is >= 992px  ------ large
                992: { slidesPerView: 3 },
                // when window width is >= 1200px  ------ extra large
                1200: { slidesPerView: 3 },
                ...productsInViewBreakPoints
            }
        }),
        []
    );

    // Component Hooks.
    useEffect(() => {
        setProductsState([...products]);
        return () => false;
    }, [products]);

    // Event Handlers
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
            <section className={className}>
                <Container fluid className="px-0">
                    <Row>
                        {title ? (
                            <>
                                <Col xs={{ span: 12 }} className="mb-gutter">
                                    <Container>
                                        <Row>
                                            <Col xs={{ span: 12 }}>
                                                <h2 className={`h3 text-capitalize mb-4 text-${titleDirection}`}>{title}</h2>
                                            </Col>
                                        </Row>
                                    </Container>
                                </Col>
                            </>
                        ) : (
                            <></>
                        )}
                        <Col xs={{ span: 12 }} className="d-none d-md-block">
                            <Swiper {...swiperConfiguration}>
                                {isLoading
                                    ? Array.apply(null, Array(cardLoaderCount))
                                          .map((x, i) => i)
                                          .map((product, i) => (
                                              <SwiperSlide key={i}>
                                                  <Card className="d-flex align-items-center justify-content-center product-card loading">
                                                      <Spinner animation="border" size="sm" variant="primary" />
                                                  </Card>
                                              </SwiperSlide>
                                          ))
                                    : productsState?.map((product, i) => (
                                          <SwiperSlide key={i}>
                                              <ProductCard
                                                  product={product}
                                                  clampLines={clampLines}
                                                  showExpiryDate={showExpiryDate}
                                                  disabledActionButton={disabledActionButtonState}
                                                  wishlistClickHandler={product?.in_wishlist ? onRemoveFromWishlistClickHandler : onAddToWishlistClickHandler}
                                              />
                                          </SwiperSlide>
                                      ))}
                                <div className="swiper-controls swiper-controls--center">
                                    <div className="swiper-pagination"></div>
                                </div>
                            </Swiper>
                        </Col>
                        <Col xs={{ span: 12 }} className="d-md-none">
                            <Row>
                                {isLoading
                                    ? Array.apply(null, Array(cardLoaderCount))
                                          .map((x, i) => i)
                                          .map((product, i) => (
                                              <Col key={i} xs={{ span: 10, offset: 1 }} sm={{ span: 6, offset: 3 }} className="mb-gutter">
                                                  <Card className="d-flex align-items-center justify-content-center product-card loading">
                                                      <Spinner animation="border" size="sm" variant="primary" />
                                                  </Card>
                                              </Col>
                                          ))
                                    : productsState?.map((product, i) => (
                                          <Col key={i} xs={{ span: 10, offset: 1 }} sm={{ span: 6, offset: 3 }} className="mb-gutter">
                                              <ProductCard
                                                  product={product}
                                                  clampLines={clampLines}
                                                  showExpiryDate={showExpiryDate}
                                                  disabledActionButton={disabledActionButtonState}
                                                  wishlistClickHandler={product?.in_wishlist ? onRemoveFromWishlistClickHandler : onAddToWishlistClickHandler}
                                              />
                                          </Col>
                                      ))}
                            </Row>
                        </Col>
                    </Row>
                </Container>
            </section>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(ProductShowCaseSection);
