import React, { useState, useEffect, FC } from 'react';
import ReactPaginate from 'react-paginate';
import styles from './MyPagination.module.scss';

interface IMyPaginationProps {
  itemsPerPage: number;
  items: any;
  pageCount: number;
  setItemOffset: (newOffset: number) => void;

  forcePage?: number;
  setItemPageNumber?: (pageNumber: number) => void;
  scrollToTop?: any;
}

const MyPagination: FC<IMyPaginationProps> = ({
  itemsPerPage,
  items,
  pageCount,
  setItemOffset,
  forcePage,
  setItemPageNumber,
  scrollToTop,
}) => {
  const handlePageClick = (event: any) => {
    const newOffset = (event.selected * itemsPerPage) % items.length;
    setItemOffset(newOffset);

    if (setItemPageNumber) {
      setItemPageNumber(event.selected);
    }

    if (typeof scrollToTop === 'function') {
      scrollToTop();
    }
  };

  return (
    <>
      <ReactPaginate
        breakLabel="..."
        nextLabel=">"
        onPageChange={handlePageClick}
        pageRangeDisplayed={2}
        marginPagesDisplayed={1}
        pageCount={pageCount}
        previousLabel="<"
        containerClassName={styles.MyPaginationContainer}
        pageClassName={styles.MyPaginationLi}
        activeClassName={styles.MyPaginationLiActive}
        activeLinkClassName={styles.MyPaginationLinkActive}
        pageLinkClassName={styles.MyPaginationLiLink}
        nextClassName={styles.NextClassName}
        nextLinkClassName={styles.NextLinkClassName}
        previousClassName={styles.PreviousClassName}
        previousLinkClassName={styles.PreviousLinkClassName}
        forcePage={forcePage}
      />
    </>
  );
};

export default MyPagination;
