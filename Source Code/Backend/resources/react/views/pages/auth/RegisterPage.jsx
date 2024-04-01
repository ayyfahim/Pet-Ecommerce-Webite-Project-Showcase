/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { object, string } from "yup";
import { Container, Row, Col, Card, Form, Button, Spinner } from "react-bootstrap";
import to from "await-to-js";
import qs from "qs";
import { Link } from "react-router-dom";
import { useFormik } from "formik";

import * as actions from "../../../store/rootActions";
import AuthService from "../../../services/AuthService";

import FacebookOAuthButton from "../../components/OAuth/FacebookOAuthButton";
import GoogleOAuthButton from "../../components/OAuth/GoogleOAuthButton";

function RegisterPage(props) {
    const {
        pageTitle,
        history: {
            push,
            location: { search }
        },
        onAddFlashMessage,
        onLoginUserData
    } = props;

    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });
    // Component State.
    const initialFacebookOAuthLoadingState = false;
    const initialGoogleOAuthLoadingState = false;
    const initialDefaultFormValueState = { full_name: "", email: "", password: "", ...queryParams };
    const [defaultFormValueState, setDefaultFormValueState] = useState(initialDefaultFormValueState);
    const [facebookOAuthLoadingState, setFacebookOAuthLoadingState] = useState(initialFacebookOAuthLoadingState);
    const [googleOAuthLoadingState, setGoogleOAuthLoadingState] = useState(initialGoogleOAuthLoadingState);
    const [socialEmailState, setSocialEmailState] = useState("");
    const [emailUniqueErrorState, setEmailUniqueErrorState] = useState(false);

    const formik = useFormik({
        validateOnBlur: false,
        enableReinitialize: true,
        initialValues: { ...defaultFormValueState },
        validationSchema: object().shape({
            full_name: string().required("full Name field is required."),
            email: string()
                .required("Email field is required.")
                .email(),
            password: string()
        }),
        onSubmit: async (values, { setSubmitting, setErrors }) => {
            setEmailUniqueErrorState(false);
            const [registerErrors, registerResponse] = await to(AuthService.register(values));
            if (registerErrors) {
                const {
                    response: {
                        data: { email_unique_error, errors }
                    }
                } = registerErrors;

                setErrors(errors);
                setSubmitting(false);
                setEmailUniqueErrorState(email_unique_error);
                setGoogleOAuthLoadingState(false);
                setFacebookOAuthLoadingState(false);
                return;
            }

            const {
                data: {
                    message,
                    data: { token, user }
                }
            } = registerResponse;

            onLoginUserData({ token, user });
            push(!user?.status?.email_verified ? "/email/verify" : "/dashboard/account");
            if (message) onAddFlashMessage({ type: "success", message });
            setSubmitting(false);
            setGoogleOAuthLoadingState(false);
            setFacebookOAuthLoadingState(false);
        }
    });

    useEffect(() => {
        if (Number(defaultFormValueState?.social) === 1) {
            let { password, ...otherDefaultFormValueState } = defaultFormValueState;
            formik.setValues({ ...otherDefaultFormValueState, ...(Number(otherDefaultFormValueState?.social) !== 1 && { password }) });
            formik.handleSubmit();
        }
        return () => false;
    }, [defaultFormValueState?.social]);

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
                setSocialEmailState(email);
                setDefaultFormValueState({ ...defaultFormValueState, email, full_name, social: 1 });
                formik.setValues({ ...defaultFormValueState, email, full_name, social: 1 });
                formik.handleSubmit();
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
            setSocialEmailState(email);
            setDefaultFormValueState({ ...defaultFormValueState, email, full_name, social: 1 });
            formik.setValues({ ...defaultFormValueState, email, full_name, social: 1 });
            formik.handleSubmit();
            return;
        }

        onLoginUserData({ token, user });
        if (message) onAddFlashMessage({ type: "success", message });
        setDefaultFormValueState({ ...initialDefaultFormValueState });
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
                if (message) onAddFlashMessage({ type: "danger", message });
                setSocialEmailState(email);
                setDefaultFormValueState({ ...defaultFormValueState, email, full_name, social: 1 });
                formik.setValues({ ...defaultFormValueState, email, full_name, social: 1 });
                formik.handleSubmit();
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
            setSocialEmailState(email);
            setDefaultFormValueState({ ...defaultFormValueState, email, full_name, social: 1 });
            formik.setValues({ ...defaultFormValueState, email, full_name, social: 1 });
            formik.handleSubmit();
            return;
        }

        onLoginUserData({ token, user });
        if (message) onAddFlashMessage({ type: "success", message });
        setDefaultFormValueState({ ...initialDefaultFormValueState });
        push(!user?.status?.email_verified ? "/email/verify" : "/dashboard/account");
        setGoogleOAuthLoadingState(false);
    };

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row className="justify-content-center">
                        {Number(defaultFormValueState?.social) === 1 ? (
                            <>
                                <Col
                                    xs={{ span: 12 }}
                                    sm={{ span: 10 }}
                                    md={{ span: 8 }}
                                    lg={{ span: 7 }}
                                    xl={{ span: 6 }}
                                    className="d-flex align-items-center justify-content-center"
                                >
                                    <Spinner animation="border" variant="primary" />
                                </Col>
                            </>
                        ) : (
                            <>
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
                                                        <Form.Row className="justify-content-center">
                                                            <Col xs={{ span: 12 }} className="mb-gutter">
                                                                <Form.Row>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <Form.Group controlId="registerFirstName">
                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                Name <span className="text-danger">*</span>
                                                                            </Form.Label>
                                                                            <Form.Control
                                                                                onChange={formik.handleChange}
                                                                                onBlur={formik.handleBlur}
                                                                                value={formik?.values?.full_name || ""}
                                                                                isInvalid={
                                                                                    !!formik?.touched?.full_name &&
                                                                                    !!formik?.errors?.full_name
                                                                                }
                                                                                isValid={
                                                                                    formik?.values?.full_name &&
                                                                                    !!formik?.touched?.full_name &&
                                                                                    !!!formik?.errors?.full_name
                                                                                }
                                                                                name="full_name"
                                                                                type="text"
                                                                                className="rounded-lg"
                                                                                placeholder="Enter first and last name"
                                                                                autoComplete="given-name"
                                                                            />
                                                                            {!!formik?.touched?.full_name &&
                                                                                !!formik?.errors?.full_name && (
                                                                                    <Form.Control.Feedback type="invalid">
                                                                                        {formik.errors.full_name}
                                                                                    </Form.Control.Feedback>
                                                                                )}
                                                                        </Form.Group>
                                                                    </Col>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <Form.Group controlId="registerEmail">
                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                Email <span className="text-danger">*</span>
                                                                            </Form.Label>
                                                                            <Form.Control
                                                                                onChange={formik.handleChange}
                                                                                onBlur={formik.handleBlur}
                                                                                value={formik?.values?.email || ""}
                                                                                isInvalid={
                                                                                    !!formik?.touched?.email && !!formik?.errors?.email
                                                                                }
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
                                                                                    {emailUniqueErrorState && (
                                                                                        <>
                                                                                            <Button
                                                                                                as={Link}
                                                                                                to="/login"
                                                                                                variant="link"
                                                                                                className="p-0 pl-1 font-weight-bold text-capitalize"
                                                                                            >
                                                                                                click here to login
                                                                                            </Button>
                                                                                        </>
                                                                                    )}
                                                                                </Form.Control.Feedback>
                                                                            )}
                                                                        </Form.Group>
                                                                    </Col>
                                                                    <Col xs={{ span: 12 }}>
                                                                        <Form.Group controlId="registerPassword">
                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                Password <span className="text-danger">*</span>
                                                                            </Form.Label>
                                                                            <Form.Control
                                                                                onChange={formik.handleChange}
                                                                                onBlur={formik.handleBlur}
                                                                                value={formik?.values?.password || ""}
                                                                                isInvalid={
                                                                                    !!formik?.touched?.password &&
                                                                                    !!formik?.errors?.password
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
                                                                                autoComplete="current-password"
                                                                            />
                                                                            {!!formik?.touched?.password && !!formik?.errors?.password && (
                                                                                <Form.Control.Feedback type="invalid">
                                                                                    {formik.errors.password}
                                                                                </Form.Control.Feedback>
                                                                            )}
                                                                        </Form.Group>
                                                                    </Col>
                                                                </Form.Row>
                                                            </Col>
                                                            <Col xs={{ span: 12 }} md={{ span: 9 }}>
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
                                                                        "register now"
                                                                    )}
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
                                                                    <FacebookOAuthButton
                                                                        onSuccess={facebookOAuthSuccess}
                                                                        isLoading={facebookOAuthLoadingState}
                                                                        buttonText="sign in with facebook"
                                                                    />
                                                                </Col>
                                                                <Col xs={{ span: 12 }}>
                                                                    <GoogleOAuthButton
                                                                        onSuccess={googleOAuthSuccess}
                                                                        isLoading={googleOAuthLoadingState}
                                                                        buttonText="sign in with google"
                                                                    />
                                                                </Col>
                                                            </Row>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                            </Row>
                                        </Card.Footer>
                                    </Card>
                                </Col>
                            </>
                        )}
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

export default connect(mapStateToProps, mapDispatchToProps)(RegisterPage);
