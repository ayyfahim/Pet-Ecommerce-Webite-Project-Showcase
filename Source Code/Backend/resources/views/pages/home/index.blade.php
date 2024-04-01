@extends('layouts.front',['basic'=>true])
@section('title','Home Page')
@section('f-content')
    <main class="home-main" role="main">
        <div class="swiper-container" id="main-slider">
            <div class="swiper-wrapper">
                @foreach ($slides as $item)
                    <div class="swiper-slide jarallax">
                        <img class="jarallax-img" src="{{ $item->getUrlFor('cover') }}">
                        <div class="container">
                            <div class="row">
                                <div class="main-content" data-swiper-parallax="-300">
                                    <h1 class="mb-4">{{$item->title}}</h1>
                                    <a class="btn btn-danger btn-sm px-4"
                                       href="{{route($item->route_name)}}">{{$item->btn_text}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </main>

    <section class="home-sectors">
        <div class="container">
            <div class="row">
                <div class="col-12 home-sec-head">
                    <h2 class="text-left">all sectors</h2>
                </div>
                <div class="col-12">
                    <div class="row">
                        @foreach ($all_categories as $item)
                            <div class="col-12 col-sm-6 col-md-4 mb-gutter">
                                <div class="card-category">
                                    <img class="card-img" src="{{ $item->getUrlFor('badge') }}" alt="card image"/>
                                    <div class="card-img-overlay">
                                        <h5 class="card-title">
                                            <button class="btn btn-link btn-block"
                                                    type="button"
                                                    data-toggle="modal"
                                                    data-target="#categoryModal-{{$item->name}}">
                                                {{$item->name}}
                                            </button>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @include('pages.home.partials.modal', [
                                'id'=>'categoryModal-'.$item->name,
                                'activities'=>$item->descendants
                            ])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-services-featured">
        <div class="container">
            <div class="row">
                <div class="col-12 home-sec-head">
                    <h2>promoted services</h2>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($featured_services as $service)
                                <div class="swiper-slide">
                                    @include('pages.services.partials.info')
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-jobs-latest">
        <div class="container">
            <div class="row">
                <div class="col-12 home-sec-head">
                    <h3 class="home-title">featured request for proposals</h3>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($featured_rfps as $rfp)
                                <div class="swiper-slide">
                                    @include('pages.rfps.partials.info', ['basic'=>true])
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-services-latest">
        <div class="container">
            <div class="row">
                <div class="col-12 home-sec-head">
                    <h3 class="home-title">latest services</h3>
                    <a class="btn btn-link text-danger" href="{{route('service.index')}}">view all services</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($latest_services as $service)
                                <div class="swiper-slide">
                                    @include('pages.services.partials.info')
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
