import React from "react";
import { Button } from "react-bootstrap";
import shortid from "shortid";
import { Pagination as BootstrapPagination } from "react-bootstrap";

function PaginationSection(props) {
    let {
        paginatingData: { current_page: page, total_pages: pages },
        onClickHandler,
        maxPages = 2
    } = props;

    const renderPagesButtons = (page, pages) => {
        const items = [];
        let i = Number(page) > maxPages ? Number(page) - maxPages : 1;

        if (i !== 1) {
            items.push(
                <BootstrapPagination.Ellipsis
                    key={shortid.generate()}
                    as={Button}
                    variant="link"
                    aria-label="page 1"
                    onClick={e => onClickHandler(e, 1)}
                />
            );
        }

        for (; i <= Number(page) + maxPages && i <= pages; i++) {
            let index = i;
            items.push(
                <BootstrapPagination.Item
                    key={shortid.generate()}
                    className={index < pages ? "mr-2" : undefined}
                    active={index === Number(page)}
                    as={index !== Number(page) ? Button : undefined}
                    variant={index !== Number(page) ? "link" : undefined}
                    onClick={index !== Number(page) ? e => onClickHandler(e, index) : undefined}
                >
                    {index}
                </BootstrapPagination.Item>
            );
            if (index === Number(page) + maxPages && i < pages) {
                items.push(
                    <BootstrapPagination.Ellipsis
                        key={shortid.generate()}
                        as={Button}
                        variant="link"
                        aria-label={`page ${pages}`}
                        onClick={e => onClickHandler(e, Number(pages))}
                    />
                );
            }
        }
        return items;
    };

    return (
        <>
            <BootstrapPagination className="m-0 d-flex justify-content-center align-items-center">
                <BootstrapPagination.Prev
                    className="mr-5"
                    as={Button}
                    variant="link"
                    onClick={e => onClickHandler(e, Number(page) - 1)}
                    disabled={Number(page) <= 1}
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            fillRule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"
                        />
                    </svg>
                    <small className="text-uppercase ml-2 sr-only">previous</small>
                </BootstrapPagination.Prev>
                {renderPagesButtons(page, pages)}
                <BootstrapPagination.Next
                    className="ml-5"
                    as={Button}
                    variant="link"
                    onClick={e => onClickHandler(e, Number(page) + 1)}
                    disabled={Number(page) >= pages}
                >
                    <small className="text-uppercase mr-2 sr-only">next</small>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            fillRule="evenodd"
                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                        />
                    </svg>
                </BootstrapPagination.Next>
            </BootstrapPagination>
        </>
    );
}
export default PaginationSection;
