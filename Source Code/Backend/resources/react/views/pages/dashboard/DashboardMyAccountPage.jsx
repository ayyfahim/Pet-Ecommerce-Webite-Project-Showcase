/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
import { Container, Row, Col, Button, Collapse, Spinner, Form, Card } from "react-bootstrap";
import { object, string } from "yup";
import to from "await-to-js";
import { useFormik } from "formik";

import * as actions from "../../../store/rootActions";
import { ADDRESS_COUNTRY_NAME } from "../../../config/globals";
import AuthService from "../../../services/AuthService";
import AddressService from "../../../services/AddressService";

import RootMenu from "../../sections/RootMenu";
import Badge1 from "../../../assets/images/badges/badge-1.png";
import Badge2 from "../../../assets/images/badges/badge-2.png";
import Badge3 from "../../../assets/images/badges/badge-3.png";
import Badge4 from "../../../assets/images/badges/badge-4.png";

function DashboardMyAccountPage(props) {
    const {
        pageTitle,
        history: { push },
        match: { params },
        auth: { user },
        onAddFlashMessage,
        onChangeUserState
    } = props;

    // Component state.
    const initialAddressFormVisibilityState = false;
    const initialAddressFormState = {
        values: {
            country: ADDRESS_COUNTRY_NAME,
            name: "",
            email: "",
            phone: "",
            title: "",
            business_name: "",
            street_address: "",
            area: "",
            city: "",
            postal_code: ""
        }
    };
    const [addressFormVisibilityState, setAddressFormVisibilityState] = useState(initialAddressFormVisibilityState);
    const [addressFormState, setAddressFormState] = useState(initialAddressFormState);

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

    // Component hooks.
    useEffect(() => {
        if (params?.addressId) {
            let { id, address_info_id, country, ...resetAddressData } = user?.addresses?.filter(
                address => address?.id === params?.addressId
            )?.[0];
            setAddressFormState({
                ...addressFormState,
                values: { ...addressFormState?.values, ...(country ? { country } : { country: ADDRESS_COUNTRY_NAME }), ...resetAddressData }
            });
            setAddressFormVisibilityState(true);
        }
        return () => false;
    }, [user, params?.addressId]);

    const onAddressFormCancelHandler = async e => {
        if (addressFormVisibilityState) {
            setAddressFormVisibilityState(!addressFormVisibilityState);
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            return push("/dashboard/account");
        }
        setAddressFormVisibilityState(!addressFormVisibilityState);
    };

    const formik = useFormik({
        validateOnBlur: false,
        enableReinitialize: true,
        initialValues: { ...addressFormState?.values },
        validationSchema: object().shape({
            name: string().required("name is required field."),
            email: string()
                .email("email is invalid")
                .required("email is required field."),
            phone: string().required("phone is required field."),
            title: string().required("title is required field."),
            street_address: string().required("street address is required field."),
            area: string().required("area is required field."),
            country: string().required("country is required field."),
            city: string().required("city is required field."),
            postal_code: string().required("postcode is required field.")
        }),
        onSubmit: async (values, { setSubmitting, setErrors, resetForm }) => {
            if (params?.addressId) {
                const [addressUpdateErrors, addressUpdateResponse] = await to(AddressService.update(params, values));
                if (addressUpdateErrors) {
                    const {
                        response: {
                            data: { errors }
                        }
                    } = addressUpdateErrors;

                    setErrors(errors);
                    setSubmitting(false);
                    return;
                }

                const {
                    data: { message }
                } = addressUpdateResponse;

                setSubmitting(false);
                resetForm();
                getUserData();
                setAddressFormState({ ...addressFormState, ...initialAddressFormState });
                onAddressFormCancelHandler();
                if (message) onAddFlashMessage({ type: "success", message });
            } else {
                const [addressSubmitFormErrors, addressSubmitFormResponse] = await to(AddressService?.store(values));
                if (addressSubmitFormErrors) {
                    const {
                        response: {
                            data: { errors }
                        }
                    } = addressSubmitFormErrors;

                    setErrors(errors);
                    setSubmitting(false);
                    return;
                }

                const {
                    data: { message }
                } = addressSubmitFormResponse;

                setSubmitting(false);
                resetForm();
                getUserData();
                setAddressFormState({ ...addressFormState, ...initialAddressFormState });
                onAddressFormCancelHandler();
                if (message) onAddFlashMessage({ type: "success", message });
            }
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
                                                    <section className="pt-5 pb-4 pl-md-4 pl-0">
                                                        <Row className="mb-gutter align-items-center">
                                                            <Col xs={{ span: 12 }} sm>
                                                                <p className="mb-0 text-capitalize">
                                                                    <small className="font-weight-bold text-dark">My Badges:</small>
                                                                </p>
                                                            </Col>
                                                        </Row>
                                                        <Row>
                                                            <Col xs={{ span: 12 }}>
                                                                <Row>
                                                                    <Col xs={{ span: 12 }} lg={{ span: 8 }} xl={{ span: 9 }}>
                                                                        <Row>
                                                                            <Col
                                                                                xs={{ span: 4 }}
                                                                                md={{ span: 6 }}
                                                                                lg={{ span: 4 }}
                                                                                xl={{ span: 3 }}
                                                                                className="mb-gutter"
                                                                            >
                                                                                <div className="d-flex flex-column align-items-center justify-content-center h-100">
                                                                                    <img
                                                                                        src={Badge1}
                                                                                        alt="Frequency DADer"
                                                                                        className="mb-2"
                                                                                        height="38"
                                                                                        width="auto"
                                                                                    />
                                                                                    <p className="m-0 text-capitalize small text-center">
                                                                                        Frequency DADer
                                                                                    </p>
                                                                                </div>
                                                                            </Col>
                                                                            <Col
                                                                                xs={{ span: 4 }}
                                                                                md={{ span: 6 }}
                                                                                lg={{ span: 4 }}
                                                                                xl={{ span: 3 }}
                                                                                className="mb-gutter"
                                                                            >
                                                                                <div className="d-flex flex-column align-items-center justify-content-center h-100">
                                                                                    <img
                                                                                        src={Badge2}
                                                                                        alt="Frequency DADer"
                                                                                        className="mb-2"
                                                                                        height="38"
                                                                                        width="auto"
                                                                                    />
                                                                                    <p className="m-0 text-capitalize small text-center">
                                                                                        Social Champ
                                                                                    </p>
                                                                                </div>
                                                                            </Col>
                                                                            <Col
                                                                                xs={{ span: 4 }}
                                                                                md={{ span: 6 }}
                                                                                lg={{ span: 4 }}
                                                                                xl={{ span: 3 }}
                                                                                className="mb-gutter"
                                                                            >
                                                                                <div className="d-flex flex-column align-items-center justify-content-center h-100">
                                                                                    <img
                                                                                        src={Badge3}
                                                                                        alt="Frequency DADer"
                                                                                        className="mb-2"
                                                                                        height="38"
                                                                                        width="auto"
                                                                                    />
                                                                                    <p className="m-0 text-capitalize small text-center">
                                                                                        Referral Whiz
                                                                                    </p>
                                                                                </div>
                                                                            </Col>
                                                                            <Col
                                                                                xs={{ span: 4 }}
                                                                                md={{ span: 6 }}
                                                                                lg={{ span: 4 }}
                                                                                xl={{ span: 3 }}
                                                                                className="mb-gutter"
                                                                            >
                                                                                <div className="d-flex flex-column align-items-center justify-content-center h-100">
                                                                                    <img
                                                                                        src={Badge4}
                                                                                        alt="Frequency DADer"
                                                                                        className="mb-2"
                                                                                        height="38"
                                                                                        width="auto"
                                                                                    />
                                                                                    <p className="m-0 text-capitalize small text-center">
                                                                                        Deal Master
                                                                                    </p>
                                                                                </div>
                                                                            </Col>
                                                                        </Row>
                                                                    </Col>
                                                                    <Col xs={{ span: 12 }} lg={{ span: 4 }} xl={{ span: 3 }}>
                                                                        <div className="d-flex align-items-center justify-content-center p-1 bg-light h-100 w-100">
                                                                            <p className="mb-0 text-capitalize">info</p>
                                                                        </div>
                                                                    </Col>
                                                                </Row>
                                                            </Col>
                                                        </Row>
                                                    </section>
                                                </Col>
                                            </Row>
                                        </section>
                                        <hr />
                                        <section>
                                            <Row>
                                                <Col xs={{ span: 12 }} md={{ span: 10 }} xl={{ span: 10 }}>
                                                    <section className="py-4 pl-md-4 pl-0">
                                                        <Row className="mb-gutter align-items-center">
                                                            <Col xs={{ span: 12 }} sm>
                                                                <h2 className="h5 text-capitalize">delivery addresses:</h2>
                                                            </Col>
                                                            <Col
                                                                xs={{ span: 12 }}
                                                                sm={{ span: 5 }}
                                                                lg={{ span: 7 }}
                                                                className="mt-3 mt-sm-0"
                                                            >
                                                                <Row className="row-cols-1 justify-content-end">
                                                                    <Col xs md={{ span: "auto" }}>
                                                                        <Button
                                                                            variant={!addressFormVisibilityState ? "primary" : "danger"}
                                                                            size="sm"
                                                                            onClick={onAddressFormCancelHandler}
                                                                            block
                                                                            className="text-capitalize px-5"
                                                                            data-target="#address-form-section"
                                                                            aria-expanded={addressFormVisibilityState}
                                                                            aria-controls="address-form-section"
                                                                        >
                                                                            {!addressFormVisibilityState ? "Add" : "Cancel"}
                                                                        </Button>
                                                                    </Col>
                                                                </Row>
                                                            </Col>
                                                        </Row>
                                                        {user?.addresses?.length ? (
                                                            <Row>
                                                                {user?.addresses?.map((address, i) => (
                                                                    <Col
                                                                        key={address?.id}
                                                                        xs={{ span: 12 }}
                                                                        sm={{ span: 6 }}
                                                                        md={{ span: 6 }}
                                                                        lg={{ span: 4 }}
                                                                        className="mb-gutter"
                                                                    >
                                                                        <Card className="border border-gray-light rounded-lg flex-column-reverse h-100">
                                                                            <Card.Header className="pb-0 pt-2 border-bottom-0">
                                                                                <h3 className="display-3 font-weight-bold mb-0 text-muted text-right address-number">
                                                                                    {i + 1}
                                                                                </h3>
                                                                            </Card.Header>
                                                                            <Card.Body className="pb-0">
                                                                                <Row noGutters>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <h4 className="text-capitalize h6 mb-4 text-dark d-flex align-items-center justify-content-between">
                                                                                            <span>{address?.title}</span>
                                                                                            {address?.id !== params?.addressId && (
                                                                                                <Button
                                                                                                    as={Link}
                                                                                                    to={`/dashboard/account/address/edit/${address?.id}`}
                                                                                                    size="sm"
                                                                                                    variant="link"
                                                                                                    className="d-flex align-items-center p-0 text-decoration-none"
                                                                                                >
                                                                                                    Edit
                                                                                                    <span
                                                                                                        className="mdi mdi-pencil mdi-20px ml-2"
                                                                                                        aria-hidden="true"
                                                                                                    ></span>
                                                                                                </Button>
                                                                                            )}
                                                                                        </h4>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <p className="mb-0 small text-secondary">
                                                                                            {address?.street_address}
                                                                                            {"\n"}
                                                                                            {address?.area},{"\n"}
                                                                                            {address?.city} {address?.postal_code}
                                                                                        </p>
                                                                                    </Col>
                                                                                </Row>
                                                                            </Card.Body>
                                                                        </Card>
                                                                    </Col>
                                                                ))}
                                                            </Row>
                                                        ) : (
                                                            <></>
                                                        )}
                                                    </section>
                                                </Col>
                                            </Row>
                                        </section>
                                        <Collapse in={addressFormVisibilityState}>
                                            <section id="#address-form-section">
                                                <Row>
                                                    <Col xs={{ span: 12 }} md={{ span: 10 }} xl={{ span: 10 }}>
                                                        <section className="py-4 pl-md-4 pl-0">
                                                            <Row className="mb-gutter align-items-center">
                                                                <Col xs={{ span: 12 }} sm>
                                                                    <h2 className="h5 text-capitalize">Shipping Address Information:</h2>
                                                                    <small>
                                                                        Please provide your shipping address information in the following
                                                                        form.
                                                                    </small>
                                                                </Col>
                                                            </Row>
                                                            <Row>
                                                                <Col xs={{ span: 12 }} md={{ span: 8 }}>
                                                                    <Form onSubmit={formik.handleSubmit} noValidate>
                                                                        <Form.Row>
                                                                            <Col xs={{ span: 12 }}>
                                                                                <Form.Row>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <Form.Group controlId="addressName">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                Name <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.name}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.name &&
                                                                                                    !!formik?.errors?.name
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.name &&
                                                                                                    !!formik?.touched?.name &&
                                                                                                    !!!formik?.errors?.name
                                                                                                }
                                                                                                name="name"
                                                                                                type="text"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Enter your first and last name"
                                                                                            />
                                                                                            {!!formik?.touched?.name &&
                                                                                                !!formik?.errors?.name && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.name}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} md={{ span: 6 }}>
                                                                                        <Form.Group controlId="addressEmail">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                Email <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.email}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.email &&
                                                                                                    !!formik?.errors?.email
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.email &&
                                                                                                    !!formik?.touched?.email &&
                                                                                                    !!!formik?.errors?.email
                                                                                                }
                                                                                                name="email"
                                                                                                type="text"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Enter your email"
                                                                                            />
                                                                                            {!!formik?.touched?.email &&
                                                                                                !!formik?.errors?.email && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.email}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} md={{ span: 6 }}>
                                                                                        <Form.Group controlId="addressPhone">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                Contact Number
                                                                                                <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.phone}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.phone &&
                                                                                                    !!formik?.errors?.phone
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.phone &&
                                                                                                    !!formik?.touched?.phone &&
                                                                                                    !!!formik?.errors?.phone
                                                                                                }
                                                                                                name="phone"
                                                                                                type="text"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Enter your phone"
                                                                                            />
                                                                                            {!!formik?.touched?.phone &&
                                                                                                !!formik?.errors?.phone && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.phone}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <Form.Group controlId="addressBusinessName">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                Business Name
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.business_name}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.business_name &&
                                                                                                    !!formik?.errors?.business_name
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.business_name &&
                                                                                                    !!formik?.touched?.business_name &&
                                                                                                    !!!formik?.errors?.business_name
                                                                                                }
                                                                                                name="business_name"
                                                                                                type="text"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Enter your business name"
                                                                                            />
                                                                                            {!!formik?.touched?.business_name &&
                                                                                                !!formik?.errors?.business_name && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.business_name}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>

                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <Form.Group controlId="addressTitle">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                name your delivery address
                                                                                                <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.title}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.title &&
                                                                                                    !!formik?.errors?.title
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.title &&
                                                                                                    !!formik?.touched?.title &&
                                                                                                    !!!formik?.errors?.title
                                                                                                }
                                                                                                name="title"
                                                                                                type="text"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Home, office, person name"
                                                                                            />
                                                                                            {!!formik?.touched?.title &&
                                                                                                !!formik?.errors?.title && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.title}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }}>
                                                                                        <Form.Group controlId="addressStreetAddress">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                street address
                                                                                                <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.street_address}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.street_address &&
                                                                                                    !!formik?.errors?.street_address
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.street_address &&
                                                                                                    !!formik?.touched?.street_address &&
                                                                                                    !!!formik?.errors?.street_address
                                                                                                }
                                                                                                name="street_address"
                                                                                                type="text"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Street address"
                                                                                                autoComplete="street-address"
                                                                                            />
                                                                                            {!!formik?.touched?.street_address &&
                                                                                                !!formik?.errors?.street_address && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.street_address}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                    <Col
                                                                                        className="d-none"
                                                                                        xs={{ span: 12 }}
                                                                                        md={{ span: 6 }}
                                                                                    >
                                                                                        <Form.Group controlId="addressCountry">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                Country
                                                                                                <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.country}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.country &&
                                                                                                    !!formik?.errors?.country
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.country &&
                                                                                                    !!formik?.touched?.country &&
                                                                                                    !!!formik?.errors?.country
                                                                                                }
                                                                                                name="country"
                                                                                                type="hidden"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Country name"
                                                                                                autoComplete="country"
                                                                                                disabled
                                                                                            />
                                                                                            {!!formik?.touched?.country &&
                                                                                                !!formik?.errors?.country && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.country}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} md={{ span: 4 }}>
                                                                                        <Form.Group controlId="addressArea">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                Suburb
                                                                                                <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.area}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.area &&
                                                                                                    !!formik?.errors?.area
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.area &&
                                                                                                    !!formik?.touched?.area &&
                                                                                                    !!!formik?.errors?.area
                                                                                                }
                                                                                                name="area"
                                                                                                type="text"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Enter suburb"
                                                                                                autoComplete="address-level2"
                                                                                            />
                                                                                            {!!formik?.touched?.area &&
                                                                                                !!formik?.errors?.area && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.area}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} md={{ span: 4 }}>
                                                                                        <Form.Group controlId="addressCity">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                Town/City
                                                                                                <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.city}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.city &&
                                                                                                    !!formik?.errors?.city
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.city &&
                                                                                                    !!formik?.touched?.city &&
                                                                                                    !!!formik?.errors?.city
                                                                                                }
                                                                                                name="city"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Town/City name"
                                                                                                autoComplete="address-level1"
                                                                                            />
                                                                                            {!!formik?.touched?.city &&
                                                                                                !!formik?.errors?.city && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.city}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                    <Col xs={{ span: 12 }} md={{ span: 4 }}>
                                                                                        <Form.Group controlId="addressPostalCode">
                                                                                            <Form.Label className="text-capitalize font-weight-light">
                                                                                                PostCode
                                                                                                <span className="text-danger">*</span>
                                                                                            </Form.Label>
                                                                                            <Form.Control
                                                                                                onChange={formik.handleChange}
                                                                                                onBlur={formik.handleBlur}
                                                                                                value={formik?.values?.postal_code}
                                                                                                isInvalid={
                                                                                                    !!formik?.touched?.postal_code &&
                                                                                                    !!formik?.errors?.postal_code
                                                                                                }
                                                                                                isValid={
                                                                                                    formik?.values?.postal_code &&
                                                                                                    !!formik?.touched?.postal_code &&
                                                                                                    !!!formik?.errors?.postal_code
                                                                                                }
                                                                                                name="postal_code"
                                                                                                type="text"
                                                                                                className="rounded-lg"
                                                                                                placeholder="Enter postcode"
                                                                                                autoComplete="postal-code"
                                                                                            />
                                                                                            {!!formik?.touched?.postal_code &&
                                                                                                !!formik?.errors?.postal_code && (
                                                                                                    <Form.Control.Feedback type="invalid">
                                                                                                        {formik.errors.postal_code}
                                                                                                    </Form.Control.Feedback>
                                                                                                )}
                                                                                        </Form.Group>
                                                                                    </Col>
                                                                                </Form.Row>
                                                                            </Col>
                                                                            <Col xs={{ span: 12 }}>
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
                                                                                            ) : params?.addressId ? (
                                                                                                "Submit"
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
                                        </Collapse>
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

export default connect(mapStateToProps, mapDispatchToProps)(DashboardMyAccountPage);
