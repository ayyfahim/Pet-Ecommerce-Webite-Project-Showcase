@extends('layouts.admin.dashboard')
@section('title','Categories')
@section('d-styles')
    <style>
        table.table-nested tr.nested {
            /*display: none;*/
        }

        table.table-nested tr.nested.child td:first-child {
            padding-left: 40px;
        }

        table.table-nested tr.nested.child-child td:first-child {
            padding-left: 80px;
        }

        table.table-nested tr.nested.child-child-child td:first-child {
            padding-left: 80px;
        }

        table.table-nested th:first-of-type,
        table.table-nested td:first-of-type {
            text-align: left !important;
        }
    </style>
@endsection
@section('d-buttons')
    @permission('add_categories')
    <a href="{{route('category.admin.create')}}" class="btn btn-primary btn-block">New Category</a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-8">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="status_id" data-width="100%">
                <option value="all">Status</option>
                @foreach($status as $item)
                    <option @if(request('status_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
@section('filter-route',route('category.admin.index'))

@section('d-filters-btn')
    <a href="{{route('category.admin.export',request()->getQueryString())}}" class="btn btn-warning">
        Export Results
    </a>
@endsection
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title">{{$helper->pagination_label($categories,'Main Categories')}}</h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-nested table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Products</th>
                            <th scope="col">Qtty Sold</th>
                            <th scope="col">Total Sales</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $firstCategoryKey=>$category)
                            @php
                                $parentId = 'parent-'.$firstCategoryKey
                            @endphp
                            @include('pages.categories.manager.partials.info',[
                            'tr_class'=>$category->children?'parent':'',
                            'tr_id'=>$parentId,
                            ])
                            @foreach($category->children->sortBy('name') as $secondCategoryKey=>$secondCategory)
                                @php
                                    $secondId = 'parent-'.$firstCategoryKey.'-'.$secondCategoryKey
                                @endphp
                                @include('pages.categories.manager.partials.info',[
                            'category'=>$secondCategory,
                           'tr_class'=>$secondCategory->children->count() ?'nested child parent': 'nested child',
                           'data_parent'=>$parentId,
                           'tr_id'=>$secondId,
                           'indicator'=>'-',
                           ])
                                @foreach($secondCategory->children->sortBy('name') as $thirdLevelChildKey=>$thirdLevelChild)
                                    @php
                                        $thirdId = 'parent-'.$firstCategoryKey.'-'.$secondCategoryKey.'-'.$thirdLevelChildKey
                                    @endphp
                                    @include('pages.categories.manager.partials.info',[
                                'category'=>$thirdLevelChild,
                               'tr_class'=>$thirdLevelChild->children->count() ?'nested child-child parent': 'nested child-child',
                               'data_parent'=>$secondId,
                               'data_top_parent'=>$parentId,
                                'tr_id'=>$thirdId,
                               'indicator'=>'--',
                               ])
                                    @foreach($thirdLevelChild->children->sortBy('name') as $key=>$lastChild)
                                        @include('pages.categories.manager.partials.info',[
                                    'category'=>$lastChild,
                                   'tr_class'=>$lastChild->children->count() ?'nested child-child parent': 'nested child-child-child',
                                   'data_parent'=>$thirdId,
                                   'data_top_parent'=>$parentId,
                                  'indicator'=>'---',
                                   ])
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    @include('layouts.admin.partials.pagination',['collection'=>$categories])
                </div>
            </div>
        </div>
    </div>
@endsection
