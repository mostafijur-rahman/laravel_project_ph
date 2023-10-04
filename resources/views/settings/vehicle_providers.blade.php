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
                    gfjhfgf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name_phone" value="{{ old('name_phone',$request->name_phone) }}" placeholder="Name or Phone">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- add modal -->
            <div class="modal fade" id="add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('settings/providers') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">{{$title}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.providers') @lang('cmn.name') <sup style="color: red">*</sup></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.providers') @lang('cmn.name')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.phone') </label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone')}}" placeholder="@lang('cmn.phone')">
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.address') </label>
                                    <textarea class="form-control" rows="2" name="address" placeholder="@lang('cmn.address')">{{ old('address')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.note') </label>
                                    <textarea class="form-control" rows="2" name="note" placeholder="@lang('cmn.note')">{{ old('note')}}</textarea>
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
            <!-- end add modal -->

            <!-- edit modal start -->
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('/settings/providers-update') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">{{$title}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.providers') @lang('cmn.name') <sup style="color: red">*</sup></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.providers') @lang('cmn.name')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.phone') </label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone')}}" placeholder="@lang('cmn.phone')">
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.address') </label>
                                    <textarea class="form-control" rows="2" id="address" name="address" placeholder="@lang('cmn.address')">{{ old('address')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.note') </label>
                                    <textarea class="form-control" rows="2" id="note" name="note" placeholder="@lang('cmn.note')">{{ old('note')}}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save')</button>
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
                            <th>@lang('cmn.providers') @lang('cmn.name')</th>
                            <th>@lang('cmn.phone')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->name }}</td>
                            <td>{{ $list->phone }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="editData({{$list->id }})" type="button" title="@lang('cmn.edit')"><i class='fa fa-edit'></i></button>
                                <button type="button" class="btn btn-sm bg-gradient-danger" onclick="return deleteCertification(<?php echo $list->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{ url('settings/providers',$list->id) }}" method="POST" style="display: none;">
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

<script type="text/javascript">
    function editData(id){
        if(id){
            $.ajax({
                type: 'GET',
                dataType: "json",
                url: "providers/" + id+"/edit",
                success: function(data) {
                   if(data.status){
                        let providers = data.data
                        $("#editModal").modal("show");
                        $("#encrypt").val(providers.encrypt)
                        $("#name").val(providers.name)
                        $("#phone").val(providers.phone)
                        $("#address").val(providers.address)
                        $("#note").val(providers.note)
                   }else{
                    alert(data.message)
                   }
                }
            });
        }
    }
</script>

@endsection