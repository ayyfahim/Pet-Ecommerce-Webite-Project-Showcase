import React from "react";
import { connect } from "react-redux";
import { useLocation } from "react-router-dom";
import Helmet from "react-helmet";

import { FACEBOOK_APP_ID, APP_NAME } from "../../config/globals";

function MetaTags(props) {
	const { pageTitle = "", description = "", keywords = "", title = "", cover = "" } = props;

	const { pathname: path } = useLocation();

	return (
		<>
			<Helmet>
				<title>
					{pageTitle ? `${pageTitle} |` : ""} {APP_NAME}
				</title>
				<meta name="description" content={description} />
				<meta name="keywords" content={keywords} />
				<meta name="fb:app_id" content={FACEBOOK_APP_ID} />
				<meta name="twitter:card" content="summary_large_image" />
				<meta name="twitter:title" content={title} />
				<meta name="twitter:description" content={description} />
				<meta name="twitter:image" content={cover} />

				<meta property="type" content="website" />
				<meta property="url" content={path} />
				<meta property="og:title" content={title} />
				<meta property="og:description" content={description} />
				<meta property="og:image" content={cover} />
				<meta property="og:image:url" content={cover} />
				<meta property="og:image:secure_url" content={cover} />
				<meta property="og:image:type" content="image/*" />
				<meta property="og:image:width" content="400" />
				<meta property="og:image:height" content="300" />
				<meta property="og:url" content={path} />
				<meta property="og:type" content="website" />
				<meta property="og:site_name" content={APP_NAME} />
			</Helmet>
		</>
	);
}

const mapStateToProps = (state) => ({ ...state });
const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(MetaTags);
