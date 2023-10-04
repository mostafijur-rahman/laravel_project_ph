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
                    <button type="button" class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add" title="Add"><i class="fas fa-plus"></i> Add</button>
                    <div class="modal fade" id="add">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ url('admin/tabs') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{$title}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="icon">Icon</label>
                                            <input type="text" class="form-control" id="icon" name="icon" placeholder="fa-name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="code">Code</label>
                                            <textarea class="form-control" id="code" name="code" rows="5" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                        <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                        @if(isset($tabs))
                        @foreach($tabs as $key => $tab)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $tab->tab_title }}</td>
                            <td><i class="fa {{ $tab->tab_icon }}"></i></td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" value="{{ $tab->tab_sort }}" name="sort" required>
                                    <span class="input-group-append">
                                      <button type="button" class="btn btn-success btn-flat" onclick="return (confirm('Are you sure?'))?true:false" title="Sort order"><i class="fa fa-sort"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-md bg-gradient-primary"  data-toggle="modal" data-target="#edit_{{$tab->tab_id}}" title="Edit"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-md bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$tab->tab_id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$tab->tab_id}}" action="{{ url('tabs',$tab->tab_id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="edit_{{$tab->tab_id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ url('admin/tabs',$tab->tab_id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{$title}}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" value="{{$tab->tab_title}}" placeholder="title" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="icon">Icon</label>
                                                <input type="text" class="form-control" id="icon" name="icon" value="{{$tab->tab_icon}}" placeholder="fa-name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <textarea class="form-control" id="code" name="code" rows="5" required>{{$tab->tab_code}}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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