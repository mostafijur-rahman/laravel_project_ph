@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('settings.submenu')
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <form method="GET" name="form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#add" title="Add"><i class="fas fa-plus"></i> @lang('cmn.add')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="add">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ url('/user/roles') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.add') @lang('cmn.form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>@lang('cmn.name_of_position') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.write_here')" required>
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="read" name="read" value="1" checked onclick="return false">
                                        <label for="read">@lang('cmn.read') <span class="text-muted">(@lang('cmn.read_only'))</span></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="create" name="create"  value="1">
                                        <label for="create">@lang('cmn.add') <span class="text-muted">(@lang('cmn.create_only'))</span></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="edit"  name="edit"  value="1">
                                        <label for="edit">@lang('cmn.edit') <span class="text-muted">(@lang('cmn.edit_only'))</span></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="delete" name="delete" value="1">
                                        <label for="delete">@lang('cmn.delete') <span class="text-muted">(@lang('cmn.delete_only'))</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.name')</th>
                            <th>@lang('cmn.read')</th>
                            <th>@lang('cmn.add')</th>
                            <th>@lang('cmn.edit')</th>
                            <th>@lang('cmn.delete')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->name }}</td>
                            <td>
                                <input type="checkbox" {{ ($list->read==1)?'checked':'' }} onclick="return false">
                            </td>
                            <td>
                                <input type="checkbox" {{ ($list->create==1)?'checked':'' }} onclick="return false">
                            </td>
                            <td>
                                <input type="checkbox" {{ ($list->edit==1)?'checked':'' }} onclick="return false">
                            </td>
                            <td>
                                <input type="checkbox" {{ ($list->delete==1)?'checked':'' }} onclick="return false">
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs bg-gradient-primary"  data-toggle="modal" data-target="#edit_{{$list->id}}" title="Edit"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification(<?php echo $list->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{ url('user/roles',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                            <div class="modal fade" id="edit_{{$list->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ url('/user/roles',$list->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('cmn.edit') @lang('cmn.form')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>@lang('cmn.name_of_position') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                    <input type="text" class="form-control" name="name" value="{{ old('name',$list->name)}}" placeholder="@lang('cmn.write_here')" required>
                                                </div>
                                                <div class="form-group">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" id="read_{{$list->id}}" name="read" value="1" checked onclick="return false">
                                                        <label for="read_{{$list->id}}">@lang('cmn.read') <span class="text-muted">(@lang('cmn.read_only'))</span></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" id="create_{{$list->id}}" name="create"  value="1" {{ ($list->create==1)?'checked':'' }}>
                                                        <label for="create_{{$list->id}}">@lang('cmn.add') <span class="text-muted">(@lang('cmn.create_only'))</span></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" id="editt_{{$list->id}}"  name="edit"  value="1" {{ ($list->edit==1)?'checked':'' }}>
                                                        <label for="editt_{{$list->id}}">@lang('cmn.edit') <span class="text-muted">(@lang('cmn.edit_only'))</span></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" id="delete_{{$list->id}}" name="delete" value="1" {{ ($list->delete==1)?'checked':'' }}>
                                                        <label for="delete_{{$list->id}}">@lang('cmn.delete') <span class="text-muted">(@lang('cmn.delete_only'))</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.update')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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