/* eslint-disable react-hooks/exhaustive-deps */
import React, { useEffect, useState } from "react";
import { connect } from "react-redux";
import { Container, Row, Col, Spinner } from "react-bootstrap";

export const StaticPage = props => {
    const {
        match: { params },
        globals: { pages }
    } = props;

    // Component State.
    const initialPageState = {};
    const [pagesLoadingState, setPagesLoadingState] = useState(false);
    const [pageState, setPageState] = useState(initialPageState);

    // API Calls.
    const setPageData = async () => {
        const page = pages?.filter(page => page?.slug === params?.slug)?.[0];
        setPageState({ ...page });
        setPagesLoadingState(false);
    };

    // Component Hooks.
    useEffect(() => {
        setPagesLoadingState(true);
        setPageData();
        return () => false;
    }, [params?.slug, pages]);

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <h1 className="h3 font-weight-bold text-capitalize mb-0">{pageState?.title}</h1>
                        </Col>
                        <Col xs={{ span: 12 }} className="mt-4">
                            <Row>
                                {pagesLoadingState ? (
                                    <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                        <Spinner animation="border" variant="primary" />
                                    </Col>
                                ) : (
                                    <Col xs={{ span: 12 }}>
                                        <section>
                                            <Row>
                                                <Col xs={{ span: 12 }}>
                                                    <section className="section">
                                                        <Row>
                                                            {/* FIXME: fix condition */}
                                                            {pageState?.content ? (
                                                                <Col xs={{ span: 12 }} md={{ span: 8 }} className="mb-gutter" dangerouslySetInnerHTML={{ __html: pageState.content }} />
                                                            ) : (
                                                                <></>
                                                            )}
                                                        </Row>
                                                    </section>
                                                </Col>
                                            </Row>
                                        </section>
                                    </Col>
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
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(StaticPage);
