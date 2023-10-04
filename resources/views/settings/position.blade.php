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
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="head" value="{{ old('head',$request->head) }}" placeholder="@lang('cmn.position')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                @if(Auth::user()->role->create)
                                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#position_add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- position add --}}
        <div class="modal fade" id="position_add">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ url('settings/tyer-positions') }}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">@lang('cmn.position_form')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">@lang('cmn.tyer_position_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('invesor_name')}}" placeholder="@lang('cmn.tyer_position_name')" required>
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
         {{-- position edit --}}
         <div class="modal fade" id="position_edit">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action=""  method="post" id="action_edit">
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h4 class="modal-title">@lang('cmn.position_form')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">@lang('cmn.tyer_position_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                <input type="text" class="form-control" name="name" id="name_edit" value="{{ old('invesor_name')}}" placeholder="@lang('cmn.tyer_position_name')" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.do_posting')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:10%">@lang('cmn.sort')</th>
                            <th>@lang('cmn.position')</th>
                            @if(Auth::user()->role->edit or Auth::user()->role->delete)
                            <th>@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($lists)>0)
                            @foreach($lists as $key => $list)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    <form action="{{ url('settings/position-sort') }}" method="POST">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" value="{{ $list->sort }}" name="sort" required>
                                            <input type="hidden" class="form-control" name="id" value="{{ $list->id }}" required>
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-success btn-flat" onclick="return (confirm('Are you sure?'))?true:false" title="Sort order"><i class="fa fa-sort"></i></button>
                                            </span>
                                        </div>
                                    </form>
                                </td>
                                <td>{{ $list->name }}</td>
                                <td>
                                    @if(Auth::user()->role->edit)
                                    <button type="button" class="btn btn-xs bg-gradient-primary" onclick="editData({{json_encode($list) }})" title="Edit"><i class="fas fa-edit"></i></button>
                                    @endif
                                    @if(Auth::user()->role->delete)
                                    <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                    <form id="{{$list->id}}" action="{{ url('settings/tyer-positions',$list->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else 
                            <tr>
                                <td colspan="6" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4></td>
                            </tr>
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
@push('js')
<script src="{{ asset('assets/plugins/js.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">

    function editData(value){

        $("#position_edit").modal('show');

        $("#name_edit").val(value.name);
 
        $('#action_edit').attr('action', '');
        $('#action_edit').attr('action', '/settings/tyer-positions/' + value.id);
    }
    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;
        event.preventDefault();
        document.getElementById('action').submit();
    }
</script>
@endpush