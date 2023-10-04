@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#"><strong>{{ $title }}</strong></a></li>
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
                            <h3 class="card-title">{{ $title }}</h3>
                            <a href="{{ url('vehicle') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i> @lang('cmn.list')</a>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('/vehicle', $car->car_encrypt) }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.vehicle') @lang('cmn.no')<sup style="color: red">*</sup></label>
                                    <input type="text" class="form-control" name="car_no" value="{{ old('car_no',$car->car_no)}}" placeholder="@lang('cmn.vehicle') @lang('cmn.no')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.vehicle') @lang('cmn.number') <sup style="color: red">*</sup></label>
                                    <input type="text" class="form-control" name="car_number" value="{{ old('car_number',$car->car_number)}}" placeholder="@lang('cmn.vehicle') @lang('cmn.number')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.driver')<sup style="color: red">*</sup></label>
                                    {{-- <select name="car_driver_id"  class="form-control select2" style="width: 100%;" required> --}}
                                    <select name="car_driver_id"  class="form-control" required>
                                        <option value="">@lang('cmn.please_select')</option>
                                        @if(isset($drivers))
                                        @foreach($drivers as $driver)
                                        <option value="{{ $driver->people_id }}" {{old('car_driver_id',$car->car_driver_id)==$driver->people_id ? 'selected':''}}>{{ $driver->people_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.helper')<sup style="color: red">*</sup></label>
                                    {{-- <select name="car_helper_id"  class="form-control select2" style="width: 100%;" required> --}}
                                    <select name="car_helper_id"  class="form-control" required>
                                        <option value="">@lang('cmn.please_select')</option>
                                        @if(isset($helpers))
                                        @foreach($helpers as $helper)
                                        <option value="{{ $helper->people_id }}" {{old('car_helper_id',$car->car_helper_id)==$helper->people_id ? 'selected':''}}>{{ $helper->people_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.description')</label>
                                    <textarea class="form-control" name="car_details" rows="3" placeholder="@lang('cmn.description')">{{ old('car_details',$car->car_details)}}</textarea>
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