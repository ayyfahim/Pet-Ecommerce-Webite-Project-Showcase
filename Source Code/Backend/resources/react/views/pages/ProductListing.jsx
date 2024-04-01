/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { Container, Row, Col, Form, ListGroup, Spinner } from "react-bootstrap";
import InputRange from "react-input-range";
import qs from "qs";
import to from "await-to-js";

import * as actions from "../../store/rootActions";
import ProductService from "../../services/ProductService";
import ListService from "../../services/ListService";

import ProductShowCaseSection from "../sections/ProductShowCaseSection";
import NoDataSection from "../sections/NoDataSection";
import PaginationSection from "../sections/PaginationSection";
import ProductCard from "../components/ProductCard/ProductCard";

function ProductListing(props) {
    const {
        history: {
            location: { pathname, search },
            push
        },
        onAddFlashMessage
    } = props;

    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    // Component State
    const initialQueryState = { ...queryParams };
    const initialFilterFormState = { isFormLoading: false, values: {}, errors: {} };
    const initialAttributesFilterState = [];
    const initialProductsState = [];
    const initialPaginationState = {};
    const initialSortState = [];
    const initialBrandsState = [];
    const initialCategoriesState = [];
    const initialPriceState = {};
    const initialTopSellingProductsState = [];
    const initialDisabledActionButtonState = "";
    const [filterFormState, setFilterFormState] = useState(initialFilterFormState);
    const [attributesFilterState, setAttributesFilterState] = useState(initialAttributesFilterState);
    const [queryState, setQueryState] = useState(initialQueryState);
    const [productsState, setProductsState] = useState(initialProductsState);
    const [productsLoadingState, setProductsLoadingState] = useState(false);
    const [paginationState, setPaginationState] = useState(initialPaginationState);
    const [sortState, setSortState] = useState(initialSortState);
    const [brandsState, setBrandsState] = useState(initialBrandsState);
    const [categoriesState, setCategoriesState] = useState(initialCategoriesState);
    const [priceState, setPriceState] = useState(initialPriceState);
    const [topSellingProductsState, setTopSellingProductsState] = useState(initialTopSellingProductsState);
    const [topSellingProductsLoadingState, setTopSellingProductsLoadingState] = useState(false);
    const [disabledActionButtonState, setDisabledActionButtonState] = useState(initialDisabledActionButtonState);

    // API Calls.
    const fetchProductsData = async query => {
        const [productsErrors, productsResponse] = await to(ProductService.listing(query));
        if (productsErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = productsErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setProductsLoadingState(false);
            return;
        }

        const {
            data: {
                data: products,
                meta: { brands, categories, pagination, price, sorting, attributes }
            }
        } = productsResponse;

        setBrandsState([...brands]);
        setCategoriesState([...categories]);
        setPaginationState({ ...pagination });
        setPriceState({ ...price });
        setSortState([...sorting]);
        setProductsState([...products]);
        setAttributesFilterState([...attributes]);
        setProductsLoadingState(false);
    };

    const fetchTopSellingProductState = async () => {
        const [topSellingProductsErrors, topSellingProductsResponse] = await to(ProductService.listing({ ...queryState, include: "top_selling" }));
        if (topSellingProductsErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = topSellingProductsErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setTopSellingProductsLoadingState(false);
            return;
        }

        const {
            data: { top_selling_products }
        } = topSellingProductsResponse;

        setTopSellingProductsState([...top_selling_products]);
        setTopSellingProductsLoadingState(false);
    };

    // Component Hooks.
    useEffect(() => {
        setProductsLoadingState(true);
        setTopSellingProductsLoadingState(true);
        fetchProductsData(queryState);
        fetchTopSellingProductState();
        return () => false;
    }, [search]);

    useEffect(() => {
        push({ pathname, search: `?${qs.stringify(queryState)}` });
        return () => false;
    }, [queryState]);

    useEffect(() => {
        setQueryState({ ...queryState, ...filterFormState?.values });
        return () => false;
    }, [filterFormState?.values]);

    useEffect(() => {
        let header = document.querySelector(".root-header");
        let headerHeight = header?.getBoundingClientRect().height || header?.clientHeight || 0;
        window.scrollTo({
            top: document.getElementById("page-content").getBoundingClientRect().top - document.body.getBoundingClientRect().top - headerHeight,
            behavior: "smooth"
        });
        return () => false;
    }, [queryState?.page]);

    // Event Handlers.
    const onChangeSortInputHandler = e => setQueryState({ ...queryState, ...qs.parse(e.target.value) });
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
    // Wishlist Events
    const onAddToWishlistClickHandler = async (e, { id, ...product }) => {
        setDisabledActionButtonState(id);
        const [listStoreErrors, listStoreResponse] = await to(ListService.store({ type: "wishlist", product_id: id }));
        if (listStoreErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = listStoreErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            setDisabledActionButtonState(initialDisabledActionButtonState);
            return;
        }

        const {
            data: {
                data: { id: wishlist_id },
                message
            }
        } = listStoreResponse;

        setProductsState([...productsState?.map(product => (product?.id === id ? { ...product, in_wishlist: true, wishlist_id } : product))]);
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({ type: "success", message });
    };
    const onRemoveFromWishlistClickHandler = async (e, { id, wishlist_id, ...product }) => {
        setDisabledActionButtonState(id);
        const [listDeleteErrors, listDeleteResponse] = await to(ListService.delete({ id: wishlist_id }));
        if (listDeleteErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = listDeleteErrors;

            if (message || error)
                onAddFlashMessage({
                    type: "danger",
                    message: message || error
                });
            setDisabledActionButtonState(initialDisabledActionButtonState);
            return;
        }

        const {
            data: { message }
        } = listDeleteResponse;

        setProductsState([
            ...productsState?.map(product =>
                product?.id === id
                    ? {
                          ...product,
                          in_wishlist: false,
                          wishlist_id: ""
                      }
                    : product
            )
        ]);
        setDisabledActionButtonState(initialDisabledActionButtonState);
        onAddFlashMessage({
            type: "success",
            message
        });
    };

    return (
        <>
            {topSellingProductsLoadingState || (!topSellingProductsLoadingState && topSellingProductsState?.length) ? (
                <ProductShowCaseSection
                    title="Top selling products"
                    titleDirection="left"
                    className="products-showcase-section top-selling-products-section section bg-light py-5"
                    products={topSellingProductsState}
                    isLoading={topSellingProductsLoadingState}
                    cardLoaderCount={3}
                    deals={false}
                />
            ) : (
                <></>
            )}
            <section className="section bg-white py-5">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }} md={{ span: 3 }} className="mb-5 mb-md-0">
                            <section>
                                <Row>
                                    {attributesFilterState?.filter(attribute => attribute?.type === "color")?.length ? (
                                        attributesFilterState
                                            ?.filter(attribute => attribute?.type === "color")
                                            ?.map((attribute, attribute_index) => (
                                                <Col xs={{ span: 12 }} className="mb-5" key={attribute?.label?.toLowerCase()}>
                                                    <Row>
                                                        <Col xs={{ span: 12 }}>
                                                            <h3 className="h5 text-capitalize">{attribute?.label}</h3>
                                                        </Col>
                                                        <Col xs={{ span: 12 }}>
                                                            <ListGroup variant="flush" className="border-bottom customized-scroll" role="menu">
                                                                {attribute?.options?.map((attribute_option, attribute_option_index) => (
                                                                    <ListGroup.Item role="menuitem" key={attribute_option?.id}>
                                                                        <Form.Check
                                                                            key={attribute_option?.id}
                                                                            id={`attributes-${attribute_index}-${attribute_option_index}-${attribute_option?.id}`}
                                                                            className="color-radio"
                                                                            type="radio"
                                                                            inline
                                                                            custom
                                                                        >
                                                                            <style
                                                                                dangerouslySetInnerHTML={{
                                                                                    __html: [
                                                                                        `[for='attributes-${attribute_index}-${attribute_option_index}-${
                                                                                            attribute_option?.id
                                                                                        }']:after { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='-4 -4 8 8'%3E%3Ccircle r='3.5' fill='%23${
                                                                                            attribute_option?.value?.split("#")?.[1]
                                                                                        }'/%3E%3C/svg%3E") !important }`
                                                                                    ]
                                                                                }}
                                                                            ></style>
                                                                            <Form.Check.Input
                                                                                name="attributes"
                                                                                type="checkbox"
                                                                                value={attribute_option?.value}
                                                                                onChange={onFilterFormInputChangeHandler}
                                                                                checked={
                                                                                    filterFormState?.values?.attributes?.length &&
                                                                                    filterFormState?.values?.attributes?.includes(attribute_option?.value)
                                                                                        ? true
                                                                                        : undefined
                                                                                }
                                                                                disabled={productsLoadingState}
                                                                            />
                                                                            <Form.Check.Label style={{ color: attribute_option?.value }}>{attribute_option?.color_name}</Form.Check.Label>
                                                                        </Form.Check>
                                                                    </ListGroup.Item>
                                                                ))}
                                                            </ListGroup>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                            ))
                                    ) : (
                                        <></>
                                    )}
                                    {attributesFilterState?.filter(attribute => attribute?.type === "text")?.length ? (
                                        attributesFilterState
                                            ?.filter(attribute => attribute?.type === "text")
                                            ?.map((attribute, attribute_index) => (
                                                <Col xs={{ span: 12 }} className="mb-5" key={attribute?.label?.toLowerCase()}>
                                                    <Row>
                                                        <Col xs={{ span: 12 }}>
                                                            <h3 className="h5 text-capitalize">{attribute?.label}</h3>
                                                        </Col>
                                                        <Col xs={{ span: 12 }}>
                                                            <ListGroup variant="flush" className="border-bottom customized-scroll" role="menu">
                                                                {attribute?.options?.map((attribute_option, attribute_option_index) => (
                                                                    <ListGroup.Item role="menuitem" key={attribute_option?.id}>
                                                                        <Form.Check
                                                                            custom
                                                                            name="attributes"
                                                                            value={attribute_option?.value}
                                                                            type="checkbox"
                                                                            id={`attributes-${attribute_index +
                                                                                attributesFilterState?.filter(attribute => attribute?.type === "color")?.length}-${attribute_option_index}-${
                                                                                attribute_option?.id
                                                                            }`}
                                                                            label={attribute_option?.value}
                                                                            onChange={onFilterFormInputChangeHandler}
                                                                            checked={
                                                                                filterFormState?.values?.attributes?.length && filterFormState?.values?.attributes?.includes(attribute_option?.value)
                                                                                    ? true
                                                                                    : undefined
                                                                            }
                                                                            disabled={productsLoadingState}
                                                                        />
                                                                    </ListGroup.Item>
                                                                ))}
                                                            </ListGroup>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                            ))
                                    ) : (
                                        <></>
                                    )}
                                    {categoriesState?.length ? (
                                        <Col xs={{ span: 12 }} className="mb-5">
                                            <Row>
                                                <Col xs={{ span: 12 }}>
                                                    <h3 className="h5 text-capitalize">Categories</h3>
                                                </Col>
                                                <Col xs={{ span: 12 }}>
                                                    <ListGroup variant="flush" className="border-bottom customized-scroll" role="menu">
                                                        {categoriesState.map(category => (
                                                            <ListGroup.Item role="menuitem" key={category?.id}>
                                                                <Form.Check
                                                                    custom
                                                                    name="categories"
                                                                    value={category?.id}
                                                                    type="checkbox"
                                                                    id={`category-${category?.id}`}
                                                                    label={category?.name}
                                                                    onChange={onFilterFormInputChangeHandler}
                                                                    checked={
                                                                        (filterFormState?.values?.categories?.length && filterFormState?.values?.categories?.includes(category?.id)) ||
                                                                        filterFormState?.values?.category_id === category?.id
                                                                            ? true
                                                                            : undefined
                                                                    }
                                                                    disabled={productsLoadingState}
                                                                />
                                                            </ListGroup.Item>
                                                        ))}
                                                    </ListGroup>
                                                </Col>
                                            </Row>
                                        </Col>
                                    ) : (
                                        <></>
                                    )}
                                    {brandsState?.length ? (
                                        <Col xs={{ span: 12 }} className="mb-5">
                                            <Row>
                                                <Col xs={{ span: 12 }}>
                                                    <h3 className="h5 text-capitalize">Filter by brands</h3>
                                                </Col>
                                                <Col xs={{ span: 12 }}>
                                                    <ListGroup variant="flush" className="border-bottom customized-scroll" role="menu">
                                                        {brandsState.map(brand => (
                                                            <ListGroup.Item role="menuitem" key={brand?.id}>
                                                                <Form.Check
                                                                    custom
                                                                    name="brands"
                                                                    value={brand?.id}
                                                                    type="checkbox"
                                                                    id={`brand-${brand?.id}`}
                                                                    label={brand?.name}
                                                                    onChange={onFilterFormInputChangeHandler}
                                                                    checked={
                                                                        (filterFormState?.values?.brands?.length && filterFormState?.values?.brands?.includes(brand?.id)) ||
                                                                        filterFormState?.values?.brand_id === brand?.id
                                                                            ? true
                                                                            : undefined
                                                                    }
                                                                    disabled={productsLoadingState}
                                                                />
                                                            </ListGroup.Item>
                                                        ))}
                                                    </ListGroup>
                                                </Col>
                                            </Row>
                                        </Col>
                                    ) : (
                                        <></>
                                    )}
                                    {priceState?.min || priceState?.max ? (
                                        <Col xs={{ span: 12 }} className="mb-5">
                                            <Row>
                                                <Col xs={{ span: 12 }} className="mb-3">
                                                    <h3 className="h5 text-capitalize">price</h3>
                                                </Col>
                                                <Col xs={{ span: 12 }}>
                                                    <ListGroup variant="flush" role="menu">
                                                        <ListGroup.Item role="menuitem">
                                                            <InputRange
                                                                draggableTrack
                                                                allowSameValues
                                                                name="price"
                                                                minValue={priceState?.min}
                                                                maxValue={priceState?.max}
                                                                formatLabel={value => `$${value}`}
                                                                disabled={productsLoadingState}
                                                                value={{
                                                                    min: Number(queryState?.price_from) || priceState?.min,
                                                                    max: Number(queryState?.price_to) || priceState?.max
                                                                }}
                                                                onChange={({ min: price_from, max: price_to }) =>
                                                                    setQueryState({
                                                                        ...queryState,
                                                                        ...(price_from && { price_from }),
                                                                        ...(price_to && { price_to })
                                                                    })
                                                                }
                                                            />
                                                            <Form.Group>
                                                                <Form.Control
                                                                    onChange={onFilterFormInputChangeHandler}
                                                                    value={queryState?.price_from || priceState?.min}
                                                                    name="price_from"
                                                                    type="number"
                                                                    disabled={productsLoadingState}
                                                                    hidden
                                                                />
                                                                <Form.Control
                                                                    onChange={onFilterFormInputChangeHandler}
                                                                    value={queryState?.price_to || priceState?.max}
                                                                    name="price_to"
                                                                    type="number"
                                                                    disabled={productsLoadingState}
                                                                    hidden
                                                                />
                                                            </Form.Group>
                                                        </ListGroup.Item>
                                                    </ListGroup>
                                                </Col>
                                            </Row>
                                        </Col>
                                    ) : (
                                        <></>
                                    )}
                                </Row>
                            </section>
                        </Col>
                        <Col xs={{ span: 12 }} md={{ span: 9 }}>
                            <article id="page-content">
                                <Row>
                                    <Col xs={{ span: 12 }}>
                                        <Row className="mb-gutter align-items-center">
                                            <Col xs={{ span: 6 }} md>
                                                <h2 className="h3 text-capitalize m-0">Electronics</h2>
                                                {/*{filterFormState?.values?.category_id || filterFormState?.values?.categories?.length ? (*/}
                                                {/*    <h2 className="h3 text-capitalize m-0">*/}
                                                {/*        {filterFormState?.values?.category_id ? (*/}
                                                {/*            <>*/}
                                                {/*                {*/}
                                                {/*                    categoriesState?.filter(*/}
                                                {/*                        category => category?.id === filterFormState.values.category_id*/}
                                                {/*                    )?.[0]?.name*/}
                                                {/*                }*/}
                                                {/*            </>*/}
                                                {/*        ) : filterFormState?.values?.categories?.length ? (*/}
                                                {/*            <>*/}
                                                {/*                {*/}
                                                {/*                    categoriesState?.filter(*/}
                                                {/*                        category => category?.id === filterFormState.values.categories[0]*/}
                                                {/*                    )?.[0]?.name*/}
                                                {/*                }*/}
                                                {/*            </>*/}
                                                {/*        ) : (*/}
                                                {/*            <></>*/}
                                                {/*        )}*/}
                                                {/*    </h2>*/}
                                                {/*) : (*/}
                                                {/*    <></>*/}
                                                {/*)}*/}
                                            </Col>
                                            {sortState?.length ? (
                                                <Col xs={{ span: 6 }} md={{ span: 6 }}>
                                                    <Row className="align-items-center">
                                                        <Col xs={{ span: 6 }}>
                                                            <p className="mb-0 text-right">
                                                                <small className="font-weight-bold text-uppercase">Sort by</small>
                                                            </p>
                                                        </Col>
                                                        <Col xs={{ span: 6 }}>
                                                            <Form.Group controlId="sortInput" className="mb-0">
                                                                <Form.Control
                                                                    as="select"
                                                                    size="sm"
                                                                    className="mt-0 text-truncate overflow-hidden"
                                                                    value={`sort_by=${queryState?.sort_by}&sort_dir=${queryState?.sort_dir}`}
                                                                    onChange={onChangeSortInputHandler}
                                                                    custom
                                                                    disabled={productsLoadingState}
                                                                >
                                                                    {sortState?.map((option, i) => (
                                                                        <option value={`sort_by=${option?.sort_by}&sort_dir=${option?.sort_dir}`} key={i}>
                                                                            {option?.title}
                                                                        </option>
                                                                    ))}
                                                                </Form.Control>
                                                            </Form.Group>
                                                        </Col>
                                                    </Row>
                                                </Col>
                                            ) : (
                                                <></>
                                            )}
                                        </Row>
                                    </Col>
                                    <Col xs={{ span: 12 }}>
                                        <section className="products-listing-section">
                                            <Row>
                                                <Col xs={{ span: 12 }}>
                                                    {productsLoadingState ? (
                                                        <Col xs={{ span: 12 }} className="d-flex align-items-center justify-content-center">
                                                            <Spinner animation="border" variant="primary" />
                                                        </Col>
                                                    ) : productsState?.length ? (
                                                        <Row>
                                                            {productsState?.map(product => (
                                                                <Col key={product?.id} xs={{ span: 12 }} md={{ span: 6 }} lg={{ span: 4 }} className="mb-gutter">
                                                                    <ProductCard
                                                                        product={product}
                                                                        clampLines={1}
                                                                        disabledActionButton={disabledActionButtonState}
                                                                        wishlistClickHandler={product?.in_wishlist ? onRemoveFromWishlistClickHandler : onAddToWishlistClickHandler}
                                                                    />
                                                                </Col>
                                                            ))}
                                                        </Row>
                                                    ) : (
                                                        <NoDataSection />
                                                    )}
                                                </Col>
                                                {productsState?.length && paginationState?.total_pages > 1 && !productsLoadingState ? (
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
                    </Row>
                </Container>
            </section>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(ProductListing);
