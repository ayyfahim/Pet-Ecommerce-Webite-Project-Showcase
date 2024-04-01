import React from "react";

import userDefaultImage from "../../../assets/images/avatars/user-default.jpg";

function Avatar(props) {
    const {
        src = userDefaultImage,
        size = "md",
        appearance = "square",
        thumbnail = false,
        title = "",
        fluid,
        className,
        ...anotherProps
    } = props;

    return (
        <>
            <span
                className={`avatar avatar--size-${size} avatar--appearance-${appearance} ${thumbnail ? "avatar--thumbnail" : ""} ${
                    fluid ? "avatar--fluid" : ""
                } ${className ? className : ""}`}
                {...anotherProps}
            >
                <span className="avatar__image-wrapper">
                    <img src={src} alt={title} className="avatar__image" />
                </span>
            </span>
        </>
    );
}

export default Avatar;
