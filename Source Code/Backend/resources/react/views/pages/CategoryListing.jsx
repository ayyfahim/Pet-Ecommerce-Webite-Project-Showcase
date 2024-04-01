/* eslint-disable react-hooks/exhaustive-deps */
import React from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
import { Container, Row, Col, Card } from "react-bootstrap";

import * as actions from "../../store/rootActions";

export const CategoryListing = props => {
    const { pageTitle, categories } = props;

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <h1 className="h3 font-weight-bold text-capitalize mb-0">{pageTitle}</h1>
                        </Col>
                        <Col xs={{ span: 12 }} className="mt-4">
                            <Row className="row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 justify-content-center">
                                {categories?.length ? (
                                    categories?.map((category, i) => (
                                        <Col className="mb-gutter" key={category?.id}>
                                            <Card className="category-single-card">
                                                <Link to={`/category/${category?.slug}`} className="d-block">
                                                    <Card.Img
                                                        variant="top"
                                                        src={category?.icon?.img}
                                                        alt={category?.icon?.alt}
                                                        className="bg-white"
                                                        style={{
                                                            height: "200px",
                                                            objectFit: "scale-down",
                                                            objectPosition: "center"
                                                        }}
                                                    />
                                                </Link>
                                                <Card.Body>
                                                    <Card.Title as="h2" className="h6 text-center mb-0">
                                                        {category?.name}
                                                    </Card.Title>
                                                </Card.Body>
                                            </Card>
                                        </Col>
                                    ))
                                ) : (
                                    <></>
                                )}
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

export default connect(mapStateToProps, mapDispatchToProps)(CategoryListing);
