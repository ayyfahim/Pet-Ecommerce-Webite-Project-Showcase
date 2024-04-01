@extends('layouts.admin.dashboard')
@section('title',"Static Pages")
@section('d-buttons')
    <a href="{{route('content.admin.page.create')}}" class="btn btn-primary btn-block">
        New Page
    </a>
@endsection
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>Page</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pages as $key=>$page)
                            @include('pages.pages.manager.partials.info')
                        @empty
                            <tr>
                                <td colspan="4">No matching records found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{--                @include('layouts.admin.partials.pagination',['collection'=>$pages])--}}
            </div>
        </div>
    </div>
@endsection
