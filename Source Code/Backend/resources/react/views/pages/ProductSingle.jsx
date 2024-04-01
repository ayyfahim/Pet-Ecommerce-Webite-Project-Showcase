/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect, useContext, Fragment } from "react";
import { connect } from "react-redux";
import { Container, Row, Col, Form, FormControl, Button, InputGroup, Collapse, Tab, Nav, Spinner, Accordion, useAccordionToggle, AccordionContext, OverlayTrigger, Tooltip } from "react-bootstrap";
import ReactStars from "react-rating-stars-component";
import { useFormik } from "formik";
import { object, string } from "yup";
import to from "await-to-js";
import { isEmpty, flattenDeep } from "lodash";
import decodeHtml from "decode-html";
import qs from "qs";

import ProductService from "../../services/ProductService";
import ListService from "../../services/ListService";
import CartService from "../../services/CartService";
import * as actions from "../../store/rootActions";
import { expiryDateRemaining } from "../../helpers/utilities";

import StopWatch from "../../assets/images/icons/stopwatch.png";
import MetaTags from "../sections/MetaTags";
import SingleProductSlider from "../sections/SingleProductSlider";
import ProductShowCaseSection from "../sections/ProductShowCaseSection";

function ContextAwareToggle({ children, eventKey, callback }) {
    const currentEventKey = useContext(AccordionContext);
    const decoratedOnClick = useAccordionToggle(eventKey, () => callback && callback(eventKey));
    const isCurrentEventKey = currentEventKey === eventKey;

    return (
        <>
            <p className={`text-capitalize mb-0 d-flex align-items-center justify-content-between ${isCurrentEventKey ? "text-primary" : "text-dark"}`}>
                {children}
                <Button variant="link" className="stretched-link p-0" onClick={decoratedOnClick}>
                    {isCurrentEventKey ? <i className="mdi mdi-minus mdi-20px text-dark" aria-hidden="true"></i> : <i className="mdi mdi-plus mdi-20px" aria-hidden="true"></i>}
                </Button>
            </p>
        </>
    );
}

