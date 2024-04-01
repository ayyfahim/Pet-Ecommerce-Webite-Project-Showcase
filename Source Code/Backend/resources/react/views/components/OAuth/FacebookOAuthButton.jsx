import React from "react";
import FacebookLogin from "react-facebook-login/dist/facebook-login-render-props";

import { FACEBOOK_APP_ID } from "../../../config/globals";

import OAuthButton from "./OAuthButton";
import FaceBookIcon from "../SVG/Logo/FacebookLogo";

function FacebookOAuthButton(props) {
    const { onSuccess, isLoading, buttonText } = props;

    return (
        <FacebookLogin
            fields="name,email"
            appId={FACEBOOK_APP_ID}
            callback={onSuccess}
            render={props => (
                <OAuthButton {...props} isLoading={isLoading} socialType="facebook" buttonText={buttonText} iconComponent={FaceBookIcon} />
            )}
        />
    );
}

export default FacebookOAuthButton;
