import React, { useState } from "react";
import { connect } from "react-redux";
import { object, string } from "yup";
import { Container, Row, Col, Form, InputGroup, FormControl, Button, Spinner } from "react-bootstrap";
import to from "await-to-js";

import { validationErrorExtraction } from "../../helpers/utilities";

function NewsLetterSection(props) {
    // Component state
    const initialSubscribeFormState = { isFormLoading: false, values: {}, errors: {} };
    const [subscribeFormState, setSubscribeFormState] = useState(initialSubscribeFormState);

    // Forms Schemas.
    const subscribeFormSchema = object().shape({
        email: string()
            .required("Email field is required.")
            .email()
    });

    // Event Handlers.
    const onSubscribeInputChangeHandler = e =>
        setSubscribeFormState({
            ...subscribeFormState,
            values: { ...subscribeFormState?.values, [e.target.name]: e.target.value }
        });
    const onSubscribeFormSubmitHandler = async e => {
        e.preventDefault();
        setSubscribeFormState({ ...subscribeFormState, isFormLoading: true, errors: {} });
        // validating form state.
        const [validationErrors] = await to(subscribeFormSchema?.validate(subscribeFormState.values, { abortEarly: false }));
        if (validationErrors) {
            // Caching validation errors.
            const { inner } = validationErrors;
            // Format errors to match application error handler style.
            const errors = validationErrorExtraction(inner);
            // Passing validation errors to state.
            return setSubscribeFormState({ ...subscribeFormState, isFormLoading: false, errors: { ...errors } });
        }
    };

    return (
        <>
            <section className="newsletter-section section py-6 bg-light">
                <div className="section__bg--text-container">
                    <p className="section__bg--text font-weight-bold text-capitalize text-center">newsletter</p>
                </div>
                <Container>
                    <Row className="justify-content-center">
                        <Col xs={{ span: 12 }} sm={{ span: 10 }} md={{ span: 8 }} lg={{ span: 6 }} xl={{ span: 5 }}>
                            <Row>
                                <Col xs={{ span: 12 }}>
                                    <h2 className="h4 text-center mb-0">Subscribe today</h2>
                                </Col>
                                <Col xs={{ span: 12 }} className="mb-3">
                                    <h3 className="h2 text-orange text-center m-0">Never miss a deal</h3>
                                </Col>
                                <Col xs={{ span: 12 }}>
                                    <Form onSubmit={onSubscribeFormSubmitHandler} noValidate autoComplete="off">
                                        <fieldset disabled={subscribeFormState?.isFormLoading}>
                                            <Form.Group controlId="subscribeInput" className="m-0">
                                                <Form.Label className="sr-only">newsletter</Form.Label>
                                                <InputGroup>
                                                    <FormControl
                                                        type="email"
                                                        name="email"
                                                        onChange={onSubscribeInputChangeHandler}
                                                        isInvalid={!!subscribeFormState?.errors?.email}
                                                        value={subscribeFormState?.values?.email || ""}
                                                        placeholder="Enter your email address."
                                                        autoComplete="email"
                                                    />
                                                    <InputGroup.Prepend>
                                                        <Button variant="primary" type="submit" className="text-capitalize px-4">
                                                            {subscribeFormState?.isFormLoading ? (
                                                                <Spinner animation="border" size="sm" />
                                                            ) : (
                                                                "Join 25,000+ Subscribers"
                                                            )}
                                                        </Button>
                                                    </InputGroup.Prepend>
                                                    {!!subscribeFormState?.errors?.email ? (
                                                        subscribeFormState.errors.email?.map(error => (
                                                            <Form.Control.Feedback key={error} type="invalid">
                                                                {error}
                                                            </Form.Control.Feedback>
                                                        ))
                                                    ) : (
                                                        <></>
                                                    )}
                                                </InputGroup>
                                                <Form.Text className="text-secondary text-center mt-3">
                                                    By signing up, you are agreeing to our terms and conditions and privacy policy. We don’t
                                                    share your email with any third party.
                                                </Form.Text>
                                            </Form.Group>
                                        </fieldset>
                                    </Form>
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
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NewsLetterSection);
