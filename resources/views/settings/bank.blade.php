@extends('layout')


@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- /.card-header -->
            <div class="card"> 
                <div class="card-header">
                    <form method="GET" name="form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="head" value="{{ old('head',$request->head) }}" placeholder="@lang('cmn.bank')">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                    @if(Auth::user()->role->create)
                                    <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#bank_add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            {{-- bank add --}}
            <div class="modal fade" id="bank_add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('settings/banks') }}"  method="post">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.bank') @lang('cmn.form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.bank') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('invesor_name')}}" placeholder="@lang('cmn.bank')" required>
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
            {{-- bank edit --}}
            <div class="modal fade" id="bank_edit">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="" id="action_edit"  method="post">
                            @csrf
                            @method('put')
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.bank') @lang('cmn.form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.bank') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                    <input type="text" class="form-control" name="name" id="name_edit" value="{{ old('bank_name')}}" placeholder="@lang('cmn.bank')" required>
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
            <div class="card"> 
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped text-center table-hover">
                        <thead>
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:10%">@lang('cmn.sort')</th>
                                <th>@lang('cmn.bank')</th>
                                @if(Auth::user()->role->edit or Auth::user()->role->delete)
                                <th>@lang('cmn.action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($lists))
                                @foreach($lists as $key => $list)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <form action="{{ url('settings/bank-sort') }}" method="POST">
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
                                            <form id="{{$list->id}}" action="{{ url('settings/banks',$list->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/js.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">

    function editData(value){

        $("#bank_edit").modal("show");
        $("#name_edit").val(value.name);
 
        $('#action_edit').attr('action', '');
        $('#action_edit').attr('action', '/settings/banks/' + value.id);

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