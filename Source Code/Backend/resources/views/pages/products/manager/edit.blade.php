@extends('layouts.admin.dashboard')
@section('title',$product->info->title)
@include('pages.products.manager.partials.styles')
@section('d-content')
    <div class="row">
        <form action="{{route('product.admin.update',$product->id)}}" enctype="multipart/form-data" class="ajax"
              method="POST" id="BasicInfo">
            <div class="col-12">
                <div class="card">
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    <div class="card-body">
                        @method('PATCH')
                        @include('pages.products.manager.partials.form')
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-right mt-1">
                        <button type="submit" class="btn btn-primary">Save All</button>
                        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="variationMediaModal" data-variation_id="" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="variationMediaModalLabel">Select Variation Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($product->gallery as $image)
                        <div class="variation-image d-inline-block pointer" data-id="{{$image->id}}">
                            <img src="{{$image->getUrl('thumb')}}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@include('pages.products.manager.partials.scripts')
