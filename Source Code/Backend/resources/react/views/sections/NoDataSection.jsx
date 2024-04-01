import React from "react";
import { connect } from "react-redux";

export const NoDataSection = props => {
    const { title = "unfortunately no results found !", description = "Please try different search or change filters!" } = props;

    return (
        <>
            <section className="section text-center">
                <h2 className="h5 text-primary text-uppercase">{title}</h2>
                <p>{description}</p>
            </section>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NoDataSection);
