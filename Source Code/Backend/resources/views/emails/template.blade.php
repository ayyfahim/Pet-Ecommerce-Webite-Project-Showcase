<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Tajawal:300,400,500,700,800&display=swap');
        @import url('https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700,800&display=swap');

        /* -------------------------------------
    GLOBAL RESETS
------------------------------------- */
        table.products th,
        table.products td{
            border:1px solid #333;
            text-align: center;
            vertical-align: middle;
        }
        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        html {
            height: 100%;
        }

        body {
            background-color: rgba(00, 00, 00, 0.1);
            font-family: "Montserrat", sans-serif
                /*rtl:prepend: Tajawal ,*/
            !important;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            height: 100%;
        }

        html[dir="rtl"] body {
            font-family: 'Tajawal';
            height: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
        }

        table td {
            font-family: "Montserrat", sans-serif
                /*rtl:prepend: Tajawal ,*/
            !important;
            font-size: 14px;
            vertical-align: top;
        }

        html[dir="rtl"] table td {
            font-family: 'Cairo', sans-serif;
        }

        /* -------------------------------------
    BODY & CONTAINER
------------------------------------- */

        .body {
            width: 100%;
            height: 100%;
            background-color: #fff;
            position: relative;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        img.bg-shape {
            position: absolute;
            z-index: 2;
            opacity: 0.3;
            width: 200px;
        }

        img.bg-shape.shape2 {
            top: 128px;
            left: 35%;
        }

        img.bg-shape.shape3 {
            right: 34%;
            width: 130px;
            top: 89px;
        }

        img.bg-shape.shape1 {
            width: 141px;
            position: absolute;
            right: 39%;
            top: 276px;
        }

        .full-section {
            display: block;
            width: 100%;
        }

        .container {
            display: block;
            Margin: 0 auto !important;
            /* makes it centered */
            max-width: 800px;
            padding: 10px;
            width: 800px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            Margin: 0 auto;
            max-width: 800px;
            padding: 10px;
            position: relative;
            z-index: 1;
        }

        /* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
        .top-header {
            height: 90px;
            background-color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main {
            background: transparent;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 20px;
        }


        .header,
        .footer,
        .content {
            clear: both;
            width: 100%;
            text-align: left;
        }

        .header {
            /*border-bottom: 1px solid #999999;*/
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .content {
            padding: 20px 0;
        }

        .footer {
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid #999999;
        }

        .footer p,
        .footer span,
        .footer a,
        .header p,
        .header span,
        .header a {
            color: #999999;
            font-size: 12px;
            text-align: left;
        }

        .header a,
        .footer a {
            margin: 0 5px;
        }

        /* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
        .black-color {
            color: #000;
        }

        h1,
        h2,
        h3,
        h4 {
            color: #000;
            font-family: "Montserrat", sans-serif
                /*rtl:prepend: Tajawal ,*/
            !important;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px;
            text-align: left;
            text-transform: capitalize;
        }

        html[dir="rtl"] h1,
        html[dir="rtl"] h2,
        html[dir="rtl"] h3,
        html[dir="rtl"] h4 {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
        }


        h1 {
            color: #000;
            font-size: 32px;
            font-weight: 600;
            text-align: left;
            text-transform: capitalize;
            Margin-bottom: 20px;
        }

        p,
        ul,
        ol {
            font-family: "Montserrat", sans-serif
                /*rtl:prepend: Tajawal ,*/
            !important;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            Margin-bottom: 15px;
            color: #999999;
        }

        html[dir="rtl"] p,
        html[dir="rtl"] ul,
        html[dir="rtl"] ol {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
        }

        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }

        /* -------------------------------------
    BUTTONS
------------------------------------- */
        .btn {
            box-sizing: border-box;
            width: 100%;
        }

        .btn>tbody>tr>td {
            padding-bottom: 15px;
        }

        .btn table {
            width: auto;
        }

        .btn table td {
            background-color: transparent;
            border-radius: 36px;
            text-align: center;
            transition: all .2s ease-in-out;
            text-transform: uppercase;
        }

        .btn a {
            background-color: transparent;
            border: solid 1px #FA9014;
            border-radius: 36px;
            box-sizing: border-box;
            color: #FA9014;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: uppercase;
            transition: all .2s ease-in-out;
        }

        .btn:first-of-type {
            margin-top: 20px;
        }

        .btn:not(:last-of-type) {
            margin-bottom: 20px;
        }

        .btn-primary table td {
            background-color: #FA9014;
        }

        .btn-primary a {
            background-color: #FA9014;
            border-color: #FA9014;
            color: #000;
        }

        .btn-outline-primary table td {
            background-color: transparent;
        }

        .btn-outline-primary a {
            background-color: #fff;
            border-color: #FA9014;
            color: #FA9014;
        }

        .btn-link table td {
            background-color: inherit;
        }

        .btn-link a {
            background-color: inherit;
            border-color: inherit;
            border: 0px;
            color: #FA9014 !important;
            padding-left: 0px;
        }
        .btn-link{
            color: #FA9014 !important;
        }

        a {
            text-transform: none;
            padding: 0;
            display: inline-block;
            background-color: transparent;
            box-sizing: border-box;
            color: #FA9014;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
            margin: 0;
            padding: 5px 20px;
            transition: all .2s ease-in-out;
            border-color: inherit;
            border: 0px;
            padding-left: 0px;
            font-weight: normal;
        }

        a.btn-link {
            font-weight: bold;
            display: block;
            text-decoration: none;
            text-transform: uppercase;

        }

        /* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .mx-auto {
            margin-right: auto;
            margin-left: auto;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .text-blue {
            color: #FA9014 !important;
        }

        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            /*border-bottom: 1px solid #999999;*/
            Margin-top: 20px;
            Margin-bottom: 20px;
        }

        .w-75 {
            width: 75%;
        }

        /* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
------------------------------------- */
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 16px !important;
            }

            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }

            table[class=body] .content {
                padding: 0 !important;
            }

            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }

            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            table[class=body] .btn table {
                width: 100% !important;
            }

            table[class=body] .btn a {
                width: 100% !important;
            }

            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }

            .w-75 {
                width: 100% !important;
            }
        }

        /* -------------------------------------
    PRESERVE THESE STYLES IN THE HEAD
------------------------------------- */
        @media all {
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }



        }
    </style>
</head>
<body>
<table class="body" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td></td>
        <td class="container">
            <div class="content">
                <table class="main">
                    <tr>
                        <td class="wrapper">
                            <table border="0" cellpadding="0" cellspacing="0">
{{--                                <tr>--}}
{{--                                    <td class="header">--}}
{{--                                        <a href="{{ route('home') }}" target="_blank">--}}
{{--                                            <img src="https://dealaday-dev.karimkhamiss.com/assets/admin/img/logo.png" width="150"--}}
{{--                                                 height="auto" alt="{{config('app.name')}} logo">--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
                                <tr>
                                    <td class="content">
                                        @yield('content')
                                    </td>
                                </tr>
{{--                                <tr>--}}
{{--                                    <td class="footer">--}}
{{--                                        <p>--}}
{{--                                            Copyright © {{now()->year}}--}}
{{--                                            <a href="{{ route('home') }}">{{config('app.name')}}.</a>All rights--}}
{{--                                            reserved.--}}
{{--                                        </p>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
