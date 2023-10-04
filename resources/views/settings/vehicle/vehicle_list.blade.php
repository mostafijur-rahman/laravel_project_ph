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
                                <input type="text" class="form-control" name="name" value="{{ old('name',$request->name) }}" placeholder="@lang('cmn.no_or_number')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                @if(Auth::user()->role->create)
                                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#vehicle_add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                                @endif
                                <a href="{{ url('vehicle-report-form') }}" class="btn btn-md btn-warning"><i class="fa fa-print"></i> @lang('cmn.report')</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- add modal -->
            @include('include.add_vehicle_form')
            <!-- end add modal -->
            <!-- edit modal start -->
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="" id="update_action"  method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.vehicle_update')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               <div class="form-group">
                                    <label for="">@lang('cmn.ownership_type')</label>
                                    <select name="ownership_type" id="ownership_type" onchange="editGetOwner(this.value)" class="form-control" required>
                                        <option value="1">@lang('cmn.own')</option>
                                        <option value="2">@lang('cmn.transport')</option>
                                    </select>
                                </div>
                                <div class="form-group" id="edit_transport_supp">
                                    <label>@lang('cmn.transport') <span class="text-danger">(@lang('cmn.required'))</span></label>
                                    <select class="form-control select2" id="transport" name="supplier_id">
                                        <option value="">@lang('cmn.please_select')</option>
                                        @foreach($suppliers as $supp)
                                        <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.vehicle') @lang('cmn.no')</label>
                                    <input type="text" class="form-control" id="no" name="vehicle_serial" value="{{ old('vehicle_serial')}}" placeholder="@lang('cmn.vehicle') @lang('cmn.no')">
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.vehicle') @lang('cmn.number') <span class="text-danger">(@lang('cmn.required'))</span></label>
                                    <input type="text" class="form-control" id="number" name="vehicle_number" value="{{ old('vehicle_number')}}" placeholder="@lang('cmn.vehicle') @lang('cmn.number')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.driver')</label>
                                    <select name="driver_id" id="driver_id" class="form-control select2">
                                        <option value="">@lang('cmn.please_select')</option>
                                        @if(isset($drivers))
                                        @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}" {{old('driver_id')==$driver->id ? 'selected':''}}>{{ $driver->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.helper')</label>
                                    <select name="helper_id" id="helper_id"  class="form-control select2">
                                        <option value="">@lang('cmn.please_select')</option>
                                        @if(isset($helpers))
                                        @foreach($helpers as $helper)
                                        <option value="{{ $helper->id }}" {{old('helper_id')==$helper->id ? 'selected':''}}>{{ $helper->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.description')</label>
                                    <textarea class="form-control" id="details" name="details" rows="3" placeholder="@lang('cmn.description')">{{ old('details')}}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.do_update')</button>
                            </div>
                            <input type="hidden" name="encrypt" id="encrypt">
                        </form>
                    </div>
                </div>
            </div>
            <!-- end edit modal -->
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.transport')</th>
                            <th>@lang('cmn.no')</th>
                            <th>@lang('cmn.number')</th>
                            <th>@lang('cmn.driver')</th>
                            <th>@lang('cmn.phone')</th>
                            <th>@lang('cmn.helper')</th>
                            @if(Auth::user()->role->eidt or Auth::user()->role->delete)
                            <th>@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($cars))
                        @foreach($cars as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ ($list->supplier_id)?$list->supplier->name:'------' }}</td>
                            <td>{{ $list->vehicle_serial }}</td>
                            <td>{{ $list->vehicle_number }}</td>
                            <td>{{ $list->driver->name }}</td>
                            <td><a href='tel:{{ $list->driver->people_phone }}'>{{ $list->driver->phone }}</a></td>
                            <td>{{ $list->helper->name }}</td>
                            <td>
                                <div class="btn-group">
                                    @if(Auth::user()->role->edit)
                                    <button class="btn btn-xs bg-gradient-primary" onclick="editData({{ json_encode($list) }})" type="button" title="@lang('cmn.edit')"><i class='fa fa-edit'></i></button>
                                    @endif
                                    @if(Auth::user()->role->delete)
                                    <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification(<?php echo $list->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                    <form id="delete-form-{{$list->id}}" action="{{ url('settings/vehicles',$list->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                    <div class="dropdown show ml-1">
                                        <a class="btn btn-xs bg-gradient-warning dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('cmn.others')
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ url('vehicle/' . $list->encrypt . '/document') }}">@lang('cmn.document_update')</a>
                                            <a class="dropdown-item" href="{{ url('vehicle/' . $list->encrypt . '/document-print') }}" target="_blank">@lang('cmn.document_print')</a>
                                            {{-- <a class="dropdown-item" href="{{ url('vehicle/' . $list->encrypt . '/history') }}" title="@lang('cmn.history') / @lang('cmn.total_project_print')" target="_blank">@lang('cmn.history')</a> --}}
                                        </div>
                                    </div>
                                </div>
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
        {{ $cars->appends(Request::input())->links() }}
    </section>
    <!-- /.content -->
</div>

@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#transport_supp').hide();
        $('#edit_transport_supp').hide();
    });

    function getOwner(value){
        if(value == 2){
            $('#transport_supp').show();
        }else{
            $('#transport_supp').hide();
        }
    }

    function editGetOwner(value){
        if(value == 2){
            $('#edit_transport_supp').show();
        }else{
            $('#edit_transport_supp').hide();
        }
    }

    function editData(value){
        $("#editModal").modal("show");
        if(value.supplier_id){
            $('#edit_transport_supp').show();
            $('#transport').val(value.supplier_id);
            $('#ownership_type').val(2);
        }else{
            $('#edit_transport_supp').hide();
        }
        $("#encrypt").val(value.encrypt)
        $("#no").val(value.vehicle_serial)
        $("#number").val(value.vehicle_number)
        $("#driver_id").val(value.driver_id)
        $("#helper_id").val(value.helper_id)
        $("#details").val(value.details)
        $(".select2").select2();
        $('#update_action').attr('action', 'vehicles/' + value.id)                          
    }
</script>
@endpush