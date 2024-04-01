@extends('layouts.admin.dashboard')
@section('title','Email Templates')
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($email_templates as $key=>$email_template)
                            @include('pages.email_templates.manager.partials.info')
                        @empty
                            <tr>
                                <td colspan="4">No matching records found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @include('layouts.admin.partials.pagination',['collection'=>$email_templates])
            </div>
        </div>
    </div>
@endsection
