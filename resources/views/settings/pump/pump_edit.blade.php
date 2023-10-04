@extends('layout')

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
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">@lang('cmn.pump') @lang('cmn.edit') @lang('cmn.form')</h3>
                            <a href="{{ url('pump') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i> @lang('cmn.list')</a>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('/pump', $pump->pump_encrypt) }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.pump_name') <sup style="color: red">*</sup></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $pump->pump_name) }}" placeholder="@lang('cmn.pump_name')" required>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-save"></i> @lang('cmn.update')</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script>
    $("#logo").attr('type', 'file'); 
    $("#favicon").attr('type', 'file'); 
</script>
@endpush