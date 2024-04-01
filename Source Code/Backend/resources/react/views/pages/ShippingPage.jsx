/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { NavLink, Link } from "react-router-dom";
import { Container, Row, Col, Form, Button, FormControl, InputGroup, ListGroup, Nav, Spinner, Collapse, Card } from "react-bootstrap";
import { useFormik } from "formik";
import { object, string, array } from "yup";
import to from "await-to-js";
import qs from "qs";

import * as actions from "../../store/rootActions";
import CartService from "../../services/CartService";
import { ADDRESS_COUNTRY_NAME } from "../../config/globals";
import AuthService from "../../services/AuthService";
import AddressService from "../../services/AddressService";

import NoDataSection from "../sections/NoDataSection";

export const ShippingPage = props => {
    const {
        history: {
            location: { pathname, search },
            push,
            goBack
        },
        auth: { user },
        onChangeCart,
        onAddFlashMessage,
        onChangeUserState
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
    const initialSelectedOrderDeliveryAddressFormState = "";
    const initialOrderDeliveryAddressState = {};
    const initialOrderDeliveryAddressFormCollapseState = false;
    const initialAddressFormState = {
        values: { country: ADDRESS_COUNTRY_NAME, name: "", email: "", phone: "", title: "", business_name: "", street_address: "", area: "", city: "", postal_code: "" }
    };
    const initialDefaultAdditionalFormState = { values: { additional: [] } };
    const [addressFormState, setAddressFormState] = useState(initialAddressFormState);
    const [selectedOrderDeliveryAddressFormState, setSelectedOrderDeliveryAddressFormState] = useState(initialSelectedOrderDeliveryAddressFormState);
    const [orderDeliveryAddressState, setOrderDeliveryAddressState] = useState(initialOrderDeliveryAddressState);
    const [orderDeliveryAddressFormCollapseState, setOrderDeliveryAddressFormCollapseState] = useState(initialOrderDeliveryAddressFormCollapseState);
    const [defaultCouponFormValueState, setDefaultCouponFormValueState] = useState(initialCouponFormValueState);
    const [queryState, setQueryState] = useState(initialQueryState);
    const [cartState, setCartState] = useState(initialCartState);
    const [cartLoadingState, setCartLoadingState] = useState(initialCartLoadingState);
    const [disabledActionButtonState, setDisabledActionButtonState] = useState(initialDisabledActionButtonState);
    const [redeemPointsCollapseState, setRedeemPointsCollapseState] = useState(initialRedeemPointsCollapseState);
    const [useRewardPointState, setUseRewardPointState] = useState(initialUseRewardPointState);
    const [defaultAdditionalFormState, setDefaultAdditionalFormState] = useState(initialDefaultAdditionalFormState);

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
            data: { cart }
        } = cartResponse;
        setCartState({ ...cart });
        onChangeCart({ ...cart });
        if (cart?.additional?.length)
            setDefaultAdditionalFormState({
                ...defaultAdditionalFormState,
                values: { ...defaultAdditionalFormState?.values, additional: [...defaultAdditionalFormState?.values?.additional, ...cart?.additional] }
            });
        setCartLoadingState(false);
        if (cb && typeof cb === "function") cb();
    };
    const getUserData = async () => {
        const [userDataErrors, userDataResponse] = await to(AuthService.me());
        if (userDataErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = userDataErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            return;
        }

        const {
            data: { data: user }
        } = userDataResponse;
        onChangeUserState({ user });
    };
    const updateAddressData = async (params, body, cb) => {
        const [addressUpdateErrors, addressUpdateResponse] = await to(AddressService.update(params, body));
        if (addressUpdateErrors) {
            const {
                response: {
                    data: { errors }
                }
            } = addressUpdateErrors;

            if (errors) onAddFlashMessage({ type: "danger", errors });
            return;
        }

        const {
            data: { message }
        } = addressUpdateResponse;

        getUserData();
        setAddressFormState({ ...addressFormState, ...initialAddressFormState });
    };

    // Component Hooks.

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

    useEffect(() => {
        if (selectedOrderDeliveryAddressFormState) {
            let { id, address_info_id, country, ...restAddressData } = user?.addresses?.filter(address => address?.id === selectedOrderDeliveryAddressFormState)?.[0];
            setOrderDeliveryAddressState({ id, address_info_id, country, ...restAddressData });
            setAddressFormState({
                ...addressFormState,
                values: { ...addressFormState?.values, ...(country ? { country } : { country: ADDRESS_COUNTRY_NAME }), ...restAddressData }
            });
        }
        return () => false;
    }, [user?.addresses]);

    useEffect(() => {
        if (selectedOrderDeliveryAddressFormState) {
            let { id, address_info_id, country, ...resetAddressData } = user?.addresses?.filter(address => address?.id === selectedOrderDeliveryAddressFormState)?.[0];
            updateAddressData({ id: selectedOrderDeliveryAddressFormState }, { ...resetAddressData, default: true });
        }
        return () => false;
    }, [selectedOrderDeliveryAddressFormState]);

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

    const orderDeliveryAddressFormik = useFormik({
        validateOnBlur: false,
        enableReinitialize: true,
        initialValues: { ...addressFormState?.values },
        validationSchema: object().shape({
            name: string().required("name is required field."),
            email: string()
                .email("email is invalid")
                .required("email is required field."),
            phone: string().required("phone is required field."),
            title: string().required("title is required field."),
            street_address: string().required("street address is required field."),
            area: string().required("area is required field."),
            country: string().required("country is required field."),
            city: string().required("city is required field."),
            postal_code: string().required("postcode is required field.")
        }),
        onSubmit: async (values, { setSubmitting, setErrors, resetForm }) => {
            const [addressUpdateErrors, addressUpdateResponse] = await to(AddressService.update({ id: orderDeliveryAddressState?.id }, values));
            if (addressUpdateErrors) {
                const {
                    response: {
                        data: { errors }
                    }
                } = addressUpdateErrors;
                setErrors(errors);
                setSubmitting(false);
                return;
            }
            const {
                data: { message }
            } = addressUpdateResponse;
            setSubmitting(false);
            resetForm();
            getUserData();
            setAddressFormState({ ...addressFormState, ...initialAddressFormState });
            setOrderDeliveryAddressFormCollapseState(false);
            if (message) onAddFlashMessage({ type: "success", message });
        }
    });
    const additionalFormik = useFormik({
        validateOnBlur: false,
        enableReinitialize: true,
        initialValues: { ...defaultAdditionalFormState?.values },
        validationSchema: object().shape({
            additional: array(
                object().shape({
                    question: string().required(`question is required field.`),
                    answer: string().required(`answer is required field.`)
                })
            )
                .min(cartState?.questions?.length, "all additional must have answered")
                .required("additional is required")
        }),
        onSubmit: async (values, { setSubmitting, setErrors }) => {
            const [additionalErrors, additionalResponse] = await to(CartService.setAdditional(values));
            if (additionalErrors) {
                const {
                    response: {
                        data: { errors }
                    }
                } = additionalErrors;
                setErrors(errors);
                setSubmitting(false);
                return;
            }
            const {
                data: { message }
            } = additionalResponse;
            setSubmitting(false);
            push("/payment");
            if (message) onAddFlashMessage({ type: "success", message });
        }
    });

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
                                                    <Nav.Link as={NavLink} to="/shipping" className="text-capitalize pb-4">
                                                        shipping
                                                    </Nav.Link>
                                                </Nav.Item>
                                                <Nav.Item as="li">
                                                    <Nav.Link as={NavLink} to="/payment" className="text-capitalize pb-4">
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
                                                    <Col xs={{ span: 12 }} md={{ span: 6 }} className="border-right-0 border-md-right mb-gutter mb-md-0">
                                                        <Row>
                                                            <Col xs={{ span: 12 }} md={{ span: 11 }}>
                                                                <Row>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <section>
                                                                            <Row>
                                                                                <Col xs={{ span: 12 }} className="mb-3">
                                                                                    <h2 className="h5 text-capitalize">shipping information</h2>
                                                                                </Col>
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <Form noValidate>
                                                                                        <Form.Row>
                                                                                            <Col xs={{ span: 12 }}>
                                                                                                <Form.Group controlId="orderShippingAddress" className="mb-0">
                                                                                                    <Form.Label className="text-capitalize text-dark">select delivery address</Form.Label>
                                                                                                    <Form.Control
                                                                                                        name="address_id"
                                                                                                        as="select"
                                                                                                        size="sm"
                                                                                                        className="mt-0 text-truncate overflow-hidden rounded-lg"
                                                                                                        onChange={e => setSelectedOrderDeliveryAddressFormState(e.target.value)}
                                                                                                        value={selectedOrderDeliveryAddressFormState || ""}
                                                                                                        custom
                                                                                                    >
                                                                                                        <option value="">-select address-</option>
                                                                                                        {user?.addresses?.map(address => (
                                                                                                            <option value={address?.id} key={address?.id}>
                                                                                                                {address?.name}
                                                                                                            </option>
                                                                                                        ))}
                                                                                                    </Form.Control>
                                                                                                </Form.Group>
                                                                                            </Col>
                                                                                        </Form.Row>
                                                                                    </Form>
                                                                                </Col>
                                                                            </Row>
                                                                        </section>
                                                                        {orderDeliveryAddressState?.id ? (
                                                                            <>
                                                                                <section className="mt-gutter">
                                                                                    <Row>
                                                                                        <Col xs={{ span: 12 }} className="mb-3 d-flex align-items-center justify-content-between">
                                                                                            <h2 className="h5 text-capitalize">delivery address</h2>
                                                                                            <Button
                                                                                                size="sm"
                                                                                                variant="link"
                                                                                                className="d-flex align-items-center p-0 text-decoration-none"
                                                                                                onClick={() => setOrderDeliveryAddressFormCollapseState(true)}
                                                                                            >
                                                                                                Edit
                                                                                                <span className="mdi mdi-pencil mdi-20px ml-2" aria-hidden="true"></span>
                                                                                            </Button>
                                                                                        </Col>
                                                                                        <Collapse in={!orderDeliveryAddressFormCollapseState}>
                                                                                            <Col xs={{ span: 12 }}>
                                                                                                <Card className="border-0">
                                                                                                    <Card.Body className="p-0">
                                                                                                        <Row noGutters>
                                                                                                            <Col xs={{ span: 12 }}>
                                                                                                                <h4 className="text-capitalize h6 text-primary">
                                                                                                                    <span>{orderDeliveryAddressState?.title}</span>
                                                                                                                </h4>
                                                                                                            </Col>
                                                                                                            <Col xs={{ span: 12 }}>
                                                                                                                <p className="text-dark">
                                                                                                                    {orderDeliveryAddressState?.street_address}
                                                                                                                    {"\n"}
                                                                                                                    {orderDeliveryAddressState?.area},{"\n"}
                                                                                                                    {orderDeliveryAddressState?.city} {orderDeliveryAddressState?.postal_code}
                                                                                                                </p>
                                                                                                                <p className="small text-dark">
                                                                                                                    You have chooses standard standard shipping method for delivery.
                                                                                                                </p>
                                                                                                            </Col>
                                                                                                        </Row>
                                                                                                    </Card.Body>
                                                                                                </Card>
                                                                                            </Col>
                                                                                        </Collapse>
                                                                                        <Collapse in={orderDeliveryAddressFormCollapseState}>
                                                                                            <Col xs={{ span: 12 }}>
                                                                                                <Button
                                                                                                    size="sm"
                                                                                                    variant="link"
                                                                                                    className="text-secondary text-decoration-none float-right p-0"
                                                                                                    onClick={() => setOrderDeliveryAddressFormCollapseState(false)}
                                                                                                >
                                                                                                    <div className="mdi mdi-close mdi-18px" aria-hidden="true"></div>
                                                                                                </Button>
                                                                                                <Row>
                                                                                                    <Col xs={{ span: 12 }}>
                                                                                                        <Form onSubmit={orderDeliveryAddressFormik.handleSubmit} noValidate>
                                                                                                            <Form.Row>
                                                                                                                <Col xs={{ span: 12 }}>
                                                                                                                    <Form.Row>
                                                                                                                        <Col xs={{ span: 12 }}>
                                                                                                                            <Form.Group controlId="addressStreetAddress">
                                                                                                                                <Form.Label className="text-capitalize font-weight-light">
                                                                                                                                    street address
                                                                                                                                    <span className="text-danger">*</span>
                                                                                                                                </Form.Label>
                                                                                                                                <Form.Control
                                                                                                                                    onChange={orderDeliveryAddressFormik.handleChange}
                                                                                                                                    onBlur={orderDeliveryAddressFormik.handleBlur}
                                                                                                                                    value={orderDeliveryAddressFormik?.values?.street_address}
                                                                                                                                    isInvalid={
                                                                                                                                        !!orderDeliveryAddressFormik?.touched?.street_address &&
                                                                                                                                        !!orderDeliveryAddressFormik?.errors?.street_address
                                                                                                                                    }
                                                                                                                                    isValid={
                                                                                                                                        orderDeliveryAddressFormik?.values?.street_address &&
                                                                                                                                        !!orderDeliveryAddressFormik?.touched?.street_address &&
                                                                                                                                        !!!orderDeliveryAddressFormik?.errors?.street_address
                                                                                                                                    }
                                                                                                                                    name="street_address"
                                                                                                                                    type="text"
                                                                                                                                    className="rounded-lg"
                                                                                                                                    placeholder="Street address"
                                                                                                                                    autoComplete="street-address"
                                                                                                                                />
                                                                                                                                {!!orderDeliveryAddressFormik?.touched?.street_address &&
                                                                                                                                    !!orderDeliveryAddressFormik?.errors?.street_address && (
                                                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                                                            {orderDeliveryAddressFormik.errors.street_address}
                                                                                                                                        </Form.Control.Feedback>
                                                                                                                                    )}
                                                                                                                            </Form.Group>
                                                                                                                        </Col>
                                                                                                                        <Col xs={{ span: 12 }} md={{ span: 4 }}>
                                                                                                                            <Form.Group controlId="addressArea">
                                                                                                                                <Form.Label className="text-capitalize font-weight-light">
                                                                                                                                    Suburb
                                                                                                                                    <span className="text-danger">*</span>
                                                                                                                                </Form.Label>
                                                                                                                                <Form.Control
                                                                                                                                    onChange={orderDeliveryAddressFormik.handleChange}
                                                                                                                                    onBlur={orderDeliveryAddressFormik.handleBlur}
                                                                                                                                    value={orderDeliveryAddressFormik?.values?.area}
                                                                                                                                    isInvalid={
                                                                                                                                        !!orderDeliveryAddressFormik?.touched?.area &&
                                                                                                                                        !!orderDeliveryAddressFormik?.errors?.area
                                                                                                                                    }
                                                                                                                                    isValid={
                                                                                                                                        orderDeliveryAddressFormik?.values?.area &&
                                                                                                                                        !!orderDeliveryAddressFormik?.touched?.area &&
                                                                                                                                        !!!orderDeliveryAddressFormik?.errors?.area
                                                                                                                                    }
                                                                                                                                    name="area"
                                                                                                                                    type="text"
                                                                                                                                    className="rounded-lg"
                                                                                                                                    placeholder="Enter suburb"
                                                                                                                                    autoComplete="address-level2"
                                                                                                                                />
                                                                                                                                {!!orderDeliveryAddressFormik?.touched?.area &&
                                                                                                                                    !!orderDeliveryAddressFormik?.errors?.area && (
                                                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                                                            {orderDeliveryAddressFormik.errors.area}
                                                                                                                                        </Form.Control.Feedback>
                                                                                                                                    )}
                                                                                                                            </Form.Group>
                                                                                                                        </Col>
                                                                                                                        <Col xs={{ span: 12 }} md={{ span: 4 }}>
                                                                                                                            <Form.Group controlId="addressCity">
                                                                                                                                <Form.Label className="text-capitalize font-weight-light">
                                                                                                                                    Town/City
                                                                                                                                    <span className="text-danger">*</span>
                                                                                                                                </Form.Label>
                                                                                                                                <Form.Control
                                                                                                                                    onChange={orderDeliveryAddressFormik.handleChange}
                                                                                                                                    onBlur={orderDeliveryAddressFormik.handleBlur}
                                                                                                                                    value={orderDeliveryAddressFormik?.values?.city}
                                                                                                                                    isInvalid={
                                                                                                                                        !!orderDeliveryAddressFormik?.touched?.city &&
                                                                                                                                        !!orderDeliveryAddressFormik?.errors?.city
                                                                                                                                    }
                                                                                                                                    isValid={
                                                                                                                                        orderDeliveryAddressFormik?.values?.city &&
                                                                                                                                        !!orderDeliveryAddressFormik?.touched?.city &&
                                                                                                                                        !!!orderDeliveryAddressFormik?.errors?.city
                                                                                                                                    }
                                                                                                                                    name="city"
                                                                                                                                    className="rounded-lg"
                                                                                                                                    placeholder="Town/City name"
                                                                                                                                    autoComplete="address-level1"
                                                                                                                                />
                                                                                                                                {!!orderDeliveryAddressFormik?.touched?.city &&
                                                                                                                                    !!orderDeliveryAddressFormik?.errors?.city && (
                                                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                                                            {orderDeliveryAddressFormik.errors.city}
                                                                                                                                        </Form.Control.Feedback>
                                                                                                                                    )}
                                                                                                                            </Form.Group>
                                                                                                                        </Col>
                                                                                                                        <Col xs={{ span: 12 }} md={{ span: 4 }}>
                                                                                                                            <Form.Group controlId="addressPostalCode">
                                                                                                                                <Form.Label className="text-capitalize font-weight-light">
                                                                                                                                    PostCode
                                                                                                                                    <span className="text-danger">*</span>
                                                                                                                                </Form.Label>
                                                                                                                                <Form.Control
                                                                                                                                    onChange={orderDeliveryAddressFormik.handleChange}
                                                                                                                                    onBlur={orderDeliveryAddressFormik.handleBlur}
                                                                                                                                    value={orderDeliveryAddressFormik?.values?.postal_code}
                                                                                                                                    isInvalid={
                                                                                                                                        !!orderDeliveryAddressFormik?.touched?.postal_code &&
                                                                                                                                        !!orderDeliveryAddressFormik?.errors?.postal_code
                                                                                                                                    }
                                                                                                                                    isValid={
                                                                                                                                        orderDeliveryAddressFormik?.values?.postal_code &&
                                                                                                                                        !!orderDeliveryAddressFormik?.touched?.postal_code &&
                                                                                                                                        !!!orderDeliveryAddressFormik?.errors?.postal_code
                                                                                                                                    }
                                                                                                                                    name="postal_code"
                                                                                                                                    type="text"
                                                                                                                                    className="rounded-lg"
                                                                                                                                    placeholder="Enter postcode"
                                                                                                                                    autoComplete="postal-code"
                                                                                                                                />
                                                                                                                                {!!orderDeliveryAddressFormik?.touched?.postal_code &&
                                                                                                                                    !!orderDeliveryAddressFormik?.errors?.postal_code && (
                                                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                                                            {orderDeliveryAddressFormik.errors.postal_code}
                                                                                                                                        </Form.Control.Feedback>
                                                                                                                                    )}
                                                                                                                            </Form.Group>
                                                                                                                        </Col>
                                                                                                                    </Form.Row>
                                                                                                                </Col>
                                                                                                                <Col xs={{ span: 12 }}>
                                                                                                                    <Row>
                                                                                                                        <Col>
                                                                                                                            <Button
                                                                                                                                variant="outline-primary"
                                                                                                                                block
                                                                                                                                className="rounded-lg text-capitalize"
                                                                                                                                disabled={!orderDeliveryAddressFormik.isValid}
                                                                                                                                onClick={() => setOrderDeliveryAddressFormCollapseState(false)}
                                                                                                                            >
                                                                                                                                cancel
                                                                                                                            </Button>
                                                                                                                        </Col>
                                                                                                                        <Col>
                                                                                                                            <Button
                                                                                                                                type="submit"
                                                                                                                                variant="primary"
                                                                                                                                block
                                                                                                                                className="rounded-lg text-capitalize"
                                                                                                                                disabled={!orderDeliveryAddressFormik.isValid}
                                                                                                                            >
                                                                                                                                {orderDeliveryAddressFormik.isSubmitting ? (
                                                                                                                                    <Spinner animation="border" size="sm" />
                                                                                                                                ) : (
                                                                                                                                    "update address"
                                                                                                                                )}
                                                                                                                            </Button>
                                                                                                                        </Col>
                                                                                                                    </Row>
                                                                                                                </Col>
                                                                                                            </Form.Row>
                                                                                                        </Form>
                                                                                                    </Col>
                                                                                                </Row>
                                                                                            </Col>
                                                                                        </Collapse>
                                                                                    </Row>
                                                                                </section>
                                                                            </>
                                                                        ) : (
                                                                            <></>
                                                                        )}
                                                                    </Col>
                                                                    {cartState?.questions?.length ? (
                                                                        <Col xs={{ span: 12 }} className="mt-gutter">
                                                                            <section>
                                                                                <Row>
                                                                                    <Col xs={{ span: 12 }} className="mb-3">
                                                                                        <h2 className="h5 text-capitalize">Additional information</h2>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <Form
                                                                                            noValidate
                                                                                            onSubmit={e => {
                                                                                                e.preventDefault();
                                                                                                return !cartState?.questions?.length ? push("/payment") : additionalFormik.submitForm();
                                                                                            }}
                                                                                        >
                                                                                            {cartState.questions?.map((question, i) => (
                                                                                                <Form.Row className={cartState?.questions?.length > i + 1 ? "mb-3" : ""} key={question?.question}>
                                                                                                    <Col xs={{ span: 12 }}>
                                                                                                        {typeof question?.answers === "string" ? (
                                                                                                            <Form.Group controlId={`orderShippingAddress-${i}`} className="mb-0">
                                                                                                                <Form.Label className="text-capitalize text-dark">{question?.question}</Form.Label>
                                                                                                                <Form.Control
                                                                                                                    name={`additional[${i}]`}
                                                                                                                    type="text"
                                                                                                                    size="sm"
                                                                                                                    className="mt-0 text-truncate overflow-hidden rounded-lg"
                                                                                                                    onChange={e =>
                                                                                                                        setDefaultAdditionalFormState({
                                                                                                                            ...defaultAdditionalFormState,
                                                                                                                            values: {
                                                                                                                                ...defaultAdditionalFormState?.values,
                                                                                                                                additional: Object.assign(
                                                                                                                                    [],
                                                                                                                                    defaultAdditionalFormState?.values?.additional,
                                                                                                                                    {
                                                                                                                                        [i]: {
                                                                                                                                            question: question.question,
                                                                                                                                            answer: e.target.value
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                )
                                                                                                                            }
                                                                                                                        })
                                                                                                                    }
                                                                                                                    value={additionalFormik?.values?.additional?.[`${i}`]?.answer || ""}
                                                                                                                    isInvalid={
                                                                                                                        (!!additionalFormik?.errors?.additional?.[i]?.answer &&
                                                                                                                            !!additionalFormik?.touched?.additional?.[i]?.answer) ||
                                                                                                                        (typeof additionalFormik?.errors?.additional === "string" &&
                                                                                                                            !!additionalFormik?.errors?.additional &&
                                                                                                                            !additionalFormik?.touched?.additional?.[i]?.answer)
                                                                                                                    }
                                                                                                                    isValid={
                                                                                                                        additionalFormik?.values?.additional?.[i]?.answer &&
                                                                                                                        !!additionalFormik?.touched?.additional?.[i]?.answer &&
                                                                                                                        !!!additionalFormik?.errors?.additional?.[i]?.answer
                                                                                                                    }
                                                                                                                />
                                                                                                                {!!additionalFormik?.errors?.additional?.[i]?.answer &&
                                                                                                                    !!additionalFormik?.touched?.additional?.[i]?.answer && (
                                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                                            {additionalFormik.errors?.additional?.[i]?.answer}
                                                                                                                        </Form.Control.Feedback>
                                                                                                                    )}
                                                                                                                {typeof additionalFormik?.errors?.additional === "string" &&
                                                                                                                    !!additionalFormik?.errors?.additional &&
                                                                                                                    !additionalFormik?.touched?.additional?.[i]?.answer && (
                                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                                            {additionalFormik.errors?.additional}
                                                                                                                        </Form.Control.Feedback>
                                                                                                                    )}
                                                                                                            </Form.Group>
                                                                                                        ) : (
                                                                                                            <Form.Group controlId={`orderShippingAddress-${i}`} className="mb-0">
                                                                                                                <Form.Label className="text-capitalize text-dark">{question?.question}</Form.Label>
                                                                                                                <Form.Control
                                                                                                                    name={`additional[${i}]`}
                                                                                                                    as="select"
                                                                                                                    size="sm"
                                                                                                                    className="mt-0 text-truncate overflow-hidden rounded-lg"
                                                                                                                    onChange={e => {
                                                                                                                        setDefaultAdditionalFormState({
                                                                                                                            ...defaultAdditionalFormState,
                                                                                                                            values: {
                                                                                                                                ...defaultAdditionalFormState?.values,
                                                                                                                                additional: Object.assign(
                                                                                                                                    [],
                                                                                                                                    defaultAdditionalFormState?.values?.additional,
                                                                                                                                    {
                                                                                                                                        [i]: {
                                                                                                                                            question: question.question,
                                                                                                                                            answer: e.target.value
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                )
                                                                                                                            }
                                                                                                                        });
                                                                                                                    }}
                                                                                                                    value={additionalFormik?.values?.additional?.[`${i}`]?.answer || ""}
                                                                                                                    isInvalid={
                                                                                                                        (!!additionalFormik?.errors?.additional?.[i]?.answer &&
                                                                                                                            !!additionalFormik?.touched?.additional?.[i]?.answer) ||
                                                                                                                        (typeof additionalFormik?.errors?.additional === "string" &&
                                                                                                                            !!additionalFormik?.errors?.additional &&
                                                                                                                            !additionalFormik?.touched?.additional?.[i]?.answer)
                                                                                                                    }
                                                                                                                    isValid={
                                                                                                                        additionalFormik?.values?.additional?.[i]?.answer &&
                                                                                                                        !!additionalFormik?.touched?.additional?.[i]?.answer &&
                                                                                                                        !!!additionalFormik?.errors?.additional?.[i]?.answer
                                                                                                                    }
                                                                                                                    custom
                                                                                                                >
                                                                                                                    <option value="" disabled>
                                                                                                                        -select an answer-
                                                                                                                    </option>
                                                                                                                    {question?.answers?.map((answer, i) => (
                                                                                                                        <option value={answer} key={`${answer}-${i}`}>
                                                                                                                            {answer}
                                                                                                                        </option>
                                                                                                                    ))}
                                                                                                                </Form.Control>
                                                                                                                {!!additionalFormik?.errors?.additional?.[i]?.answer &&
                                                                                                                    !!additionalFormik?.touched?.additional?.[i]?.answer && (
                                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                                            {additionalFormik.errors?.additional?.[i]?.answer}
                                                                                                                        </Form.Control.Feedback>
                                                                                                                    )}
                                                                                                                {typeof additionalFormik?.errors?.additional === "string" &&
                                                                                                                    !!additionalFormik?.errors?.additional &&
                                                                                                                    !additionalFormik?.touched?.additional?.[i]?.answer && (
                                                                                                                        <Form.Control.Feedback type="invalid">
                                                                                                                            {additionalFormik.errors?.additional}
                                                                                                                        </Form.Control.Feedback>
                                                                                                                    )}
                                                                                                            </Form.Group>
                                                                                                        )}
                                                                                                    </Col>
                                                                                                </Form.Row>
                                                                                            ))}
                                                                                        </Form>
                                                                                    </Col>
                                                                                </Row>
                                                                            </section>
                                                                        </Col>
                                                                    ) : (
                                                                        <></>
                                                                    )}
                                                                </Row>
                                                            </Col>
                                                        </Row>
                                                    </Col>
                                                    <Col xs={{ span: 12 }} md={{ span: 6 }}>
                                                        <Row>
                                                            <Col xs={{ span: 12 }} md={{ span: 11, offset: 1 }}>
                                                                <section>
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                            <h2 className="h5 text-capitalize">summary of your order</h2>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <Row as={ListGroup} variant="flush" noGutters>
                                                                                {cartState.items?.map(item => (
                                                                                    <Col key={item?.id} xs={{ span: 12 }} as={ListGroup.Item} className="py-3">
                                                                                        <div className="float-right">
                                                                                            <Button
                                                                                                variant="link"
                                                                                                size="sm"
                                                                                                className="text-danger text-decoration-none p-2"
                                                                                                disabled={disabledActionButtonState === item?.id}
                                                                                                onClick={e => removeFromCartClickHandler(e, item)}
                                                                                                block
                                                                                            >
                                                                                                <i className="mdi mdi-close mdi-18px" aria-hidden="true"></i>
                                                                                                <span className="sr-only">remove product</span>
                                                                                            </Button>
                                                                                        </div>
                                                                                        <Row noGutters>
                                                                                            <Col xs={{ span: 8 }}>
                                                                                                <Row>
                                                                                                    <Col xs={{ span: 3 }}>
                                                                                                        <div
                                                                                                            className="bg-light rounded-sm w-100 border border-secondary"
                                                                                                            style={{
                                                                                                                height: "75px",
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
                                                                                                    <Col xs={{ span: 9 }}>
                                                                                                        <h6 className="mb-2 font-weight-normal">
                                                                                                            <Link to={`/products/${item?.product?.slug}`} className="text-dark text-decoration-none">
                                                                                                                {item?.product?.title}
                                                                                                            </Link>
                                                                                                        </h6>
                                                                                                        {item?.variation_options?.map((option, i) => (
                                                                                                            <p
                                                                                                                key={option?.id}
                                                                                                                className={`text-secondary small ${
                                                                                                                    i < item?.variation_options?.length - 1 ? "mb-2" : "mb-0"
                                                                                                                }`}
                                                                                                            >
                                                                                                                {option?.value}
                                                                                                            </p>
                                                                                                        ))}
                                                                                                    </Col>
                                                                                                </Row>
                                                                                            </Col>
                                                                                            <Col xs={{ span: 4 }}>
                                                                                                <Row>
                                                                                                    <Col xs={{ span: 12 }} className="mb-3 mt-2">
                                                                                                        <p className="text-right mb-0">${item?.total}</p>
                                                                                                    </Col>
                                                                                                    <Col xs={{ span: 12 }}>
                                                                                                        <InputGroup size="sm">
                                                                                                            <InputGroup.Prepend>
                                                                                                                <Button
                                                                                                                    variant="outline-secondary"
                                                                                                                    className="rounded-left-lg py-0 shadow-none px-2"
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
                                                                                                                    className="rounded-right-lg py-0 shadow-none px-2"
                                                                                                                    disabled={disabledActionButtonState === item?.id}
                                                                                                                    onClick={e => onProductQuantityIncrementClickHandler(e, item)}
                                                                                                                >
                                                                                                                    <i className="mdi mdi-plus mdi-20px" aria-hidden="true"></i>
                                                                                                                    <span className="sr-only">increment quantity</span>
                                                                                                                </Button>
                                                                                                            </InputGroup.Append>
                                                                                                        </InputGroup>
                                                                                                    </Col>
                                                                                                </Row>
                                                                                            </Col>
                                                                                        </Row>
                                                                                    </Col>
                                                                                ))}
                                                                            </Row>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <hr className="mt-0" />
                                                                        </Col>
                                                                        {cartState?.shipping_method_id ? (
                                                                            <>
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <Row>
                                                                                        <Col xs>
                                                                                            <h2 className="h6 text-capitalize">shipping method</h2>
                                                                                        </Col>
                                                                                        <Col xs>
                                                                                            <p className="mb-0 text-right text-capitalize">{cartState?.totals?.shipping?.label}</p>
                                                                                        </Col>
                                                                                    </Row>
                                                                                </Col>
                                                                            </>
                                                                        ) : (
                                                                            <></>
                                                                        )}
                                                                        <Col xs={{ span: 12 }}>
                                                                            <Row>
                                                                                <Col xs={{ span: 12 }} className="mb-3 mt-md-3 d-flex justify-content-md-end">
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
                                                                                                                    You have <strong>{cartState?.points?.total_reward_points}</strong> reward points
                                                                                                                    worth of <strong>${cartState?.points?.total_reward_points_exchange}</strong>
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
                                                                                                            <p className="m-0 text-right h5 text-primary-dark">${cartState.totals.shipping.amount}</p>
                                                                                                        </Col>
                                                                                                    </Row>
                                                                                                </Col>
                                                                                            </>
                                                                                        ) : (
                                                                                            <></>
                                                                                        )}
                                                                                    </Row>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <hr className="my-4" />
                                                                        </Col>
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
                                                                                        <span className="d-none d-sm-inline">back to cart</span>
                                                                                        <span className="d-sm-none">back</span>
                                                                                    </Button>
                                                                                </Col>
                                                                                <Col xs={{ span: 7 }} sm={{ span: 7 }}>
                                                                                    <Button
                                                                                        variant="primary"
                                                                                        onClick={() => (!cartState?.questions?.length ? push("/payment") : additionalFormik.submitForm())}
                                                                                        className="text-capitalize rounded-lg d-flex align-items-center justify-content-center"
                                                                                        block
                                                                                    >
                                                                                        continue to payment
                                                                                        <i className="mdi mdi-arrow-right mdi-18px ml-2" aria-hidden="true"></i>
                                                                                    </Button>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                    </Row>
                                                                </section>
                                                            </Col>
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
    onChangeCart: payload => dispatch(actions.changeCart(payload)),
    onChangeUserState: payload => dispatch(actions.changeUserState(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(ShippingPage);
