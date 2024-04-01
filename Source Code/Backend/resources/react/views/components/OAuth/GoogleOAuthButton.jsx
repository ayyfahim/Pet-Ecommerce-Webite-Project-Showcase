import React from "react";
import GoogleLogin from "react-google-login";

import { GOOGLE_APP_ID } from "../../../config/globals";

import OAuthButton from "./OAuthButton";
import GoogleIcon from "../SVG/Logo/GoogleLogo";

function GoogleOAuthButton(props) {
	const { onSuccess, isLoading, buttonText } = props;
	return (
		<GoogleLogin
			fields="name,email"
			clientId={GOOGLE_APP_ID}
			onSuccess={onSuccess}
			cookiePolicy={"single_host_origin"}
			render={(props) => <OAuthButton {...props} isLoading={isLoading} socialType="google" buttonText={buttonText} iconComponent={GoogleIcon} />}
		/>
	);
}

export default GoogleOAuthButton;
