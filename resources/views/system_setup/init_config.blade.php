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
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">@lang('cmn.init_config')</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('save-init-config') }}"  method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        {{ $info }}
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.business_type')</label>
                                            <select name="business_type" class="form-control">
                                                {{-- {{ (isset($info) && $info->key == 'init_business_type' && $info->key == 'transport')?'selected':'' }} --}}
                                                {{-- {{ (isset($info) && $info->key == 'init_business_type' && $info->key == 'vehicle')?'selected':'' }} --}}
                                                <option value="">Select Please</option>
                                                <option value="transport">Transport Business</option>
                                                <option value="vehicle">Vehicle Business</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.bill_type')</label>
                                            <select name="bill_type" class="form-control">
                                                <option value="">Select Please</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="yearly">Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.periodic_bill')</label>
                                            <input type="text" class="form-control" name="periodic_bill"  value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-icon"><i class="fas fa-upload"></i> @lang('cmn.update')</button>
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