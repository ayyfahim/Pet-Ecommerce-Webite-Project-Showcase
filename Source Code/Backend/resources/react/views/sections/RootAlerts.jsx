/* eslint-disable react-hooks/rules-of-hooks */
import React from "react";
import { connect } from "react-redux";
import { Alert, Fade, Row, Col } from "react-bootstrap";

import * as actions from "../../store/rootActions";

function RootAlerts(props) {
    const { flashes, onRemoveFlashMessage } = props;
    const messagesTypes = Object.keys(flashes);

    return (
        <>
            <div className="root-alerts">
                <div className="root-alerts__container">
                    {messagesTypes?.map((type, i) =>
                        [...flashes[type]?.sort((a, b) => b.created_at - a.created_at)]?.map((message, i2) => (
                            <Alert
                                key={message?.id}
                                variant={type}
                                transition={Fade}
                                className="w-100 rounded-lg"
                                id={`alert-${i}-${i2}`}
                                onClose={() => onRemoveFlashMessage({ type, message: { id: message.id } })}
                                dismissible
                            >
                                <Row noGutters>
                                    <Col xs={{ span: "auto" }}>
                                        <div className="d-flex align-items-center justify-content-center p-2 mr-3 rounded-circle alert-icon">
                                            <i
                                                className={`mdi mdi-24px ${
                                                    type === "success"
                                                        ? "mdi-check"
                                                        : type === "danger"
                                                        ? "mdi-close"
                                                        : type === "info"
                                                        ? "mdi-information-variant"
                                                        : type === "warning"
                                                        ? "mdi-alert"
                                                        : ""
                                                }`}
                                                aria-hidden="true"
                                            ></i>
                                        </div>
                                    </Col>
                                    <Col xs>
                                        <Row>
                                            <Col xs={{ span: 12 }}>
                                                <strong className="text-capitalize">{type === "danger" ? "error" : type}!</strong>
                                            </Col>
                                            <Col xs={{ span: 12 }}>
                                                <p className="mb-0 small">{message?.message}</p>
                                            </Col>
                                        </Row>
                                    </Col>
                                </Row>
                            </Alert>
                        ))
                    )}
                </div>
            </div>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onRemoveFlashMessage: payload => dispatch(actions.removeFlashMessage(payload))
});

// Exporting the component.
export default connect(mapStateToProps, mapDispatchToProps)(RootAlerts);
