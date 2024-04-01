/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { Link, NavLink } from "react-router-dom";
import { Container, Row, Col, Spinner, Card, Table } from "react-bootstrap";
import qs from "qs";
import to from "await-to-js";
import moment from "moment";

import * as actions from "../../../store/rootActions";
import OrderService from "../../../services/OrderService";

import RootMenu from "../../sections/RootMenu";
import NoDataSection from "../../sections/NoDataSection";
import PaginationSection from "../../sections/PaginationSection";

export const DashboardOrderSummary = props => {
    const {
        pageTitle,
        history: {
            location: { pathname, search },
            push
        },
        onAddFlashMessage
    } = props;

    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    // Component State.
    const initialQueryState = { ...queryParams };
    const initialPaginationState = {};
    const initialOrdersState = [];
    const initialOrdersLoadingState = false;
    const [queryState, setQueryState] = useState(initialQueryState);
    const [paginationState, setPaginationState] = useState(initialPaginationState);
    const [ordersState, setOrdersState] = useState(initialOrdersState);
    const [ordersLoadingState, setOrdersLoadingState] = useState(initialOrdersLoadingState);

    // Api Calls.
    const fetchOrdersData = async query => {
        const [ordersErrors, ordersResponse] = await to(OrderService.listing(query));
        if (ordersErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = ordersErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setOrdersLoadingState(false);
            return;
        }
        const {
            data: {
                data: orders,
                meta: { pagination }
            }
        } = ordersResponse;

        setPaginationState({ ...pagination });
        setOrdersState([...orders]);
        setOrdersLoadingState(false);
    };

    // Component Hooks.
    useEffect(() => {
        push({ pathname, search: `?${qs.stringify(queryState)}` });
        return () => false;
    }, [queryState]);

    useEffect(() => {
        setOrdersLoadingState(true);
        fetchOrdersData(queryState);
        return () => false;
    }, [search]);

    // Event Handler.
    const onChangePaginationHandler = (e, page) => setQueryState({ ...queryState, page });

    return (
        <>
            <section className="section bg-white h-100">
                <Container fluid className="px-0">
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <Row noGutters>
                                <Col xs={{ span: 10, offset: 1 }} md={{ span: 4, offset: 0 }} lg={{ span: 3 }} className="mb-5 mb-md-0 border-right-0 border-md-right">
                                    <Row className="justify-content-end">
                                        <Col xs={{ span: 12 }} md={{ span: 9 }}>
                                            <RootMenu pageTitle={pageTitle} />
                                        </Col>
                                    </Row>
                                </Col>
                                <Col xs={{ span: 10, offset: 1 }} md={{ span: 8, offset: 0 }} lg>
                                    <article id="page-content">
                                        <section>
                                            <Row>
                                                <Col xs={{ span: 12 }} md={{ span: 10 }} xl={{ span: 10 }}>
                                                    <section className="py-5 pl-md-4 pl-0">
                                                        <Row className="mb-gutter align-items-center">
                                                            <Col xs={{ span: 12 }} sm>
                                                                <h2 className="h5 text-capitalize">order summary</h2>
                                                            </Col>
                                                        </Row>
                                                        <Row>
                                                            {ordersLoadingState ? (
                                                                <>
                                                                    <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                                                        <Spinner animation="border" variant="primary" />
                                                                    </Col>
                                                                </>
                                                            ) : ordersState?.length ? (
                                                                <>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <Card className="border rounded-lg">
                                                                            <Card.Header className="bg-dark rounded-top-lg px-3 py-0 d-none d-lg-block">
                                                                                <Table responsive borderless className="mb-0">
                                                                                    <thead>
                                                                                        <Row as="tr" noGutters className="align-items-center">
                                                                                            <Col as="th" xs className="px-1">
                                                                                                <p className="m-0 small text-capitalize text-white">
                                                                                                    <small>date</small>
                                                                                                </p>
                                                                                            </Col>
                                                                                            <Col as="th" xs className="px-1">
                                                                                                <p className="m-0 small text-capitalize text-white">
                                                                                                    <small>invoice id</small>
                                                                                                </p>
                                                                                            </Col>
                                                                                            <Col as="th" xs={{ span: 2 }} className="px-1">
                                                                                                <p className="m-0 small text-capitalize text-white">
                                                                                                    <small>deal name</small>
                                                                                                </p>
                                                                                            </Col>
                                                                                            <Col as="th" xs={{ span: 1 }} className="px-1">
                                                                                                <p className="m-0 small text-capitalize text-center text-white">
                                                                                                    <small>qty.</small>
                                                                                                </p>
                                                                                            </Col>
                                                                                            <Col as="th" xs className="px-1">
                                                                                                <p className="m-0 small text-capitalize text-white">
                                                                                                    <small>payment</small>
                                                                                                </p>
                                                                                            </Col>
                                                                                            <Col as="th" xs className="px-1">
                                                                                                <p className="m-0 small text-capitalize text-white">
                                                                                                    <small>order status</small>
                                                                                                </p>
                                                                                            </Col>
                                                                                            <Col as="th" xs className="px-1">
                                                                                                <p className="m-0 small text-capitalize text-white">
                                                                                                    <small>delivery date</small>
                                                                                                </p>
                                                                                            </Col>
                                                                                            <Col as="th" xs className="px-1">
                                                                                                <p className="m-0 small text-capitalize text-white">
                                                                                                    <small>tracking code</small>
                                                                                                </p>
                                                                                            </Col>
                                                                                        </Row>
                                                                                    </thead>
                                                                                </Table>
                                                                            </Card.Header>
                                                                            <Card.Body className="p-0">
                                                                                <Table responsive striped hover borderless className="mb-0 d-none d-lg-table">
                                                                                    <tbody>
                                                                                        {ordersState?.map((order, i) => (
                                                                                            <Row
                                                                                                as="tr"
                                                                                                key={order?.id}
                                                                                                noGutters
                                                                                                className={`px-3 align-items-center ${ordersState?.length - 1 <= i ? "rounded-bottom-lg" : ""}`}
                                                                                            >
                                                                                                <Col as="td" xs className="px-1">
                                                                                                    <p className="m-0 small text-uppercase">
                                                                                                        <small>{order?.created_at}</small>
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs className="px-1">
                                                                                                    <p className="m-0 small text-capitalize">
                                                                                                        <small>#{order?.short_id}</small>
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs={{ span: 2 }} className="px-1">
                                                                                                    <p className="m-0 small text-capitalize">
                                                                                                        {order?.products?.map(product => (
                                                                                                            <small>{product?.product?.title}</small>
                                                                                                        ))}
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs={{ span: 1 }} className="px-1">
                                                                                                    <p className="m-0 small text-capitalize text-center">
                                                                                                        {order?.products?.map(product => (
                                                                                                            <small>{product?.quantity}</small>
                                                                                                        ))}
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs className="px-1">
                                                                                                    <p className="m-0 small text-capitalize">
                                                                                                        <small>${order?.totals?.total}</small>
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs className="px-1">
                                                                                                    <p className={`m-0 small text-capitalize text-${order?.status?.color}`}>
                                                                                                        <small>{order?.status?.title}</small>
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs className="px-1">
                                                                                                    <p className="m-0 small text-uppercase">
                                                                                                        <small>-</small>
                                                                                                        {/* <small>8 DEC 2020</small> */}
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs className="px-1">
                                                                                                    <p className="m-0 small">
                                                                                                        <Link to="/">
                                                                                                            <small>EA125424NZ</small>
                                                                                                        </Link>
                                                                                                    </p>
                                                                                                </Col>
                                                                                            </Row>
                                                                                        ))}
                                                                                    </tbody>
                                                                                </Table>
                                                                                <Table striped borderless className="mb-0 d-lg-none">
                                                                                    <tbody>
                                                                                        {ordersState?.map((order, i) => (
                                                                                            <Row
                                                                                                as="tr"
                                                                                                key={order?.id}
                                                                                                noGutters
                                                                                                className={`p-3 ${ordersState?.length - 1 >= i ? "rounded-bottom-lg" : ""}`}
                                                                                            >
                                                                                                <Col as="td" xs={{ span: 6 }} className="py-2">
                                                                                                    <p className="mb-0 small">
                                                                                                        <span className="text-capitalize text-secondary">date:</span>
                                                                                                        <span className="text-uppercase ml-1">{moment(order?.created_at).format("D MMM YYYY")}</span>
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs={{ span: 6 }} className="py-2">
                                                                                                    <p className="mb-0 small text-right">
                                                                                                        <span className="text-uppercase text-secondary">ID:</span>
                                                                                                        <span className="text-uppercase ml-1">#{order?.short_id}</span>
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs={{ span: 6 }} className="py-2">
                                                                                                    <p className="mb-0">
                                                                                                        {order?.products?.map(product => (
                                                                                                            <span className="text-capitalize">{product?.product?.title}</span>
                                                                                                        ))}
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs={{ span: 6 }} className="py-2">
                                                                                                    <p className="mb-0 small text-right">
                                                                                                        <span className="text-capitalize text-secondary">amount:</span>
                                                                                                        <span className="text-uppercase ml-1">${order?.totals?.total}</span>
                                                                                                        <br />
                                                                                                        <span className="text-uppercase text-secondary">qty:</span>
                                                                                                        {order?.products?.map(product => (
                                                                                                            <span className="text-uppercase ml-1">{product?.quantity}</span>
                                                                                                        ))}
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs={{ span: 6 }} className="py-2">
                                                                                                    <p className="mb-0 small">
                                                                                                        <span className={`text-capitalize text-${order?.status?.color}`}>{order?.status?.title}</span>
                                                                                                        <br />
                                                                                                        {/* <span className="text-uppercase text-secondary">8 dec 2020</span> */}
                                                                                                        <span className="text-uppercase text-secondary">-</span>
                                                                                                    </p>
                                                                                                </Col>
                                                                                                <Col as="td" xs={{ span: 6 }} className="py-2">
                                                                                                    <p className="mb-0 small text-right">
                                                                                                        <span className="text-capitalize text-secondary">tracking orders:</span>
                                                                                                        <br />
                                                                                                        <Link to="/">
                                                                                                            <span>EA125424NZ</span>
                                                                                                        </Link>
                                                                                                    </p>
                                                                                                </Col>
                                                                                            </Row>
                                                                                        ))}
                                                                                    </tbody>
                                                                                </Table>
                                                                            </Card.Body>
                                                                        </Card>
                                                                    </Col>
                                                                </>
                                                            ) : (
                                                                <>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <NoDataSection title="Unfortunately no data found!" description="Go shopping and make some orders!" />
                                                                    </Col>
                                                                </>
                                                            )}
                                                            {ordersState?.length && paginationState?.total_pages > 1 && !ordersLoadingState ? (
                                                                <>
                                                                    <Col xs={{ span: 12 }} className="mt-gutter">
                                                                        <PaginationSection paginatingData={paginationState} onClickHandler={onChangePaginationHandler} />
                                                                    </Col>
                                                                </>
                                                            ) : (
                                                                <></>
                                                            )}
                                                        </Row>
                                                    </section>
                                                </Col>
                                            </Row>
                                        </section>
                                    </article>
                                </Col>
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

export default connect(mapStateToProps, mapDispatchToProps)(DashboardOrderSummary);
