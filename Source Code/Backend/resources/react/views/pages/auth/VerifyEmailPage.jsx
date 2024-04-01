/* eslint-disable react-hooks/exhaustive-deps */
import React, { useEffect, useState } from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
import { Container, Row, Col, Card, Spinner, Button } from "react-bootstrap";
import to from "await-to-js";

import * as actions from "../../../store/rootActions";
import UserService from "../../../services/UserService";
import AuthService from "../../../services/AuthService";

function VerifyEmailPage(props) {
    const {
        pageTitle,
        history: { push },
        match: { params },
        onAddFlashMessage,
        onChangeUserState
    } = props;

    // Component State.
    const [isResendVerificationEmailLoading, setIsResendVerificationEmailLoading] = useState(false);

    // API Calls.
    const onResendEmailVerificationClickHandler = async () => {
        setIsResendVerificationEmailLoading(true);

        const [resendEmailVerificationCodeErrors, resendEmailVerificationCodeResponse] = await to(UserService.resendEmailVerificationCode());
        if (resendEmailVerificationCodeErrors) {
            const {
                response: {
                    data: { message }
                }
            } = resendEmailVerificationCodeErrors;

            if (message) onAddFlashMessage({ type: "danger", message });
            setIsResendVerificationEmailLoading(false);
            return;
        }

        const {
            data: { message }
        } = resendEmailVerificationCodeResponse;

        setIsResendVerificationEmailLoading(false);
        if (message) onAddFlashMessage({ type: "success", message });
    };
    const verifyEmailToken = async token => {
        const [verifyEmailErrors, verifyEmailResponse] = await to(UserService.verifyEmailToken({ token }));
        if (verifyEmailErrors) {
            const {
                response: {
                    data: { message }
                }
            } = verifyEmailErrors;

            if (message) onAddFlashMessage({ type: "danger", message });
            return;
        }

        const {
            data: { message }
        } = verifyEmailResponse;

        const [userDataErrors, userDataResponse] = await to(AuthService.me());
        if (userDataErrors) {
            const {
                response: {
                    data: { error, message }
                }
            } = userDataErrors;

            if (message || error) onAddFlashMessage({ type: "danger", message: message || error });
            return;
        }

        const {
            data: { data: user, url }
        } = userDataResponse;

        onChangeUserState({ user });
        if (message) onAddFlashMessage({ type: "success", message });
        push(url || "/dashboard/account");
    };

    // Component Hooks.
    useEffect(() => {
        if (params?.token) verifyEmailToken(params?.token);
        return () => false;
    }, []);

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row className="justify-content-center">
                        <Col xs={{ span: 12 }} sm={{ span: 10 }} md={{ span: 8 }}>
                            <Card className="border-0">
                                <Card.Header className="pb-0 border-0">
                                    <Row>
                                        <Col xs={{ span: 12 }}>
                                            <h1 className="font-weight-bold text-capitalize text-center mb-0">{pageTitle}</h1>
                                        </Col>
                                    </Row>
                                </Card.Header>
                                <Card.Body>
                                    <Row>
                                        <Col xs={{ span: 12 }} className="mb-gutter">
                                            <p className="text-secondary text-center m-0">
                                                Before proceeding, please check your email for a verification link.
                                                <br />
                                                Consider checking your spam/Junk folder. It may be received 5 mins late so be please be patient
                                            </p>
                                        </Col>
                                        <Col xs={{ span: 12 }} className="mb-gutter">
                                            <p className="text-gray text-center">
                                                If you did not receive the email
                                                <Button
                                                    variant="link"
                                                    size="sm"
                                                    className="text-capitalize font-weight-bold ml-1 p-0 text-decoration-none"
                                                    onClick={onResendEmailVerificationClickHandler}
                                                >
                                                    Click here to request another
                                                    {isResendVerificationEmailLoading ? <Spinner animation="border" size="sm" className="ml-3" /> : <></>}
                                                </Button>
                                            </p>
                                        </Col>
                                        <Col xs={{ span: 12 }}>
                                            <p className="text-center">
                                                <Button as={Link} to="/dashboard/account" variant="link" className="text-uppercase font-weight-bold text-decoration-none">
                                                    Skip now
                                                </Button>
                                            </p>
                                        </Col>
                                    </Row>
                                </Card.Body>
                            </Card>
                        </Col>
                    </Row>
                </Container>
            </section>
        </>
    );
}

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({
    onAddFlashMessage: payload => dispatch(actions.addFlashMessage(payload)),
    onChangeUserState: payload => dispatch(actions.changeUserState(payload))
});

export default connect(mapStateToProps, mapDispatchToProps)(VerifyEmailPage);
