import React from "react";
import { Link } from "react-router-dom";
import { Container, Row, Col, Card, Spinner } from "react-bootstrap";

function CategoriesSection(props) {
    const { categories, isLoading } = props;

    return (
        <>
            <section className="section bg-white py-5">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <h2 className="h3 text-capitalize text-center mb-4">featured categories</h2>
                        </Col>
                        <Col xs={{ span: 12 }} className="mt-gutter">
                            <Row>
                                {isLoading ? (
                                    <>
                                        {[1, 2, 3, 4]?.map((category, i) => (
                                            <Col xs={{ span: 12 }} md={{ span: 6 }} className="mb-gutter" key={category}>
                                                <Card
                                                    className="bg-light border-0 d-flex align-items-center justify-content-center"
                                                    style={{ height: "450px" }}
                                                >
                                                    <Spinner animation="border" size="sm" variant="primary" />
                                                </Card>
                                            </Col>
                                        ))}
                                    </>
                                ) : (
                                    <>
                                        {categories?.map((category, i) => (
                                            <Col xs={{ span: 12 }} md={{ span: 6 }} className="mb-gutter" key={category?.id}>
                                                <Card className="text-white bg-light category-card border-0">
                                                    <Link to={`/products?category_id=${category?.id}`} className="stretched-link"></Link>
                                                    <Card.Img src={category?.badge?.img} alt={category?.badge?.alt} />
                                                    <Card.ImgOverlay className="d-flex flex-column justify-content-end p-4">
                                                        <Card.Title className="text-white mb-0 text-capitalize">
                                                            {category?.name}
                                                        </Card.Title>
                                                        <Card.Text className="font-weight-bold">
                                                            <small>{category?.description}</small>
                                                        </Card.Text>
                                                    </Card.ImgOverlay>
                                                </Card>
                                            </Col>
                                        ))}
                                    </>
                                )}
                            </Row>
                        </Col>
                    </Row>
                </Container>
            </section>
        </>
    );
}

export default CategoriesSection;
