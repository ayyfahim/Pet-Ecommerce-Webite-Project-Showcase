import React from "react";
import { connect } from "react-redux";
import { object, string } from "yup";
import { Container, Row, Col, Card, Form, Button, Spinner } from "react-bootstrap";
import to from "await-to-js";
import { useFormik } from "formik";

import * as actions from "../../../store/rootActions";
import AuthService from "../../../services/AuthService";

function ForgotPasswordPage(props) {
    const {
        pageTitle,
        history: { push },
        onAddFlashMessage
    } = props;

    const formik = useFormik({
        validateOnBlur: false,
        initialValues: { email: "" },
        validationSchema: object().shape({
            email: string()
                .required("Email field is required.")
                .email()
        }),
        onSubmit: async (values, { setSubmitting, setErrors, resetForm }) => {
            const [forgotErrors, forgotResponse] = await to(AuthService.resetPasswordSendEmail(values));
            if (forgotErrors) {
                const {
                    response: {
                        data: { errors }
                    }
                } = forgotErrors;

                setErrors(errors);
                setSubmitting(false);
                return;
            }

            const {
                data: { message }
            } = forgotResponse;

            setSubmitting(false);
            resetForm();
            push("/login");
            if (message) onAddFlashMessage({ type: "success", message });
        }
    });

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row className="justify-content-center">
                        <Col xs={{ span: 12 }} sm={{ span: 10 }} md={{ span: 8 }} lg={{ span: 7 }} xl={{ span: 6 }}>
                            <Card className="border-0">
                                <Card.Header className="pb-0 border-0">
                                    <Row>
                                        <Col xs={{ span: 12 }}>
                                            <h1 className="font-weight-bold text-capitalize mb-0">{pageTitle}</h1>
                                            <small className="text-secondary">
                                                Please enter your email address and we will send you a link to reset your password
                                            </small>
                                        </Col>
                                        <Col xs={{ span: 2 }} className="my-2">
                                            <div className="bg-primary pt-1"></div>
                                        </Col>
                                    </Row>
                                </Card.Header>
                                <Card.Body>
                                    <Row>
                                        <Col xs={{ span: 12 }}>
                                            <Form onSubmit={formik.handleSubmit} noValidate>
                                                <Form.Row>
                                                    <Col xs={{ span: 12 }}>
                                                        <Form.Row>
                                                            <Col xs={{ span: 12 }}>
                                                                <Form.Group controlId="forgotPasswordEmail">
                                                                    <Form.Label className="text-capitalize font-weight-light">
                                                                        Email <span className="text-danger">*</span>
                                                                    </Form.Label>
                                                                    <Form.Control
                                                                        onChange={formik.handleChange}
                                                                        onBlur={formik.handleBlur}
                                                                        value={formik?.values?.email}
                                                                        isInvalid={!!formik?.touched?.email && !!formik?.errors?.email}
                                                                        isValid={
                                                                            formik?.values?.email &&
                                                                            !!formik?.touched?.email &&
                                                                            !!!formik?.errors?.email
                                                                        }
                                                                        name="email"
                                                                        type="email"
                                                                        className="rounded-lg"
                                                                        placeholder="Enter your email"
                                                                        autoComplete="email"
                                                                    />
                                                                    {!!formik?.touched?.email && !!formik?.errors?.email && (
                                                                        <Form.Control.Feedback type="invalid">
                                                                            {formik.errors.email}
                                                                        </Form.Control.Feedback>
                                                                    )}
                                                                </Form.Group>
                                                            </Col>
                                                        </Form.Row>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Button
                                                            type="submit"
                                                            variant="primary"
                                                            block
                                                            className="rounded-lg text-capitalize"
                                                            disabled={!formik.isValid}
                                                        >
                                                            {formik.isSubmitting ? <Spinner animation="border" size="sm" /> : "send"}
                                                        </Button>
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
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(ForgotPasswordPage);
