@extends('layout')


@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <form method="GET" name="form">
                        <input type="hidden" name="page_name" value="pump_list">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name_phone" value="{{ old('name_phone',$request->name_phone) }}" placeholder="@lang('cmn.name_or_phone')">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                    @if(Auth::user()->role->create)
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal fade" id="add">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="action" method="POST" action="{{ url('settings/pumps') }}">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('cmn.pump') @lang('cmn.add') @lang('cmn.form')</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.write_pump_name_here')" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.phone')</label>
                                                <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone')}}" placeholder="0171 xxx xxx">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.address')</label>
                                                <textarea class="form-control" rows="1" id="address" name="address" placeholder="@lang('cmn.write_address_here')">{{ old('address')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.note')</label>
                                                <textarea class="form-control" rows="1" id="note" name="note" placeholder="@lang('cmn.write_note_here')">{{ old('note')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                    @if(Auth::user()->role->create)
                                    <div class="form-group">
                                        <button type="button" id="show_btn1" class="btn btn-success" onclick="submitForm()">
                                        <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                        <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="edit">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="action_edit" method="POST" action="">
                                @csrf
                                <input type="hidden" id="request_type" name="" value="">
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('cmn.pump') @lang('cmn.update')</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                <input type="text" class="form-control" id="name_edit" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.write_comapny_name_here')" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.phone')</label>
                                                <input type="number" class="form-control" id="phone_edit" name="phone" value="{{ old('phone')}}" placeholder="0171 xxx xxx">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.address')</label>
                                                <textarea class="form-control" rows="1" id="address_edit" name="address" placeholder="@lang('cmn.write_address_here')">{{ old('address')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.note')</label>
                                                <textarea class="form-control" rows="1" id="note_edit" name="note" placeholder="@lang('cmn.write_note_here')">{{ old('note')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                    @if(Auth::user()->role->create)
                                    <div class="form-group">
                                        <button type="button" id="show_btn1_edit" class="btn btn-success" onclick="submitFormEdit()">
                                        <i id="load_icon1_edit" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                        <i id="show_icon1_edit" class="fas fa-save"></i> @lang('cmn.do_posting')
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped text-center table-hover">
                        <thead>
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:10%">@lang('cmn.sort')</th>
                                <th>@lang('cmn.pump_name')</th>
                                @if(Auth::user()->role->edit or Auth::user()->role->delete)
                                <th>@lang('cmn.action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($lists)
                                @foreach($lists as $key => $list)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        <form action="{{ url('settings/pump-sort') }}" method="POST">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="number" class="form-control" min="0" name="sort" value="{{ $list->sort }}" required>
                                                <input type="hidden" class="form-control" name="id" value="{{ $list->id }}" required>
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-success btn-flat" onclick="return (confirm('Are you sure?'))?true:false" title="Sort order"><i class="fa fa-sort"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <b>{{ $list->name }}</b>
                                        @if($list->phone)
                                        <br>
                                        <small>@lang('cmn.address'): {{ $list->address }}</small>
                                        @endif
                                        @if($list->phone)
                                        <br>
                                        <small>@lang('cmn.phone'): {{ $list->phone }}</small>
                                        @endif
                                        @if($list->note)
                                        <br>
                                        <small>@lang('cmn.note'): {{ $list->note }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Auth::user()->role->edit)
                                        <button type="button" class="btn btn-xs bg-gradient-primary" onclick="editData({{json_encode($list) }})" title="@lang('cmn.edit')">@lang('cmn.edit')</button>
                                        @endif
                                        @if(Auth::user()->role->delete)
                                            @if(count($list->oil_expenses)==0)
                                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $list->id  }})" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                                                <form id="delete-form-{{$list->id }}" action="{{ url('settings/pumps',$list->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
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
                <div class="card-footer clearfix">
                    {{ $lists->appends(Request::input())->links() }}
                </div>
            </div>
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
        $("#edit").modal('show');

        $("#name_edit").val(value.name);
        $("#phone_edit").val(value.phone);
        $("#address_edit").val(value.address);
        $("#note_edit").val(value.note);
 
        $('#action_edit').attr('action', '');
        $('#action_edit').attr('action', base_url + '/settings/pumps/' + value.id);

        $("#request_type").attr('name','_method');
        $("#request_type").val('PUT');
    }
    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;
        event.preventDefault();
        document.getElementById('action').submit();
    }

    function submitFormEdit(){
        document.getElementById("load_icon1_edit").style.display = "inline-block";
        document.getElementById("show_icon1_edit").style.display = "none";
        document.getElementById("show_btn1_edit").disabled=true;
        event.preventDefault();
        document.getElementById('action_edit').submit();
    }

    // delete notice
    function deleteCertification(id){
        const swalWithBootstrapButtons = Swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger mr-2',
            buttonsStyling: false,
        })
        swalWithBootstrapButtons({
            title: "{{ __('cmn.are_you_sure') }}",
            text: "{{ __('cmn.for_erase_it') }}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('cmn.yes') }}",
            cancelButtonText: "{{ __('cmn.no') }}",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('delete-form-'+id).submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // swalWithBootstrapButtons()
            }
        })
    }

</script>
@endpush