@extends('layouts.admin.dashboard')
@section('title','Import Products')
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('product.admin.importStore')}}" enctype="multipart/form-data" class="ajaxc"
                      method="POST" id="BasicInfo">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>CSV File</label>
                                    <input type="file" name="file" class="form-control">
                                    @include('layouts.admin.partials.form-errors')
                                </div>
                                <a style="margin:5px" href="{{asset('import_product_sample.csv')}}">View CSV Sample</a>
                            </div>
                        </div>
                        <hr>
                        <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            <span class="lead collapse-title">Guidelines</span>
                        </div>
                        <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse">
                            <div class="card-body">
                                <ul s>
                                    <li>Don't change columns titles</li>
                                    <li>Active: 1= product published, 0= product not published</li>
                                    <li>Featured: 1= product featured, 0= product not featured</li>
                                    <li>Category: must be the last child of categories and be from these formats:
                                        <br>
                                        Parent/Sub Category/Sub Sub Category
                                        <br>
                                        Parent/Sub Category
                                        <br>
                                        Single Category
                                    </li>
                                    <li>Gallery: URL of images with break-line separated
                                        <br>
                                        https://example.com/1.jpg<br>
                                        https://example.com/2.jpg
                                        <br>
                                        first one will be the main image
                                    </li>
{{--                                    <li>--}}
{{--                                        Variations: Variant prices that based on user selection and must be this format--}}
{{--                                        <br>--}}
{{--                                        Attribute name: value/qty/price--}}
{{--                                        <br>--}}
{{--                                        Storage: 64 GB/20/18000--}}
{{--                                        <br>--}}

{{--                                        if you want add combination of attributes it'll be by this format--}}
{{--                                        <br>--}}
{{--                                        Attribute names (,): values(,)/qty/price--}}
{{--                                        <br>--}}
{{--                                        Storage,Color: 128 GB,Red/20/21000--}}
{{--                                    </li>--}}
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 text-right mt-1">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
