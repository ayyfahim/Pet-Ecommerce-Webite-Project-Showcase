/* eslint-disable react-hooks/exhaustive-deps */
import React from "react";
import { connect } from "react-redux";
import { Container, Row, Col } from "react-bootstrap";

import AboutUsImage from "../../assets/images/about-us.jpg";
import Client1Image from "../../assets/images/clients/client-1.png";
import Client2Image from "../../assets/images/clients/client-2.png";

export const AboutPage = props => {
    const { pageTitle } = props;

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
                                <Col xs={{ span: 12 }}>
                                    <section className="section static-page-content-section">
                                        <Row className="align-items-lg-center">
                                            <Col xs={{ span: 12, order: 1 }} lg={{ span: 6, order: 2 }} className="mb-gutter mb-lg-0">
                                                <div className="py-lg-4">
                                                    <h2 className="h4 mb-4">
                                                        Welcome to Deal<span className="text-orange">a</span>day
                                                    </h2>
                                                    <p className="small">
                                                        Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate
                                                        cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat
                                                        auctor eu in elit. Class aptent taciti sociosqu ad litora.
                                                    </p>
                                                    <br />
                                                    <p className="small">
                                                        Torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non
                                                        neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut
                                                        aliquam massa nisl quis neque. Suspendisse in orci enim.
                                                    </p>
                                                </div>
                                            </Col>
                                            <Col xs={{ span: 12, order: 2 }} lg={{ span: 6, order: 1 }}>
                                                <img src={AboutUsImage} className="img-fluid w-lg-95 w-100" alt="" role="presentation" />
                                            </Col>
                                        </Row>
                                    </section>
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </Container>
            </section>
            <section className="section static-page-content-section bg-light py-6">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }} lg={{ span: 6 }} className="mb-gutter mb-lg-0">
                            <h2 className="h4 mb-4 text-capitalize">our vision</h2>
                            <p className="small">
                                Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora. Torquent per
                                conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi.
                                Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                            </p>
                        </Col>
                        <Col xs={{ span: 12 }} lg={{ span: 6 }}>
                            <h2 className="h4 mb-4 text-capitalize">our mission</h2>
                            <p className="small">
                                Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora. Torquent per
                                conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi.
                                Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                            </p>
                        </Col>
                    </Row>
                </Container>
            </section>
            <section className="section static-page-content-section bg-white py-6">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }} className="mb-gutter">
                            <h2 className="h4 text-capitalize text-center">as seen on</h2>
                        </Col>
                        <Col xs={{ span: 12 }}>
                            <Row>
                                <Col xs={{ span: 12, offset: 0 }} sm={{ span: 10, offset: 1 }} md={{ span: 8, offset: 2 }} lg={{ span: 6, offset: 3 }}>
                                    <Row className="align-items-center">
                                        <Col>
                                            <img src={Client1Image} className="img-fluid" alt="client 1" />
                                        </Col>
                                        <Col>
                                            <img src={Client2Image} className="img-fluid" alt="client 2" />
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
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(AboutPage);
