/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useCallback, useEffect } from "react";
import { NavLink, Link } from "react-router-dom";
import { connect } from "react-redux";
import { Container, Row, Col, Badge, Nav, Dropdown, Form, InputGroup, FormControl, Button } from "react-bootstrap";
import to from "await-to-js";
import { debounce } from "lodash";
import Highlighter from "react-highlight-words";

import * as actions from "../../store/rootActions";
import { APP_NAME, DEBOUNCE_TIME_OUT } from "../../config/globals";
import AuthService from "../../services/AuthService";
import ProductService from "../../services/ProductService";

import RootAlerts from "./RootAlerts";
import CategoriesMenu from "./CategoriesMenu";
import QualityProductBadge from "../components/SVG/Badges/QualityProductBadge";
import EaseReturnBadge from "../components/SVG/Badges/EaseReturnBadge";
import RewardsBadge from "../components/SVG/Badges/RewardsBadge";
import LoginBadge from "../components/SVG/Badges/LoginBadge";
import CartBadge from "../components/SVG/Badges/CartBadge";
import HeartBadge from "../components/SVG/Badges/HeartBadge";
import TrackOrderBadge from "../components/SVG/Badges/TrackOrderBadge";
import Avatar from "../components/Avatar/Avatar";
import YearsBadge from "../../assets/images/icons/12-years-badge.png";
import Magnifier from "../../assets/images/icons/magnifier.png";

