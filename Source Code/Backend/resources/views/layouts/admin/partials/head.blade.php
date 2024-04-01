<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
<link rel="icon" href="{{App\Models\ConfigData::where('title', 'favicon')->first()->getUrlFor('cover')}}">
<title>{{config('app.name')}} | @yield('title')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/admin/css/app.css')}}">
@yield('styles')
<style>
    .alerts-wrapper {
        position: fixed;
        top: 100px;
        right: 45px;
        z-index: 1090;
        max-width: calc(50% - 200px);
        width: calc(50% - 200px);
        height: auto;
    }
    .img-preview img {
        width: 150px !important;
        height: auto !important;
    }
    .images-preview img {
        width: 150px !important;
        height: auto !important;
    }
    .select2-container{
        /*z-index:99999 !important;*/
    }
</style>
<style>
    /*.images-preview img{*/
    /*    max-width: 90%;*/
    /*    height: 150px;*/
    /*}*/
</style>
<style>
    @media screen and (min-width:2000px) {
        /*.app-content{*/
        /*    width: 1300px;*/
        /*    margin-left:auto !important;*/
        /*    margin-right:auto !important;*/
        /*}*/
    }
</style>
