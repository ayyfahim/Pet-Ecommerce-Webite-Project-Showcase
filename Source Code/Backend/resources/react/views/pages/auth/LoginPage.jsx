import React, { useState } from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
import { object, string } from "yup";
import { Container, Row, Col, Card, Form, Button, Spinner } from "react-bootstrap";
import to from "await-to-js";
import qs from "qs";
import { useFormik } from "formik";

import * as actions from "../../../store/rootActions";
import AuthService from "../../../services/AuthService";

import FacebookOAuthButton from "../../components/OAuth/FacebookOAuthButton";
import GoogleOAuthButton from "../../components/OAuth/GoogleOAuthButton";

function LoginPage(props) {
    const {
        pageTitle,
        history: { push },
        onAddFlashMessage,
        onLoginUserData
    } = props;

    // Component State.
    const initialFacebookOAuthLoadingState = false;
    const initialGoogleOAuthLoadingState = false;
    const [facebookOAuthLoadingState, setFacebookOAuthLoadingState] = useState(initialFacebookOAuthLoadingState);
    const [googleOAuthLoadingState, setGoogleOAuthLoadingState] = useState(initialGoogleOAuthLoadingState);

    // Event Handlers
    const facebookOAuthSuccess = async response => {
        setFacebookOAuthLoadingState(true);
        const { email, name: full_name } = response;
        const [facebookOAuthErrors, facebookOAuthResponse] = await to(AuthService.social({ email }));
        if (facebookOAuthErrors) {
            const {
                response: {
                    data: {
                        message,
                        data: { user_exists }
                    }
                }
            } = facebookOAuthErrors;

            if (!user_exists) {
                if (message) onAddFlashMessage({ type: "danger", message });
                push(`/register?${qs.stringify({ email, full_name, social: 1 })}`);
                return;
            }
        }

        const {
            data: {
                data: { token, user, user_exists },
                message
            }
        } = facebookOAuthResponse;

        if (!user_exists) {
            if (message) onAddFlashMessage({ type: "danger", message });
            push(`/register?${qs.stringify({ email, full_name, social: 1 })}`);
            return;
        }

        onLoginUserData({ token, user });
        if (message) onAddFlashMessage({ type: "success", message });
        push(!user?.status?.email_verified ? "/email/verify" : "/dashboard/account");
        setFacebookOAuthLoadingState(false);
    };
    const googleOAuthSuccess = async response => {
        setGoogleOAuthLoadingState(true);
        const {
            profileObj: { email, name: full_name }
        } = response;
        const [googleOAuthErrors, googleOAuthResponse] = await to(AuthService.social({ email }));
        if (googleOAuthErrors) {
            // Extracting response data.
            const {
                response: {
                    data: {
                        message,
                        data: { user_exists }
                    }
                }
            } = googleOAuthErrors;

            // handle if there is no user exists in the database scenario.
            if (!user_exists) {
                if (message) onAddFlashMessage({ type: "danger", message: message });
                push(`/register?${qs.stringify({ email, full_name, social: 1 })}`);
                return;
            }
        }

        const {
            data: {
                data: { token, user, user_exists },
                message
            }
        } = googleOAuthResponse;

        if (!user_exists) {
            if (message) onAddFlashMessage({ type: "danger", message });
            push(`/register?${qs.stringify({ email, full_name, social: 1 })}`);
            return;
        }

        onLoginUserData({ token, user });
        if (message) onAddFlashMessage({ type: "success", message });
        push(!user?.status?.email_verified ? "/email/verify" : "/dashboard/account");
        setGoogleOAuthLoadingState(false);
    };

    // Component Hooks.
    const formik = useFormik({
        validateOnBlur: false,
        initialValues: { email: "", password: "" },
        validationSchema: object().shape({
            email: string()
                .required("Email field is required.")
                .email(),
            password: string().required("Password field is required.")
        }),
        onSubmit: async (values, { setSubmitting, setErrors, resetForm }) => {
            const [loginErrors, loginResponse] = await to(AuthService.login(values));
            if (loginErrors) {
                const {
                    response: {
                        data: { errors, wrong_password_error }
                    }
                } = loginErrors;

                setErrors(errors);
                setSubmitting(false);
                return;
            }

            const {
                data: {
                    message,
                    data: { token, user }
                }
            } = loginResponse;

            setSubmitting(false);
            resetForm();
            onLoginUserData({ token, user });
            push(!user?.status?.email_verified ? "/email/verify" : "/dashboard/account");
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
                                                                <Form.Group controlId="loginEmail">
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
                                                            <Col xs={{ span: 12 }}>
                                                                <Form.Group controlId="loginPassword" className="mb-0">
                                                                    <Form.Label className="text-capitalize font-weight-light">
                                                                        Password <span className="text-danger">*</span>
                                                                    </Form.Label>
                                                                    <Form.Control
                                                                        onChange={formik.handleChange}
                                                                        onBlur={formik.handleBlur}
                                                                        value={formik?.values?.password || ""}
                                                                        isInvalid={!!formik?.touched?.password && !!formik?.errors?.password}
                                                                        isValid={formik?.values?.password && !!formik?.touched?.password && !!!formik?.errors?.password}
                                                                        name="password"
                                                                        type="password"
                                                                        className="rounded-lg"
                                                                        placeholder="Enter your password"
                                                                        autoComplete="current-password"
                                                                    />
                                                                    {!!formik?.touched?.password && !!formik?.errors?.password && (
                                                                        <Form.Control.Feedback type="invalid">{formik.errors.password}</Form.Control.Feedback>
                                                                    )}
                                                                </Form.Group>
                                                            </Col>
                                                        </Form.Row>
                                                    </Col>
                                                    <Col xs={{ span: 12 }} className="mb-gutter">
                                                        <p className="text-right">
                                                            <Button as={Link} to="/password/forgot" variant="link" size="sm" className="text-capitalize text-underline p-0">
                                                                forgot your password?
                                                            </Button>
                                                        </p>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Button type="submit" variant="primary" block className="rounded-lg text-capitalize" disabled={!formik.isValid}>
                                                            {formik.isSubmitting ? <Spinner animation="border" size="sm" /> : "login"}
                                                        </Button>
                                                    </Col>
                                                </Form.Row>
                                            </Form>
                                        </Col>
                                    </Row>
                                </Card.Body>
                                <Card.Footer className="pt-0 border-0">
                                    <Row className="justify-content-center">
                                        <Col xs={{ span: 10 }} md={{ span: 11 }} lg={{ span: 10 }} xl={{ span: 9 }}>
                                            <Row>
                                                <Col xs={{ span: 12 }} className="mb-2">
                                                    <p className="text-center text-secondary m-0">
                                                        <small>
                                                            Don't have an account yet? Register
                                                            <Button as={Link} to="/register" variant="link" className="text-decoration-none p-0 pl-1 small">
                                                                here
                                                            </Button>
                                                        </small>
                                                    </p>
                                                </Col>
                                                <Col xs={{ span: 12 }} className="mb-2">
                                                    <div className="d-flex align-items-center">
                                                        <span className="w-100">
                                                            <hr />
                                                        </span>
                                                        <span className="px-3 text-uppercase">or</span>
                                                        <span className="w-100">
                                                            <hr />
                                                        </span>
                                                    </div>
                                                </Col>
                                                <Col xs={{ span: 12 }}>
                                                    <Row>
                                                        <Col xs={{ span: 12 }} className="mb-3">
                                                            <FacebookOAuthButton onSuccess={facebookOAuthSuccess} isLoading={facebookOAuthLoadingState} buttonText="sign in with facebook" />
                                                        </Col>
                                                        <Col xs={{ span: 12 }}>
                                                            <GoogleOAuthButton onSuccess={googleOAuthSuccess} isLoading={googleOAuthLoadingState} buttonText="sign in with google" />
                                                        </Col>
                                                    </Row>
                                                </Col>
                                            </Row>
                                        </Col>
                                    </Row>
                                </Card.Footer>
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
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload)),
    onLoginUserData: payload => dispatch(actions.loginUserData(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(LoginPage);
