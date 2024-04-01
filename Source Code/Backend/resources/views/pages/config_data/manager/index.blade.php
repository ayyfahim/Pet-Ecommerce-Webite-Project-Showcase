@extends('layouts.admin.dashboard')
@section('title',$title)
@section('d-content')
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <form action="{{route('config.manager.update')}}" method="POST" class="ajax"
                      id="configUpdate" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    @method('PATCH')
                    <div class="card-body">
                        <div class="row">
                            @foreach($config_data as $key=>$config)
                                @include('pages.config_data.manager.partials.form')
                            @endforeach
                        </div>
                        <hr>
                        <div class="row">
                            @if ($group == 'social_media')
                                <div class="col-sm-6 text-sm-left text-center mt-1">
                                    <a href="{{ route('config.manager.authorizeInstagram') }}" class="btn btn-info">Authorize Instagram</a>
                                </div>
                                <div class="col-sm-6 text-sm-right text-center mt-1">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            @else
                                <div class="col-12 text-right mt-1">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
