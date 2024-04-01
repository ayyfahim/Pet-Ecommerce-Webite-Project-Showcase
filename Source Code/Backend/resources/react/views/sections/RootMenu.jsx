import React from "react";
import { NavLink, useLocation } from "react-router-dom";
import { ListGroup, Nav, Button } from "react-bootstrap";
import { connect } from "react-redux";

function RootMenu(props) {
    const { pageTitle } = props;

    const location = useLocation();

    const menu = [
        { title: "My Account", path: "/dashboard/account" },
        { title: "Order summary", path: "/dashboard/orders" },
        { title: "My Rewards", path: "/dashboard/rewards" },
        { title: "change password", path: "/dashboard/account/edit" }
    ];

    return (
        <>
            <section className="root-menu">
                <header className="root-menu__header pt-4 pb-3 pt-md-5 pb-md-4">
                    <h2 className="h3 text-capitalize">{pageTitle}</h2>
                </header>
                <div className="root-menu__body">
                    <ListGroup as={Nav} variant="flush" role="menu">
                        <ListGroup.Item as={Nav.Item} className="px-0 border-0" role="menuitem">
                            <Nav.Link
                                href="#page-content"
                                className="sr-only sr-only-focusable d-inline-block text-decoration-none text-capitalize font-weight-bold px-0"
                            >
                                Skip to content
                            </Nav.Link>
                        </ListGroup.Item>
                        {menu?.map((item, i) => (
                            <ListGroup.Item as={Nav.Item} className="px-0" role="menuitem" key={i}>
                                <Nav.Link
                                    as={NavLink}
                                    to={item?.path}
                                    activeClassName={location?.pathname === item?.path ? "active" : ""}
                                    className="text-capitalize px-0"
                                >
                                    <strong>{item?.title}</strong>
                                </Nav.Link>
                            </ListGroup.Item>
                        ))}
                    </ListGroup>
                </div>
            </section>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(RootMenu);
