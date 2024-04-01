/* eslint-disable react-hooks/exhaustive-deps */
import React, { useEffect } from "react";
import { connect } from "react-redux";
import qs from "qs";

function Redirect(props) {
    const {
        history: {
            push,
            location: { search }
        }
    } = props;

    const queryParams = qs.parse(search, { ignoreQueryPrefix: true });

    useEffect(() => {
        if (queryParams?.success === "1") {
            push(`/orders/confirmation${search}`);
        } else {
            push(`/payment`);
        }
        return () => false;
    }, []);

    return <></>;
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(Redirect);
