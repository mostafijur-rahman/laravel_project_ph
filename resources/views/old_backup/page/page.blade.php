@extends('backend.layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ url('admin/pages/create') }}" class="btn btn-md btn-success pull-right" title="Add"><i class="fas fa-plus"></i> Add</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>Title</th>
                            <th>Icon</th>
                            <th style="width:10%">Sort</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($pages))
                        @foreach($pages as $key => $page)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $page->page_title }}</td>
                            <td><i class="fa {{ $page->page_icon }}"></i></td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" value="{{ $page->page_sort }}" name="sort" required>
                                    <span class="input-group-append">
                                      <button type="button" class="btn btn-success btn-flat" onclick="return (confirm('Are you sure?'))?true:false" title="Sort order"><i class="fa fa-sort"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('admin/pages/' . $page->page_id . '/edit') }}" class="btn btn-md bg-gradient-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-md bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$page->page_id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$page->page_id}}" action="{{ url('admin/pages',$page->page_id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection