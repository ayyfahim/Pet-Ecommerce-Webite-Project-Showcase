@extends('layouts.admin.app')
@section('title',$action->title)
@php
    $a4 = in_array($action->name,['hysteroscope','pregnancy_report']);
@endphp
@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            @if(!$a4)
                     padding-top: 4.5cm;
            @endif
                 background: #fff !important;
        }

        div.printContainer {
            height: {{$a4?'297mm':'210mm'}};
        }

        * {
            color: #000;
        }

        table {
            width: 70% !important;
            margin: 50px auto;

        }

        .table-bordered {
            border: 1px solid #aaa !important;
        }

        td {
            text-align: left !important;
            font-weight:bold;
            font-size: 30px;

            border-color: #aaa !important;
        }

        #obstetrics-referral td {
            font-size: 20px;
            font-weight:bold;
        !important;
        }

        #obstetrics-pregnancy_report td {
            font-size: 20px;
            font-weight:bold;
        !important;
        }
        #gynecology-referral td {
            font-size: 22px;
            font-weight:bold;
        !important;
        }
        #gynecology-hysteroscope td {
            font-size: 20px;
            font-weight:bold;
            padding:3px;
        !important;
        }

        header h5 {
            font-size: 30px;
            margin-bottom: 1cm;
            margin-left: 2.5cm;
            font-weight: bold;


        }

        footer {
            position: absolute;
            top: 242mm;
            right: 2cm;

        }

        h5.signature {
            font-size: 35px;
            font-weight:bold;
            font-family: 'Cookie', cursive;
        }

        .customHeader {
            border-bottom: 1px solid;
            padding-bottom: 2px;
            margin-bottom: 30px !important;
        }

        .customHeader h5 {
            font-size: 22px;
        }

        .customHeader p {
            font-size: 16px;
        }
    </style>
@endsection
@section('content')
    <div class="printContainer" id="{{$visit_type}}-{{$action->name}}">
        @if($a4)
            <div class="customHeader text-center">
                <div class="float-left" style="margin: 10px 70px;">
                    <h5>
                        Dr.<br>
                        Khaled Ahmed Abd El Aziz Elsetohy
                    </h5>
                    <p>
                        M.B.B.Ch, M.Sc, M.D OB & GYN
                        <br>
                        Professor of OB & GYN Cairo University
                        <br>
                        Consultant of Endoscopic Surgery
                        <br>
                        Consultant of Infertility and ART
                    </p>
                </div>
                <div class="float-right" style="margin: 10px 70px;">
                    <h5>
                        دكتور
                        <br>
                        خالد احمد عبد العزيز السطوحي
                    </h5>
                    <p>
                        دكتوراه امراض النساء و التوليد - جامعة القاهرة
                        <br>
                        استاذ امراض النساء و التوليد - القصر العيني
                        <br>
                        استشاري جراحة المناظير
                        <br>
                        استشاري الحقن المجهري و تأخر الانجاب
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        @else
            <header>
                <h5 class="float-left" style="margin-left: 6cm">{{today()->format("d / m / Y")}}</h5>
                <h5 class="float-right" style="margin-right: 5cm">{{$action->visit->patient->name}} </h5>
                <div class="clearfix"></div>
            </header>
        @endif
        <div class="content">
            @yield('print-content')
        </div>
        @if($a4)
            <div class="customFooter" style="margin-top: 60px;margin-right: 120px;">
                <div class="text-center float-right">
                    <h5>Signature</h5>
                    <h5 class="signature">
                        Prof.Khaled Abdelaziz
                    </h5>
                </div>
            </div>
        @else
            <footer>
                <h5 class="text-right signature" style="margin-right: 3.5cm; margin-top:1cm" >
                    Prof.Khaled Abdelaziz
                </h5>
            </footer>
        @endif
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            window.print();
            window.onafterprint = function (event) {
                location.href = "{{route('visit.show',$action->visit_id)}}"
            };
        });
    </script>

@endsection