function ProductSingle(props) {
    const {
        pageTitle,
        match: { params },
        history: { push },
        ui: { breakpointType },
        onAddFlashMessage,
        onChangeCart,
        globals,
        cart
    } = props;

    // Component State.
    const initialProductState = {};
    const initialExpiryDateState = {};
    const initialCartState = {};
    const initialRecentlyViewedState = [];
    const initialRelatedProductsState = [];
    const initialConfigurationsValuesState = {};
    const initialProductTitleOptionsState = [];
    const initialDisabledActionButtonState = "";
    const initialShippingAddressCollapseState = false;
    const initialExpandAllState = true;
    const initialProductQuantityState = 1;
    const initialDefaultShippingAddressFormValueState = { shipping_method_id: undefined, zone_id: "" };
    const [productTitleOptionsState, setProductTitleOptionsState] = useState(initialProductTitleOptionsState);
    const [disabledActionButtonState, setDisabledActionButtonState] = useState(initialDisabledActionButtonState);
    const [shippingAddressCollapseState, setShippingAddressCollapseState] = useState(initialShippingAddressCollapseState);
    const [productLoadingState, setProductLoadingState] = useState(false);
    const [productState, setProductState] = useState(initialProductState);
    const [cartState, setCartState] = useState(initialCartState);
    const [configurationsValuesState, setConfigurationsValuesState] = useState(initialConfigurationsValuesState);
    const [expandAllState, setExpandAllState] = useState(initialExpandAllState);
    const [productQuantityState, setProductQuantityState] = useState(initialProductQuantityState);
    const [recentlyViewedState, setRecentlyViewedState] = useState(initialRecentlyViewedState);
    const [relatedProductsState, setRelatedProductsState] = useState(initialRelatedProductsState);
    const [expiryDateState, setExpiryDateState] = useState(initialExpiryDateState);
    const [defaultShippingAddressFormValueState, setDefaultShippingAddressFormValueState] = useState(initialDefaultShippingAddressFormValueState);
    const shippingAddressFormik = useFormik({
        validateOnBlur: false,
        enableReinitialize: true,
        initialValues: { ...defaultShippingAddressFormValueState },
        validationSchema: object().shape({ shipping_method_id: string().required("shipping method field is required."), zone_id: string() }),
        onSubmit: async (values, { setSubmitting, setErrors }) => {
            const [setShippingMethodErrors, setShippingMethodResponse] = await to(CartService.setShippingMethods(values));
            if (setShippingMethodErrors) {
                const {
                    response: {
                        data: { errors }
                    }
                } = setShippingMethodErrors;

                setErrors(errors);
                setSubmitting(false);
                return;
            }

            const {
                data: {
                    data: {
                        cart: { shipping_method_id, ...cart }
                    }
                },
                message
            } = setShippingMethodResponse;

            setCartState({ ...(shipping_method_id && { shipping_method_id }), ...cart });
            onChangeCart({ ...(shipping_method_id && { shipping_method_id }), ...cart });
            if (message) onAddFlashMessage({ type: "success", message });
            setSubmitting(false);
        }
    });

    // API Calls.
    const fetchProductData = async () => {
        const [productDataErrors, productDataResponse] = await to(ProductService.single(params));
        if (productDataErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = productDataErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setProductLoadingState(false);
            return;
        }

        let {
            data: { product, recently_viewed, related_products }
        } = productDataResponse;

        const configurationsValues = Object.assign(
            {},
            ...product?.configurations
                ?.filter(configuration => configuration?.options?.length === 1)
                ?.map(configuration => ({
                    [`options[${product?.configurations?.findIndex(item => item?.label === configuration?.label)}]`]: configuration?.options[0]?.id
                }))
        );

        setProductState({ ...product });
        setConfigurationsValuesState({ ...configurationsValues });
        setRecentlyViewedState([...recently_viewed]);
        setRelatedProductsState([...related_products]);
        setProductLoadingState(false);
        setShippingAddressCollapseState(initialShippingAddressCollapseState);
        setExpandAllState(initialExpandAllState);
    };
    const fetchConfigurationData = async () => {
        const [configurationErrors, configurationResponse] = await to(ProductService.variationsPrice({ id: productState?.id }, configurationsValuesState));
        if (configurationErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = configurationErrors;
            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setDisabledActionButtonState(initialDisabledActionButtonState);
            return;
        }
        const {
            data: {
                data: { price, cover }
            }
        } = configurationResponse;

        const configurationIds = Object.values(configurationsValuesState).filter(Boolean);
        const productConfigurationsVariant = productState?.configurations.filter(variant => variant?.options?.some(option => configurationIds.includes(option.id)));
        const productConfigurationsVariantOptions = productConfigurationsVariant.map(variant => variant.options.filter(option => configurationIds.includes(option.id)));
        const productConfigurationsVariantOptionsNames = productConfigurationsVariantOptions.map(options => options.map(option => option?.color_name || option.value));

        setDisabledActionButtonState(initialDisabledActionButtonState);
        setProductState({
            ...productState,
            ...(productState?.sale_price ? { sale_price: price } : { regular_price: price }),
            ...(cover && { cover })
        });
        setProductTitleOptionsState([...productConfigurationsVariantOptionsNames]);
    };

    // Component Hooks
    useEffect(() => {
        setProductTitleOptionsState([...initialProductTitleOptionsState]);
        setProductLoadingState(true);
        fetchProductData();
        return () => false;
    }, [params?.slug]);

    useEffect(() => {
        if (!isEmpty(configurationsValuesState)) fetchConfigurationData();
        return () => false;
    }, [configurationsValuesState]);

    useEffect(() => {
        if (productState?.cover)
            setProductState({
                ...productState,
                gallery: {
                    data: [{ url: productState?.cover }, ...productState?.gallery?.data?.filter(item => item?.id)]
                }
            });
        return () => false;
    }, [productState?.cover]);

    useEffect(() => {
        let interval;
        if (productState?.deal?.expiry_date)
            interval = setInterval(() => setExpiryDateState(prevState => ({ ...prevState, ...expiryDateRemaining(new Date(productState.deal.expiry_date).getTime()) })), 1000);
        return () => (productState?.deal?.expiry_date ? clearInterval(interval) : false);
    }, [productState.deal]);

    useEffect(() => {
        if (breakpointType === "mobile") setShippingAddressCollapseState(false);

        // onScroll function.
        const resizeFooterOnScroll = () => {
            let footer = document.querySelector(".root-footer");
            let fixedActionButtons = document.querySelector("#fixed-bottom-actions");
            let fixedActionButtonsHeight = fixedActionButtons?.getBoundingClientRect().height || fixedActionButtons?.clientHeight || 0;
            footer.style.setProperty("padding-bottom", `${fixedActionButtonsHeight}px`, "important");
        };

        resizeFooterOnScroll();
        window.addEventListener("scroll", resizeFooterOnScroll);
        window.addEventListener("resize", resizeFooterOnScroll);

        return () => {
            window.removeEventListener("scroll", resizeFooterOnScroll);
            window.removeEventListener("resize", resizeFooterOnScroll);
        };
    }, [breakpointType]);

    useEffect(() => {
        setShippingAddressCollapseState(cart?.shipping_method_id);
        setDefaultShippingAddressFormValueState({ ...defaultShippingAddressFormValueState, ...(cart?.shipping_method_id && { shipping_method_id: cart.shipping_method_id }) });
        return () => false;
    }, [cart]);

    // Event Handlers.
    const configurationsChangeHandler = async e => {
        setDisabledActionButtonState(productState?.id);
        setConfigurationsValuesState({ ...configurationsValuesState, [e.target.name]: e.target.value });
    };
    // Wishlist handlers
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

        setProductState({ ...productState, in_wishlist: true, wishlist_id });
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

        setProductState({ ...productState, in_wishlist: false, wishlist_id: "" });
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
    };
    // Cart handlers
    const addToCartClickHandler = async (e, { id, ...product }, cb) => {
        setDisabledActionButtonState(id);
        const [cartErrors, cartResponse] = await to(
            CartService.store(
                qs.parse(
                    qs.stringify({
                        product_id: id,
                        quantity: productQuantityState,
                        ...configurationsValuesState
                    })
                )
            )
        );

        if (cartErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = cartErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setDisabledActionButtonState(initialDisabledActionButtonState);
            return;
        }

        const {
            data: {
                message,
                data: { cart }
            }
        } = cartResponse;

        onChangeCart({ ...cart });
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
        if (cb && typeof cb === "function") return cb();
    };

    return (
        <>
            <MetaTags
                pageTitle={!productTitleOptionsState?.length ? productState?.title : flattenDeep([productState?.title, ...productTitleOptionsState]).join(" - ") || pageTitle}
                title={productState?.seo?.meta_title || productState?.title}
                description={productState?.seo?.meta_description || productState?.description}
                keywords={productState?.seo?.meta_keywords}
                cover={productState?.cover}
            />
            <section className="section bg-white py-5">
                <Container>
                    <Row>
                        {productLoadingState ? (
                            <>
                                <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                    <Spinner animation="border" variant="primary" />
                                </Col>
                            </>
                        ) : (
                            <>
                                <Col xs={{ span: 12 }} className="d-none d-lg-block" id="product-single-desktop-content">
                                    <Row>
                                        <Col xs={{ span: 12 }} lg={{ span: 6 }} className="mb-gutter mb-lg-0">
                                            <Row>
                                                <Col xs={{ span: 12 }}>
                                                    <SingleProductSlider gallery={productState?.gallery?.data} discount={productState?.discount?.amount} />
                                                </Col>
                                                {productState?.icons?.length ? (
                                                    <Col xs={{ span: 12 }} className="mt-3 mb-4 d-flex justify-content-center">
                                                        <ul className="list-inline list-unstyled d-flex w-100 justify-content-center">
                                                            {productState.icons?.map((icon, i) => (
                                                                <li className="list-inline-item flex-fill" key={icon?.badge} style={{ maxWidth: "80px" }}>
                                                                    {icon?.helper ? (
                                                                        <>
                                                                            <OverlayTrigger placement="top" overlay={<Tooltip id={`icon-${icon?.badge}`}>{icon?.helper}</Tooltip>}>
                                                                                <div className="d-flex flex-column justify-content-center text-center">
                                                                                    <span
                                                                                        className="mb-2 mx-auto"
                                                                                        style={{
                                                                                            width: "60px",
                                                                                            height: "60px"
                                                                                        }}
                                                                                    >
                                                                                        <img
                                                                                            src={icon?.badge}
                                                                                            alt=""
                                                                                            role="presentation"
                                                                                            style={{
                                                                                                objectFit: "scale-down",
                                                                                                objectPosition: "center",
                                                                                                width: "100%",
                                                                                                height: "100%"
                                                                                            }}
                                                                                        />
                                                                                    </span>
                                                                                    <span className="text-capitalize small" style={{ fontSize: "14px" }}>
                                                                                        {icon?.label}
                                                                                    </span>
                                                                                </div>
                                                                            </OverlayTrigger>
                                                                        </>
                                                                    ) : (
                                                                        <>
                                                                            <div className="d-flex flex-column justify-content-center text-center">
                                                                                <span
                                                                                    className="mb-2 mx-auto"
                                                                                    style={{
                                                                                        width: "60px",
                                                                                        height: "60px"
                                                                                    }}
                                                                                >
                                                                                    <img
                                                                                        src={icon?.badge}
                                                                                        alt=""
                                                                                        role="presentation"
                                                                                        style={{
                                                                                            objectFit: "scale-down",
                                                                                            objectPosition: "center",
                                                                                            width: "100%",
                                                                                            height: "100%"
                                                                                        }}
                                                                                    />
                                                                                </span>
                                                                                <span className="text-capitalize small" style={{ fontSize: "14px" }}>
                                                                                    {icon?.label}
                                                                                </span>
                                                                            </div>
                                                                        </>
                                                                    )}
                                                                </li>
                                                            ))}
                                                        </ul>
                                                    </Col>
                                                ) : (
                                                    <></>
                                                )}
                                                <Col xs={{ span: 12 }} className="mt-3">
                                                    <Row>
                                                        <Col xs={{ span: 12 }}>
                                                            <Nav as="nav" variant="tabs">
                                                                {productState?.description ? (
                                                                    <Nav.Link href="#product-description" className="white-space-nowrap">
                                                                        <small>Product Description</small>
                                                                    </Nav.Link>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                                {productState?.vide ? (
                                                                    <Nav.Link href="#product-video" className="white-space-nowrap">
                                                                        <small>Product Video</small>
                                                                    </Nav.Link>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                                {productState?.faq ? (
                                                                    <Nav.Link href="#faqs" className="white-space-nowrap">
                                                                        <small>FAQs</small>
                                                                    </Nav.Link>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                                {productState?.delivery_information ? (
                                                                    <Nav.Link href="#delivery-info" className="white-space-nowrap">
                                                                        <small>Delivery Info</small>
                                                                    </Nav.Link>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                                {productState?.warranty_information ? (
                                                                    <Nav.Link href="#warranty-guarantee" className="white-space-nowrap">
                                                                        <small>Warranty & Guarantee</small>
                                                                    </Nav.Link>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                            </Nav>
                                                        </Col>
                                                        <Col xs={{ span: 12 }}>
                                                            <Row>
                                                                {productState?.description ? (
                                                                    <Col xs={{ span: 12 }}>
                                                                        <section id="product-description" className="py-4">
                                                                            <Row>
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <h4 className="mb-0 text-capitalize">Product Description</h4>
                                                                                </Col>
                                                                                <Col xs={{ span: 12 }} className="mt-3">
                                                                                    <p
                                                                                        dangerouslySetInnerHTML={{
                                                                                            __html: decodeHtml(productState.description.trim().toString())
                                                                                        }}
                                                                                    />
                                                                                </Col>
                                                                            </Row>
                                                                        </section>
                                                                    </Col>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                                {productState?.video ? (
                                                                    <>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <hr />
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <section id="product-video" className="py-4">
                                                                                <Row>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <h4 className="mb-0 text-capitalize">Product video</h4>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                                                        <iframe
                                                                                            src={productState.video}
                                                                                            title="product video"
                                                                                            frameborder="0"
                                                                                            style={{
                                                                                                height: "100px",
                                                                                                width: "100%",
                                                                                                objectFit: "none"
                                                                                            }}
                                                                                        ></iframe>
                                                                                    </Col>
                                                                                </Row>
                                                                            </section>
                                                                        </Col>
                                                                    </>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                                {productState?.faq ? (
                                                                    <>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <hr />
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <section id="faqs" className="py-4">
                                                                                <Row>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <h4 className="mb-0 text-capitalize d-flex align-items-center">
                                                                                            <span className="border-right pr-3 mr-3">FAQs</span>
                                                                                            <Button
                                                                                                variant="link"
                                                                                                className="text-capitalize text-decoration-underline p-0"
                                                                                                onClick={() => setExpandAllState(!expandAllState)}
                                                                                            >
                                                                                                {`${expandAllState ? "unExpand" : "expand"} all`}
                                                                                            </Button>
                                                                                        </h4>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                                                        {expandAllState ? (
                                                                                            <>
                                                                                                {productState.faq?.map((faq, i) => (
                                                                                                    <Accordion defaultActiveKey={i + 1} key={faq?.question}>
                                                                                                        <Row
                                                                                                            className={`pt-3 ${productState.faq.length - 1 > i ? "pb-3 border-bottom" : ""}`}
                                                                                                            noGutters
                                                                                                        >
                                                                                                            <Col
                                                                                                                xs={{
                                                                                                                    span: 12
                                                                                                                }}
                                                                                                            >
                                                                                                                <ContextAwareToggle eventKey={i + 1}>
                                                                                                                    <span className="font-weight-bold">{faq?.question}</span>
                                                                                                                </ContextAwareToggle>
                                                                                                            </Col>
                                                                                                            <Col
                                                                                                                xs={{
                                                                                                                    span: 12
                                                                                                                }}
                                                                                                            >
                                                                                                                <Accordion.Collapse eventKey={i + 1}>
                                                                                                                    <div className="py-3">
                                                                                                                        <p className="mb-0">{faq?.answer}</p>
                                                                                                                    </div>
                                                                                                                </Accordion.Collapse>
                                                                                                            </Col>
                                                                                                        </Row>
                                                                                                    </Accordion>
                                                                                                ))}
                                                                                            </>
                                                                                        ) : (
                                                                                            <>
                                                                                                <Accordion>
                                                                                                    {productState.faq?.map((faq, i) => (
                                                                                                        <Row
                                                                                                            className={`pt-3 ${productState.faq.length - 1 > i ? "pb-3 border-bottom" : ""}`}
                                                                                                            key={faq?.question}
                                                                                                            noGutters
                                                                                                        >
                                                                                                            <Col
                                                                                                                xs={{
                                                                                                                    span: 12
                                                                                                                }}
                                                                                                            >
                                                                                                                <ContextAwareToggle eventKey={i + 1}>
                                                                                                                    <span className="font-weight-bold">{faq?.question}</span>
                                                                                                                </ContextAwareToggle>
                                                                                                            </Col>
                                                                                                            <Col
                                                                                                                xs={{
                                                                                                                    span: 12
                                                                                                                }}
                                                                                                            >
                                                                                                                <Accordion.Collapse eventKey={i + 1}>
                                                                                                                    <div className="py-3">
                                                                                                                        <p className="mb-0">{faq?.answer}</p>
                                                                                                                    </div>
                                                                                                                </Accordion.Collapse>
                                                                                                            </Col>
                                                                                                        </Row>
                                                                                                    ))}
                                                                                                </Accordion>
                                                                                            </>
                                                                                        )}
                                                                                    </Col>
                                                                                </Row>
                                                                            </section>
                                                                        </Col>
                                                                    </>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                                {productState?.delivery_information ? (
                                                                    <>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <hr />
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <section id="delivery-info" className="py-4">
                                                                                <Row>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <h4 className="mb-0 text-capitalize">Delivery Info</h4>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                                                        <p
                                                                                            dangerouslySetInnerHTML={{
                                                                                                __html: decodeHtml(productState.delivery_information.trim().toString())
                                                                                            }}
                                                                                        />
                                                                                    </Col>
                                                                                </Row>
                                                                            </section>
                                                                        </Col>
                                                                    </>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                                {productState?.warranty_information ? (
                                                                    <>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <hr />
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <section id="warranty-guarantee" className="py-4">
                                                                                <Row>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <h4 className="mb-0 text-capitalize">Warranty & Guarantee</h4>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                                                        <p
                                                                                            dangerouslySetInnerHTML={{
                                                                                                __html: decodeHtml(productState.warranty_information.trim().toString())
                                                                                            }}
                                                                                        />
                                                                                    </Col>
                                                                                </Row>
                                                                            </section>
                                                                        </Col>
                                                                    </>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                            </Row>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                            </Row>
                                        </Col>
                                        <Col xs={{ span: 12 }} lg={{ span: 6 }} xl={{ span: 5, offset: 1 }}>
                                            <section>
                                                <Row>
                                                    <Col xs={{ span: 12 }}>
                                                        <Row>
                                                            <Col xs={{ span: 12 }} className="mb-3">
                                                                <Row noGutters>
                                                                    <Col xs>
                                                                        <h1 className="h3">
                                                                            {!productTitleOptionsState?.length
                                                                                ? productState?.title
                                                                                : flattenDeep([productState?.title, ...productTitleOptionsState]).join(", ")}
                                                                        </h1>
                                                                        {productState?.excerpt ? (
                                                                            <p
                                                                                className="text-secondary m-0"
                                                                                dangerouslySetInnerHTML={{
                                                                                    __html: decodeHtml(productState.excerpt.trim().toString())
                                                                                }}
                                                                            />
                                                                        ) : (
                                                                            <></>
                                                                        )}
                                                                    </Col>
                                                                    <Col xs={{ span: 4 }}>
                                                                        <Row>
                                                                            <Col xs={{ span: 12 }}>
                                                                                <p className="text-right text-capitalize mb-0">
                                                                                    {productState?.sale_price ? (
                                                                                        <>
                                                                                            <del>{productState?.regular_price ? `$${productState?.regular_price}` : 0}</del>
                                                                                            <br />
                                                                                        </>
                                                                                    ) : (
                                                                                        <></>
                                                                                    )}
                                                                                    <strong className="h3 text-primary-dark mb-0">
                                                                                        {productState?.sale_price ? `$${productState?.sale_price}` : `$${productState?.regular_price}`}
                                                                                    </strong>
                                                                                    <br />
                                                                                    <small>our price</small>
                                                                                    <br />
                                                                                    <span className="small">
                                                                                        <small className="text-secondary">excluded shipping cost</small>
                                                                                    </span>
                                                                                </p>
                                                                            </Col>
                                                                            <Col xs={{ span: 12 }} className="d-flex flex-column align-items-end">
                                                                                <ReactStars
                                                                                    name=""
                                                                                    edit={false}
                                                                                    isHalf={true}
                                                                                    size={24}
                                                                                    value={4.5}
                                                                                    activeColor="#fa9014"
                                                                                    color="#cccccc"
                                                                                    halfIcon={<i className="fa fa-star-half" />}
                                                                                    emptyIcon={<i className="fa fa-star" />}
                                                                                    fullIcon={<i className="fa fa-star" />}
                                                                                />
                                                                            </Col>
                                                                        </Row>
                                                                    </Col>
                                                                </Row>
                                                            </Col>
                                                            {productState?.deal?.expiry_date ? (
                                                                <>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <Row>
                                                                            <Col xs={{ span: 12 }}>
                                                                                <div className="d-flex align-items-center my-2">
                                                                                    <span className="w-100">
                                                                                        <hr />
                                                                                    </span>
                                                                                    <span className="px-3">
                                                                                        <img src={StopWatch} alt="" role="presentation" />
                                                                                    </span>
                                                                                    <span className="w-100">
                                                                                        <hr />
                                                                                    </span>
                                                                                </div>
                                                                            </Col>
                                                                            <Col xs={{ span: 12 }}>
                                                                                <Row>
                                                                                    <Col xs={{ span: 10, offset: 1 }}>
                                                                                        <Row className="align-items-center" noGutters>
                                                                                            <Col xs={{ span: "auto" }}>
                                                                                                <p className="text-primary mb-0 font-weight-bold text-capitalize small">Next Deal in:</p>
                                                                                            </Col>
                                                                                            <Col xs>
                                                                                                <ul className="list-inline mb-0 text-right">
                                                                                                    {Object.keys(expiryDateState).map((key, i) => (
                                                                                                        <Fragment key={key}>
                                                                                                            <li className="list-inline-item font-weight-bold text-dark" key={key}>
                                                                                                                <span className="mr-1">{`0${expiryDateState?.[key]}`.slice(-2) || "00"}</span>
                                                                                                                <span className="text-secondary text-uppercase font-weight-bold small">{key}</span>
                                                                                                            </li>
                                                                                                            {i < Object.keys(expiryDateState)?.length - 1 ? (
                                                                                                                <li className="list-inline-item font-weight-bold">
                                                                                                                    <span className="text-secondary font-weight-bold small">:</span>
                                                                                                                </li>
                                                                                                            ) : (
                                                                                                                <></>
                                                                                                            )}
                                                                                                        </Fragment>
                                                                                                    ))}
                                                                                                </ul>
                                                                                            </Col>
                                                                                        </Row>
                                                                                    </Col>
                                                                                </Row>
                                                                            </Col>
                                                                        </Row>
                                                                    </Col>
                                                                </>
                                                            ) : (
                                                                <></>
                                                            )}
                                                        </Row>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <hr className="my-4" />
                                                    </Col>
                                                    {productState?.configurations?.filter(config => config?.type === "text")?.length ? (
                                                        <>
                                                            <Col xs={{ span: 12 }} sm={{ span: 8 }}>
                                                                <Row>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <h2 className="h6 text-capitalize">Variants</h2>
                                                                    </Col>
                                                                    {productState?.configurations
                                                                        ?.filter(config => config?.type === "text")
                                                                        ?.slice(0, 1)
                                                                        ?.map((configuration, i) => (
                                                                            <Col xs={{ span: 12 }} key={i} className={i >= 1 ? "mt-3" : null}>
                                                                                <Form.Group controlId={`variantsInput${i}`} className="mb-0">
                                                                                    <Form.Control
                                                                                        name={`options[0]`}
                                                                                        as="select"
                                                                                        size="sm"
                                                                                        className="mt-0 text-truncate overflow-hidden rounded-lg"
                                                                                        onChange={configurationsChangeHandler}
                                                                                        disabled={disabledActionButtonState === productState?.id}
                                                                                        value={configurationsValuesState[`options[0]`] || ""}
                                                                                        custom
                                                                                    >
                                                                                        <option value="" disabled={configuration?.options?.length <= 1}>
                                                                                            -select {configuration?.label}-
                                                                                        </option>
                                                                                        {configuration?.options?.map((configuration_option, i) => (
                                                                                            <option value={configuration_option?.id} key={configuration_option?.id}>
                                                                                                {configuration_option?.value}
                                                                                            </option>
                                                                                        ))}
                                                                                    </Form.Control>
                                                                                </Form.Group>
                                                                            </Col>
                                                                        ))}
                                                                </Row>
                                                            </Col>
                                                        </>
                                                    ) : (
                                                        <></>
                                                    )}
                                                    <Col xs={{ span: 12 }} sm={{ span: 4 }} className="mt-3 mt-sm-0">
                                                        <Row className="justify-content-end">
                                                            <Col xs={{ span: 12 }}>
                                                                <h2
                                                                    className={`h6 text-capitalize ${
                                                                        productState?.configurations?.filter(config => config?.type === "text")?.length ? "text-sm-right" : ""
                                                                    }`}
                                                                >
                                                                    Quantity
                                                                </h2>
                                                            </Col>
                                                            <Col xs={{ span: 12 }}>
                                                                <InputGroup size="sm">
                                                                    <InputGroup.Prepend>
                                                                        <Button
                                                                            variant="outline-primary"
                                                                            className="rounded-left-lg py-0 shadow-none"
                                                                            disabled={disabledActionButtonState === productState?.id}
                                                                            onClick={e => productQuantityState > 1 && setProductQuantityState(productQuantityState - 1)}
                                                                        >
                                                                            <i className="mdi mdi-minus mdi-20px" aria-hidden="true"></i>
                                                                            <span className="sr-only">decrement quantity</span>
                                                                        </Button>
                                                                    </InputGroup.Prepend>
                                                                    <FormControl
                                                                        type="number"
                                                                        className="text-center border-primary shadow-none"
                                                                        value={productQuantityState}
                                                                        disabled={disabledActionButtonState === productState?.id}
                                                                        onChange={e => Number(e.target.value) && setProductQuantityState(Number(e.target.value))}
                                                                        min={1}
                                                                    />
                                                                    <InputGroup.Append>
                                                                        <Button
                                                                            variant="outline-primary"
                                                                            className="rounded-right-lg py-0 shadow-none"
                                                                            disabled={disabledActionButtonState === productState?.id}
                                                                            onClick={e => setProductQuantityState(productQuantityState + 1)}
                                                                        >
                                                                            <i className="mdi mdi-plus mdi-20px" aria-hidden="true"></i>
                                                                            <span className="sr-only">increment quantity</span>
                                                                        </Button>
                                                                    </InputGroup.Append>
                                                                </InputGroup>
                                                            </Col>
                                                        </Row>
                                                    </Col>
                                                    {productState?.configurations?.filter(config => config?.type === "color")?.length ? (
                                                        <Col xs={{ span: 12 }} className="mt-3">
                                                            <Row>
                                                                {productState?.configurations
                                                                    ?.filter(config => config?.type === "color")
                                                                    ?.map((configuration, i) => (
                                                                        <Col xs={{ span: 12 }} key={i} className={i >= 1 ? "mt-3" : null}>
                                                                            <Row className="align-items-center">
                                                                                <Col xs={{ span: 6 }} md={{ span: 4 }}>
                                                                                    <h2 className="h6 text-capitalize mb-0">Choose {configuration?.label}</h2>
                                                                                </Col>
                                                                                <Col xs={{ span: 6 }} md={{ span: 8 }}>
                                                                                    <div className="d-flex align-items-center justify-content-end">
                                                                                        {configuration?.options?.map((configuration_option, i) => (
                                                                                            <Form.Check
                                                                                                key={configuration_option?.id}
                                                                                                id={`color-option-${i}`}
                                                                                                className="mb-0 color-radio"
                                                                                                type="radio"
                                                                                                inline
                                                                                                custom
                                                                                            >
                                                                                                <style
                                                                                                    dangerouslySetInnerHTML={{
                                                                                                        __html: [
                                                                                                            `[for='color-option-${i}']:after { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%23${
                                                                                                                configuration_option?.value?.split("#")?.[1]
                                                                                                            }'/%3E%3C/svg%3E") !important }`
                                                                                                        ]
                                                                                                    }}
                                                                                                ></style>
                                                                                                <Form.Check.Input
                                                                                                    name="options[1]"
                                                                                                    type="radio"
                                                                                                    value={configuration_option?.id}
                                                                                                    onChange={configurationsChangeHandler}
                                                                                                    disabled={disabledActionButtonState === productState?.id}
                                                                                                    checked={configurationsValuesState?.[`options[1]`] === configuration_option?.id}
                                                                                                />
                                                                                                <Form.Check.Label
                                                                                                    style={{
                                                                                                        color: configuration_option?.value
                                                                                                    }}
                                                                                                ></Form.Check.Label>
                                                                                            </Form.Check>
                                                                                        ))}
                                                                                    </div>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                    ))}
                                                            </Row>
                                                        </Col>
                                                    ) : (
                                                        <></>
                                                    )}
                                                    {productState?.configurations?.filter(config => config?.type === "text")?.slice(1)?.length ? (
                                                        <Col xs={{ span: 12 }} className="mt-3">
                                                            <Row>
                                                                {productState?.configurations
                                                                    ?.filter(config => config?.type === "text")
                                                                    ?.slice(1)
                                                                    ?.map((configuration, i) => (
                                                                        <Col xs={{ span: 12 }} key={i} className={i >= 1 ? "mt-3" : null}>
                                                                            <Row className="align-items-center">
                                                                                <Col xs={{ span: 12 }} md={{ span: 3 }}>
                                                                                    <strong className="text-dark mb-0">{configuration?.label}</strong>
                                                                                </Col>
                                                                                <Col xs={{ span: 12 }} md={{ span: 9 }}>
                                                                                    <Form.Group controlId={`variantsInput${i}`} className="mb-0">
                                                                                        <Form.Control
                                                                                            name={`options[${i + 2}]`}
                                                                                            as="select"
                                                                                            size="sm"
                                                                                            className="mt-0 text-truncate overflow-hidden rounded-lg"
                                                                                            custom
                                                                                            onChange={configurationsChangeHandler}
                                                                                            disabled={disabledActionButtonState === productState?.id}
                                                                                            value={configurationsValuesState[`options[${i + 2}]`] || ""}
                                                                                        >
                                                                                            <option value="" disabled={configuration?.options?.length <= 1}>
                                                                                                -select {configuration?.label}-
                                                                                            </option>
                                                                                            {configuration?.options?.map((configuration_option, i) => (
                                                                                                <option value={configuration_option?.id} key={configuration_option?.id}>
                                                                                                    {configuration_option?.value}
                                                                                                </option>
                                                                                            ))}
                                                                                        </Form.Control>
                                                                                    </Form.Group>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                    ))}
                                                            </Row>
                                                        </Col>
                                                    ) : (
                                                        <></>
                                                    )}
                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                        <Row>
                                                            <Col xs={{ span: 12 }}>
                                                                <h2 className="h6 text-capitalize mb-0 d-flex align-items-center justify-content-between">
                                                                    <span>Shipping Cost Calculator</span>
                                                                    <Button
                                                                        variant="link"
                                                                        className="stretched-link p-0"
                                                                        onClick={() => setShippingAddressCollapseState(!shippingAddressCollapseState)}
                                                                        aria-controls="shipping-address-collapse"
                                                                        aria-expanded={shippingAddressCollapseState}
                                                                    >
                                                                        {shippingAddressCollapseState ? (
                                                                            <i className="mdi mdi-chevron-up mdi-28px text-dark" aria-hidden="true"></i>
                                                                        ) : (
                                                                            <i className="mdi mdi-chevron-down mdi-28px text-dark" aria-hidden="true"></i>
                                                                        )}
                                                                    </Button>
                                                                </h2>
                                                            </Col>
                                                            <Collapse in={shippingAddressCollapseState}>
                                                                <Col xs={{ span: 12 }} className="mt-3">
                                                                    <div className="bg-light rounded-lg p-5" id="shipping-address-collapse">
                                                                        <Form onSubmit={shippingAddressFormik.handleSubmit} noValidate>
                                                                            <Form.Row>
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <Form.Group controlId="shippingAddressCalculatorAddress">
                                                                                        <Form.Label className="text-capitalize ">shipping address</Form.Label>
                                                                                        <InputGroup
                                                                                            className="m-0 flex-row-reverse rounded-lg bg-white border border-input"
                                                                                            style={{
                                                                                                overflow: "hidden"
                                                                                            }}
                                                                                        >
                                                                                            <FormControl
                                                                                                onChange={shippingAddressFormik.handleChange}
                                                                                                value={shippingAddressFormik?.values?.zone_id}
                                                                                                name="zone_id"
                                                                                                type="text"
                                                                                                className="rounded-0 border-0 pl-0"
                                                                                                placeholder="Enter your shipping address"
                                                                                                autoComplete="street-address"
                                                                                            />
                                                                                            <InputGroup.Prepend>
                                                                                                <InputGroup.Text className="border-0 rounded-0 bg-transparent py-0 px-2">
                                                                                                    <i className="mdi mdi-map-marker mdi-24px text-primary" aria-hidden="true"></i>
                                                                                                </InputGroup.Text>
                                                                                            </InputGroup.Prepend>
                                                                                        </InputGroup>
                                                                                    </Form.Group>
                                                                                </Col>
                                                                                {globals?.order?.shipping_methods?.length ? (
                                                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                                                        <Form.Group>
                                                                                            <Form.Row>
                                                                                                <Col xs={{ span: 12 }}>
                                                                                                    <Form.Label className="text-capitalize ">Preferred shipping method</Form.Label>
                                                                                                </Col>
                                                                                                {globals?.order?.shipping_methods?.map((method, i) => (
                                                                                                    <Col xs={{ span: 6 }} key={method?.id}>
                                                                                                        <Form.Check type="radio" custom id={`shippingAddressCalculatorMethod${method?.id}`}>
                                                                                                            <Form.Check.Input
                                                                                                                name="shipping_method_id"
                                                                                                                type="radio"
                                                                                                                value={method?.id}
                                                                                                                onChange={shippingAddressFormik.handleChange}
                                                                                                                checked={Number(shippingAddressFormik?.values?.shipping_method_id) === method?.id}
                                                                                                                isInvalid={
                                                                                                                    !!shippingAddressFormik?.touched?.shipping_method_id &&
                                                                                                                    !!shippingAddressFormik?.errors?.shipping_method_id
                                                                                                                }
                                                                                                                isValid={
                                                                                                                    shippingAddressFormik?.values?.shipping_method_id &&
                                                                                                                    !!shippingAddressFormik?.touched?.shipping_method_id &&
                                                                                                                    !!!shippingAddressFormik?.errors?.shipping_method_id
                                                                                                                }
                                                                                                            />
                                                                                                            <Form.Check.Label className="text-capitalize font-weight-bold small">
                                                                                                                <span className="text-dark">{method?.title}</span>
                                                                                                                {method?.color ? (
                                                                                                                    <>
                                                                                                                        <br />
                                                                                                                        <span className="small text-dark">
                                                                                                                            <small>{method.color}</small>
                                                                                                                        </span>
                                                                                                                    </>
                                                                                                                ) : (
                                                                                                                    <></>
                                                                                                                )}
                                                                                                            </Form.Check.Label>
                                                                                                            {!!shippingAddressFormik?.touched?.shipping_method_id &&
                                                                                                                !!shippingAddressFormik?.errors?.shipping_method_id && (
                                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                                        {shippingAddressFormik.errors.shipping_method_id}
                                                                                                                    </Form.Control.Feedback>
                                                                                                                )}
                                                                                                        </Form.Check>
                                                                                                    </Col>
                                                                                                ))}
                                                                                            </Form.Row>
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                ) : (
                                                                                    <></>
                                                                                )}
                                                                                <Col xs={{ span: 12 }} className="mt-3">
                                                                                    <Button
                                                                                        variant="outline-primary"
                                                                                        type="submit"
                                                                                        block
                                                                                        className="text-capitalize rounded-lg"
                                                                                        disabled={!shippingAddressFormik.isValid}
                                                                                    >
                                                                                        {shippingAddressFormik.isSubmitting ? <Spinner animation="border" size="sm" /> : "calculate shipping cost"}
                                                                                    </Button>
                                                                                </Col>
                                                                            </Form.Row>
                                                                        </Form>
                                                                    </div>
                                                                </Col>
                                                            </Collapse>
                                                        </Row>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <hr className="my-4" />
                                                    </Col>
                                                    <Col xs={{ span: 12 }} className="mb-3">
                                                        <Row>
                                                            <Col xs={{ span: 12 }} className="mb-3">
                                                                <Row className="align-items-center">
                                                                    <Col xs={{ span: 9 }}>
                                                                        <p className="m-0 text-right">
                                                                            <strong className="text-dark d-block text-capitalize">product price</strong>
                                                                        </p>
                                                                    </Col>
                                                                    <Col xs={{ span: 3 }}>
                                                                        <p className="m-0 text-right h5 text-primary-dark">${productState?.regular_price}</p>
                                                                    </Col>
                                                                </Row>
                                                            </Col>
                                                            <Col xs={{ span: 12 }} className="mb-3">
                                                                <Row className="align-items-center">
                                                                    <Col xs={{ span: 9 }}>
                                                                        <p className="m-0 text-right">
                                                                            <strong className="text-dark d-block text-capitalize">shipping cost</strong>
                                                                            <small className="d-block">Please enter your shipping address or login to calculate the shipping cost.</small>
                                                                        </p>
                                                                    </Col>
                                                                    <Col xs={{ span: 3 }}>
                                                                        <p className="m-0 text-right h5 text-primary-dark">$0</p>
                                                                    </Col>
                                                                </Row>
                                                            </Col>
                                                            <Col xs={{ span: 12 }} className="mb-3">
                                                                <Row className="align-items-center">
                                                                    <Col xs={{ span: 9 }}>
                                                                        <p className="m-0 text-right">
                                                                            <strong className="text-dark d-block text-capitalize">total cost</strong>
                                                                        </p>
                                                                    </Col>
                                                                    <Col xs={{ span: 3 }}>
                                                                        <p className="m-0 text-right h5 text-primary-dark">${productState?.regular_price}</p>
                                                                    </Col>
                                                                </Row>
                                                            </Col>
                                                        </Row>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Row className="align-items-stretch">
                                                            <Col xs={{ span: 2 }} className="px-2">
                                                                <Button
                                                                    variant="outline-primary"
                                                                    size="sm"
                                                                    className="text-capitalize rounded-lg d-flex align-items-center justify-content-center h-100"
                                                                    disabled={disabledActionButtonState === productState?.id}
                                                                    onClick={e =>
                                                                        productState?.in_wishlist ? onRemoveFromWishlistClickHandler(e, productState) : onAddToWishlistClickHandler(e, productState)
                                                                    }
                                                                    block
                                                                >
                                                                    <i className={`mdi mdi-heart${!productState?.in_wishlist ? "-outline" : ""} mdi-26px`} aria-hidden="true"></i>
                                                                </Button>
                                                            </Col>
                                                            <Col xs={{ span: 6 }} className="px-2">
                                                                <Button
                                                                    variant="outline-primary"
                                                                    size="sm"
                                                                    className="text-capitalize rounded-lg px-1 h-100"
                                                                    disabled={disabledActionButtonState === productState?.id}
                                                                    onClick={e => addToCartClickHandler(e, productState)}
                                                                    block
                                                                >
                                                                    Add to cart
                                                                    <br />
                                                                    <small style={{ fontSize: "70%" }}>Choose this option to keep shopping</small>
                                                                </Button>
                                                            </Col>
                                                            <Col xs={{ span: 4 }} className="px-2">
                                                                <Button
                                                                    variant="orange"
                                                                    size="sm"
                                                                    className="text-capitalize rounded-lg h-100"
                                                                    disabled={disabledActionButtonState === productState?.id}
                                                                    onClick={e =>
                                                                        cart?.shipping_method_id && cart?.items?.filter(item => item?.id === productState?.id)?.length
                                                                            ? push("/shipping")
                                                                            : addToCartClickHandler(e, productState, () => {
                                                                                  setShippingAddressCollapseState(true);
                                                                                  shippingAddressFormik.submitForm();
                                                                                  push("/shipping");
                                                                              })
                                                                    }
                                                                    block
                                                                >
                                                                    buy now
                                                                </Button>
                                                            </Col>
                                                        </Row>
                                                    </Col>
                                                </Row>
                                            </section>
                                        </Col>
                                    </Row>
                                </Col>
                                <Col xs={{ span: 12 }} className="d-lg-none" id="product-single-mobile-content">
                                    <Row>
                                        <Col xs={{ span: 12 }} className="mb-3">
                                            <h1 className="h3 text-center">
                                                {!productTitleOptionsState?.length ? productState?.title : flattenDeep([productState?.title, ...productTitleOptionsState]).join(", ")}
                                            </h1>
                                            {productState?.excerpt ? (
                                                <p
                                                    className="text-secondary m-0 text-center"
                                                    dangerouslySetInnerHTML={{
                                                        __html: decodeHtml(productState.excerpt.trim().toString())
                                                    }}
                                                />
                                            ) : (
                                                <></>
                                            )}
                                        </Col>
                                        <Col xs={{ span: 12 }}>
                                            <SingleProductSlider gallery={productState?.gallery?.data} discount={productState?.discount?.amount} />
                                        </Col>
                                        {productState?.icons?.length ? (
                                            <Col xs={{ span: 12 }} className="mt-3 d-flex justify-content-center">
                                                <ul className="list-inline list-unstyled d-flex w-100 justify-content-center">
                                                    {productState.icons?.map((icon, i) => (
                                                        <li className="list-inline-item flex-fill" key={icon?.badge} style={{ maxWidth: "80px" }}>
                                                            {icon?.helper ? (
                                                                <>
                                                                    <OverlayTrigger placement="top" overlay={<Tooltip id={`icon-${icon?.badge}`}>{icon?.helper}</Tooltip>}>
                                                                        <div className="d-flex flex-column justify-content-center text-center">
                                                                            <span
                                                                                className="mb-2 mx-auto"
                                                                                style={{
                                                                                    width: "60px",
                                                                                    height: "60px"
                                                                                }}
                                                                            >
                                                                                <img
                                                                                    src={icon?.badge}
                                                                                    alt=""
                                                                                    role="presentation"
                                                                                    style={{
                                                                                        objectFit: "scale-down",
                                                                                        objectPosition: "center",
                                                                                        width: "100%",
                                                                                        height: "100%"
                                                                                    }}
                                                                                />
                                                                            </span>
                                                                            <span className="text-capitalize small" style={{ fontSize: "14px" }}>
                                                                                {icon?.label}
                                                                            </span>
                                                                        </div>
                                                                    </OverlayTrigger>
                                                                </>
                                                            ) : (
                                                                <>
                                                                    <div className="d-flex flex-column justify-content-center text-center">
                                                                        <span
                                                                            className="mb-2 mx-auto"
                                                                            style={{
                                                                                width: "60px",
                                                                                height: "60px"
                                                                            }}
                                                                        >
                                                                            <img
                                                                                src={icon?.badge}
                                                                                alt=""
                                                                                role="presentation"
                                                                                style={{
                                                                                    objectFit: "scale-down",
                                                                                    objectPosition: "center",
                                                                                    width: "100%",
                                                                                    height: "100%"
                                                                                }}
                                                                            />
                                                                        </span>
                                                                        <span className="text-capitalize small" style={{ fontSize: "14px" }}>
                                                                            {icon?.label}
                                                                        </span>
                                                                    </div>
                                                                </>
                                                            )}
                                                        </li>
                                                    ))}
                                                </ul>
                                            </Col>
                                        ) : (
                                            <></>
                                        )}
                                        <Col xs={{ span: 12 }} className="mt-4">
                                            <Row>
                                                <Col xs={{ span: 12 }}>
                                                    <p className="text-center text-capitalize mb-0">
                                                        {productState?.sale_price ? (
                                                            <>
                                                                <del>{productState?.regular_price ? `$${productState?.regular_price}` : 0}</del>
                                                                <br />
                                                            </>
                                                        ) : (
                                                            <></>
                                                        )}
                                                        <strong className="h3 text-primary-dark mb-0">
                                                            {productState?.sale_price ? `$${productState?.sale_price}` : `$${productState?.regular_price}`}
                                                        </strong>
                                                        <br />
                                                        <small>our price</small>
                                                        <br />
                                                        <span className="small">
                                                            <small className="text-secondary">excluded shipping cost</small>
                                                        </span>
                                                    </p>
                                                </Col>
                                                <Col xs={{ span: 12 }} className="d-flex flex-column align-items-center mt-4">
                                                    <ReactStars
                                                        name=""
                                                        edit={false}
                                                        isHalf={true}
                                                        size={24}
                                                        value={4.5}
                                                        activeColor="#fa9014"
                                                        color="#cccccc"
                                                        halfIcon={<i className="fa fa-star-half" />}
                                                        emptyIcon={<i className="fa fa-star" />}
                                                        fullIcon={<i className="fa fa-star" />}
                                                    />
                                                </Col>
                                            </Row>
                                        </Col>
                                        {productState?.deal?.expiry_date ? (
                                            <>
                                                <Col xs={{ span: 12 }}>
                                                    <Row>
                                                        <Col xs={{ span: 12 }}>
                                                            <div className="d-flex align-items-center my-2">
                                                                <span className="w-100">
                                                                    <hr />
                                                                </span>
                                                                <span className="px-3">
                                                                    <img src={StopWatch} alt="" role="presentation" />
                                                                </span>
                                                                <span className="w-100">
                                                                    <hr />
                                                                </span>
                                                            </div>
                                                        </Col>
                                                        <Col xs={{ span: 12 }}>
                                                            <Row>
                                                                <Col xs={{ span: 10, offset: 1 }}>
                                                                    <Row className="align-items-center" noGutters>
                                                                        <Col xs={{ span: "auto" }}>
                                                                            <p className="text-primary mb-0 font-weight-bold text-capitalize small">Next Deal in:</p>
                                                                        </Col>
                                                                        <Col xs>
                                                                            <ul className="list-inline mb-0 text-right">
                                                                                {Object.keys(expiryDateState).map((key, i) => (
                                                                                    <Fragment key={key}>
                                                                                        <li className="list-inline-item font-weight-bold text-dark" key={key}>
                                                                                            <span className="mr-1">{`0${expiryDateState?.[key]}`.slice(-2) || "00"}</span>
                                                                                            <span className="text-secondary text-uppercase font-weight-bold small">{key}</span>
                                                                                        </li>
                                                                                        {i < Object.keys(expiryDateState)?.length - 1 ? (
                                                                                            <li className="list-inline-item font-weight-bold">
                                                                                                <span className="text-secondary font-weight-bold small">:</span>
                                                                                            </li>
                                                                                        ) : (
                                                                                            <></>
                                                                                        )}
                                                                                    </Fragment>
                                                                                ))}
                                                                            </ul>
                                                                        </Col>
                                                                    </Row>
                                                                </Col>
                                                            </Row>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                            </>
                                        ) : (
                                            <></>
                                        )}
                                        <Col xs={{ span: 12 }}>
                                            <hr className="my-4" />
                                        </Col>
                                        {productState?.configurations?.filter(config => config?.type === "text")?.length ? (
                                            <>
                                                <Col xs={{ span: 6 }} sm={{ span: 8 }}>
                                                    <Row>
                                                        <Col xs={{ span: 12 }}>
                                                            <h2 className="h6 text-capitalize">Variants</h2>
                                                        </Col>
                                                        {productState?.configurations
                                                            ?.filter(config => config?.type === "text")
                                                            ?.slice(0, 1)
                                                            ?.map((configuration, i) => (
                                                                <Col xs={{ span: 12 }} key={i} className={i >= 1 ? "mt-3" : null}>
                                                                    <Form.Group controlId={`variantsInput${i}`} className="mb-0">
                                                                        <Form.Control
                                                                            name={`options[0]`}
                                                                            as="select"
                                                                            size="sm"
                                                                            className="mt-0 text-truncate overflow-hidden rounded-lg"
                                                                            onChange={configurationsChangeHandler}
                                                                            disabled={disabledActionButtonState === productState?.id}
                                                                            value={configurationsValuesState[`options[0]`] || ""}
                                                                            custom
                                                                        >
                                                                            <option value="" disabled={configuration?.options?.length <= 1}>
                                                                                -select {configuration?.label}-
                                                                            </option>
                                                                            {configuration?.options?.map((configuration_option, i) => (
                                                                                <option value={configuration_option?.id} key={configuration_option?.id}>
                                                                                    {configuration_option?.value}
                                                                                </option>
                                                                            ))}
                                                                        </Form.Control>
                                                                    </Form.Group>
                                                                </Col>
                                                            ))}
                                                    </Row>
                                                </Col>
                                            </>
                                        ) : (
                                            <></>
                                        )}
                                        <Col xs={{ span: 6 }} sm={{ span: 4 }} className="mt-lg-3 mt-0">
                                            <Row className="justify-content-end">
                                                <Col xs={{ span: 12 }}>
                                                    <h2 className={`h6 text-capitalize ${productState?.configurations?.filter(config => config?.type === "text")?.length ? "text-right" : ""}`}>
                                                        Quantity
                                                    </h2>
                                                </Col>
                                                <Col xs={{ span: 12 }}>
                                                    <InputGroup size="sm">
                                                        <InputGroup.Prepend>
                                                            <Button
                                                                variant="outline-primary"
                                                                className="rounded-left-lg py-0 shadow-none"
                                                                disabled={disabledActionButtonState === productState?.id}
                                                                onClick={e => productQuantityState > 1 && setProductQuantityState(productQuantityState - 1)}
                                                            >
                                                                <i className="mdi mdi-minus mdi-20px" aria-hidden="true"></i>
                                                            </Button>
                                                        </InputGroup.Prepend>
                                                        <FormControl
                                                            type="number"
                                                            className="text-center border-primary shadow-none"
                                                            value={productQuantityState}
                                                            disabled={disabledActionButtonState === productState?.id}
                                                            onChange={e => Number(e.target.value) && setProductQuantityState(Number(e.target.value))}
                                                            min={1}
                                                        />
                                                        <InputGroup.Append>
                                                            <Button
                                                                variant="outline-primary"
                                                                className="rounded-right-lg py-0 shadow-none"
                                                                disabled={disabledActionButtonState === productState?.id}
                                                                onClick={e => setProductQuantityState(productQuantityState + 1)}
                                                            >
                                                                <i className="mdi mdi-plus mdi-20px" aria-hidden="true"></i>
                                                            </Button>
                                                        </InputGroup.Append>
                                                    </InputGroup>
                                                </Col>
                                            </Row>
                                        </Col>
                                        {productState?.configurations?.filter(config => config?.type === "color")?.length ? (
                                            <Col xs={{ span: 12 }} className="mt-3">
                                                <Row>
                                                    {productState?.configurations
                                                        ?.filter(config => config?.type === "color")
                                                        ?.map((configuration, i) => (
                                                            <Col xs={{ span: 12 }} key={i} className={i >= 1 ? "mt-3" : null}>
                                                                <Row className="align-items-center">
                                                                    <Col xs={{ span: 6 }} md={{ span: 4 }}>
                                                                        <h2 className="h6 text-capitalize mb-0">Choose {configuration?.label}</h2>
                                                                    </Col>
                                                                    <Col xs={{ span: 6 }} md={{ span: 8 }}>
                                                                        <div className="d-flex align-items-center justify-content-end">
                                                                            {configuration?.options?.map((configuration_option, i) => (
                                                                                <Form.Check
                                                                                    key={configuration_option?.id}
                                                                                    id={`color-option-${i}`}
                                                                                    className="mb-0 color-radio"
                                                                                    type="radio"
                                                                                    inline
                                                                                    custom
                                                                                >
                                                                                    <style
                                                                                        dangerouslySetInnerHTML={{
                                                                                            __html: [
                                                                                                `[for='color-option-${i}']:after { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%23${
                                                                                                    configuration_option?.value?.split("#")?.[1]
                                                                                                }'/%3E%3C/svg%3E") !important }`
                                                                                            ]
                                                                                        }}
                                                                                    ></style>
                                                                                    <Form.Check.Input
                                                                                        name="options[1]"
                                                                                        value={configuration_option?.id}
                                                                                        onChange={configurationsChangeHandler}
                                                                                        disabled={disabledActionButtonState === productState?.id}
                                                                                        checked={configurationsValuesState?.[`options[1]`] === configuration_option?.id}
                                                                                    />
                                                                                    <Form.Check.Label
                                                                                        style={{
                                                                                            color: configuration_option?.value
                                                                                        }}
                                                                                    ></Form.Check.Label>
                                                                                </Form.Check>
                                                                            ))}
                                                                        </div>
                                                                    </Col>
                                                                </Row>
                                                            </Col>
                                                        ))}
                                                </Row>
                                            </Col>
                                        ) : (
                                            <></>
                                        )}
                                        {productState?.configurations?.filter(config => config?.type === "text")?.slice(1)?.length ? (
                                            <Col xs={{ span: 12 }} className="mt-3">
                                                <Row>
                                                    {productState?.configurations
                                                        ?.filter(config => config?.type === "text")
                                                        ?.slice(1)
                                                        ?.map((configuration, i) => (
                                                            <Col xs={{ span: 12 }} key={i} className={i >= 1 ? "mt-3" : null}>
                                                                <Row className="align-items-center">
                                                                    <Col xs={{ span: 12 }} md={{ span: 3 }}>
                                                                        <strong className="text-dark mb-0">{configuration?.label}</strong>
                                                                    </Col>
                                                                    <Col xs={{ span: 12 }} md={{ span: 9 }}>
                                                                        <Form.Group controlId={`variantsInput${i}`} className="mb-0">
                                                                            <Form.Control
                                                                                name={`options[${i + 2}]`}
                                                                                as="select"
                                                                                size="sm"
                                                                                className="mt-0 text-truncate overflow-hidden rounded-lg"
                                                                                custom
                                                                                onChange={configurationsChangeHandler}
                                                                                disabled={disabledActionButtonState === productState?.id}
                                                                                value={configurationsValuesState[`options[${i + 2}]`] || ""}
                                                                            >
                                                                                <option value="" disabled={configuration?.options?.length <= 1}>
                                                                                    -select {configuration?.label}-
                                                                                </option>
                                                                                {configuration?.options?.map((configuration_option, i) => (
                                                                                    <option value={configuration_option?.id} key={configuration_option?.id}>
                                                                                        {configuration_option?.value}
                                                                                    </option>
                                                                                ))}
                                                                            </Form.Control>
                                                                        </Form.Group>
                                                                    </Col>
                                                                </Row>
                                                            </Col>
                                                        ))}
                                                </Row>
                                            </Col>
                                        ) : (
                                            <></>
                                        )}
                                        <Col xs={{ span: 12 }} className="mt-3">
                                            <Row>
                                                <Col xs={{ span: 12 }}>
                                                    <h2 className="h6 text-capitalize mb-0 d-flex align-items-center justify-content-between">
                                                        <span>Shipping Cost Calculator</span>
                                                        <Button
                                                            variant="link"
                                                            className="stretched-link p-0"
                                                            onClick={() => setShippingAddressCollapseState(!shippingAddressCollapseState)}
                                                            aria-controls="shipping-address-collapse"
                                                            aria-expanded={shippingAddressCollapseState}
                                                        >
                                                            {shippingAddressCollapseState ? (
                                                                <i className="mdi mdi-chevron-up mdi-28px text-dark" aria-hidden="true"></i>
                                                            ) : (
                                                                <i className="mdi mdi-chevron-down mdi-28px text-dark" aria-hidden="true"></i>
                                                            )}
                                                        </Button>
                                                    </h2>
                                                </Col>
                                                <Collapse in={shippingAddressCollapseState}>
                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                        <div className="bg-light rounded-lg p-4" id="shipping-address-collapse">
                                                            <Form onSubmit={shippingAddressFormik.handleSubmit} noValidate>
                                                                <Form.Row>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <Form.Group controlId="shippingAddressCalculatorAddress">
                                                                            <Form.Label className="text-capitalize ">shipping address</Form.Label>
                                                                            <InputGroup
                                                                                className="m-0 flex-row-reverse rounded-lg bg-white border border-input"
                                                                                style={{
                                                                                    overflow: "hidden"
                                                                                }}
                                                                            >
                                                                                <FormControl
                                                                                    onChange={shippingAddressFormik.handleChange}
                                                                                    value={shippingAddressFormik?.values?.zone_id}
                                                                                    name="zone_id"
                                                                                    type="text"
                                                                                    className="rounded-0 border-0 pl-0"
                                                                                    placeholder="Enter your shipping address"
                                                                                    autoComplete="street-address"
                                                                                />
                                                                                <InputGroup.Prepend>
                                                                                    <InputGroup.Text className="border-0 rounded-0 bg-transparent py-0 px-2">
                                                                                        <i className="mdi mdi-map-marker mdi-24px text-primary" aria-hidden="true"></i>
                                                                                    </InputGroup.Text>
                                                                                </InputGroup.Prepend>
                                                                            </InputGroup>
                                                                        </Form.Group>
                                                                    </Col>
                                                                    {globals?.order?.shipping_methods?.length ? (
                                                                        <Col xs={{ span: 12 }} className="mt-3">
                                                                            <Form.Group>
                                                                                <Form.Row>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <Form.Label className="text-capitalize ">Preferred shipping method</Form.Label>
                                                                                    </Col>
                                                                                    {globals?.order?.shipping_methods?.map((method, i) => (
                                                                                        <Col xs={{ span: 6 }} key={method?.id}>
                                                                                            <Form.Check type="radio" custom id={`shippingAddressCalculatorMethod${method?.id}`}>
                                                                                                <Form.Check.Input
                                                                                                    name="shipping_method_id"
                                                                                                    type="radio"
                                                                                                    value={method?.id}
                                                                                                    onChange={shippingAddressFormik.handleChange}
                                                                                                    checked={Number(shippingAddressFormik?.values?.shipping_method_id) === method?.id}
                                                                                                    isInvalid={
                                                                                                        !!shippingAddressFormik?.touched?.shipping_method_id &&
                                                                                                        !!shippingAddressFormik?.errors?.shipping_method_id
                                                                                                    }
                                                                                                    isValid={
                                                                                                        shippingAddressFormik?.values?.shipping_method_id &&
                                                                                                        !!shippingAddressFormik?.touched?.shipping_method_id &&
                                                                                                        !!!shippingAddressFormik?.errors?.shipping_method_id
                                                                                                    }
                                                                                                />
                                                                                                <Form.Check.Label className="text-capitalize font-weight-bold small">
                                                                                                    <span className="text-dark">{method?.title}</span>
                                                                                                    {method?.color ? (
                                                                                                        <>
                                                                                                            <br />
                                                                                                            <span className="small text-dark">
                                                                                                                <small>{method.color}</small>
                                                                                                            </span>
                                                                                                        </>
                                                                                                    ) : (
                                                                                                        <></>
                                                                                                    )}
                                                                                                </Form.Check.Label>
                                                                                                {!!shippingAddressFormik?.touched?.shipping_method_id &&
                                                                                                    !!shippingAddressFormik?.errors?.shipping_method_id && (
                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                            {shippingAddressFormik.errors.shipping_method_id}
                                                                                                        </Form.Control.Feedback>
                                                                                                    )}
                                                                                            </Form.Check>
                                                                                        </Col>
                                                                                    ))}
                                                                                </Form.Row>
                                                                            </Form.Group>
                                                                        </Col>
                                                                    ) : (
                                                                        <></>
                                                                    )}
                                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                                        <Button
                                                                            variant="outline-primary"
                                                                            type="submit"
                                                                            block
                                                                            className="text-capitalize rounded-lg"
                                                                            disabled={!shippingAddressFormik.isValid}
                                                                        >
                                                                            {shippingAddressFormik.isSubmitting ? <Spinner animation="border" size="sm" /> : "calculate shipping cost"}
                                                                        </Button>
                                                                    </Col>
                                                                </Form.Row>
                                                            </Form>
                                                        </div>
                                                    </Col>
                                                </Collapse>
                                            </Row>
                                        </Col>
                                        <Col xs={{ span: 12 }}>
                                            <hr className="my-4" />
                                        </Col>
                                        <Col xs={{ span: 12 }} className="mb-3">
                                            <Row>
                                                <Col xs={{ span: 12 }} className="mb-3">
                                                    <Row className="align-items-center">
                                                        <Col xs={{ span: 9 }}>
                                                            <p className="m-0 text-right">
                                                                <strong className="text-dark d-block text-capitalize">product price</strong>
                                                            </p>
                                                        </Col>
                                                        <Col xs={{ span: 3 }}>
                                                            <p className="m-0 text-right h5 text-primary-dark">${productState?.regular_price}</p>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                                <Col xs={{ span: 12 }} className="mb-3">
                                                    <Row className="align-items-center">
                                                        <Col xs={{ span: 9 }}>
                                                            <p className="m-0 text-right">
                                                                <strong className="text-dark d-block text-capitalize">shipping cost</strong>
                                                                <small className="d-block">Please enter your shipping address or login to calculate the shipping cost.</small>
                                                            </p>
                                                        </Col>
                                                        <Col xs={{ span: 3 }}>
                                                            <p className="m-0 text-right h5 text-primary-dark">$0</p>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                                <Col xs={{ span: 12 }} className="mb-3">
                                                    <Row className="align-items-center">
                                                        <Col xs={{ span: 9 }}>
                                                            <p className="m-0 text-right">
                                                                <strong className="text-dark d-block text-capitalize">total cost</strong>
                                                            </p>
                                                        </Col>
                                                        <Col xs={{ span: 3 }}>
                                                            <p className="m-0 text-right h5 text-primary-dark">${productState?.regular_price}</p>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                            </Row>
                                        </Col>
                                        <Col xs={{ span: 12 }} className="fixed-bottom py-3 bg-light shadow" id="fixed-bottom-actions">
                                            <Container>
                                                <Row className="align-items-stretch">
                                                    <Col xs={{ span: 3 }} sm={{ span: 2 }} className="pr-2">
                                                        <Button
                                                            variant="outline-primary"
                                                            size="sm"
                                                            className="text-capitalize rounded-lg d-flex align-items-center justify-content-center h-100"
                                                            disabled={disabledActionButtonState === productState?.id}
                                                            block
                                                        >
                                                            <i className={`mdi mdi-heart${!productState?.in_wishlist ? "-outline" : ""} mdi-26px`} aria-hidden="true"></i>
                                                        </Button>
                                                    </Col>
                                                    <Col xs={{ span: 9 }} sm={{ span: 10 }} className="pl-2">
                                                        <Button
                                                            variant="outline-primary"
                                                            size="sm"
                                                            className="text-capitalize rounded-lg px-1 h-100"
                                                            disabled={disabledActionButtonState === productState?.id}
                                                            onClick={e => addToCartClickHandler(e, productState)}
                                                            block
                                                        >
                                                            Add to cart
                                                            <br />
                                                            <small style={{ fontSize: "70%" }}>Choose this option to keep shopping</small>
                                                        </Button>
                                                    </Col>
                                                    <Col xs={{ span: 12 }} className="mt-3">
                                                        <Button
                                                            variant="orange"
                                                            size="sm"
                                                            className="text-capitalize rounded-lg h-100 py-3"
                                                            disabled={disabledActionButtonState === productState?.id}
                                                            onClick={e =>
                                                                cart?.shipping_method_id && cart?.items?.filter(item => item?.id === productState?.id)?.length
                                                                    ? push("/shipping")
                                                                    : addToCartClickHandler(e, productState, () => {
                                                                          setShippingAddressCollapseState(true);
                                                                          shippingAddressFormik.submitForm();
                                                                          push("/shipping");
                                                                      })
                                                            }
                                                            block
                                                        >
                                                            buy now
                                                        </Button>
                                                    </Col>
                                                </Row>
                                            </Container>
                                        </Col>
                                        <Col xs={{ span: 12 }} className="mt-gutter">
                                            <Tab.Container defaultActiveKey="product-description" id="uncontrolled-tab-example">
                                                <Row>
                                                    <Col xs={{ span: 12 }}>
                                                        <Nav as="nav" variant="tabs">
                                                            {productState?.description ? (
                                                                <Nav.Link eventKey="product-description" className="white-space-nowrap">
                                                                    <small>Product Description</small>
                                                                </Nav.Link>
                                                            ) : (
                                                                <></>
                                                            )}
                                                            {productState?.video ? (
                                                                <Nav.Link eventKey="product-video" className="white-space-nowrap">
                                                                    <small>Product video</small>
                                                                </Nav.Link>
                                                            ) : (
                                                                <></>
                                                            )}
                                                            {productState?.faq?.length ? (
                                                                <Nav.Link eventKey="faqs" className="white-space-nowrap">
                                                                    <small>FAQs</small>
                                                                </Nav.Link>
                                                            ) : (
                                                                <></>
                                                            )}
                                                            {productState?.delivery_information ? (
                                                                <Nav.Link eventKey="delivery-info" className="white-space-nowrap">
                                                                    <small>Delivery Info</small>
                                                                </Nav.Link>
                                                            ) : (
                                                                <></>
                                                            )}
                                                            {productState?.warranty_information ? (
                                                                <Nav.Link eventKey="warranty-guarantee" className="white-space-nowrap">
                                                                    <small>Warranty & Guarantee</small>
                                                                </Nav.Link>
                                                            ) : (
                                                                <></>
                                                            )}
                                                        </Nav>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Tab.Content>
                                                            {productState?.description ? (
                                                                <Tab.Pane eventKey="product-description" className="py-4">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h4 className="mb-0 text-capitalize">Product Description</h4>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} className="mt-3">
                                                                            <p
                                                                                dangerouslySetInnerHTML={{
                                                                                    __html: decodeHtml(productState.description.trim().toString())
                                                                                }}
                                                                            />
                                                                        </Col>
                                                                    </Row>
                                                                </Tab.Pane>
                                                            ) : (
                                                                <></>
                                                            )}
                                                            {productState?.video ? (
                                                                <Tab.Pane eventKey="product-video" className="py-4">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h4 className="mb-0 text-capitalize">Product video</h4>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} className="mt-3">
                                                                            <iframe
                                                                                src={productState.video}
                                                                                title="product video"
                                                                                frameborder="0"
                                                                                style={{
                                                                                    height: "100px",
                                                                                    width: "100%",
                                                                                    objectFit: "none"
                                                                                }}
                                                                            ></iframe>
                                                                        </Col>
                                                                    </Row>
                                                                </Tab.Pane>
                                                            ) : (
                                                                <></>
                                                            )}
                                                            {productState?.faq?.length ? (
                                                                <Tab.Pane eventKey="faqs" className="py-4">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h4 className="mb-0 text-capitalize d-flex align-items-center">
                                                                                <span className="border-right pr-3 mr-3">FAQs</span>
                                                                                <Button
                                                                                    variant="link"
                                                                                    className="text-capitalize text-decoration-underline p-0"
                                                                                    onClick={() => setExpandAllState(!expandAllState)}
                                                                                >
                                                                                    {`${expandAllState ? "unExpand" : "expand"} all`}
                                                                                </Button>
                                                                            </h4>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} className="mt-3">
                                                                            {expandAllState ? (
                                                                                <>
                                                                                    {productState.faq?.map((faq, i) => (
                                                                                        <Accordion defaultActiveKey={i + 1} key={faq?.question}>
                                                                                            <Row className={`pt-3 ${productState.faq.length - 1 > i ? "pb-3 border-bottom" : ""}`} noGutters>
                                                                                                <Col
                                                                                                    xs={{
                                                                                                        span: 12
                                                                                                    }}
                                                                                                >
                                                                                                    <ContextAwareToggle eventKey={i + 1}>
                                                                                                        <span className="font-weight-bold">{faq?.question}</span>
                                                                                                    </ContextAwareToggle>
                                                                                                </Col>
                                                                                                <Col
                                                                                                    xs={{
                                                                                                        span: 12
                                                                                                    }}
                                                                                                >
                                                                                                    <Accordion.Collapse eventKey={i + 1}>
                                                                                                        <div className="py-3">
                                                                                                            <p className="mb-0">{faq?.answer}</p>
                                                                                                        </div>
                                                                                                    </Accordion.Collapse>
                                                                                                </Col>
                                                                                            </Row>
                                                                                        </Accordion>
                                                                                    ))}
                                                                                </>
                                                                            ) : (
                                                                                <>
                                                                                    <Accordion>
                                                                                        {productState.faq?.map((faq, i) => (
                                                                                            <Row
                                                                                                className={`pt-3 ${productState.faq.length - 1 > i ? "pb-3 border-bottom" : ""}`}
                                                                                                key={faq?.question}
                                                                                                noGutters
                                                                                            >
                                                                                                <Col
                                                                                                    xs={{
                                                                                                        span: 12
                                                                                                    }}
                                                                                                >
                                                                                                    <ContextAwareToggle eventKey={i + 1}>
                                                                                                        <span className="font-weight-bold">{faq?.question}</span>
                                                                                                    </ContextAwareToggle>
                                                                                                </Col>
                                                                                                <Col
                                                                                                    xs={{
                                                                                                        span: 12
                                                                                                    }}
                                                                                                >
                                                                                                    <Accordion.Collapse eventKey={i + 1}>
                                                                                                        <div className="py-3">
                                                                                                            <p className="mb-0">{faq?.answer}</p>
                                                                                                        </div>
                                                                                                    </Accordion.Collapse>
                                                                                                </Col>
                                                                                            </Row>
                                                                                        ))}
                                                                                    </Accordion>
                                                                                </>
                                                                            )}
                                                                        </Col>
                                                                    </Row>
                                                                </Tab.Pane>
                                                            ) : (
                                                                <></>
                                                            )}
                                                            {productState?.delivery_information ? (
                                                                <Tab.Pane eventKey="delivery-info" className="py-4">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h4 className="mb-0 text-capitalize">Delivery Info</h4>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} className="mt-3">
                                                                            <p
                                                                                dangerouslySetInnerHTML={{
                                                                                    __html: decodeHtml(productState.delivery_information.trim().toString())
                                                                                }}
                                                                            />
                                                                        </Col>
                                                                    </Row>
                                                                </Tab.Pane>
                                                            ) : (
                                                                <></>
                                                            )}
                                                            {productState?.warranty_information ? (
                                                                <Tab.Pane eventKey="warranty-guarantee" className="py-4">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h4 className="mb-0 text-capitalize">Warranty & Guarantee</h4>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} className="mt-3">
                                                                            <p
                                                                                dangerouslySetInnerHTML={{
                                                                                    __html: decodeHtml(productState.warranty_information.trim().toString())
                                                                                }}
                                                                            />
                                                                        </Col>
                                                                    </Row>
                                                                </Tab.Pane>
                                                            ) : (
                                                                <></>
                                                            )}
                                                        </Tab.Content>
                                                    </Col>
                                                </Row>
                                            </Tab.Container>
                                        </Col>
                                    </Row>
                                </Col>
                            </>
                        )}
                    </Row>
                </Container>
            </section>
            {productLoadingState || (!productLoadingState && recentlyViewedState?.length) ? (
                <ProductShowCaseSection
                    title="Recently viewed"
                    className="products-showcase-section recently-viewed-section section bg-light py-5"
                    products={recentlyViewedState?.slice(0, 4)?.map(({ id, wishlist_id, in_wishlist, slug, cover, title, discount, ...product }) => ({
                        id,
                        wishlist_id,
                        in_wishlist,
                        slug,
                        cover,
                        title,
                        discount
                    }))}
                    isLoading={productLoadingState}
                    cardLoaderCount={4}
                    deals={false}
                    productsInViewBreakPoints={{
                        1200: { slidesPerView: 4 }
                    }}
                />
            ) : (
                <></>
            )}
            {productLoadingState || (!productLoadingState && relatedProductsState?.length) ? (
                <ProductShowCaseSection
                    title="other products"
                    className="products-showcase-section other-products-section section bg-white py-5"
                    products={relatedProductsState?.slice(0, 4)?.map(({ id, wishlist_id, in_wishlist, slug, cover, title, discount, sale_price, regular_price, ...product }) => ({
                        id,
                        wishlist_id,
                        in_wishlist,
                        slug,
                        cover,
                        title,
                        discount,
                        sale_price,
                        regular_price
                    }))}
                    isLoading={productLoadingState}
                    cardLoaderCount={4}
                    deals={false}
                    productsInViewBreakPoints={{
                        1200: { slidesPerView: 4 }
                    }}
                />
            ) : (
                <></>
            )}
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload)),
    onChangeCart: payload => dispatch(actions.changeCart(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(ProductSingle);
