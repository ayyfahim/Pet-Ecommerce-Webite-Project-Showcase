/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { NavLink, Link } from "react-router-dom";
import { Container, Row, Col, Form, Button, FormControl, InputGroup, ListGroup, Nav, Spinner, Collapse } from "react-bootstrap";
import { useFormik } from "formik";
import { object, string } from "yup";
import to from "await-to-js";
import qs from "qs";

import * as actions from "../../store/rootActions";
import CartService from "../../services/CartService";

import NoDataSection from "../sections/NoDataSection";

export const CartPage = props => {
    const {
        history: {
            location: { pathname, search },
            push,
            goBack
        },
        onAddFlashMessage,
        onChangeCart,
        auth: { isAuthenticated },
        globals,
        cart
    } = props;
    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    // Component State.
    const initialQueryState = { ...queryParams };
    const initialCartState = {};
    const initialCartLoadingState = false;
    const initialDisabledActionButtonState = "";
    const initialRedeemPointsCollapseState = false;
    const initialCouponFormValueState = { coupon_code: "" };
    const initialUseRewardPointState = 0;
    const initialDefaultShippingAddressFormValueState = { shipping_method_id: undefined, zone_id: "" };
    const [defaultCouponFormValueState, setDefaultCouponFormValueState] = useState(initialCouponFormValueState);
    const [queryState, setQueryState] = useState(initialQueryState);
    const [cartState, setCartState] = useState(initialCartState);
    const [cartLoadingState, setCartLoadingState] = useState(initialCartLoadingState);
    const [disabledActionButtonState, setDisabledActionButtonState] = useState(initialDisabledActionButtonState);
    const [redeemPointsCollapseState, setRedeemPointsCollapseState] = useState(initialRedeemPointsCollapseState);
    const [useRewardPointState, setUseRewardPointState] = useState(initialUseRewardPointState);
    const [defaultShippingAddressFormValueState, setDefaultShippingAddressFormValueState] = useState(initialDefaultShippingAddressFormValueState);

    // API Calls.
    const fetchCartData = async (query, cb) => {
        const [cartErrors, cartResponse] = await to(CartService.listing(query));
        if (cartErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = cartErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setCartLoadingState(false);
            if (cb && typeof cb === "function") cb();
            return;
        }

        const {
            data: {
                cart: { shipping_method_id, ...cart }
            }
        } = cartResponse;
        setCartState({ ...(shipping_method_id && { shipping_method_id }), ...cart });
        onChangeCart({ ...(shipping_method_id && { shipping_method_id }), ...cart });
        setDefaultShippingAddressFormValueState({ ...defaultShippingAddressFormValueState, ...(shipping_method_id && { shipping_method_id }) });
        setCartLoadingState(false);
        if (cb && typeof cb === "function") cb();
    };

    // Component Hooks.
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

    const applyCouponFormik = useFormik({
        validateOnBlur: false,
        enableReinitialize: true,
        initialValues: { ...defaultCouponFormValueState },
        validationSchema: object().shape({ coupon_code: string().required("coupon code field is required.") }),
        onSubmit: async (values, { setSubmitting, setErrors }) => {
            await fetchCartData({ ...values, use_coupon: Number(!!values?.coupon_code) }, () => {
                setErrors(false);
                setSubmitting(false);
            });
        }
    });

    useEffect(() => {
        push({ pathname, search: `?${qs.stringify(queryState)}` });
        return () => false;
    }, [queryState]);

    useEffect(() => {
        setCartLoadingState(true);
        fetchCartData(queryState);
        return () => false;
    }, [search]);

    useEffect(() => {
        setUseRewardPointState(cartState?.use_points);
        if (cartState?.use_points) setRedeemPointsCollapseState(cartState?.use_points);
        return () => false;
    }, [cartState?.use_points]);

    // Event handlers
    // Quantity Handlers.
    const onProductQuantityIncrementClickHandler = async (e, { product: { id: product_id }, id, quantity }) => {
        setDisabledActionButtonState(id);
        const [cartErrors, cartResponse] = await to(CartService.update({ id }, { product_id, quantity: quantity + 1 }));
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

        setCartState({ ...cart });
        onChangeCart({ ...cart });
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
    };
    const onProductQuantityDecrementClickHandler = async (e, { product: { id: product_id }, id, quantity }) => {
        setDisabledActionButtonState(id);
        const [cartErrors, cartResponse] = await to(CartService.update({ id }, { product_id, quantity: quantity - 1 }));
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

        setCartState({ ...cart });
        onChangeCart({ ...cart });
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
    };
    const onProductQuantityChangeHandler = async (e, { product: { id: product_id }, id }) => {
        setDisabledActionButtonState(id);
        const [cartErrors, cartResponse] = await to(CartService.update({ id }, { product_id, quantity: Number(e.target.value) }));
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

        setCartState({ ...cart });
        onChangeCart({ ...cart });
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
    };
    const removeFromCartClickHandler = async (e, { product: { id: product_id }, id }) => {
        setDisabledActionButtonState(id);
        const [cartErrors, cartResponse] = await to(CartService.delete({ id }));
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

        setCartState({ ...cart });
        onChangeCart({ ...cart });
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
    };
    // Reward Points Handlers.
    const onRewardPointStateInputChangeHandler = async e => fetchCartData({ ...queryState, [e.target.name]: Number(!useRewardPointState) });

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <section id="page-content">
                                <Row>
                                    <Col xs={{ span: 12 }} className="mb-gutter">
                                        <nav aria-label="order process navigation">
                                            <Nav as="ul" fill variant="tabs" className="nav-steps">
                                                <Nav.Item as="li">
                                                    <Nav.Link as={NavLink} to="/cart" className="text-capitalize pb-4">
                                                        cart
                                                    </Nav.Link>
                                                </Nav.Item>
                                                <Nav.Item as="li">
                                                    <Nav.Link as={NavLink} to="/shipping" disabled={!cart?.shipping_method_id} className="text-capitalize pb-4">
                                                        shipping
                                                    </Nav.Link>
                                                </Nav.Item>
                                                <Nav.Item as="li">
                                                    <Nav.Link as={NavLink} to="/payment" disabled={!cart?.shipping_method_id} className="text-capitalize pb-4">
                                                        payment
                                                    </Nav.Link>
                                                </Nav.Item>
                                                <Nav.Item as="li">
                                                    <Nav.Link as={NavLink} to="/orders/confirmation" disabled className="text-capitalize pb-4">
                                                        done
                                                    </Nav.Link>
                                                </Nav.Item>
                                            </Nav>
                                        </nav>
                                    </Col>
                                    <Col xs={{ span: 12 }}>
                                        <Row>
                                            {cartLoadingState ? (
                                                <>
                                                    <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                                        <Spinner animation="border" variant="primary" />
                                                    </Col>
                                                </>
                                            ) : cartState?.items?.length ? (
                                                <>
                                                    <Col xs={{ span: 12 }}>
                                                        <Row>
                                                            <Col xs={{ span: 12 }} className="mb-gutter">
                                                                <Row as={ListGroup} variant="flush" noGutters className="border-bottom">
                                                                    {cartState.items?.map(item => (
                                                                        <Col key={item?.id} xs={{ span: 12 }} as={ListGroup.Item} className="py-4">
                                                                            <Row noGutters className="align-items-lg-center">
                                                                                <Col xs={{ span: 11 }} md={{ span: 6 }} lg={{ span: 5 }} className="order-1">
                                                                                    <Row className="align-items-lg-center">
                                                                                        <Col xs={{ span: 4 }}>
                                                                                            <div
                                                                                                className="bg-light rounded-sm w-100 border border-secondary"
                                                                                                style={{
                                                                                                    height: "100px",
                                                                                                    overflow: "hidden"
                                                                                                }}
                                                                                            >
                                                                                                <Link to={`/products/${item?.product?.slug}`}>
                                                                                                    <img
                                                                                                        src={item?.product?.cover}
                                                                                                        alt={`${item?.product?.title}`}
                                                                                                        className="d-block text-center bg-light rounded-sm"
                                                                                                        style={{
                                                                                                            height: "100%",
                                                                                                            width: "100%",
                                                                                                            objectFit: "scale-down",
                                                                                                            objectPosition: "center"
                                                                                                        }}
                                                                                                    />
                                                                                                </Link>
                                                                                            </div>
                                                                                        </Col>
                                                                                        <Col xs={{ span: 8 }}>
                                                                                            <h6 className="mb-2 font-weight-normal">
                                                                                                <Link to={`/products/${item?.product?.slug}`} className="text-dark text-decoration-none">
                                                                                                    {item?.product?.title}
                                                                                                </Link>
                                                                                            </h6>
                                                                                            {item?.variation_options?.map((option, i) => (
                                                                                                <p
                                                                                                    key={option?.id}
                                                                                                    className={`text-secondary small ${i < item?.variation_options?.length - 1 ? "mb-2" : "mb-0"}`}
                                                                                                >
                                                                                                    {option?.value}
                                                                                                </p>
                                                                                            ))}
                                                                                        </Col>
                                                                                    </Row>
                                                                                </Col>
                                                                                <Col xs={{ span: 8, offset: 4 }} md={{ span: 5, offset: 0 }} lg={{ span: 6 }} className="order-3 order-md-2">
                                                                                    <Row className="align-items-lg-center">
                                                                                        <Col
                                                                                            xs={{ span: 12 }}
                                                                                            md={{ span: 6, offset: 6 }}
                                                                                            lg={{ span: 4, offset: 1 }}
                                                                                            className="order-last order-lg-first"
                                                                                        >
                                                                                            <InputGroup size="sm">
                                                                                                <InputGroup.Prepend>
                                                                                                    <Button
                                                                                                        variant="outline-secondary"
                                                                                                        className="rounded-left-lg py-0 shadow-none"
                                                                                                        disabled={disabledActionButtonState === item?.id}
                                                                                                        onClick={e => onProductQuantityDecrementClickHandler(e, item)}
                                                                                                    >
                                                                                                        <i className="mdi mdi-minus mdi-20px" aria-hidden="true"></i>
                                                                                                        <span className="sr-only">decrement quantity</span>
                                                                                                    </Button>
                                                                                                </InputGroup.Prepend>
                                                                                                <FormControl
                                                                                                    type="number"
                                                                                                    className="text-center border-secondary shadow-none"
                                                                                                    value={item?.quantity}
                                                                                                    disabled={disabledActionButtonState === item?.id}
                                                                                                    onChange={e => onProductQuantityChangeHandler(e, item)}
                                                                                                    min={1}
                                                                                                />
                                                                                                <InputGroup.Append>
                                                                                                    <Button
                                                                                                        variant="outline-secondary"
                                                                                                        className="rounded-right-lg py-0 shadow-none"
                                                                                                        disabled={disabledActionButtonState === item?.id}
                                                                                                        onClick={e => onProductQuantityIncrementClickHandler(e, item)}
                                                                                                    >
                                                                                                        <i className="mdi mdi-plus mdi-20px" aria-hidden="true"></i>
                                                                                                        <span className="sr-only">increment quantity</span>
                                                                                                    </Button>
                                                                                                </InputGroup.Append>
                                                                                            </InputGroup>
                                                                                        </Col>
                                                                                        <Col xs={{ span: 12 }} lg={{ span: 6 }} className="order-first order-lg-last mb-3 mb-lg-0">
                                                                                            <p className="text-md-right mb-0">${item?.total}</p>
                                                                                        </Col>
                                                                                    </Row>
                                                                                </Col>
                                                                                <Col xs={{ span: 1 }} className="text-right order-2 order-md-3">
                                                                                    <Button
                                                                                        variant="link"
                                                                                        className="text-danger text-decoration-none p-2"
                                                                                        disabled={disabledActionButtonState === item?.id}
                                                                                        onClick={e => removeFromCartClickHandler(e, item)}
                                                                                    >
                                                                                        <i className="mdi mdi-close mdi-20px" aria-hidden="true"></i>
                                                                                        <span className="sr-only">remove product</span>
                                                                                    </Button>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                    ))}
                                                                </Row>
                                                            </Col>
                                                            {isAuthenticated ? (
                                                                <Col xs={{ span: 12 }} className="mb-gutter">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }} md={{ span: 6 }} className="mb-gutter mb-md-0">
                                                                            <Row>
                                                                                <Col xs={{ span: 12 }} md={{ span: 11 }}>
                                                                                    <Row>
                                                                                        <Col xs={{ span: 12 }}>
                                                                                            <h2 className="h6 text-capitalize mb-4">shipping cost calculator</h2>
                                                                                        </Col>
                                                                                        <Col xs={{ span: 12 }}>
                                                                                            <div className="bg-light rounded-lg p-md-5 p-4">
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
                                                                                                                            <i
                                                                                                                                className="mdi mdi-map-marker mdi-24px text-primary"
                                                                                                                                aria-hidden="true"
                                                                                                                            ></i>
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
                                                                                                                            <Form.Label className="text-capitalize ">
                                                                                                                                Preferred shipping method
                                                                                                                            </Form.Label>
                                                                                                                        </Col>
                                                                                                                        {globals?.order?.shipping_methods?.map((method, i) => (
                                                                                                                            <Col xs={{ span: 6 }} key={method?.id}>
                                                                                                                                <Form.Check
                                                                                                                                    type="radio"
                                                                                                                                    custom
                                                                                                                                    id={`shippingAddressCalculatorMethod${method?.id}`}
                                                                                                                                >
                                                                                                                                    <Form.Check.Input
                                                                                                                                        name="shipping_method_id"
                                                                                                                                        type="radio"
                                                                                                                                        value={method?.id}
                                                                                                                                        onChange={shippingAddressFormik.handleChange}
                                                                                                                                        checked={
                                                                                                                                            Number(
                                                                                                                                                shippingAddressFormik?.values?.shipping_method_id
                                                                                                                                            ) === method?.id
                                                                                                                                        }
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
                                                                                                                {shippingAddressFormik.isSubmitting ? (
                                                                                                                    <Spinner animation="border" size="sm" />
                                                                                                                ) : (
                                                                                                                    "calculate shipping cost"
                                                                                                                )}
                                                                                                            </Button>
                                                                                                        </Col>
                                                                                                    </Form.Row>
                                                                                                </Form>
                                                                                            </div>
                                                                                        </Col>
                                                                                    </Row>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} md={{ span: 6 }}>
                                                                            <Row>
                                                                                <Col xs={{ span: 12 }} md={{ span: 11, offset: 1 }}>
                                                                                    <Row>
                                                                                        <Col xs={{ span: 12 }} className="mb-3 mt-md-5 d-flex justify-content-md-end">
                                                                                            <Button
                                                                                                variant="link"
                                                                                                className="p-0"
                                                                                                onClick={() => setRedeemPointsCollapseState(!redeemPointsCollapseState)}
                                                                                                aria-controls="redeem-points-collapse"
                                                                                                aria-expanded={redeemPointsCollapseState}
                                                                                            >
                                                                                                I want to redeem my Points/Coupon
                                                                                            </Button>
                                                                                        </Col>
                                                                                        <Collapse in={redeemPointsCollapseState}>
                                                                                            <Col xs={{ span: 12 }} className="mb-3">
                                                                                                <div className="border-top border-bottom py-4" id="redeem-points-collapse">
                                                                                                    <Row noGutters>
                                                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                                                            <div className="d-flex align-items-center justify-content-between">
                                                                                                                <h3 className="h6 text-capitalize">redeem coupon/points</h3>
                                                                                                                <Button
                                                                                                                    variant="link"
                                                                                                                    size="sm"
                                                                                                                    className="text-secondary"
                                                                                                                    onClick={() => setRedeemPointsCollapseState(false)}
                                                                                                                >
                                                                                                                    <span className="mdi mdi-close mdi-18px" aria-hidden="true"></span>
                                                                                                                </Button>
                                                                                                            </div>
                                                                                                        </Col>
                                                                                                        {!cartState?.use_coupon ? (
                                                                                                            <>
                                                                                                                <Col xs={{ span: 12 }} className="mb-3">
                                                                                                                    <Form onSubmit={applyCouponFormik.handleSubmit} noValidate>
                                                                                                                        <Form.Row>
                                                                                                                            <Col xs={{ span: 8 }}>
                                                                                                                                <Form.Group controlId="CartApplyCoupons" className="mb-0">
                                                                                                                                    <Form.Control
                                                                                                                                        onChange={applyCouponFormik.handleChange}
                                                                                                                                        onBlur={applyCouponFormik.handleBlur}
                                                                                                                                        value={applyCouponFormik?.values?.coupon_code || ""}
                                                                                                                                        isInvalid={
                                                                                                                                            !!applyCouponFormik?.touched?.coupon_code &&
                                                                                                                                            !!applyCouponFormik?.errors?.coupon_code
                                                                                                                                        }
                                                                                                                                        isValid={
                                                                                                                                            applyCouponFormik?.values?.coupon_code &&
                                                                                                                                            !!applyCouponFormik?.touched?.coupon_code &&
                                                                                                                                            !!!applyCouponFormik?.errors?.coupon_code
                                                                                                                                        }
                                                                                                                                        name="coupon_code"
                                                                                                                                        type="text"
                                                                                                                                        className="rounded-lg"
                                                                                                                                        placeholder="Enter coupon code or points to redeem"
                                                                                                                                    />
                                                                                                                                    {!!applyCouponFormik?.touched?.coupon_code &&
                                                                                                                                        !!applyCouponFormik?.errors?.coupon_code && (
                                                                                                                                            <Form.Control.Feedback type="invalid">
                                                                                                                                                {applyCouponFormik.errors.coupon_code}
                                                                                                                                            </Form.Control.Feedback>
                                                                                                                                        )}
                                                                                                                                </Form.Group>
                                                                                                                            </Col>
                                                                                                                            <Col xs={{ span: 4 }}>
                                                                                                                                <Button
                                                                                                                                    type="submit"
                                                                                                                                    variant="primary"
                                                                                                                                    className="text-capitalize rounded-lg"
                                                                                                                                    disabled={!applyCouponFormik.isValid}
                                                                                                                                    block
                                                                                                                                >
                                                                                                                                    {applyCouponFormik.isSubmitting ? (
                                                                                                                                        <Spinner animation="border" size="sm" />
                                                                                                                                    ) : (
                                                                                                                                        "redeem"
                                                                                                                                    )}
                                                                                                                                </Button>
                                                                                                                            </Col>
                                                                                                                        </Form.Row>
                                                                                                                    </Form>
                                                                                                                </Col>
                                                                                                            </>
                                                                                                        ) : (
                                                                                                            <></>
                                                                                                        )}
                                                                                                        <Col xs={{ span: 12 }}>
                                                                                                            <Form.Group className="mb-0">
                                                                                                                <Form.Check type="checkbox" custom id="rewardPointsCheckbox">
                                                                                                                    <Form.Check.Input
                                                                                                                        checked={useRewardPointState}
                                                                                                                        name="use_points"
                                                                                                                        onChange={onRewardPointStateInputChangeHandler}
                                                                                                                    />
                                                                                                                    <Form.Check.Label className="text-capitalize">
                                                                                                                        <span className="font-weight-light">
                                                                                                                            You have <strong>{cartState?.points?.total_reward_points}</strong> reward
                                                                                                                            points worth of{" "}
                                                                                                                            <strong>${cartState?.points?.total_reward_points_exchange}</strong>
                                                                                                                        </span>
                                                                                                                    </Form.Check.Label>
                                                                                                                </Form.Check>
                                                                                                            </Form.Group>
                                                                                                        </Col>
                                                                                                    </Row>
                                                                                                </div>
                                                                                            </Col>
                                                                                        </Collapse>
                                                                                        <Col xs={{ span: 12 }}>
                                                                                            <Row>
                                                                                                <Col xs={{ span: 12 }} className="mb-3">
                                                                                                    <Row className="align-items-center">
                                                                                                        <Col xs={{ span: 9 }}>
                                                                                                            <p className="m-0 text-right">
                                                                                                                <strong className="text-dark d-block text-capitalize">subTotal</strong>
                                                                                                            </p>
                                                                                                        </Col>
                                                                                                        <Col xs={{ span: 3 }}>
                                                                                                            <p className="m-0 text-right h5 text-primary-dark">${cartState?.totals?.sub_total || 0}</p>
                                                                                                        </Col>
                                                                                                    </Row>
                                                                                                </Col>
                                                                                                {cartState?.totals?.vat ? (
                                                                                                    <>
                                                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                                                            <Row className="align-items-center">
                                                                                                                <Col xs={{ span: 9 }}>
                                                                                                                    <p className="m-0 text-right">
                                                                                                                        <strong className="text-dark d-block text-capitalize">vat</strong>
                                                                                                                    </p>
                                                                                                                </Col>
                                                                                                                <Col xs={{ span: 3 }}>
                                                                                                                    <p className="m-0 text-right h5 text-primary-dark">${cartState.totals.vat}</p>
                                                                                                                </Col>
                                                                                                            </Row>
                                                                                                        </Col>
                                                                                                    </>
                                                                                                ) : (
                                                                                                    <></>
                                                                                                )}
                                                                                                {cartState?.totals?.cod ? (
                                                                                                    <>
                                                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                                                            <Row className="align-items-center">
                                                                                                                <Col xs={{ span: 9 }}>
                                                                                                                    <p className="m-0 text-right">
                                                                                                                        <strong className="text-dark d-block text-capitalize">cod</strong>
                                                                                                                    </p>
                                                                                                                </Col>
                                                                                                                <Col xs={{ span: 3 }}>
                                                                                                                    <p className="m-0 text-right h5 text-primary-dark">${cartState.totals.cod}</p>
                                                                                                                </Col>
                                                                                                            </Row>
                                                                                                        </Col>
                                                                                                    </>
                                                                                                ) : (
                                                                                                    <></>
                                                                                                )}
                                                                                                {cartState?.totals?.discounts?.length ? (
                                                                                                    cartState.totals.discounts?.map((discount, i) => (
                                                                                                        <Col xs={{ span: 12 }} className="mb-3" key={i.toString()}>
                                                                                                            <Row className="align-items-center">
                                                                                                                <Col xs={{ span: 9 }}>
                                                                                                                    <p className="m-0 text-right">
                                                                                                                        <strong className="text-dark d-block text-capitalize">{discount?.label}</strong>
                                                                                                                    </p>
                                                                                                                </Col>
                                                                                                                <Col xs={{ span: 3 }}>
                                                                                                                    <p className="m-0 text-right h5 text-primary-dark">
                                                                                                                        {Math.sign(discount?.amount) === -1 ? "-" : ""}$
                                                                                                                        {Math.sign(discount?.amount) === -1
                                                                                                                            ? Number(String(discount?.amount).split("-")?.[1])
                                                                                                                            : discount?.amount}
                                                                                                                    </p>
                                                                                                                </Col>
                                                                                                            </Row>
                                                                                                        </Col>
                                                                                                    ))
                                                                                                ) : (
                                                                                                    <></>
                                                                                                )}
                                                                                                {cartState?.totals?.shipping?.amount ? (
                                                                                                    <>
                                                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                                                            <Row className="align-items-center">
                                                                                                                <Col xs={{ span: 9 }}>
                                                                                                                    <p className="m-0 text-right">
                                                                                                                        <strong className="text-dark d-block text-capitalize">shipping cost</strong>
                                                                                                                    </p>
                                                                                                                </Col>
                                                                                                                <Col xs={{ span: 3 }}>
                                                                                                                    <p className="m-0 text-right h5 text-primary-dark">
                                                                                                                        ${cartState.totals.shipping.amount}
                                                                                                                    </p>
                                                                                                                </Col>
                                                                                                            </Row>
                                                                                                        </Col>
                                                                                                    </>
                                                                                                ) : (
                                                                                                    <></>
                                                                                                )}
                                                                                                <Col xs={{ span: 12 }} className="mb-3">
                                                                                                    <Row className="align-items-center">
                                                                                                        <Col xs={{ span: 9 }}>
                                                                                                            <p className="m-0 text-right">
                                                                                                                <strong className="text-dark d-block text-capitalize">total cost</strong>
                                                                                                            </p>
                                                                                                        </Col>
                                                                                                        <Col xs={{ span: 3 }}>
                                                                                                            <p className="m-0 text-right h5 text-primary-dark">${cartState?.totals?.total}</p>
                                                                                                        </Col>
                                                                                                    </Row>
                                                                                                </Col>
                                                                                            </Row>
                                                                                        </Col>
                                                                                        <Col xs={{ span: 12 }}>
                                                                                            <hr className="my-4" />
                                                                                        </Col>
                                                                                        <Col xs={{ span: 12 }}>
                                                                                            <Row>
                                                                                                <Col xs={{ span: 5 }} sm={{ span: 5 }} className="mb-3 md-sm-0">
                                                                                                    <Button
                                                                                                        variant="outline-primary"
                                                                                                        className="text-capitalize rounded-lg d-flex align-items-center justify-content-center"
                                                                                                        onClick={goBack}
                                                                                                        disabled={false}
                                                                                                        block
                                                                                                    >
                                                                                                        <i className="mdi mdi-arrow-left mdi-18px mr-2" aria-hidden="true"></i>
                                                                                                        <span className="d-none d-sm-inline">back to shop</span>
                                                                                                        <span className="d-sm-none">back</span>
                                                                                                    </Button>
                                                                                                </Col>
                                                                                                <Col xs={{ span: 7 }} sm={{ span: 7 }}>
                                                                                                    <Button
                                                                                                        variant="primary"
                                                                                                        className="text-capitalize rounded-lg d-flex align-items-center justify-content-center"
                                                                                                        disabled={!shippingAddressFormik.isValid}
                                                                                                        onClick={() =>
                                                                                                            cart?.shipping_method_id ? push("/shipping") : shippingAddressFormik.submitForm()
                                                                                                        }
                                                                                                        block
                                                                                                    >
                                                                                                        continue to shipping
                                                                                                        <i className="mdi mdi-arrow-right mdi-18px ml-2" aria-hidden="true"></i>
                                                                                                    </Button>
                                                                                                </Col>
                                                                                            </Row>
                                                                                        </Col>
                                                                                    </Row>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                    </Row>
                                                                </Col>
                                                            ) : (
                                                                <></>
                                                            )}
                                                        </Row>
                                                    </Col>
                                                </>
                                            ) : (
                                                <>
                                                    <Col xs={{ span: 12 }}>
                                                        <NoDataSection title="unfortunately cart is empty!" description="Try to add product to card." />
                                                    </Col>
                                                </>
                                            )}
                                        </Row>
                                    </Col>
                                </Row>
                            </section>
                        </Col>
                    </Row>
                </Container>
            </section>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload)),
    onChangeCart: payload => dispatch(actions.changeCart(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(CartPage);
