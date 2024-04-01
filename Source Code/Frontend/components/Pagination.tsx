import React, { FC } from 'react';
import styles from 'styles/Pagination.module.css';
import MainButton from 'components/MainButton';
import Image from 'next/image';
import arrowSvg from 'public/img/common/arrow.svg';
import classnames from 'classnames';

interface PaginationProps {
  onChangePage: (val: number) => void;
  lengthElements: number;
  perPage: number;
  currentPage: number;
  showButtons?: number;
}

const Pagination: FC<PaginationProps> = ({ onChangePage, lengthElements, perPage, currentPage, showButtons = 5 }) => {
  const numberOfPages = Math.ceil(lengthElements / perPage);
  const handleChangePage = (page: number) => {
    if (page >= 1 && page <= numberOfPages) {
      onChangePage(page);
    }
  };

  const createArrPages = (pages: number): number[] => {
    const arrOfPages = [];
    for (let i = 0; i < pages; i++) {
      arrOfPages.push(i + 1);
    }
    return arrOfPages;
  };

  const scliceButtonsFrom = currentPage < showButtons ? currentPage - 1 : numberOfPages - showButtons;
  const scliceButtonsTo = showButtons + currentPage - 1;

  return (
    <div className={styles.wrapper}>
      <MainButton onClick={() => handleChangePage(currentPage - 1)} classButton={styles.btn}>
        <Image alt="<" src={arrowSvg} />
      </MainButton>
      <div className={styles.pagesbuttons}>
        {createArrPages(numberOfPages)
          .slice(scliceButtonsFrom, scliceButtonsTo)
          .map((el, index) => (
            <MainButton
              key={`btn_pag_${index}`}
              onClick={() => handleChangePage(el)}
              classButton={classnames(styles.btn, {
                [styles.active]: el === currentPage,
              })}
            >
              {el}
            </MainButton>
          ))}
      </div>
      <MainButton onClick={() => handleChangePage(currentPage + 1)} classButton={`${styles.btn} rotate-180`}>
        <Image alt=">" src={arrowSvg} />
      </MainButton>
    </div>
  );
};

export default Pagination;
