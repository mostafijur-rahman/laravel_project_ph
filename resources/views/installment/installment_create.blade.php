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
                            <h3 class="card-title">@lang('cmn.client') @lang('cmn.add') @lang('cmn.form')</h3>
                            <a href="{{ url('client') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i> @lang('cmn.list')</a>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ url('/client') }}"  method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.client') @lang('cmn.name') <sup style="color: red">*</sup></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.client') @lang('cmn.name')" required>
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
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-save"></i> @lang('cmn.save')</button>
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