@extends('layouts.admin.dashboard')
@section('title',"Authors")
@section('d-buttons')
    <a href="{{route('author.admin.create')}}" class="btn btn-primary btn-block">
        New Author
    </a>
@endsection
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($authors as $key=>$author)
                            @include('pages.authors.manager.partials.info')
                        @empty
                            <tr>
                                <td colspan="4">No matching records found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @include('layouts.admin.partials.pagination',['collection'=>$authors])
            </div>
        </div>
    </div>
@endsection
