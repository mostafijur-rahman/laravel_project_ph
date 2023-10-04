@extends('layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ url('settings/save-admin') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('cmn.billing') @lang('cmn.info')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.business_type')</label>
                                                <select class="form-control" name="business_type" id="">
                                                    <option value="own_vehilce" {{ (isset($setting['business_type']) &&  $setting['business_type'] == 'own_vehilce') ? 'selected':'' }}>@lang('cmn.own_vehilce')</option>
                                                    <option value="only_comission" {{ (isset($setting['business_type']) &&  $setting['business_type'] == 'only_comission') ? 'selected':'' }}>@lang('cmn.only_comission')</option>
                                                    <option value="own_vehilce_and_comission" {{ (isset($setting['business_type']) && $setting['business_type'] == 'own_vehilce_and_comission') ? 'selected':'' }}>@lang('cmn.own_vehilce_and_comission')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.max_own_vehicle_qty')</label>
                                                <input type="number" min="0" class="form-control" id="" placeholder="5" name="max_own_vehicle_qty" value="{{ $setting['max_own_vehicle_qty']??'' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.max_challan_qty_per_month')</label>
                                                <input type="number" min="0" class="form-control" id="" placeholder="1000" name="max_challan_qty_per_month" value="{{ $setting['max_challan_qty_per_month']??'' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.last_date_of_bill_payment')</label>
                                                <input type="date" min="0" class="form-control" id="" placeholder="1000" name="last_date_of_bill_payment" value="{{ $setting['last_date_of_bill_payment']??'' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.total_bill')</label>
                                                <input type="number" min="0" class="form-control" id="" placeholder="20000" name="total_bill" value="{{ $setting['total_bill']??'' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.notify_days_for_bill')</label>
                                                <input type="number" min="0" class="form-control" id="" placeholder="1000" name="notify_days_for_bill" value="{{ $setting['notify_days_for_bill']??'' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.due_payment_action')</label>
                                                <select class="form-control" name="due_payment_action" id="">
                                                    <option value="warning" {{ (isset($setting['due_payment_action']) &&  $setting['due_payment_action'] == 'warning') ? 'selected':'' }}>@lang('cmn.warning')</option>
                                                    <option value="lock" {{ (isset($setting['due_payment_action']) &&  $setting['due_payment_action'] == 'lock') ? 'selected':'' }}>@lang('cmn.lock')</option>
                                                    <option value="shutdown" {{ (isset($setting['due_payment_action']) && $setting['due_payment_action'] == 'shutdown') ? 'selected':'' }}>@lang('cmn.shutdown')</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> @lang('cmn.save')</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
    </section>
    <!-- /.content -->
</div>
@endsection