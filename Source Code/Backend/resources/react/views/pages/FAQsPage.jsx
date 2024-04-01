import React from "react";
import { connect } from "react-redux";
import { Container, Row, Col, Nav, Tab, Form, Button, FormControl, InputGroup } from "react-bootstrap";

import Magnifier from "../../assets/images/icons/magnifier.png";

export const FAQsPage = props => {
    const { pageTitle } = props;

    return (
        <>
            <section className="section bg-white h-100">
                <Container fluid className="px-0">
                    <Row noGutters>
                        <Tab.Container id="faqs-tabs-container" defaultActiveKey="faqs-tab-0">
                            <Col xs={{ span: 12 }}>
                                <header className="section bg-light pt-5">
                                    <Container>
                                        <Row className="justify-content-center">
                                            <Col xs={{ span: 12 }} md={{ span: 9 }} lg={{ span: 8 }} xl={{ span: 7 }} className="mb-gutter">
                                                <h1 className="h3 text-center text-capitalize">{pageTitle}</h1>
                                            </Col>
                                            <Col xs={{ span: 12 }} md={{ span: 9 }} lg={{ span: 8 }} xl={{ span: 7 }} className="mb-gutter">
                                                <Form className="w-100 pb-lg-2" noValidate>
                                                    <Form.Group controlId="faqsSearchInput" className="m-0">
                                                        <Form.Label className="sr-only">Search...</Form.Label>
                                                        <InputGroup size="lg" className="m-0">
                                                            <FormControl type="search" name="q" placeholder="Search..." spellCheck="false" />
                                                            <InputGroup.Append>
                                                                <InputGroup.Text className="p-0">
                                                                    <Button variant="link" type="submit" className="py-0">
                                                                        <img src={Magnifier} alt="" role="presentation" style={{ width: "21px", height: "21px" }} />
                                                                        <span className="sr-only">submit</span>
                                                                    </Button>
                                                                </InputGroup.Text>
                                                            </InputGroup.Append>
                                                        </InputGroup>
                                                    </Form.Group>
                                                </Form>
                                            </Col>
                                            <Col xs={{ span: 12 }}>
                                                <Nav as="ul" fill variant="tabs" className="list-inline border-0">
                                                    <Nav.Item as="li" className="list-inline-item">
                                                        <Nav.Link eventKey="faqs-tab-0" className="bg-transparent rounded-0 font-weight-bold text-capitalize py-3 white-space-nowrap">
                                                            general questions
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                    <Nav.Item as="li" className="list-inline-item">
                                                        <Nav.Link eventKey="faqs-tab-1" className="bg-transparent rounded-0 font-weight-bold text-capitalize py-3 white-space-nowrap">
                                                            buying
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                    <Nav.Item as="li" className="list-inline-item">
                                                        <Nav.Link eventKey="faqs-tab-2" className="bg-transparent rounded-0 font-weight-bold text-capitalize py-3 white-space-nowrap">
                                                            my account
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                    <Nav.Item as="li" className="list-inline-item">
                                                        <Nav.Link eventKey="faqs-tab-3" className="bg-transparent rounded-0 font-weight-bold text-capitalize py-3 white-space-nowrap">
                                                            customer support
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                    <Nav.Item as="li" className="list-inline-item">
                                                        <Nav.Link eventKey="faqs-tab-4" className="bg-transparent rounded-0 font-weight-bold text-capitalize py-3 white-space-nowrap">
                                                            shipping & returns
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                    <Nav.Item as="li" className="list-inline-item">
                                                        <Nav.Link eventKey="faqs-tab-5" className="bg-transparent rounded-0 font-weight-bold text-capitalize py-3 white-space-nowrap">
                                                            payments
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                    <Nav.Item as="li" className="list-inline-item">
                                                        <Nav.Link eventKey="faqs-tab-6" className="bg-transparent rounded-0 font-weight-bold text-capitalize py-3 white-space-nowrap">
                                                            company
                                                        </Nav.Link>
                                                    </Nav.Item>
                                                </Nav>
                                            </Col>
                                        </Row>
                                    </Container>
                                </header>
                            </Col>
                            <Col xs={{ span: 12 }}>
                                <main className="section static-page-content-section bg-white py-5">
                                    <Container>
                                        <Row>
                                            <Col xs={{ span: 12 }}>
                                                <Tab.Content>
                                                    <Tab.Pane eventKey="faqs-tab-0">
                                                        <ol>
                                                            <li>
                                                                <div>
                                                                    <h6 className="text-primary">What is deal a day?</h6>
                                                                    <p>
                                                                        Deal A Day offers multiple deals at great prices. Deals start each day at 10:00 am (NZT) ending the following day at 10:00 am.
                                                                        (NZT)
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <h6 className="text-primary">Is it free to join? Do I have to join to buy the products?</h6>
                                                                    <p>
                                                                        Yes, joining dealaday.co.nz. is absolutely free. In order to buy products from dealaday.co.nz you do not have to register with
                                                                        us: we offer the flexibility of buying products from our site as a guest user. Alternatively, Facebook members can login and
                                                                        make purchases using their Facebook Account. (Please note, we do not store your Facebook password, you login using the Facebook
                                                                        site.)
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <h6 className="text-primary">When I am buying a product where am I buying from?</h6>
                                                                    <p>
                                                                        You are buying products from dealaday.co.nz. In the case of services on offer you are buying directly from the company offering
                                                                        those services.
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <h6 className="text-primary">Are all products on offer new</h6>
                                                                    <p>
                                                                        Yes, all products on offer are new, and come in manufacturer's packing. From time to time we may offer refurbished products, but
                                                                        we will let you know up front. All products carry a manufacturer's warranty. Please read specifications on product pages for
                                                                        warranty information.
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <h6 className="text-primary">Will you offer the same product or service in future?</h6>
                                                                    <p>
                                                                        Yes, if inventory allows. If the product or service becomes available again we may be able to offer it at a similar or better
                                                                        price.
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <h6 className="text-primary">What time do I get to see the deal of the day?</h6>
                                                                    <p>
                                                                        We offer the Deal of the Day at 10:00am each day, and it remains valid until 10:00 am the next day, when a new deal is posted.
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        </ol>
                                                    </Tab.Pane>
                                                    <Tab.Pane eventKey="faqs-tab-1">
                                                        <h3 className="text-uppercase">Buying tab</h3>
                                                    </Tab.Pane>
                                                    <Tab.Pane eventKey="faqs-tab-2">
                                                        <h3 className="text-uppercase">My Account tab</h3>
                                                    </Tab.Pane>
                                                    <Tab.Pane eventKey="faqs-tab-3">
                                                        <h3 className="text-uppercase">Customer Support tab</h3>
                                                    </Tab.Pane>
                                                    <Tab.Pane eventKey="faqs-tab-4">
                                                        <h3 className="text-uppercase">Shipping & returns tab</h3>
                                                    </Tab.Pane>
                                                    <Tab.Pane eventKey="faqs-tab-5">
                                                        <h3 className="text-uppercase">Payments tab</h3>
                                                    </Tab.Pane>
                                                    <Tab.Pane eventKey="faqs-tab-6">
                                                        <h3 className="text-uppercase">Company tab</h3>
                                                    </Tab.Pane>
                                                </Tab.Content>
                                            </Col>
                                        </Row>
                                    </Container>
                                </main>
                            </Col>
                        </Tab.Container>
                    </Row>
                </Container>
            </section>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(FAQsPage);
