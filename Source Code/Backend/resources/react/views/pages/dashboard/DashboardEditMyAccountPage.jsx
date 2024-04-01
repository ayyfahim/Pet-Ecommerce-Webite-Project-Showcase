import React from "react";
import { connect } from "react-redux";
import { Container, Row, Col, Form, Button, Spinner } from "react-bootstrap";
import { object, string, ref } from "yup";
import to from "await-to-js";
import { useFormik } from "formik";

import * as actions from "../../../store/rootActions";
import UserService from "../../../services/UserService";
import AuthService from "../../../services/AuthService";

import RootMenu from "../../sections/RootMenu";

function DashboardEditMyAccountPage(props) {
    const {
        pageTitle,
        auth: { user },
        onAddFlashMessage,
        onChangeUserState
    } = props;

    // API Calls.
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

    const formik = useFormik({
        validateOnBlur: false,
        initialValues: { current_password: "", password: "", password_confirmation: "" },
        validationSchema: object().shape({
            current_password: string().required("old password field is required"),
            password: string()
                .required("Password field is required.")
                .min(8, "Password is too short - should be 8 chars minimum."),
            password_confirmation: string()
                .required("Confirm Password field is required.")
                .oneOf([ref("password"), null], "Passwords must match")
        }),
        onSubmit: async (values, { setSubmitting, setErrors, resetForm }) => {
            const [updateUserErrors, updateUserResponse] = await to(UserService.userUpdate({ id: user?.id }, values));
            if (updateUserErrors) {
                const {
                    response: {
                        data: { errors }
                    }
                } = updateUserErrors;

                setSubmitting(false);
                setErrors(errors);
                return;
            }

            const {
                data: { message }
            } = updateUserResponse;

            setSubmitting(false);
            resetForm();
            getUserData();
            if (message) onAddFlashMessage({ type: "success", message });
        }
    });

    return (
        <>
            <section className="section bg-white h-100">
                <Container fluid className="px-0">
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <Row noGutters>
                                <Col
                                    xs={{ span: 10, offset: 1 }}
                                    md={{ span: 4, offset: 0 }}
                                    lg={{ span: 3 }}
                                    className="mb-5 mb-md-0 border-right-0 border-md-right"
                                >
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
                                                                <h2 className="h5 text-capitalize">change password:</h2>
                                                            </Col>
                                                        </Row>
                                                        <Row>
                                                            <Col xs={{ span: 12 }} md={{ span: 10, offset: 1 }}>
                                                                <Form onSubmit={formik.handleSubmit} noValidate>
                                                                    <Form.Row>
                                                                        <Col xs={{ span: 12 }} md={{ span: 10 }}>
                                                                            <Form.Row>
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <Form.Group controlId="updateOldPassword">
                                                                                        <Form.Label className="text-capitalize font-weight-light">
                                                                                            Old Password
                                                                                            <span className="text-danger">*</span>
                                                                                        </Form.Label>
                                                                                        <Form.Control
                                                                                            onChange={formik.handleChange}
                                                                                            onBlur={formik.handleBlur}
                                                                                            value={formik?.values?.current_password}
                                                                                            isInvalid={
                                                                                                !!formik?.touched?.current_password &&
                                                                                                !!formik?.errors?.current_password
                                                                                            }
                                                                                            isValid={
                                                                                                formik?.values?.current_password &&
                                                                                                !!formik?.touched?.current_password &&
                                                                                                !!!formik?.errors?.current_password
                                                                                            }
                                                                                            name="current_password"
                                                                                            type="password"
                                                                                            className="rounded-lg"
                                                                                            placeholder="Enter your new password"
                                                                                            autoComplete="current-password"
                                                                                        />
                                                                                        {!!formik?.touched?.current_password &&
                                                                                            !!formik?.errors?.current_password && (
                                                                                                <Form.Control.Feedback type="invalid">
                                                                                                    {formik.errors.current_password}
                                                                                                </Form.Control.Feedback>
                                                                                            )}
                                                                                    </Form.Group>
                                                                                </Col>
                                                                                <Col xs={{ span: 12 }}>
                                                                                    <Form.Group controlId="updatePassword">
                                                                                        <Form.Label className="text-capitalize font-weight-light">
                                                                                            new Password
                                                                                            <span className="text-danger">*</span>
                                                                                        </Form.Label>
                                                                                        <Form.Control
                                                                                            onChange={formik.handleChange}
                                                                                            onBlur={formik.handleBlur}
                                                                                            value={formik?.values?.password}
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
                                                                                            placeholder="Enter your new password"
                                                                                            autoComplete="current-password"
                                                                                        />
                                                                                        {!!formik?.touched?.password &&
                                                                                            !!formik?.errors?.password && (
                                                                                                <Form.Control.Feedback type="invalid">
                                                                                                    {formik.errors.password}
                                                                                                </Form.Control.Feedback>
                                                                                            )}
                                                                                    </Form.Group>
                                                                                </Col>
                                                                                <Col
                                                                                    xs={{
                                                                                        span: 12
                                                                                    }}
                                                                                >
                                                                                    <Form.Group controlId="updatePasswordConfirmation">
                                                                                        <Form.Label className="text-capitalize font-weight-light">
                                                                                            Password confirmation
                                                                                            <span className="text-danger">*</span>
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
                                                                                            placeholder="Enter your new password confirmation"
                                                                                            autoComplete="current-password"
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
                                                                        <Col xs={{ span: 12 }} md={{ span: 10 }}>
                                                                            <Row>
                                                                                <Col>
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
                                                                                            "Submit"
                                                                                        )}
                                                                                    </Button>
                                                                                </Col>
                                                                            </Row>
                                                                        </Col>
                                                                    </Form.Row>
                                                                </Form>
                                                            </Col>
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
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload)),
    onChangeUserState: payload => dispatch(actions.changeUserState(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(DashboardEditMyAccountPage);
