/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState } from "react";
import { object, string } from "yup";
import { connect } from "react-redux";
import { Container, Row, Col, Form, Button, Spinner } from "react-bootstrap";
import { useFormik } from "formik";
import to from "await-to-js";
import ReCAPTCHA from "react-google-recaptcha";

import { GOOGLE_RECAPTCHA_SITE_KEY } from "../../config/globals";
import * as actions from "../../store/rootActions";
import HomeService from "../../services/HomeService";

export const ContactUsPage = props => {
    const { pageTitle, onAddFlashMessage } = props;

    // Component State.
    const initialDefaultContactUsFormState = { name: "", phone: "", email: "", subject: "", message: "", "g-recaptcha-response": "" };
    const [defaultContactUsFormState, setDefaultContactUsFormState] = useState(initialDefaultContactUsFormState);

    // Component Hooks.
    const contactUsFormik = useFormik({
        validateOnBlur: false,
        enableReinitialize: true,
        initialValues: { ...defaultContactUsFormState },
        validationSchema: object().shape({
            name: string().required("Name field is required."),
            phone: string().required("phone field is required."),
            email: string()
                .required("Email field is required.")
                .email(),
            subject: string().required("subject field is required."),
            message: string().required("message field is required."),
            "g-recaptcha-response": string().required("field is required.")
        }),
        onSubmit: async (values, { setSubmitting, setErrors }) => {
            const [supportErrors, SupportResponse] = await to(HomeService.support(values));
            if (supportErrors) {
                const {
                    response: {
                        data: { errors }
                    }
                } = supportErrors;
                setErrors(errors);
                setSubmitting(false);
                return;
            }
            const {
                data: { message }
            } = SupportResponse;
            setSubmitting(false);
            if (message) onAddFlashMessage({ type: "success", message });
        }
    });

    return (
        <>
            <section className="section static-page-content-section bg-white py-5 h-100">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <h1 className="h3 font-weight-bold text-capitalize mb-0">{pageTitle}</h1>
                        </Col>
                        <Col xs={{ span: 12 }} className="mt-4">
                            <Row>
                                <Col xs={{ span: 12, order: 1 }} md={{ span: 6, order: 0 }}>
                                    <Form onSubmit={contactUsFormik.handleSubmit} noValidate>
                                        <Form.Row>
                                            <Col xs={{ span: 12 }} className="mb-gutter">
                                                <Row>
                                                    <Col xs={{ span: 12 }}>
                                                        <Form.Group controlId="contactUsFullName">
                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                Name <span className="text-danger">*</span>
                                                            </Form.Label>
                                                            <Form.Control
                                                                onChange={contactUsFormik.handleChange}
                                                                onBlur={contactUsFormik.handleBlur}
                                                                value={contactUsFormik?.values?.name || ""}
                                                                isInvalid={!!contactUsFormik?.touched?.name && !!contactUsFormik?.errors?.name}
                                                                isValid={contactUsFormik?.values?.name && !!contactUsFormik?.touched?.name && !!!contactUsFormik?.errors?.name}
                                                                name="name"
                                                                type="text"
                                                                className="rounded-lg"
                                                                placeholder="Enter first and last name"
                                                                autoComplete="given-name"
                                                            />
                                                            {!!contactUsFormik?.touched?.name && !!contactUsFormik?.errors?.name && (
                                                                <Form.Control.Feedback type="invalid">{contactUsFormik.errors.name}</Form.Control.Feedback>
                                                            )}
                                                        </Form.Group>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Form.Group controlId="contactUsContactNumber">
                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                Contact number <span className="text-danger">*</span>
                                                            </Form.Label>
                                                            <Form.Control
                                                                onChange={contactUsFormik.handleChange}
                                                                onBlur={contactUsFormik.handleBlur}
                                                                value={contactUsFormik?.values?.phone || ""}
                                                                isInvalid={!!contactUsFormik?.touched?.phone && !!contactUsFormik?.errors?.phone}
                                                                isValid={contactUsFormik?.values?.phone && !!contactUsFormik?.touched?.phone && !!!contactUsFormik?.errors?.phone}
                                                                name="phone"
                                                                type="tel"
                                                                className="rounded-lg"
                                                                placeholder="Enter your contact number"
                                                                autoComplete="tel"
                                                            />
                                                            {!!contactUsFormik?.touched?.phone && !!contactUsFormik?.errors?.phone && (
                                                                <Form.Control.Feedback type="invalid">{contactUsFormik.errors.phone}</Form.Control.Feedback>
                                                            )}
                                                        </Form.Group>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Form.Group controlId="contactUsEmail">
                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                Email <span className="text-danger">*</span>
                                                            </Form.Label>
                                                            <Form.Control
                                                                onChange={contactUsFormik.handleChange}
                                                                onBlur={contactUsFormik.handleBlur}
                                                                value={contactUsFormik?.values?.email || ""}
                                                                isInvalid={!!contactUsFormik?.touched?.email && !!contactUsFormik?.errors?.email}
                                                                isValid={contactUsFormik?.values?.email && !!contactUsFormik?.touched?.email && !!!contactUsFormik?.errors?.email}
                                                                name="email"
                                                                type="email"
                                                                className="rounded-lg"
                                                                placeholder="Enter your email"
                                                                autoComplete="email"
                                                            />
                                                            {!!contactUsFormik?.touched?.email && !!contactUsFormik?.errors?.email && (
                                                                <Form.Control.Feedback type="invalid">{contactUsFormik.errors.email}</Form.Control.Feedback>
                                                            )}
                                                        </Form.Group>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Form.Group controlId="contactUsSubject">
                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                Subject <span className="text-danger">*</span>
                                                            </Form.Label>
                                                            <Form.Control
                                                                onChange={contactUsFormik.handleChange}
                                                                onBlur={contactUsFormik.handleBlur}
                                                                value={contactUsFormik?.values?.subject || ""}
                                                                isInvalid={!!contactUsFormik?.touched?.subject && !!contactUsFormik?.errors?.subject}
                                                                isValid={contactUsFormik?.values?.subject && !!contactUsFormik?.touched?.subject && !!!contactUsFormik?.errors?.subject}
                                                                name="subject"
                                                                type="text"
                                                                className="rounded-lg"
                                                                placeholder="Enter subject"
                                                            />
                                                            {!!contactUsFormik?.touched?.subject && !!contactUsFormik?.errors?.subject && (
                                                                <Form.Control.Feedback type="invalid">{contactUsFormik.errors.subject}</Form.Control.Feedback>
                                                            )}
                                                        </Form.Group>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <Form.Group controlId="contactUsMessage">
                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                Message <span className="text-danger">*</span>
                                                            </Form.Label>
                                                            <Form.Control
                                                                as="textarea"
                                                                rows={4}
                                                                onChange={contactUsFormik.handleChange}
                                                                onBlur={contactUsFormik.handleBlur}
                                                                value={contactUsFormik?.values?.message || ""}
                                                                isInvalid={!!contactUsFormik?.touched?.message && !!contactUsFormik?.errors?.message}
                                                                isValid={contactUsFormik?.values?.message && !!contactUsFormik?.touched?.message && !!!contactUsFormik?.errors?.message}
                                                                name="message"
                                                                className="rounded-lg"
                                                                placeholder="Enter message"
                                                            />
                                                            {!!contactUsFormik?.touched?.message && !!contactUsFormik?.errors?.message && (
                                                                <Form.Control.Feedback type="invalid">{contactUsFormik.errors.message}</Form.Control.Feedback>
                                                            )}
                                                        </Form.Group>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <ReCAPTCHA sitekey={GOOGLE_RECAPTCHA_SITE_KEY} onChange={value => contactUsFormik.setFieldValue("g-recaptcha-response", value)} />
                                                        <Form.Group controlId="contactUsRecaptcha">
                                                            <Form.Control
                                                                type="text"
                                                                onChange={contactUsFormik.handleChange}
                                                                onBlur={contactUsFormik.handleBlur}
                                                                value={contactUsFormik?.values?.["g-recaptcha-response"] || ""}
                                                                isInvalid={!!contactUsFormik?.touched?.["g-recaptcha-response"] && !!contactUsFormik?.errors?.["g-recaptcha-response"]}
                                                                isValid={
                                                                    contactUsFormik?.values?.["g-recaptcha-response"] &&
                                                                    !!contactUsFormik?.touched?.["g-recaptcha-response"] &&
                                                                    !!!contactUsFormik?.errors?.["g-recaptcha-response"]
                                                                }
                                                                name="g-recaptcha-response"
                                                                className="rounded-lg"
                                                                hidden
                                                                disabled
                                                                readOnly
                                                            />
                                                            {!!contactUsFormik?.touched?.["g-recaptcha-response"] && !!contactUsFormik?.errors?.["g-recaptcha-response"] && (
                                                                <Form.Control.Feedback type="invalid">{contactUsFormik.errors["g-recaptcha-response"]}</Form.Control.Feedback>
                                                            )}
                                                        </Form.Group>
                                                    </Col>
                                                </Row>
                                            </Col>
                                            <Col xs={{ span: 12 }}>
                                                <Button type="submit" variant="primary" block className="rounded-lg text-capitalize" disabled={!contactUsFormik.isValid}>
                                                    {contactUsFormik.isSubmitting ? <Spinner animation="border" size="sm" /> : "send"}
                                                </Button>
                                            </Col>
                                        </Form.Row>
                                    </Form>
                                </Col>
                                <Col xs={{ span: 12, order: 0 }} md={{ span: 6, order: 1 }} className="mb-gutter mb-md-0">
                                    <Row>
                                        <Col xs={{ span: 12 }} md={{ span: 11, offset: 1 }}>
                                            <Row>
                                                <Col xs={{ span: 12 }} className="mb-gutter">
                                                    <h6 className="text-capitalize">office address</h6>
                                                    <p>
                                                        <address>
                                                            level2, 18 Railway Street, New Market <br />
                                                            Auckland 1023, New Zealand.
                                                        </address>
                                                    </p>
                                                    <p>
                                                        Email: <a href="mailto:support@dealaday.co.nz">support@dealaday.co.nz</a>
                                                    </p>
                                                </Col>
                                                <Col xs={{ span: 12 }} className="mb-gutter">
                                                    <h6 className="text-capitalize">postal address</h6>
                                                    <p>
                                                        <address>
                                                            PO BOX 17175 <br />
                                                            Greenland, Auckland 1546 <br />
                                                            New Zealand.
                                                        </address>
                                                    </p>
                                                </Col>
                                            </Row>
                                        </Col>
                                    </Row>
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

export default connect(mapStateToProps, mapDispatchToProps)(ContactUsPage);
