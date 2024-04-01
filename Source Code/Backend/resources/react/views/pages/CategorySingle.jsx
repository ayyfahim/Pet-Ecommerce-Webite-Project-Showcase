/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { connect } from "react-redux";
import { Container, Row, Col, Spinner, Card, ListGroup, Form } from "react-bootstrap";
import { to } from "await-to-js";
import qs from "qs";

import * as actions from "../../store/rootActions";
import CategoriesService from "../../services/CategoriesService";

import NoDataSection from "../sections/NoDataSection";
import PaginationSection from "../sections/PaginationSection";

export const CategorySingle = props => {
    const {
        history: {
            location: { pathname, search },
            push
        },
        match: { params },
        categories,
        onAddFlashMessage
    } = props;

    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    // Component State.
    const initialCategoryState = {};
    const initialQueryState = { ...queryParams };
    const initialFilterFormState = { isFormLoading: false, values: { ...queryParams }, errors: {} };
    const initialCategoriesState = [];
    const initialSubCategoriesState = [];
    const initialAttributesState = [];
    const initialPaginationState = {};
    const initialPageLoadingState = false;
    const initialCategoriesLoadingState = false;
    const [filterFormState, setFilterFormState] = useState(initialFilterFormState);
    const [queryState, setQueryState] = useState(initialQueryState);
    const [categoryState, setCategoryState] = useState(initialCategoryState);
    const [pageLoadingState, setPageLoadingState] = useState(initialPageLoadingState);
    const [categoriesLoadingState, setCategoriesLoadingState] = useState(initialCategoriesLoadingState);
    const [categoriesState, setCategoriesState] = useState(initialCategoriesState);
    const [paginationState, setPaginationState] = useState(initialPaginationState);
    const [subCategoriesState, setSubCategoriesState] = useState(initialSubCategoriesState);
    const [attributesState, setAttributesState] = useState(initialAttributesState);

    // API Calls.
    const getSingleCategoryData = async () => {
        const [categoryErrors, categoryResponse] = await to(CategoriesService.single(params, queryState));
        if (categoryErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = categoryErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setPageLoadingState(false);
            setCategoriesLoadingState(false);
            return false;
        }

        const {
            data: {
                data: categories,
                meta: { attributes, pagination, category, sub_categories }
            }
        } = categoryResponse;

        setCategoriesState([...categories]);
        setPaginationState({ ...pagination });
        setCategoryState({ ...category });
        setSubCategoriesState([...sub_categories]);
        setAttributesState([...attributes]);
        setPageLoadingState(false);
        setCategoriesLoadingState(false);
    };

    // Component Hooks
    useEffect(() => {
        push({ pathname, search: `?${qs.stringify(queryState)}` });
        return () => false;
    }, [queryState]);

    useEffect(() => {
        setCategoriesLoadingState(true);
        setPageLoadingState(true);
        getSingleCategoryData();
        return () => false;
    }, [params?.slug]);

    useEffect(() => {
        setCategoriesLoadingState(true);
        getSingleCategoryData();
        return () => false;
    }, [search]);

    useEffect(() => {
        setQueryState({ ...queryState, ...filterFormState?.values });
        return () => false;
    }, [filterFormState?.values]);

    const onChangePaginationHandler = (e, page) => setQueryState({ ...queryState, page });
    const onFilterFormInputChangeHandler = e =>
        setFilterFormState({
            ...filterFormState,
            values: {
                ...filterFormState?.values,
                [e.target.name]: ["checkbox", "radio"].includes(e.target.type) ? toggleCheckboxesValues(e.target, filterFormState) : e.target.value
            }
        });
    const toggleCheckboxesValues = (target, state) => {
        let elementName = target.name;
        let elementValue = target.value;
        let elementCheckedState = target.checked;

        if (elementCheckedState) {
            if (state[elementName]?.includes(elementValue)) {
                let index = state[elementName]?.indexOf(elementValue);
                if (index >= 0) {
                    return [...state[elementName].slice(0, index), ...state[elementName].slice(index + 1)];
                }
            }
        }

        return Array.from(document.querySelectorAll(`input[name='${target.name}']:checked`)).map(item => item.value);
    };

    return (
        <>
            <section className="section bg-white py-5">
                <Container>
                    <Row>
                        {pageLoadingState ? (
                            <>
                                <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                    <Spinner animation="border" variant="primary" />
                                </Col>
                            </>
                        ) : (
                            <>
                                <Col xs={{ span: 12 }} md={{ span: 3 }} className="mb-5 mb-md-0">
                                    <section>
                                        <Row>
                                            {attributesState?.length ? (
                                                attributesState?.map((attribute, i) => (
                                                    <Col xs={{ span: 12 }} className="mb-5" key={attribute?.label}>
                                                        <Row>
                                                            <Col xs={{ span: 12 }}>
                                                                <h3 className="h5 text-capitalize">{attribute?.label}</h3>
                                                            </Col>
                                                            <Col xs={{ span: 12 }}>
                                                                {attribute?.options?.length ? (
                                                                    <ListGroup variant="flush" className="border-bottom customized-scroll" role="menu">
                                                                        {attribute.options.map(option => (
                                                                            <ListGroup.Item role="menuitem" key={option?.id}>
                                                                                <Form.Check
                                                                                    custom
                                                                                    name="attributes"
                                                                                    value={option?.value}
                                                                                    type="checkbox"
                                                                                    id={`attribute-${option?.id}`}
                                                                                    label={option?.value}
                                                                                    onChange={onFilterFormInputChangeHandler}
                                                                                    checked={
                                                                                        (filterFormState?.values?.attributes?.length && filterFormState?.values?.attributes?.includes(option?.value)) ||
                                                                                        undefined
                                                                                    }
                                                                                />
                                                                            </ListGroup.Item>
                                                                        ))}
                                                                    </ListGroup>
                                                                ) : (
                                                                    <></>
                                                                )}
                                                            </Col>
                                                        </Row>
                                                    </Col>
                                                ))
                                            ) : (
                                                <></>
                                            )}
                                            <Col xs={{ span: 12 }} className="mb-5">
                                                <Row>
                                                    <Col xs={{ span: 12 }}>
                                                        <h3 className="h5 text-capitalize">categories</h3>
                                                    </Col>
                                                    <Col xs={{ span: 12 }}>
                                                        {subCategoriesState?.length ? (
                                                            <ListGroup variant="flush" className="border-bottom customized-scroll" role="menu">
                                                                {subCategoriesState.map(category => (
                                                                    <ListGroup.Item role="menuitem" key={category?.id}>
                                                                        <Form.Check
                                                                            custom
                                                                            name="sub_categories"
                                                                            value={category?.id}
                                                                            type="checkbox"
                                                                            id={`sub-category-${category?.id}`}
                                                                            label={category?.name}
                                                                            onChange={onFilterFormInputChangeHandler}
                                                                            checked={
                                                                                (filterFormState?.values?.sub_categories?.length && filterFormState?.values?.sub_categories?.includes(category?.id)) ||
                                                                                undefined
                                                                            }
                                                                        />
                                                                    </ListGroup.Item>
                                                                ))}
                                                            </ListGroup>
                                                        ) : (
                                                            <></>
                                                        )}
                                                    </Col>
                                                </Row>
                                            </Col>
                                        </Row>
                                    </section>
                                </Col>
                                <Col xs={{ span: 12 }} md={{ span: 9 }}>
                                    <article id="page-content">
                                        <Row>
                                            <Col xs={{ span: 12 }}>
                                                <Row className="mb-gutter align-items-center">
                                                    <Col xs={{ span: 6 }} md>
                                                        <h2 className="h3 text-capitalize m-0">{categoryState?.name}</h2>
                                                    </Col>
                                                </Row>
                                            </Col>
                                            <Col xs={{ span: 12 }}>
                                                <section className="categories-listing-section">
                                                    <Row>
                                                        <Col xs={{ span: 12 }}>
                                                            {categoriesLoadingState ? (
                                                                <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                                                    <Spinner animation="border" variant="primary" />
                                                                </Col>
                                                            ) : categoriesState?.length ? (
                                                                <Row>
                                                                    {categoriesState?.map(category => (
                                                                        <Col key={category?.id} xs={{ span: 12 }} md={{ span: 6 }} lg={{ span: 4 }} className="mb-gutter">
                                                                            <Card className="category-single-card h-100">
                                                                                <Link to={`/products?category_id=${category?.id}`} className="d-block">
                                                                                    <Card.Img
                                                                                        variant="top"
                                                                                        src={category?.badge?.img}
                                                                                        alt={category?.badge?.alt}
                                                                                        className="bg-white"
                                                                                        style={{
                                                                                            height: "200px",
                                                                                            objectFit: "cover",
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
                                                                    ))}
                                                                </Row>
                                                            ) : (
                                                                <>
                                                                    <NoDataSection />
                                                                </>
                                                            )}
                                                        </Col>
                                                        {categoriesState?.length && paginationState?.total_pages > 1 && !pageLoadingState ? (
                                                            <Col xs={{ span: 12 }} className="mt-gutter">
                                                                <PaginationSection paginatingData={paginationState} onClickHandler={onChangePaginationHandler} />
                                                            </Col>
                                                        ) : (
                                                            <></>
                                                        )}
                                                    </Row>
                                                </section>
                                            </Col>
                                        </Row>
                                    </article>
                                </Col>
                            </>
                        )}
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

export default connect(mapStateToProps, mapDispatchToProps)(CategorySingle);
