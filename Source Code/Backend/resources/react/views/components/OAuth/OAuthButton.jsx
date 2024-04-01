import React from "react";
import { Button, Spinner } from "react-bootstrap";

function OAuthButton(props) {
    const { onClick, socialType, iconComponent: IconComponent, buttonText, isLoading } = props;
    return (
        <>
            <Button variant={`outline-${socialType}`} className="text-capitalize rounded-lg" block onClick={onClick} disabled={isLoading}>
                {isLoading ? (
                    <Spinner animation="border" size="sm" />
                ) : (
                    <>
                        <span className="mr-3">
                            <IconComponent />
                        </span>
                        {buttonText}
                    </>
                )}
            </Button>
        </>
    );
}

export default OAuthButton;
