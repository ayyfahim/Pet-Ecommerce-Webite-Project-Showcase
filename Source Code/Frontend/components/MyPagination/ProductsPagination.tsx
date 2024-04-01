import React, { useState, useEffect, FC } from 'react';
import ReactPaginate from 'react-paginate';
import styles from './MyPagination.module.scss';

interface IMyPaginationProps {
  count: number;
  current_page: number;
  per_page: number;
  total: number;
  total_pages: number;
  links: {
    next: String;
  };
  handlePageChange: ({ selected }: { selected: number }) => void;
}

const MyPagination: FC<IMyPaginationProps> = ({
  count,
  current_page,
  per_page,
  total,
  total_pages,
  links,
  handlePageChange,
}) => {
  const forcePage = current_page + 1;
  return (
    <>
      <ReactPaginate
        breakLabel="..."
        nextLabel=">"
        onPageChange={(e) => handlePageChange(e)}
        pageRangeDisplayed={2}
        marginPagesDisplayed={1}
        pageCount={total_pages}
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
        // forcePage={forcePage}
      />
    </>
  );
};

export default MyPagination;
