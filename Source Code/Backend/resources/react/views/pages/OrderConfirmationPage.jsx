/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { NavLink, Link } from "react-router-dom";
import { Container, Row, Col, Card, CardGroup, Nav, Spinner, ListGroup } from "react-bootstrap";
import to from "await-to-js";
import qs from "qs";

import * as actions from "../../store/rootActions";
import OrderService from "../../services/OrderService";

import TrackOrderBadge from "../components/SVG/Badges/TrackOrderBadge";
import DeliveryTimeBadge from "../../assets/images/icons/delivery-time-badge.png";
import FAQsBadge from "../../assets/images/icons/FAQs-badge.png";

export const OrderConfirmationPage = props => {
    const {
        history: {
            location: { pathname, search },
            push
        },
        onAddFlashMessage
    } = props;

    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    // Component State.
    const initialQueryState = { ...queryParams };
    const initialOrderState = {};
    const initialOrderLoadingState = false;
    const [queryState, setQueryState] = useState(initialQueryState);
    const [orderState, setOrderState] = useState(initialOrderState);
    const [orderLoadingState, setOrderLoadingState] = useState(initialOrderLoadingState);

    // API Calls.
    const fetchSingleOrderData = async query => {
        console.log(`query`, query);
        const [singleOrderErrors, singleOrderResponse] = await to(OrderService.single(query));
        if (singleOrderErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = singleOrderErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setOrderLoadingState(false);
            return;
        }

        const { data: order } = singleOrderResponse;
        setOrderState({ ...order });
        setOrderLoadingState(false);
    };

    // Component Hooks.
    useEffect(() => {
        push({ pathname, search: `?${qs.stringify(queryState)}` });
        return () => false;
    }, [queryState]);

    useEffect(() => {
        setOrderLoadingState(true);
        fetchSingleOrderData(queryState);
        return () => false;
    }, [search]);

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
                                                    <Nav.Link as={NavLink} to="/shipping" disabled className="text-capitalize pb-4">
                                                        shipping
                                                    </Nav.Link>
                                                </Nav.Item>
                                                <Nav.Item as="li">
                                                    <Nav.Link as={NavLink} to="/payment" disabled className="text-capitalize pb-4">
                                                        payment
                                                    </Nav.Link>
                                                </Nav.Item>
                                                <Nav.Item as="li">
                                                    <Nav.Link as={NavLink} to="/orders/confirmation" className="text-capitalize pb-4">
                                                        done
                                                    </Nav.Link>
                                                </Nav.Item>
                                            </Nav>
                                        </nav>
                                    </Col>
                                    <Col xs={{ span: 12 }}>
                                        <Row>
                                            {orderLoadingState ? (
                                                <>
                                                    <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                                        <Spinner animation="border" variant="primary" />
                                                    </Col>
                                                </>
                                            ) : (
                                                <>
                                                    <Col xs={{ span: 12 }} md={{ span: 6 }} className="mb-gutter mb-md-0">
                                                        <section>
                                                            <Row>
                                                                <Col xs={{ span: 12 }}>
                                                                    <div className="float-left">
                                                                        <div className="bg-primary text-white p-3 rounded-circle">
                                                                            <span className="mdi mdi-check mdi-34px" aria-hidden="true"></span>
                                                                        </div>
                                                                    </div>
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h2 className="h4 mb-0">Thank you for shipping with us!</h2>
                                                                            <h3 className="h6 text-secondary">Your payment was successful!</h3>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} className="mt-4">
                                                                            <p className="mb-0">
                                                                                <strong className="text-capitalize text-dark">your order ID:</strong> #{orderState?.short_id}
                                                                            </p>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }} className="mt-4">
                                                                            <Row>
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <h3 className="h5 text-capitalize">delivery address</h3>
                                                                                </Col>
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <Card className="border-0">
                                                                                        <Card.Body className="p-0">
                                                                                            <p className="text-dark">
                                                                                                {orderState?.address?.street_address}
                                                                                                {"\n"}
                                                                                                {orderState?.address?.area},{"\n"}
                                                                                                {orderState?.address?.city} {orderState?.address?.postal_code}
                                                                                            </p>
                                                                                            <p className="small text-dark">You have chooses standard standard shipping method for delivery.</p>
                                                                                        </Card.Body>
                                                                                    </Card>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                    </Row>
                                                                </Col>
                                                            </Row>
                                                        </section>
                                                    </Col>
                                                    <Col xs={{ span: 12 }} md={{ span: 6 }}>
                                                        <section className="bg-light rounded-lg p-md-5 p-4">
                                                            <Row>
                                                                <Col xs={{ span: 12 }}>
                                                                    <h3 className="h6 text-capitalize mb-4">your order summary</h3>
                                                                </Col>
                                                                <Col xs={{ span: 12 }}>
                                                                    <Row as={ListGroup} variant="flush" noGutters>
                                                                        {orderState?.products?.map(item => (
                                                                            <Col key={item?.id} xs={{ span: 12 }} as={ListGroup.Item} className="py-3 bg-transparent">
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
                                                                                                        className={`text-secondary small ${i < item?.variation_options?.length - 1 ? "mb-2" : "mb-0"}`}
                                                                                                    >
                                                                                                        {option?.value}
                                                                                                    </p>
                                                                                                ))}
                                                                                                <p className="text-secondary small mt-2">qyt: {item?.quantity}</p>
                                                                                            </Col>
                                                                                        </Row>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 4 }}>
                                                                                        <Row>
                                                                                            <Col xs={{ span: 12 }} className="mb-3 mt-2">
                                                                                                <p className="text-right mb-0">share on:</p>
                                                                                            </Col>
                                                                                            <Col xs={{ span: 12 }}>
                                                                                                <ul className="list-inline mb-0 text-right">
                                                                                                    <li className="list-inline-item">
                                                                                                        <a
                                                                                                            href="/"
                                                                                                            target="_blank"
                                                                                                            className="text-body"
                                                                                                            rel="noopener noreferrer"
                                                                                                            alt="share on facebook"
                                                                                                            aria-label="facebook link"
                                                                                                        >
                                                                                                            <i className="fab fa-facebook-f" aria-hidden="true"></i>
                                                                                                        </a>
                                                                                                    </li>
                                                                                                    <li className="list-inline-item">
                                                                                                        <a
                                                                                                            href="/"
                                                                                                            target="_blank"
                                                                                                            className="text-body"
                                                                                                            rel="noopener noreferrer"
                                                                                                            alt="share on instagram"
                                                                                                            aria-label="instagram link"
                                                                                                        >
                                                                                                            <i className="fab fa-instagram" aria-hidden="true"></i>
                                                                                                        </a>
                                                                                                    </li>
                                                                                                    <li className="list-inline-item">
                                                                                                        <a
                                                                                                            href="/"
                                                                                                            target="_blank"
                                                                                                            className="text-body"
                                                                                                            rel="noopener noreferrer"
                                                                                                            alt="share on twitter"
                                                                                                            aria-label="twitter link"
                                                                                                        >
                                                                                                            <i className="fab fa-twitter" aria-hidden="true"></i>
                                                                                                        </a>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </Col>
                                                                                        </Row>
                                                                                    </Col>
                                                                                </Row>
                                                                            </Col>
                                                                        ))}
                                                                    </Row>
                                                                </Col>
                                                            </Row>
                                                        </section>
                                                    </Col>
                                                    <Col xs={{ span: 12 }} className="mt-gutter">
                                                        <CardGroup>
                                                            <Card className="rounded-lg">
                                                                <Card.Body className="p-5">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                            <Row>
                                                                                <Col xs={{ span: 4 }} md={{ span: 3 }}>
                                                                                    <div className="text-primary d-flex align-items-center" style={{ height: "60px", width: "auto" }}>
                                                                                        <TrackOrderBadge />
                                                                                    </div>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h3 className="h5 text-capitalize">track your order</h3>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <p className="mb-0 small text-secondary">
                                                                                To track your existing order(s), please login to your account, click{" "}
                                                                                <Link to="/login" className="text-capitalize text-decoration-none">
                                                                                    my account
                                                                                </Link>{" "}
                                                                                then{" "}
                                                                                <Link to="/orders" className="text-capitalize text-decoration-none">
                                                                                    order history
                                                                                </Link>
                                                                            </p>
                                                                        </Col>
                                                                    </Row>
                                                                </Card.Body>
                                                            </Card>
                                                            <Card className="rounded-lg">
                                                                <Card.Body className="p-5">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                            <Row>
                                                                                <Col xs={{ span: 4 }} md={{ span: 3 }}>
                                                                                    <div style={{ height: "60px", width: "auto" }}>
                                                                                        <img src={DeliveryTimeBadge} alt="" role="presentation" />
                                                                                    </div>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h3 className="h5 text-capitalize">estimation delivery time</h3>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <p className="mb-0 small text-secondary">
                                                                                items will generally be dispatched within 24 hours once payment has been received (unless specified). Regular Australian
                                                                                post or Courier (AAE, TIG & e-parcel) delivery times apply, we will notify you via email after each item has been sent.
                                                                            </p>
                                                                        </Col>
                                                                    </Row>
                                                                </Card.Body>
                                                            </Card>
                                                            <Card className="rounded-lg">
                                                                <Card.Body className="p-5">
                                                                    <Row>
                                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                                            <Row>
                                                                                <Col xs={{ span: 4 }} md={{ span: 3 }}>
                                                                                    <div style={{ height: "60px", width: "auto" }}>
                                                                                        <img src={FAQsBadge} alt="" role="presentation" />
                                                                                    </div>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <h3 className="h5 text-capitalize">any questions?</h3>
                                                                        </Col>
                                                                        <Col xs={{ span: 12 }}>
                                                                            <p className="mb-0 small text-secondary">
                                                                                please visit our{" "}
                                                                                <Link to="/" className="text-decoration-none">
                                                                                    FAQs
                                                                                </Link>{" "}
                                                                                page if you have any questions or problems. alternatively, if you can't find the answer to your question(s) please{" "}
                                                                                <Link to="/" className="text-decoration-none">
                                                                                    contact us
                                                                                </Link>
                                                                                .
                                                                            </p>
                                                                        </Col>
                                                                    </Row>
                                                                </Card.Body>
                                                            </Card>
                                                        </CardGroup>
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
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(OrderConfirmationPage);
