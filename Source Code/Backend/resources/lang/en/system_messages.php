<?php

return [
    "auth" => [
        "failed" => "These credentials do not match our records",
        "forgot_password" => [
            "password" => "Passwords must be at least eight characters and match the confirmation.",
            "reset" => "Your password has been reset!",
            "reset_link_success" => "We have e-mailed your password reset link!",
            "token" => "This password reset token is invalid.",
            "user" => "We can't find a user with that e-mail address."
        ],
        "inactive" => "Your account has been deactivated",
        "register_success" => "Welcome to " . config('app.name'),
        "success" => "Welcome Back",
        "verification" => [
            "email_already_verified" => "Email already Verified",
            "email_sent" => "Email sent successfully",
            "email_verified" => "Email Verified",
            "invalid_code" => "Invalid Code",
            "mobile_already_verified" => "Mobile Already Verified",
            "mobile_verified" => "Mobile Verified",
            "mobile_verified_failed" => "Invalid Verification Code",
            "verification_code_sent" => "Verification Code Sent",
            "verify_account_first" => "Please complete your account verification step first."
        ]
    ],
    "common" => [
        "create_success" => "Created Successfully",
        "delete_success" => "Deleted Successfully",
        "update_success" => "Updated Successfully"
    ],
    "delete_meal_label" => "Are you sure you want to delete this meal ?",
    "delete_offer_label" => "Are you sure you want to delete this promotion ?",
    "delete_service_label" => "Are you sure you want to delete this service ?",
    "fields_error_label" => "Please, check fields errors first!",
    "fill_reason_label" => "Please, fill in a reason first!",
    "fill_rejection_reason_label" => "Please, add the rejection reason",
    "image_error_label" => "Please, choose images less than 2 MB ",
    "logout_failed" => "An error happened while logging you out, Please try again!",
    "logout_label" => "Are you sure you want to logout ?",
    "pick_image_label" => "You can pick it from gallery or take a new one using camera",
    "required_label" => "Please, complete the required data marked with * first!",
    "review_error_label" => "Please, choose a rating and write a review first!",
    "something_wrong_label" => "Something went wrong. Please, try again later.",
    "subscription_ended_label" => "Can't perform your action now, as your subscription has ended!",
    "waiting_for_review" => "Waiting for review"
];
