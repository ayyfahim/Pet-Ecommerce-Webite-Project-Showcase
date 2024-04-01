/* eslint-disable react-hooks/exhaustive-deps */
/* eslint-disable no-unused-expressions */
import React, { useState, useEffect, useRef } from "react";
import { Row, Col, Button, Card } from "react-bootstrap";
import SwiperCore, { Controller, Keyboard, Autoplay, Navigation, Zoom } from "swiper";
import { Swiper, SwiperSlide } from "swiper/react";
import Lightbox from "react-image-lightbox";

import ProductCardBookmark from "../components/ProductCard/ProductCardBookmark";

// install Swiper components
SwiperCore.use([Controller, Keyboard, Autoplay, Navigation, Zoom]);

function SingleProductSlider(props) {
    const { gallery = [], discount } = props;

    // Component State.
    const sliderNextNavigation = useRef(null);
    const sliderPrevNavigation = useRef(null);
    const initialCurrentSlideIndexState = 0;
    const [currentSlideIndexState, setCurrentSlideIndexState] = useState(initialCurrentSlideIndexState);
    const [sliderState, setSliderState] = useState(null);
    const [thumbsState, setThumbsState] = useState(null);
    const [lightBoxIsOpenState, setLightBoxIsOpenState] = useState(false);

    // Slider & Thumbs Configurations
    const sliderOptions = {
        speed: 1000,
        initialSlide: currentSlideIndexState,
        updateOnWindowResize: true,
        slidesPerGroup: 1,
        watchOverflow: true,
        grabCursor: true,
        keyboard: { enabled: true, onlyInViewport: true },
        effect: "fade",
        fadeEffect: {
            crossFade: true
        },
        navigation: {
            nextEl: sliderNextNavigation?.current,
            prevEl: sliderPrevNavigation?.current
        },
        onSwiper: setSliderState,
        onSlideChange: swiper => setCurrentSlideIndexState(swiper.realIndex)
    };
    const thumbsOptions = {
        speed: 1000,
        initialSlide: currentSlideIndexState,
        updateOnWindowResize: true,
        slideToClickedSlide: true,
        spaceBetween: 15,
        touchRatio: 0.2,
        slidesPerGroup: 1,
        grabCursor: true,
        breakpoints: {
            // when window width is >= 0px ------ xs
            0: { slidesPerView: 2 },
            // when window width is >= 576px ------ small
            576: { slidesPerView: 3 },
            // when window width is >= 768px  ------ medium
            768: { slidesPerView: 3 },
            // when window width is >= 992px  ------ large
            992: { slidesPerView: 4 },
            // // when window width is >= 1200px  ------ extra large
            1200: { slidesPerView: 4 }
        },
        onSwiper: setThumbsState,
        onSlideChange: swiper => setCurrentSlideIndexState(swiper.realIndex)
    };

    useEffect(() => {
        sliderState?.slideTo(currentSlideIndexState);
        thumbsState?.slideTo(currentSlideIndexState);
        return () => false;
    }, [currentSlideIndexState]);

    useEffect(() => {
        setCurrentSlideIndexState(initialCurrentSlideIndexState);
        return () => false;
    }, [gallery]);

    return (
        <>
            <Row className="justify-content-center">
                <Col xs={{ span: 12 }}>
                    {lightBoxIsOpenState ? (
                        <>
                            <Lightbox
                                mainSrc={gallery[currentSlideIndexState]?.url}
                                nextSrc={gallery[(currentSlideIndexState + 1) % gallery?.length]?.url}
                                prevSrc={gallery[(currentSlideIndexState + gallery?.length - 1) % gallery?.length]?.url}
                                onCloseRequest={() => setLightBoxIsOpenState(false)}
                                onMovePrevRequest={() => setCurrentSlideIndexState((currentSlideIndexState + gallery?.length - 1) % gallery?.length)}
                                onMoveNextRequest={() => setCurrentSlideIndexState((currentSlideIndexState + 1) % gallery?.length)}
                            />
                        </>
                    ) : (
                        <></>
                    )}
                    <Swiper {...sliderOptions} className="rounded-lg">
                        {gallery?.map((slide, i) => (
                            <SwiperSlide key={i}>
                                <Card className="product-card">
                                    {discount ? <ProductCardBookmark discount={discount} /> : <></>}
                                    <Card.Img
                                        variant="top"
                                        src={slide?.url}
                                        alt={`${slide?.name || ""}`}
                                        className="d-block text-center bg-light rounded-lg"
                                        style={{
                                            height: "fit-content",
                                            width: "100%",
                                            objectFit: "contain",
                                            objectPosition: "center",
                                            minHeight: "250px",
                                            maxHeight: "500px"
                                        }}
                                        onClick={() => setLightBoxIsOpenState(!lightBoxIsOpenState)}
                                    />
                                </Card>
                            </SwiperSlide>
                        ))}
                    </Swiper>
                </Col>
                <Col xs={{ span: 12 }} md={{ span: 11 }} className="py-gutter">
                    <Row className="align-items-center">
                        <Col xs={{ span: 2 }}>
                            <div className="d-flex align-items-center justify-content-end w-100 h-100">
                                <Button ref={sliderPrevNavigation} variant="link" className="p-0 text-decoration-none" disabled={currentSlideIndexState === 0}>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            fillRule="evenodd"
                                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"
                                        />
                                    </svg>
                                    <small className="sr-only">previous</small>
                                </Button>
                            </div>
                        </Col>
                        <Col xs={{ span: 8 }}>
                            <Swiper {...thumbsOptions}>
                                {gallery?.map((slide, i) => (
                                    <SwiperSlide key={i}>
                                        <div
                                            onClick={() => setCurrentSlideIndexState(i)}
                                            className={`bg-light rounded-sm w-100 border ${currentSlideIndexState === i ? "border-primary" : "border-secondary"}`}
                                            style={{ height: "75px" }}
                                        >
                                            <img
                                                src={slide?.url}
                                                alt={`${slide?.name || ""}`}
                                                className="d-block text-center bg-light rounded-sm"
                                                style={{ height: "100%", width: "100%", objectFit: "scale-down", objectPosition: "center" }}
                                            />
                                        </div>
                                    </SwiperSlide>
                                ))}
                            </Swiper>
                        </Col>
                        <Col xs={{ span: 2 }}>
                            <div className="d-flex align-items-center justify-content-start w-100 h-100">
                                <Button ref={sliderNextNavigation} variant="link" className="p-0 text-decoration-none" disabled={currentSlideIndexState === gallery?.length - 1}>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            fillRule="evenodd"
                                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                                        />
                                    </svg>
                                    <small className="sr-only">next</small>
                                </Button>
                            </div>
                        </Col>
                    </Row>
                </Col>
            </Row>
        </>
    );
}

export default SingleProductSlider;
