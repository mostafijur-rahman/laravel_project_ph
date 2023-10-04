@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('settings.submenu')
            {{-- <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#"><strong>{{ $title }}</strong></a></li>
                    </ol>
                </div>
            </div> --}}
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="type" class="form-control">
                                    <option value="">@lang('cmn.please_select')</option>
                                    <option value="1" {{ old('month',$request->type)==1 ? 'selected':'' }}>Total Project</option>
                                    <option value="2" {{ old('month',$request->type)==2 ? 'selected':'' }}>Running Project</option>
                                    <option value="3" {{ old('month',$request->type)==2 ? 'selected':'' }}>Both Type</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" value="{{ old('name',$request->name) }}" placeholder="@lang('cmn.expense')">
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
                        <form action="{{ url('settings/project-expense') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">{{$title}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">@lang('cmn.expense_name')</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}" placeholder="এখানে খরচ এর নাম লিখুন" required>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radio1" name="type" value="1">
                                        <label for="radio1" class="custom-control-label">@lang('cmn.total_project')</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radio2" name="type" value="2">
                                        <label for="radio2" class="custom-control-label">@lang('cmn.running_project')</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radio3" name="type" value="3" checked>
                                        <label for="radio3" class="custom-control-label">@lang('cmn.both_project')</label>
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
                            <th style="width:10%">@lang('cmn.sort')</th>
                            <th>@lang('cmn.project_expense')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                <form action="{{ url('settings/project-expense-sort') }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" value="{{ $list->project_exp_sort }}" name="sort" required>
                                        <input type="hidden" class="form-control" name="encrypt" value="{{ $list->project_exp_encrypt }}" required>
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-success btn-flat" onclick="return (confirm('Are you sure?'))?true:false" title="Sort order"><i class="fa fa-sort"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </td>
                            <td>{{ $list->project_exp_head }}</td>
                            <td>
                                <button type="button" class="btn btn-md bg-gradient-primary"  data-toggle="modal" data-target="#edit_{{$list->project_exp_encrypt}}" title="Edit"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-md bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->project_exp_encrypt}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$list->project_exp_encrypt}}" action="{{ url('settings/project-expense',$list->project_exp_encrypt) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                            <div class="modal fade" id="edit_{{$list->project_exp_encrypt}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ url('/settings/project-expense',$list->project_exp_encrypt) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('cmn.edit')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name">@lang('cmn.expense_name')</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$list->project_exp_head)}}" placeholder="এখানে খরচ এর নাম লিখুন" required>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type" id="radio1" value="1" {{ ($list->project_exp_type==1)?'checked':'' }}>
                                                        <label for="radio1" class="form-check-label">@lang('cmn.total_project')</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type" id="radio2" value="2" {{ ($list->project_exp_type==2)?'checked':'' }}>
                                                        <label for="radio2" class="form-check-label">@lang('cmn.running_project')</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="type" id="radio3" value="3" {{ ($list->project_exp_type==3)?'checked':'' }}>
                                                        <label for="radio3" class="form-check-label">@lang('cmn.both_project')</label>
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