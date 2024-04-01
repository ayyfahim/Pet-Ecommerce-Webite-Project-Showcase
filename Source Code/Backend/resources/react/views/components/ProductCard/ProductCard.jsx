import React, { useEffect, useState } from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
import { Row, Col, Button, Card } from "react-bootstrap";

import { expiryDateRemaining } from "../../../helpers/utilities";

import ProductCardBookmark from "./ProductCardBookmark";
import StopWatch from "../../../assets/images/icons/stopwatch.png";
import ShippingBadge from "../SVG/Badges/ShippingBadge";

export const ProductCard = props => {
    const { product, showExpiryDate, clampLines = 1, expiredDeal, disabledActionButton, wishlistClickHandler } = props;

    const initialExpiryDateState = {};
    const [expiryDateState, setExpiryDateState] = useState(initialExpiryDateState);

    useEffect(() => {
        let interval;
        if (product?.deal?.expiry_date) interval = setInterval(() => setExpiryDateState(prevState => ({ ...prevState, ...expiryDateRemaining(new Date(product.deal.expiry_date).getTime()) })), 1000);
        return () => (product?.deal?.expiry_date ? clearInterval(interval) : false);
    }, [product.deal]);

    return (
        <>
            <Card className="product-card h-100">
                {product?.discount?.amount || expiredDeal ? (
                    <>
                        <ProductCardBookmark discount={product?.discount?.amount} expired={expiredDeal} />
                    </>
                ) : (
                    <></>
                )}
                <Link to={`/products/${product?.slug}`} className="d-block">
                    <Card.Img variant="top" src={product?.cover} className="bg-light overflow-hidden" />
                </Link>
                <Card.Body>
                    <Row className="h-100 no-gutters">
                        <Col xs={{ span: 12 }}>
                            <Card.Title as="h3" className={`h6 line-clamp line-clamp-${clampLines} mb-0`}>
                                <Link to={`/products/${product?.slug}`} className="text-decoration-none text-dark">
                                    {product?.title}
                                </Link>
                            </Card.Title>
                        </Col>
                        {product?.sale_price || product?.regular_price ? (
                            <>
                                <Col xs={{ span: 12 }} className="mt-3">
                                    <Row className="align-items-center no-gutters">
                                        <Col xs={{ span: 6 }} md={{ span: 7 }}>
                                            <ul className="list-inline mb-0 d-flex align-items-center">
                                                <li className="list-inline-item d-flex align-items-center">
                                                    <span className="mr-2">
                                                        <ShippingBadge />
                                                    </span>
                                                    <small className="text-capitalize">3 days</small>
                                                </li>
                                            </ul>
                                        </Col>
                                        <Col xs={{ span: 6 }} md={{ span: 5 }}>
                                            <p className="text-right text-capitalize mb-0">
                                                {product?.sale_price ? (
                                                    <>
                                                        <small>
                                                            <del>{product?.regular_price ? `$${product?.regular_price}` : 0}</del>
                                                        </small>
                                                        <br />
                                                    </>
                                                ) : (
                                                    <></>
                                                )}
                                                <strong className="h5 text-primary-dark">{product?.sale_price ? `$${product?.sale_price}` : `$${product?.regular_price}`}</strong>
                                                <br />
                                                <small>our price</small>
                                            </p>
                                        </Col>
                                    </Row>
                                </Col>
                            </>
                        ) : (
                            <></>
                        )}
                        {product?.deal?.expiry_date && showExpiryDate ? (
                            <>
                                <Col xs={{ span: 12 }}>
                                    <div className="d-flex align-items-center my-2">
                                        <span className="w-100">
                                            <hr />
                                        </span>
                                        <span className="px-3">
                                            <img src={StopWatch} alt="" role="presentation" />
                                        </span>
                                        <span className="w-100">
                                            <hr />
                                        </span>
                                    </div>
                                </Col>
                                <Col xs={{ span: 12 }}>
                                    <Row className="align-items-center" noGutters>
                                        <Col xs={{ span: "auto" }}>
                                            <p className="text-primary mb-0 font-weight-bold small">Next Deal in:</p>
                                        </Col>
                                        <Col xs sm={{ span: 12 }} md>
                                            <ul className="list-inline mb-0 text-right text-sm-left text-md-right mt-0 mt-sm-2 mt-md-0">
                                                {Object.keys(expiryDateState).map(key => (
                                                    <li className="list-inline-item font-weight-bold text-dark" key={key}>
                                                        <span className="mr-1">{`0${expiryDateState?.[key]}`.slice(-2) || "00"}</span>
                                                        <span className="text-secondary text-uppercase font-weight-bold small">{key}</span>
                                                    </li>
                                                ))}
                                            </ul>
                                        </Col>
                                    </Row>
                                </Col>
                            </>
                        ) : (
                            <></>
                        )}
                    </Row>
                </Card.Body>
                <Card.Footer className="pt-0 border-0">
                    <Row>
                        <Col xs={{ span: 3 }} className="px-2">
                            <Button
                                variant="outline-primary"
                                className="text-capitalize rounded-lg d-flex align-items-center justify-content-center px-2 py-2"
                                disabled={disabledActionButton === product?.id}
                                onClick={e => wishlistClickHandler(e, product)}
                                block
                            >
                                <i className={`mdi mdi-heart${!product?.in_wishlist ? "-outline" : ""} mdi-26px`} aria-hidden="true"></i>
                            </Button>
                        </Col>
                        <Col xs={{ span: 9 }} className="px-2">
                            <Button as={Link} to={`/products/${product?.slug}`} variant="outline-orange" block className="text-capitalize rounded-lg">
                                view details
                            </Button>
                        </Col>
                    </Row>
                </Card.Footer>
            </Card>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(ProductCard);