function RootHeader(props) {
    const {
        auth: { isAuthenticated, user },
        ui: { isCategoriesMenuOpen },
        cart,
        globals,
        onAddFlashMessage,
        onLogoutUserData,
        onChangeCategoriesMenuState
    } = props;

    // Component State.
    const initialSearchResultsDropdownState = [];
    const initialSearchFormState = {};
    const [searchResultsDropdownState, setSearchResultsDropdownState] = useState(initialSearchResultsDropdownState);
    const [searchFormState, setSearchFormState] = useState(initialSearchFormState);

    // API Calls.
    const fetchSearchProductsData = async query => {
        const [productsErrors, productsResponse] = await to(ProductService.listing({ source: "header", ...query }));
        if (productsErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = productsErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            return;
        }

        const {
            data: { products }
        } = productsResponse;

        setSearchResultsDropdownState([...products]);
    };

    let debounceEvent = useCallback((...args) => {
        debounceEvent = debounce(...args);
        return e => {
            if (!e) e = window.event;
            e.persist();
            return debounceEvent(e);
        };
    });

    useEffect(() => {
        return () => {
            debounceEvent.cancel();
            return false;
        };
    }, []);

    // Event Handlers
    const logoutClickEventHandler = async e => {
        const [logoutErrors, logoutResponse] = await to(AuthService.logout());
        if (logoutErrors) {
            const {
                response: {
                    data: { message }
                }
            } = logoutErrors;

            if (message) onAddFlashMessage({ type: "danger", message });
            return;
        }

        const {
            data: { message }
        } = logoutResponse;

        if (message) onAddFlashMessage({ type: "success", message });
        onLogoutUserData();
    };

    const searchChangeHandler = e => {
        setSearchFormState({ [e.target.name]: e.target.value });
        fetchSearchProductsData({ [e.target.name]: e.target.value });
    };

    return (
        <>
            <header className="root-header">
                <Container fluid className="position-relative">
                    <RootAlerts />
                    <CategoriesMenu />
                    <Row className="justify-content-center">
                        <Col xs={{ span: 12 }}>
                            <Row>
                                <Col xs={{ span: 12, order: 5 }} sm={{ span: 12 }} lg={{ span: 6, order: 1 }} className="py-2 root-header__top">
                                    <ul className="list-inline mb-0 d-flex align-items-center root-header__features-list">
                                        <li className="list-inline-item d-flex align-items-center">
                                            <span className="mr-2">
                                                <img src={YearsBadge} alt="" role="presentation" />
                                            </span>
                                            <span className="text-capitalize small">operating over 12 years</span>
                                        </li>
                                        <li className="list-inline-item d-flex align-items-center">
                                            <span className="mr-2">
                                                <QualityProductBadge />
                                            </span>
                                            <span className="text-capitalize small">quality products</span>
                                        </li>
                                        <li className="list-inline-item d-flex align-items-center">
                                            <span className="mr-2">
                                                <EaseReturnBadge />
                                            </span>
                                            <span className="text-capitalize small">ease return policy</span>
                                        </li>
                                        <li className="list-inline-item d-flex align-items-center">
                                            <span className="mr-2">
                                                <RewardsBadge />
                                            </span>
                                            <span className="text-capitalize small">earn rewards</span>
                                        </li>
                                    </ul>
                                </Col>
                                <Col xs={{ span: 7, order: 2 }} sm={{ span: 8 }} lg={{ span: 6 }} className="py-2 root-header__top">
                                    <nav aria-label="header navigation" className="h-100 d-flex align-items-center justify-content-md-end justify-content-center root-header__nav-list">
                                        <ul className="list-inline mb-0 d-flex align-items-center w-100">
                                            <li className="list-inline-item m-0 mx-md-2 flex-fill">
                                                <a className="sr-only sr-only-focusable d-inline-block text-decoration-none text-center text-md-left" href="#main-content">
                                                    Skip to content
                                                </a>
                                            </li>
                                            <li className="list-inline-item">
                                                <Link to="/orders/track" className="d-flex align-items-center text-decoration-none text-center text-md-left">
                                                    <span className="mr-md-2 mb-md-0 mb-2" style={{ height: "22px", width: "22px" }}>
                                                        <TrackOrderBadge />
                                                    </span>
                                                    <span className="text-capitalize small">track order</span>
                                                </Link>
                                            </li>
                                            <li className="list-inline-item">
                                                <Link to="/lists/wishlist" className="d-flex align-items-center text-decoration-none text-center text-md-left">
                                                    <span className="mr-md-2 mb-md-0 mb-2">
                                                        <HeartBadge />
                                                    </span>
                                                    <span className="text-capitalize small">wishlist</span>
                                                </Link>
                                            </li>
                                            <li className="list-inline-item">
                                                <Link to="/cart" className="d-flex align-items-center text-decoration-none text-center text-md-left">
                                                    <span className="mr-md-2 mb-md-0 mb-2 d-flex align-items-start">
                                                        <span className="float-left">
                                                            <CartBadge />
                                                        </span>
                                                        {cart?.items?.length ? (
                                                            <>
                                                                <Badge variant="warning" pill className="rounded-pill" style={{ marginLeft: "-12px" }}>
                                                                    {cart.items.length >= 100 ? "+99" : cart.items.length}
                                                                </Badge>
                                                            </>
                                                        ) : (
                                                            <></>
                                                        )}
                                                    </span>
                                                    <span className="text-capitalize small">my cart</span>
                                                </Link>
                                            </li>
                                            {isAuthenticated ? (
                                                <li className="list-inline-item">
                                                    <Dropdown>
                                                        <Dropdown.Toggle
                                                            variant="transparent"
                                                            id="headerDropdown"
                                                            className="d-flex align-items-center justify-content-start border-0 w-100 text-white rounded-pill px-1 py-0"
                                                        >
                                                            <Avatar src={user?.service?.data?.logo} appearance="circle" size="sm" title={user?.full_name} />
                                                            <span className="text-truncate text-capitalize font-weight-light ml-2 mr-auto text-primary" style={{ maxWidth: "70px" }}>
                                                                {user?.full_name}
                                                            </span>
                                                        </Dropdown.Toggle>
                                                        <Dropdown.Menu className="rounded-bottom-lg w-100 mt-1">
                                                            <Dropdown.Item as={Link} to="/dashboard/account" className="text-capitalize small">
                                                                My account
                                                            </Dropdown.Item>
                                                            <Dropdown.Divider />
                                                            <Dropdown.Item as={Link} to="/dashboard/orders" className="text-capitalize small">
                                                                order summery
                                                            </Dropdown.Item>
                                                            <Dropdown.Divider />
                                                            <Dropdown.Item as={Link} to="/dashboard/account" className="text-capitalize small">
                                                                my rewards
                                                            </Dropdown.Item>
                                                            <Dropdown.Divider />
                                                            <Dropdown.Item as={Link} to="/dashboard/account/edit" className="text-capitalize small">
                                                                change password
                                                            </Dropdown.Item>
                                                            <Dropdown.Divider />
                                                            <Dropdown.Item as={Button} variant="link" onClick={logoutClickEventHandler} className="text-capitalize small text-primary">
                                                                logout
                                                            </Dropdown.Item>
                                                        </Dropdown.Menu>
                                                    </Dropdown>
                                                </li>
                                            ) : (
                                                <li className="list-inline-item">
                                                    <Link to="/login" className="d-flex align-items-center text-decoration-none text-center text-md-left">
                                                        <span className="mr-md-2 mb-md-0 mb-2">
                                                            <LoginBadge />
                                                        </span>
                                                        <span className="text-capitalize small">login</span>
                                                    </Link>
                                                </li>
                                            )}
                                        </ul>
                                    </nav>
                                </Col>
                                <Col xs={{ span: 5, order: 1 }} sm={{ span: 4 }} lg={{ span: 2, order: 3 }} className="py-2 pb-md-0 root-header__bottom">
                                    <Link to="/" className="logo">
                                        <img src={globals?.config?.filter(config => config?.type?.toLowerCase() === "logo")?.[0]?.value} alt={`${APP_NAME} logo`} />
                                    </Link>
                                </Col>
                                <Col xs={{ span: 12, order: 3 }} sm={{ span: 12 }} lg={{ span: 6, order: 4 }} className="pt-lg-2 border-bottom border-lg-bottom-0 root-header__bottom">
                                    <Row className="h-100">
                                        <Col xs={{ span: 12 }} lg={{ span: 10, offset: 2 }}>
                                            <nav aria-label="header navigation" className="root-header__dropdown-nav h-100">
                                                <Nav as="ul" variant="tabs" className="nav-md-fill h-100">
                                                    <Nav.Item as="li">
                                                        <Nav.Link as={NavLink} to="/" exact className="text-capitalize h-100 d-flex align-items-center justify-content-center">
                                                            <strong className="text-dark">Todays Deal</strong>
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                    <Nav.Item as="li">
                                                        <Nav.Link as={NavLink} to="/deals/past" exact className="text-capitalize h-100 d-flex align-items-center justify-content-center">
                                                            <strong className="text-dark">past Deals</strong>
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                    <Nav.Item as="li">
                                                        <Button
                                                            variant="link"
                                                            block
                                                            onClick={() => onChangeCategoriesMenuState(!isCategoriesMenuOpen)}
                                                            className={`text-capitalize nav-link h-100 d-flex align-items-center justify-content-lg-between justify-content-center rounded-0 ${
                                                                isCategoriesMenuOpen ? "active" : ""
                                                            }`}
                                                        >
                                                            <strong className="text-dark">categories</strong>
                                                            <span className="mdi mdi-chevron-down mdi-18px ml-3" aria-hidden="true"></span>
                                                        </Button>
                                                    </Nav.Item>
                                                </Nav>
                                            </nav>
                                        </Col>
                                    </Row>
                                </Col>
                                <Col
                                    xs={{ span: 12, order: 4 }}
                                    md={{ order: 3 }}
                                    lg={{ span: 4, order: 5 }}
                                    xl={{ span: 3 }}
                                    className="pt-lg-2 d-flex align-items-center d-md-block border-bottom border-lg-bottom-0 root-header__bottom root-header__search-form"
                                >
                                    <Form className="w-100 pb-lg-2" noValidate>
                                        <Form.Group controlId="userManagerFilterSearch" className="m-0 border-bottom">
                                            <Form.Label className="sr-only">Search...</Form.Label>
                                            <InputGroup className="m-0 flex-row-reverse">
                                                <FormControl
                                                    type="search"
                                                    name="q"
                                                    onChange={debounceEvent(searchChangeHandler, DEBOUNCE_TIME_OUT)}
                                                    placeholder="Search..."
                                                    className="border-0 rounded-0 bg-transparent"
                                                    spellCheck="false"
                                                />
                                                <InputGroup.Prepend as={Dropdown} show={searchResultsDropdownState?.length ? true : null}>
                                                    <Dropdown.Toggle variant="link" className="p-0 border-0 rounded-0 bg-transparent">
                                                        <img src={Magnifier} alt="" role="presentation" style={{ width: "21px", height: "21px" }} />
                                                        <span className="sr-only">submit</span>
                                                    </Dropdown.Toggle>
                                                    <Dropdown.Menu>
                                                        {searchResultsDropdownState?.length ? (
                                                            searchResultsDropdownState?.map((product, i) => (
                                                                <Dropdown.Item as={Link} to={`/products/${product?.slug}`} eventKey={i} key={product?.id} className="text-truncate">
                                                                    <Highlighter searchWords={[searchFormState?.q]} autoEscape={true} textToHighlight={product?.title} />
                                                                </Dropdown.Item>
                                                            ))
                                                        ) : (
                                                            <></>
                                                        )}
                                                    </Dropdown.Menu>
                                                </InputGroup.Prepend>
                                            </InputGroup>
                                        </Form.Group>
                                    </Form>
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </Container>
            </header>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onLogoutUserData: () => dispatch(actions.logoutUserData()),
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload)),
    onChangeCategoriesMenuState: payload => dispatch(actions.changeCategoriesMenuState(payload))
});
export default connect(mapStateToProps, mapDispatchToProps)(RootHeader);
