import React, { useEffect } from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
import { Card, CardColumns, Row, Col, Tab, ListGroup } from "react-bootstrap";
import { Animated } from "react-animated-css";

export const CategoriesMegaMenu = props => {
    const {
        ui: { isCategoriesMenuOpen },
        categories
    } = props;

    useEffect(() => {
        // Header Scroll Effect.
        let header = document.querySelector(".root-header");
        let lastScrollTop = header?.offsetTop;

        // onScroll function.
        const resizeCategoriesMenuOnScroll = () => {
            let doc = document.documentElement;
            let categoriesMenu = header?.querySelector(".categories-menu");
            let wScroll = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
            let headerHeight = header?.getBoundingClientRect().height || header?.clientHeight || 0;
            let headerChangePoint = headerHeight;

            if (wScroll > headerChangePoint) {
                if (wScroll < lastScrollTop || window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
                    if (categoriesMenu) categoriesMenu.style.height = `calc(100vh - ${headerHeight}px - 2rem)`;
                } else {
                    if (categoriesMenu) categoriesMenu.style.height = `calc(100vh - 2rem)`;
                }
            } else {
                if (categoriesMenu) categoriesMenu.style.height = `calc(100vh - ${headerHeight}px - 2rem)`;
            }
            lastScrollTop = wScroll;
        };
        resizeCategoriesMenuOnScroll();
        window.addEventListener("scroll", resizeCategoriesMenuOnScroll);
        window.addEventListener("resize", resizeCategoriesMenuOnScroll);

        return () => {
            window.removeEventListener("scroll", resizeCategoriesMenuOnScroll);
            window.removeEventListener("resize", resizeCategoriesMenuOnScroll);
        };
    }, [categories]);

    return (
        <>
            <Animated
                className="categories-menu rounded-bottom-lg overflow-hidden shadow-lg bg-white"
                animationIn="fadeInDown"
                animationOut="fadeOutUp"
                isVisible={isCategoriesMenuOpen}
                animateOnMount={false}
            >
                <Tab.Container id="categories-menu-tab-container" defaultActiveKey="#category-0">
                    <Row noGutters className="h-100">
                        <Col xs={{ span: 5 }} md={{ span: 3 }} className="border-right h-100">
                            <ListGroup variant="flush" className="flex-column h-100 overflow-auto">
                                {categories?.map((category, i) => (
                                    <ListGroup.Item action key={category?.id} href={`#category-${i}`}>
                                        <p className="mb-0">
                                            <img
                                                src={`${category?.icon?.img}`}
                                                alt={`${category?.icon?.alt}`}
                                                role="presentation"
                                                className="mr-3 bg-white"
                                                style={{ height: "28px", objectFit: "scale-down", objectPosition: "center" }}
                                            />
                                            <span className="text-truncate">{category?.name}</span>
                                        </p>
                                    </ListGroup.Item>
                                ))}
                            </ListGroup>
                        </Col>
                        <Col xs={{ span: 7 }} md={{ span: 9 }} className="h-100">
                            <Tab.Content className="p-4 h-100 overflow-auto">
                                {categories?.map((category, i) => (
                                    <Tab.Pane key={category?.id} unmountOnExit eventKey={`#category-${i}`}>
                                        {category?.children?.data?.length ? (
                                            <CardColumns>
                                                {category?.children?.data?.map(category => (
                                                    <Card key={category?.id} className="border-0 rounded-0 mb-3">
                                                        <hr className="my-0 mx-3" />
                                                        <Card.Header className="py-2 pr-3 pl-0 border-0">
                                                            <h6 className="card-title mb-0 pl-3 border-top-0 border-bottom-0 border-right-0 border-left border-orange">
                                                                <Link to={`/products?category_id=${category?.id}`} className="text-reset text-capitalize text-decoration-none">
                                                                    {category?.name}
                                                                </Link>
                                                            </h6>
                                                        </Card.Header>
                                                        <hr className="my-0 mx-3" />
                                                        <Card.Body className="p-3">
                                                            {category?.children?.data?.length ? (
                                                                <ul className="list-unstyled">
                                                                    {category?.children?.data?.map(category => (
                                                                        <li key={category?.id} className="text-capitalize">
                                                                            <Link to={`/products?category_id=${category?.id}`} className="text-decoration-none">
                                                                                <small>- {category?.name}</small>
                                                                            </Link>
                                                                        </li>
                                                                    ))}
                                                                </ul>
                                                            ) : (
                                                                <></>
                                                            )}
                                                        </Card.Body>
                                                    </Card>
                                                ))}
                                            </CardColumns>
                                        ) : (
                                            <></>
                                        )}
                                    </Tab.Pane>
                                ))}
                            </Tab.Content>
                        </Col>
                    </Row>
                </Tab.Container>
            </Animated>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(CategoriesMegaMenu);
