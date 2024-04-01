@extends('layouts.admin.dashboard')
@section('title',"Articles")
@section('d-buttons')
    <a href="{{route('article.admin.create')}}" class="btn btn-primary btn-block">
        New Article
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
                            <th>Title</th>
                            <th>Author</th>
                            <th>Uploaded By</th>
                            <th>Last Update</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($articles as $key=>$article)
                            @include('pages.articles.manager.partials.info')
                        @empty
                            <tr>
                                <td colspan="4">No matching records found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @include('layouts.admin.partials.pagination',['collection'=>$articles])
            </div>
        </div>
    </div>
@endsection
