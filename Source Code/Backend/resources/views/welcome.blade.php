{{--@dd(LaravelLocalization::getCurrentLocaleDirection())--}}
{{--    @dd(request()->header('Accept-Language'))--}}
    <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>{{ config('app.name') }}</title>
    @if(isset($product))
        <meta property="og:image" content="{{asset($product->getUrlFor('cover'))}}">
        <meta property="og:title" content="{{$product->info->title}}">
        <meta name="description" content="{{strip_tags($product->info->description)}}"/>
        <meta name="twitter:card" content="{{asset($product->getUrlFor('cover'))}}"/>
        <meta name="twitter:title" content="{{$product->info->title}}"/>
        <meta name="twitter:description" content="{{strip_tags($product->info->description)}}"/>
        <meta name="twitter:image" content="{{asset($product->getUrlFor('cover'))}}"/>
        <meta property="type" content="website"/>
        <meta property="url" content="{{request()->fullUrl()}}"/>
        <meta property="og:title" content="{{$product->info->title}}"/>
        <meta property="og:description" content="{{strip_tags($product->info->description)}}"/>
        <meta property="og:image" content="{{asset($product->getUrlFor('cover'))}}"/>
        <meta property="og:image:url" content="{{asset($product->getUrlFor('cover'))}}"/>
        <meta property="og:image:secure_url" content="{{asset($product->getUrlFor('cover'))}}"/>
        <meta property="og:image:type" content="image/*"/>
        <meta property="og:image:width" content="400"/>
        <meta property="og:image:height" content="300"/>
        <meta property="og:url" content="{{request()->fullUrl()}}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:site_name" content="{{config('app.name')}}"/>
        @isset($google_schema)
            <script type="application/ld+json">
                {!! $google_schema !!}
            </script>
        @endisset
        @isset($breadcrumb_schema)
            <script type="application/ld+json">
                {!! $breadcrumb_schema !!}
            </script>
        @endisset
    @endif
    <link rel="preload" href="{{asset('assets/front/js/index.js?v=6.0')}}" as="script">
    <link rel="preload" href="{{asset('assets/front/css/style.css?v=6.0')}}" as="style">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/admin/img/favicon.jpg')}}"/>
    <link rel="stylesheet" id="style-direction" href="{{asset('assets/front/css/style.css?v=6.0')}}">

</head>
<body class="isPageLoading">
<div id="root"></div>
<script src="{{asset('assets/front/js/index.js?v=6.0')}}"></script>
</body>
</html>
