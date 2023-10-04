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
                                <input type="text" class="form-control" name="name_or_email" value="{{ old('name',$request->name_or_email) }}" placeholder="@lang('cmn.name_or_email')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                               <select  class="form-control" name="position_id">
                                <option value="">@lang('cmn.please_select')</option>
                                @if(isset($positions))
                                @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ ($request->position_id==$position->id)?'selected':'' }}>{{ $position->name }}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#add" title="Add"><i class="fas fa-plus"></i> @lang('cmn.add')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('/user/lists') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.add') @lang('cmn.form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.position')</label>
                                            <select name="role_id" class="form-control" required>
                                                @if(isset($positions))
                                                @foreach($positions as $position)
                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.email') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email')}}" placeholder="example@gmail.com" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.first_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name')}}" placeholder="@lang('cmn.example') @lang('cmn.mostafijur')" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.last_name')</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name')}}" placeholder="@lang('cmn.example') @lang('cmn.rahman')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.password') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="password" class="form-control" name="password" placeholder="@lang('cmn.password')" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.confirm_password') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('cmn.confirm_password')" required>
                                        </div>
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
                            <th>@lang('cmn.position')</th>
                            <th>@lang('cmn.name')</th>
                            <th>@lang('cmn.email')</th>
                            <th>@lang('cmn.activity')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->role->name }}</td>
                            <td>{{ $list->full_name }}</td>
                            <td>
                                {{ $list->email }}<br>
                                <small>
                                    @lang('cmn.status') : <button class="btn btn-{{ ($list->status)?'success':'danger' }}  btn-xs">@lang('cmn.'.$list->status) </button>
                                </small>
                            </td>
                            <td>
                                <small>
                                    @lang('cmn.ip') : --- <br> 
                                    @lang('cmn.last_login') : ---
                                </small>
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs bg-gradient-info"  data-toggle="modal" data-target="#pass_{{$list->id}}" title="@lang('cmn.password')"><i class="fas fa-key"></i></button>
                                <button type="button" class="btn btn-xs bg-gradient-primary"  data-toggle="modal" data-target="#edit_{{$list->id}}" title="@lang('cmn.edit')"><i class="fas fa-edit"></i></button>
                                @if($list->id != 1)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification(<?php echo $list->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{ url('/user/lists',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                            <div class="modal fade" id="pass_{{$list->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ url('/user/change-password',$list->id) }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('cmn.password') @lang('cmn.form')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>@lang('cmn.new_password') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                    <input type="password" class="form-control" name="password" placeholder="@lang('cmn.new_password')" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('cmn.confirm_password') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                    <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('cmn.confirm_password')" required>
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
                            @if($list->id != 1)
                            <div class="modal fade" id="edit_{{$list->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ url('/user/lists',$list->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('cmn.edit') @lang('cmn.form')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.position')</label>
                                                            <select name="role_id" class="form-control" required>
                                                                @if(isset($positions))
                                                                @foreach($positions as $position)
                                                                <option value="{{ $position->id }}" {{ ($list->position_id==$position->id)?'selected':'' }}>{{ $position->name }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.email') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            <input type="email" class="form-control" name="email" value="{{ $list->email }}" placeholder="example@gmail.com" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.first_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            <input type="text" class="form-control" name="first_name" value="{{ $list->first_name }}" placeholder="@lang('cmn.example') @lang('cmn.mostafijur')" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.last_name')</label>
                                                            <input type="text" class="form-control" name="last_name" value="{{ $list->last_name }}" placeholder="@lang('cmn.example') @lang('cmn.rahman')">
                                                        </div>
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
                            @endif
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{ $lists->appends(Request::input())->links() }}
    </section>
    <!-- /.content -->
</div>
@endsection