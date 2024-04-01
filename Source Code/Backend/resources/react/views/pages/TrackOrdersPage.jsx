import React from "react";
import { connect } from "react-redux";
import { object, string } from "yup";
import { Container, Row, Col, Card, Form, Button, Spinner } from "react-bootstrap";
import { useFormik } from "formik";

import TrackOrderBadge from "../components/SVG/Badges/TrackOrderBadge";

export const TrackOrdersPage = props => {
    const {
        pageTitle,
        history: { goBack }
    } = props;

    // Component Hooks.
    const formik = useFormik({
        validateOnBlur: false,
        initialValues: { order_id: "", email: "" },
        validationSchema: object().shape({
            email: string()
                .required("Email field is required.")
                .email(),
            order_id: string().required("order ID field is required.")
        }),
        onSubmit: async (values, { setSubmitting, setErrors, resetForm }) => {}
    });

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row className="justify-content-center">
                        <Col xs={{ span: 12 }} sm={{ span: 10 }} md={{ span: 8 }} lg={{ span: 7 }} xl={{ span: 6 }}>
                            <Card className="border-0">
                                <Card.Header className="pb-0 border-0">
                                    <Row className="justify-content-center">
                                        <Col xs={{ span: 2 }} className="mb-3">
                                            <span className="mr-md-2 mb-md-0 mb-2 text-primary">
                                                <TrackOrderBadge />
                                            </span>
                                        </Col>
                                        <Col xs={{ span: 12 }} className="mb-3">
                                            <h1 className="h3 font-weight-bold text-center text-capitalize mb-0">{pageTitle}</h1>
                                        </Col>
                                        <Col xs={{ span: 12 }}>
                                            <small className="text-secondary d-block text-center">Please enter the following information in order to track your order.</small>
                                        </Col>
                                    </Row>
                                </Card.Header>
                                <Card.Body>
                                    <Row className="justify-content-center">
                                        <Col xs={{ span: 12 }} md={{ span: 9 }}>
                                            <Form onSubmit={formik.handleSubmit} noValidate>
                                                <Form.Row>
                                                    <Col xs={{ span: 12 }}>
                                                        <Form.Row>
                                                            <Col xs={{ span: 12 }}>
                                                                <Form.Group controlId="trackOrdersOrderId">
                                                                    <Form.Label className="text-capitalize font-weight-light">
                                                                        Order ID <span className="text-danger">*</span>
                                                                    </Form.Label>
                                                                    <Form.Control
                                                                        onChange={formik.handleChange}
                                                                        onBlur={formik.handleBlur}
                                                                        value={formik?.values?.order_id || ""}
                                                                        isInvalid={!!formik?.touched?.order_id && !!formik?.errors?.order_id}
                                                                        isValid={formik?.values?.order_id && !!formik?.touched?.order_id && !!!formik?.errors?.order_id}
                                                                        name="order_id"
                                                                        type="text"
                                                                        className="rounded-lg"
                                                                        placeholder="Enter your order ID"
                                                                    />
                                                                    {!!formik?.touched?.order_id && !!formik?.errors?.order_id && (
                                                                        <Form.Control.Feedback type="invalid">{formik.errors.order_id}</Form.Control.Feedback>
                                                                    )}
                                                                </Form.Group>
                                                            </Col>
                                                            <Col xs={{ span: 12 }}>
                                                                <Form.Group controlId="trackOrdersEmail">
                                                                    <Form.Label className="text-capitalize font-weight-light">
                                                                        Email <span className="text-danger">*</span>
                                                                    </Form.Label>
                                                                    <Form.Control
                                                                        onChange={formik.handleChange}
                                                                        onBlur={formik.handleBlur}
                                                                        value={formik?.values?.email || ""}
                                                                        isInvalid={!!formik?.touched?.email && !!formik?.errors?.email}
                                                                        isValid={formik?.values?.email && !!formik?.touched?.email && !!!formik?.errors?.email}
                                                                        name="email"
                                                                        type="email"
                                                                        className="rounded-lg"
                                                                        placeholder="Enter your email"
                                                                        autoComplete="email"
                                                                    />
                                                                    {!!formik?.touched?.email && !!formik?.errors?.email && (
                                                                        <Form.Control.Feedback type="invalid">{formik.errors.email}</Form.Control.Feedback>
                                                                    )}
                                                                </Form.Group>
                                                            </Col>
                                                        </Form.Row>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Row>
                                                            <Col>
                                                                <Button type="submit" variant="outline-primary" block className="rounded-lg text-capitalize" onClick={() => goBack()}>
                                                                    cancel
                                                                </Button>
                                                            </Col>
                                                            <Col>
                                                                <Button type="submit" variant="primary" block className="rounded-lg text-capitalize" disabled={!formik.isValid}>
                                                                    {formik.isSubmitting ? <Spinner animation="border" size="sm" /> : "track order"}
                                                                </Button>
                                                            </Col>
                                                        </Row>
                                                    </Col>
                                                </Form.Row>
                                            </Form>
                                        </Col>
                                    </Row>
                                </Card.Body>
                            </Card>
                        </Col>
                    </Row>
                </Container>
            </section>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(TrackOrdersPage);
