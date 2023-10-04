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
                        <form action="{{ url('/vehicle') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">@lang('cmn.ownership_type')</label>
                                    <select name="ownership_type"  class="form-control" required>
                                        <option value="1">Own</option>
                                        <option value="2">Contractula</option> jkdhfjdksj
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.vehicle') @lang('cmn.no')<sup style="color: red">*</sup></label>
                                    <input type="text" class="form-control" name="car_no" value="{{ old('car_no')}}" placeholder="@lang('cmn.vehicle') @lang('cmn.no')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.vehicle') @lang('cmn.number') <sup style="color: red">*</sup></label>
                                    <input type="text" class="form-control" name="car_number" value="{{ old('car_number')}}" placeholder="@lang('cmn.vehicle') @lang('cmn.number')" required>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.driver')<sup style="color: red">*</sup></label>
                                    <select name="car_driver_id" class="form-control select2" style="width: 100%;" required>
                                        <option value="">@lang('cmn.please_select')</option>
                                        @if(isset($drivers))
                                        @foreach($drivers as $driver)
                                        <option value="{{ $driver->people_id }}" {{old('car_driver_id')==$driver->people_id ? 'selected':''}}>{{ $driver->people_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.helper')<sup style="color: red">*</sup></label>
                                    <select name="car_helper_id"  class="form-control select2" style="width: 100%;" required>
                                        <option value="">@lang('cmn.please_select')</option>
                                        @if(isset($helpers))
                                        @foreach($helpers as $helper)
                                        <option value="{{ $helper->people_id }}" {{old('car_helper_id')==$helper->people_id ? 'selected':''}}>{{ $helper->people_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('cmn.description')</label>
                                    <textarea class="form-control" name="car_details" rows="3" placeholder="@lang('cmn.description')">{{ old('car_details')}}</textarea>
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