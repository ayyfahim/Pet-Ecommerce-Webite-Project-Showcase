/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { NavLink, Link } from "react-router-dom";
import { Container, Row, Col, Button, Nav, Spinner, ListGroup } from "react-bootstrap";
import { loadStripe } from "@stripe/stripe-js";
import to from "await-to-js";
import qs from "qs";

import * as actions from "../../store/rootActions";
import OrderService from "../../services/OrderService";
import CartService from "../../services/CartService";

// Make sure to call `loadStripe` outside of a component’s render to avoid
// recreating the `Stripe` object on every render.
const stripePromise = loadStripe("pk_test_51IlGkSFgFZr4eSNRtSCaCi71wXVcRE99R7f2b6Jnvsour34P9J4QDq0EndR5bJckKakQE3EtiUYi4oex1UPSJXIp00EzROMA2Z");

export const PaymentPage = props => {
    const {
        history: {
            location: { pathname, search },
            push
        },
        cart,
        auth: { user },
        onAddFlashMessage,
        onChangeCart
    } = props;

    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    // Component State.
    const initialQueryState = { ...queryParams };
    const initialCartState = {};
    const initialOrderFormState = {
        isFormLoading: false,
        values: {
            address_info_id: "",
            payment_method_id: 18, // FIXME: remove static number from here after adding payment method to the system
            shipping_method_id: ""
        },
        errors: {}
    };
    const initialPaymentStripeSessionIdState = "";
    const initialCartLoadingState = false;
    const [queryState, setQueryState] = useState(initialQueryState);
    const [orderFormState, setOrderFormState] = useState(initialOrderFormState);
    const [cartState, setCartState] = useState(initialCartState);
    const [cartLoadingState, setCartLoadingState] = useState(initialCartLoadingState);
    const [paymentStripeSessionIdState, setPaymentStripeSessionIdState] = useState(initialPaymentStripeSessionIdState);

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
        setCartLoadingState(false);
        if (cb && typeof cb === "function") cb();
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
        setOrderFormState({
            ...orderFormState,
            values: {
                ...orderFormState?.values,
                address_info_id: user?.addresses?.filter(address => Boolean(address?.default))[0]?.address_info_id,
                shipping_method_id: cart?.shipping_method_id
            }
        });
        return () => false;
    }, [cart?.shipping_method_id, user?.addresses]);

    useEffect(() => {
        setCartState({ ...cartState, ...cart });
        return () => false;
    }, [cart]);

    useEffect(() => {
        (async () => {
            if (paymentStripeSessionIdState) {
                const stripe = await stripePromise;
                await stripe.redirectToCheckout({ sessionId: paymentStripeSessionIdState });
            }
        })();
        return () => false;
    }, [paymentStripeSessionIdState]);

    // Event Handlers.
    const onCreateOrderButtonClickHandler = async e => {
        setOrderFormState({ ...orderFormState, isFormLoading: true });
        const [createOrderErrors, createOrderResponse] = await to(OrderService.store(orderFormState?.values));
        if (createOrderErrors) {
            const {
                response: {
                    data: { errors, error, message }
                }
            } = createOrderErrors;

            setOrderFormState({ ...orderFormState, errors, isFormLoading: false });
            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            return;
        }

        const {
            data: { session_id, message }
        } = createOrderResponse;

        setPaymentStripeSessionIdState(session_id);
        setOrderFormState({ ...orderFormState, ...initialOrderFormState });
        if (message) onAddFlashMessage({ type: "success", message });
        // push(`/orders/confirmation?orderId=${order?.id}`);
    };

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
                                                                <section>
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                            <h2 className="h5 text-capitalize">summary of your order</h2>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <Row as={ListGroup} variant="flush" noGutters>
                                                                                {cartState.items?.map(item => (
                                                                                    <Col key={item?.id} xs={{ span: 12 }} as={ListGroup.Item} className="py-3">
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
                                                                                <Col xs={{ span: 12 }} className="mb-3">
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
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <Row>
                                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                                            <Row className="align-items-center">
                                                                                                <Col xs={{ span: 9 }}>
                                                                                                    <p className="m-0">
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
                                                                                                            <p className="m-0">
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
                                                                                                            <p className="m-0">
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
                                                                                                            <p className="m-0">
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
                                                                                                            <p className="m-0">
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
                                                                                    <p className="m-0">
                                                                                        <strong className="text-dark d-block text-capitalize">total cost</strong>
                                                                                    </p>
                                                                                </Col>
                                                                                <Col xs={{ span: 3 }}>
                                                                                    <p className="m-0 text-right h5 text-primary-dark">${cartState?.totals?.total}</p>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                    </Row>
                                                                </section>
                                                            </Col>
                                                        </Row>
                                                    </Col>
                                                    <Col xs={{ span: 12 }} md={{ span: 6 }}>
                                                        <Row>
                                                            <Col xs={{ span: 12 }} md={{ span: 11, offset: 1 }}>
                                                                <section>
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                            <h2 className="h5 text-capitalize">choose your payment method</h2>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} className="mb-5">
                                                                            <div className="bg-light p-4 rounded">
                                                                                <p className="mb-0">You will be redirected to payment page after clicking the button below</p>
                                                                            </div>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <Row>
                                                                                <Col xs={{ span: 5 }} sm={{ span: 5 }} className="mb-3 md-sm-0">
                                                                                    <Button
                                                                                        as={Link}
                                                                                        to="/shipping"
                                                                                        variant="outline-primary"
                                                                                        className="text-capitalize rounded-lg d-flex align-items-center justify-content-center"
                                                                                        disabled={orderFormState?.isFormLoading}
                                                                                        block
                                                                                    >
                                                                                        <i className="mdi mdi-arrow-left mdi-18px mr-2" aria-hidden="true"></i>
                                                                                        <span className="d-none d-sm-inline">back to shipping</span>
                                                                                        <span className="d-sm-none">back</span>
                                                                                    </Button>
                                                                                </Col>
                                                                                <Col xs={{ span: 7 }} sm={{ span: 7 }}>
                                                                                    <Button
                                                                                        variant="primary"
                                                                                        className="text-capitalize rounded-lg d-flex align-items-center justify-content-center"
                                                                                        disabled={orderFormState?.isFormLoading}
                                                                                        onClick={onCreateOrderButtonClickHandler}
                                                                                        block
                                                                                    >
                                                                                        {orderFormState?.isFormLoading ? (
                                                                                            <>
                                                                                                <Spinner animation="border" size="sm" />
                                                                                            </>
                                                                                        ) : (
                                                                                            <>
                                                                                                pay now
                                                                                                <i className="mdi mdi-arrow-right mdi-18px ml-2" aria-hidden="true"></i>
                                                                                            </>
                                                                                        )}
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
                                                <></>
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

export default connect(mapStateToProps, mapDispatchToProps)(PaymentPage);
