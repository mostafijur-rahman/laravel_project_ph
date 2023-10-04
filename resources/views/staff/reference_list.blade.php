@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $staff_name }}</h3>
                <div class="card-tools">
                    @if(Auth::user()->role->create)
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#add" title="@lang('cmn.add')"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                    @endif
                </div>
            </div>

            <!-- add -->
            <div class="modal fade" id="add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('staff/reference') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="staff_id" value="{{ $staff_id }}">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.add') @lang('cmn.form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="">@lang('cmn.referrer') @lang('cmn.name')</label>
                                    <input type="text" class="form-control" name="referrer" value="{{ old('referrer')}}" placeholder="@lang('cmn.referrer') @lang('cmn.name')">
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.relation')</label>
                                    <input type="text" class="form-control" list="unique_relation_else" name="relation" value="{{ old('relation')}}" placeholder="@lang('cmn.relation')">
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.phone')</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone')}}" placeholder="@lang('cmn.phone')">
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.nid_number')</label>
                                    <input type="text" class="form-control" name="nid_number" value="{{ old('nid_number')}}" placeholder="@lang('cmn.nid_number')">
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.address')</label>
                                    <textarea class="form-control" name="address" placeholder="@lang('cmn.write_address_here')" rows="1"></textarea>
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
                            <th style="width:20%">@lang('cmn.referrer')</th>
                            <th style="width:15%">@lang('cmn.relation')</th>
                            <th style="width:15%">@lang('cmn.phone')</th>
                            <th style="width:20%">@lang('cmn.nid_number')</th>
                            <th style="width:20%">@lang('cmn.address')</th>
                            <th style="width:10%">@lang('cmn.main_referrer')</th>

                            @if(Auth::user()->role->delete or Auth::user()->role->edit)
                            <th  style="width:10%">@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($lists) > 0)
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ $list->referrer }}</td>
                            <td>{{ $list->relation }}</td>
                            <td>
                                <span id="phone_to_copy_{{ $list->id }}" >{{ $list->phone }}</span>
                                <button type="button" class="btn btn-xs btn-success" onclick="copy({{ $list->id }})">@lang('cmn.copy')</button>
                            </td>
                            <td>{{ $list->nid_number }}</td>
                            <td>{{ $list->address }}</td>
                            <td>
                                @if($list->main_referrer == 1)
                                    <button type="button" class="btn btn-xs btn-success"><i class="fas fa-check"></i></button>
                                @else
                                <button type="button" class="btn btn-xs btn-secondary" onclick="return makeMainCertification({{ $list->id  }})"><i class="fas fa-check"></i></button>
                                <form id="make-main-form-{{$list->id}}" action="{{ url('staff/make-main-referrer', $list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                @endif
                            </td>

                            @if(Auth::user()->role->delete or Auth::user()->role->edit)
                            <td>
                                
                                @if(Auth::user()->role->edit)
                                <a href="#" class="btn btn-xs bg-gradient-primary" data-toggle="modal" data-target="#edit_{{ $list->id }}" title="@lang('cmn.edit')"><i class="fas fa-edit"></i></a>
                                @endif

                                @if(Auth::user()->role->delete)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $list->id  }})" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{ url('staff/reference', $list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif

                            </td>
                            @endif
                        </tr>

                        <div class="modal fade" id="edit_{{ $list->id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ url('staff/reference', $list->id) }}"  method="post">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="staff_id" value="{{ $staff_id }}">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('cmn.update') @lang('cmn.form')</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
            
                                            <div class="form-group">
                                                <label for="">@lang('cmn.referrer') @lang('cmn.name')</label>
                                                <input type="text" class="form-control" name="referrer" value="{{ $list->referrer }}" placeholder="@lang('cmn.referrer') @lang('cmn.name')">
                                            </div>
                                            <div class="form-group">
                                                <label for="">@lang('cmn.relation')</label>
                                                <input type="text" class="form-control" list="unique_relation_else" name="relation" value="{{ $list->relation }}" placeholder="@lang('cmn.relation')">
                                            </div>
                                            <div class="form-group">
                                                <label for="">@lang('cmn.phone')</label>
                                                <input type="text" class="form-control" name="phone" value="{{ $list->phone }}" placeholder="@lang('cmn.phone')">
                                            </div>
                                            <div class="form-group">
                                                <label for="">@lang('cmn.nid_number')</label>
                                                <input type="text" class="form-control" name="nid_number" value="{{ $list->nid_number }}" placeholder="@lang('cmn.nid_number')">
                                            </div>
                                            <div class="form-group">
                                                <label for="">@lang('cmn.address')</label>
                                                <textarea class="form-control" name="address" placeholder="@lang('cmn.write_address_here')" rows="1">{{ $list->address }}</textarea>
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

                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4></td>
                        </tr>
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
<datalist id="unique_relation_else">
    @if(count($unique_relation_names)>0)
        @foreach( $unique_relation_names as $unique_relation_name)
        <option value="{{ $unique_relation_name->relation }}"></option>
        @endforeach
    @endif
</datalist>
@endsection

@push('js')
<script type="text/javascript">
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

    function copy(id){
        
        var copyText = document.getElementById("phone_to_copy_" + id);
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();

        // alert("Copied the text: " + copyText.value);
    }

    function makeMainCertification(id){
        const swalWithBootstrapButtons = Swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger mr-2',
            buttonsStyling: false,
        })
        swalWithBootstrapButtons({
            title: "{{ __('cmn.are_you_sure') }}",
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('cmn.yes') }}",
            cancelButtonText: "{{ __('cmn.no') }}",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('make-main-form-'+id).submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // swalWithBootstrapButtons()
            }
        })
    }
</script>
@endpush