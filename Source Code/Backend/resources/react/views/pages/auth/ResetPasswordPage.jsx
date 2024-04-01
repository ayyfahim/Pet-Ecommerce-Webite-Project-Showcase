import React from "react";
import { connect } from "react-redux";
import { object, string, ref } from "yup";
import { Container, Row, Col, Card, Form, Button, Spinner } from "react-bootstrap";
import to from "await-to-js";
import qs from "qs";
import { useFormik } from "formik";

import * as actions from "../../../store/rootActions";
import AuthService from "../../../services/AuthService";

function ResetPasswordPage(props) {
    const {
        pageTitle,
        history: { push },
        location: { search },
        match: {
            params: { token: resetToken }
        },
        onAddFlashMessage
    } = props;

    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    const formik = useFormik({
        validateOnBlur: false,
        initialValues: { password: "", password_confirmation: "" },
        validationSchema: object().shape({
            password: string()
                .required("Password field is required.")
                .min(8, "Password is too short - should be 8 chars minimum."),
            password_confirmation: string()
                .required("Confirm Password field is required.")
                .oneOf([ref("password"), null], "Passwords must match")
        }),
        onSubmit: async (values, { setSubmitting, setErrors, resetForm }) => {
            // Reset Password with valid data.
            const [resetPasswordErrors, resetPasswordResponse] = await to(
                AuthService.resetPassword({
                    ...values,
                    token: resetToken,
                    email: queryParams?.email
                })
            );

            if (resetPasswordErrors) {
                const {
                    response: {
                        data: { errors }
                    }
                } = resetPasswordErrors;

                setSubmitting(false);
                setErrors(errors);
                return;
            }

            const {
                data: { message }
            } = resetPasswordResponse;

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
                                            <small className="text-secondary">please choose new password for your account</small>
                                        </Col>
                                        <Col xs={{ span: 2 }} className="mt-2">
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
                                                                <Form.Group controlId="resetPasswordPassword">
                                                                    <Form.Label className="text-capitalize font-weight-light">
                                                                        Password <span className="text-danger">*</span>
                                                                    </Form.Label>
                                                                    <Form.Control
                                                                        onChange={formik.handleChange}
                                                                        onBlur={formik.handleBlur}
                                                                        value={formik?.values?.password}
                                                                        isInvalid={
                                                                            !!formik?.touched?.password && !!formik?.errors?.password
                                                                        }
                                                                        isValid={
                                                                            formik?.values?.password &&
                                                                            !!formik?.touched?.password &&
                                                                            !!!formik?.errors?.password
                                                                        }
                                                                        name="password"
                                                                        type="password"
                                                                        className="rounded-lg"
                                                                        placeholder="Enter your password"
                                                                        autoComplete="new-password"
                                                                    />
                                                                    {!!formik?.touched?.password && !!formik?.errors?.password && (
                                                                        <Form.Control.Feedback type="invalid">
                                                                            {formik.errors.password}
                                                                        </Form.Control.Feedback>
                                                                    )}
                                                                </Form.Group>
                                                            </Col>
                                                            <Col xs={{ span: 12 }}>
                                                                <Form.Group controlId="resetPasswordPasswordConfirmation">
                                                                    <Form.Label className="text-capitalize font-weight-light">
                                                                        Password confirmation<span className="text-danger">*</span>
                                                                    </Form.Label>
                                                                    <Form.Control
                                                                        onChange={formik.handleChange}
                                                                        onBlur={formik.handleBlur}
                                                                        value={formik?.values?.password_confirmation}
                                                                        isInvalid={
                                                                            !!formik?.touched?.password_confirmation &&
                                                                            !!formik?.errors?.password_confirmation
                                                                        }
                                                                        isValid={
                                                                            formik?.values?.password_confirmation &&
                                                                            !!formik?.touched?.password_confirmation &&
                                                                            !!!formik?.errors?.password_confirmation
                                                                        }
                                                                        name="password_confirmation"
                                                                        type="password"
                                                                        className="rounded-lg"
                                                                        placeholder="Enter your password confirmation"
                                                                        autoComplete="new-password"
                                                                    />
                                                                    {!!formik?.touched?.password_confirmation &&
                                                                        !!formik?.errors?.password_confirmation && (
                                                                            <Form.Control.Feedback type="invalid">
                                                                                {formik.errors.password_confirmation}
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
                                                            {formik.isSubmitting ? (
                                                                <Spinner animation="border" size="sm" />
                                                            ) : (
                                                                "reset password"
                                                            )}
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

export default connect(mapStateToProps, mapDispatchToProps)(ResetPasswordPage);
