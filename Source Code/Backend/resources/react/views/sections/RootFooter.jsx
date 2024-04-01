import React from "react";
import { Link } from "react-router-dom";
import { connect } from "react-redux";
import { Container, Row, Col } from "react-bootstrap";

import { APP_NAME } from "../../config/globals";

import PaymentMethods from "../../assets/images/payment-methods.png";

function RootFooter(props) {
    const { globals } = props;

    return (
        <>
            <footer className="root-footer py-3" role="contentinfo" aria-label="footer">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <section className="root-footer__top">
                                <Row className="justify-content-center justify-content-lg-start">
                                    <Col xs={{ span: 8 }} sm={{ span: 6 }} md={{ span: 4 }} lg={{ span: 3 }} xl={{ span: 2 }} className="d-flex flex-column align-items-md-center my-md-0 my-gutter">
                                        <Link to="/" className="logo mb-gutter">
                                            <img src={globals?.config?.filter(config => config?.type?.toLowerCase() === "logo")?.[0]?.value} alt={`${APP_NAME} logo`} />
                                        </Link>
                                        <small className="text-center text-md-left">Best daily deals, operating since 2008.</small>
                                    </Col>
                                    <Col xs={{ span: 12 }} sm={{ span: 12 }} md={{ span: 8 }} lg={{ span: 9 }} xl={{ offset: 1 }}>
                                        <Row>
                                            <Col xs={{ span: 6 }} sm={{ span: 4 }} md={{ span: 6 }} lg className="mb-gutter mb-lg-0">
                                                <Row>
                                                    <Col xs={{ span: 12 }} className="mb-3 mb-lg-gutter">
                                                        <h3 className="h5 text-primary text-capitalize">about</h3>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <ul className="list-unstyled">
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/page/about" className="text-capitalize text-decoration-none small ml-1">
                                                                    about
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/" className="text-capitalize text-decoration-none small ml-1">
                                                                    testimonials
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/" className="text-capitalize text-decoration-none small ml-1">
                                                                    blog / news
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/page/contact-us" className="text-capitalize text-decoration-none small ml-1">
                                                                    contact us
                                                                </Link>
                                                            </li>
                                                        </ul>
                                                    </Col>
                                                </Row>
                                            </Col>
                                            <Col xs={{ span: 6 }} sm={{ span: 4 }} md={{ span: 6 }} lg className="mb-gutter mb-lg-0">
                                                <Row>
                                                    <Col xs={{ span: 12 }} className="mb-3 mb-lg-gutter">
                                                        <h3 className="h5 text-primary text-capitalize">help & support</h3>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <ul className="list-unstyled">
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/page/terms-and-conditions" className="text-capitalize text-decoration-none small ml-1">
                                                                    Terms and conditions
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/page/faqs" className="text-capitalize text-decoration-none small ml-1">
                                                                    FAQs
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/page/privacy-policy" className="text-capitalize text-decoration-none small ml-1">
                                                                    Privacy Policy
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/page/refund-policy" className="text-capitalize text-decoration-none small ml-1">
                                                                    Refund policy
                                                                </Link>
                                                            </li>
                                                        </ul>
                                                    </Col>
                                                </Row>
                                            </Col>
                                            <Col xs={{ span: 6 }} sm={{ span: 4 }} md={{ span: 6 }} lg className="mb-gutter mb-lg-0">
                                                <Row>
                                                    <Col xs={{ span: 12 }} className="mb-3 mb-lg-gutter">
                                                        <h3 className="h5 text-primary text-capitalize">corporate</h3>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <ul className="list-unstyled">
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/" className="text-capitalize text-decoration-none small ml-1">
                                                                    Advertise with us
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/" className="text-capitalize text-decoration-none small ml-1">
                                                                    recommend a product
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/" className="text-capitalize text-decoration-none small ml-1">
                                                                    jobs
                                                                </Link>
                                                            </li>
                                                        </ul>
                                                    </Col>
                                                </Row>
                                            </Col>
                                            <Col xs={{ span: 6 }} sm={{ span: 4 }} md={{ span: 6 }} lg xl={{ offset: 1 }} className="mb-gutter mb-lg-0">
                                                <Row>
                                                    <Col xs={{ span: 12 }} className="mb-3 mb-lg-gutter">
                                                        <h3 className="h5 text-primary text-capitalize">get in touch</h3>
                                                    </Col>
                                                    <Col xs={{ span: 12 }} className="mb-3 mb-lg-gutter">
                                                        <ul className="list-unstyled">
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/" className="text-capitalize text-decoration-none small ml-1">
                                                                    questions or feedback?
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <span aria-hidden="true">-</span>
                                                                <Link to="/" className="text-capitalize text-decoration-none small ml-1">
                                                                    we would love to hear from you
                                                                </Link>
                                                            </li>
                                                        </ul>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        <ul className="list-inline mb-0">
                                                            <li className="list-inline-item">
                                                                <a
                                                                    href={`${globals?.config?.filter(config => config?.type?.toLowerCase() === "facebook")?.[0]?.value || "#"}`}
                                                                    target="_blank"
                                                                    rel="noopener noreferrer"
                                                                    alt="contact us via facebook"
                                                                    aria-label="facebook link"
                                                                >
                                                                    <i className="fab fa-facebook-f" aria-hidden="true"></i>
                                                                    <span className="sr-only">facebook-f</span>
                                                                </a>
                                                            </li>
                                                            <li className="list-inline-item">
                                                                <a
                                                                    href={`${globals?.config?.filter(config => config?.type?.toLowerCase() === "linkedin")?.[0]?.value || "#"}`}
                                                                    target="_blank"
                                                                    rel="noopener noreferrer"
                                                                    alt="contact us via linkedin"
                                                                    aria-label="linkedin link"
                                                                >
                                                                    <i className="fab fa-linkedin-in" aria-hidden="true"></i>
                                                                    <span className="sr-only">linkedin in</span>
                                                                </a>
                                                            </li>
                                                            <li className="list-inline-item">
                                                                <a
                                                                    href={`${globals?.config?.filter(config => config?.type?.toLowerCase() === "twitter")?.[0]?.value || "#"}`}
                                                                    target="_blank"
                                                                    rel="noopener noreferrer"
                                                                    alt="contact us via twitter"
                                                                    aria-label="twitter link"
                                                                >
                                                                    <i className="fab fa-twitter" aria-hidden="true"></i>
                                                                    <span className="sr-only">twitter</span>
                                                                </a>
                                                            </li>
                                                            <li className="list-inline-item">
                                                                <a
                                                                    href={`${globals?.config?.filter(config => config?.type?.toLowerCase() === "instagram")?.[0]?.value || "#"}`}
                                                                    target="_blank"
                                                                    rel="noopener noreferrer"
                                                                    alt="contact us via instagram"
                                                                    aria-label="instagram link"
                                                                >
                                                                    <i className="fab fa-instagram" aria-hidden="true"></i>
                                                                    <span className="sr-only">instagram</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </Col>
                                                </Row>
                                            </Col>
                                        </Row>
                                    </Col>
                                </Row>
                            </section>
                        </Col>
                        <Col xs={{ span: 12 }}>
                            <hr />
                        </Col>
                        <Col xs={{ span: 12 }}>
                            <section className="root-footer__bottom">
                                <Row className="align-items-center">
                                    <Col xs={{ span: 8, offset: 2 }} md={{ span: 6, offset: 0 }} className="d-md-flex align-items-md-center my-lg-0 my-gutter">
                                        <p className="mb-0 text-lg-left text-center">
                                            <small>© 2020, All rights reserved. {APP_NAME}</small>
                                        </p>
                                    </Col>
                                    <Col xs={{ span: 8, offset: 2 }} md={{ span: 6, offset: 0 }} className="d-flex justify-content-center justify-content-md-end my-lg-0 my-gutter">
                                        <img src={PaymentMethods} className="img-fluid" alt="" role="presentation" />
                                    </Col>
                                </Row>
                            </section>
                        </Col>
                    </Row>
                </Container>
            </footer>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(RootFooter);
