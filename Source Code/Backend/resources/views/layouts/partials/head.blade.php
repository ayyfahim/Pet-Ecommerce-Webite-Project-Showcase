<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/admin/img/favicon.jpg')}}"/>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700);
    </style>
    <link rel="stylesheet" href="{{asset('assets/admin/css/main.css?v=3.0')}}"/>
    <style>
        .custom-switch.custom-switch-success .custom-switch-input:checked + .custom-switch-btn {
            background: #3e884f;
            border: 1px solid #3e884f;
        }

        .datepicker-dropdown {
            z-index: 9999 !important;
        }
        #categoryTreeModal .modal-dialog{
            max-width: 90% !important;
        }
        #categoryTreeModal .modal-content{
            min-height: 85vh !important;
        }
    </style>
    @yield('styles')
</head>
