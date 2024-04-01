import React from "react";
import { connect } from "react-redux";

export const ProductCardBookmark = props => {
    const { discount, expired } = props;
    return (
        <>
            <div className="product-card__bookmark">
                <div className="product-card__bookmark-top"></div>
                <div className="product-card__bookmark-body">
                    <p className="mb-0 text-white text-center">
                        {expired ? (
                            <small>
                                <small className="text-uppercase">Expired</small>
                            </small>
                        ) : (
                            <small>
                                <small className="text-uppercase">save</small>
                                <br />
                                <strong>${discount}</strong>
                            </small>
                        )}
                    </p>
                </div>
                <div className="product-card__bookmark-tail"></div>
            </div>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(ProductCardBookmark);
