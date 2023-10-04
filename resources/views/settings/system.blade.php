@extends('layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ url('settings/save-system') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('cmn.company_setting')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">@lang('cmn.your_company_name')</label>
                                        <input type="text" class="form-control" id="" placeholder="যেমন - মেসার্স আবেদা কন্টেইনার এন্ড ক্যারিয়ার সার্ভিস লিমিটেড" name="company_name" value="{{ $setting['company_name']??'' }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">@lang('cmn.company_slogan')</label>
                                        <input type="text" class="form-control" id="" placeholder="যেমন - পণ্য পরিবহনে আমরাই এগিয়ে" name="slogan" value="{{ $setting['slogan']??'' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">@lang('cmn.company_address')</label>
                                        <input type="text" class="form-control" id="" placeholder="যেমন - মুক্তবাংলা শপিং, মিরপুর - ১, ঢাকা - ১২১৬" name="address" value="{{ $setting['address']??'' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">@lang('cmn.phone_numbers')</label>
                                        <input type="text" class="form-control" id="" placeholder="যেমন - 01714078743, 01714078743" name="phone" value="{{ $setting['phone']??'' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">@lang('cmn.email_addresses')</label>
                                        <input type="text" class="form-control" id="" placeholder="যেমন - example1@gmail.com, example2@gmail.com" name="email" value="{{ $setting['email']??'' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">@lang('cmn.company_website')</label>
                                        <input type="text" class="form-control" id="" placeholder="যেমন - paribahanhishab.com" name="website" value="{{ $setting['website']??'' }}">
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('cmn.system_setting')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">@lang('cmn.default_challan')</label>
                                        <select class="form-control" name="default_challan" id="">
                                            <option value="own_vehicle_single" {{ (isset($setting['default_challan']) &&  $setting['default_challan'] == 'own_vehicle_single') ? 'selected':'' }}>@lang('cmn.own_vehicle_single_challan')</option>
                                            <option value="own_vehicle_up_down" {{ (isset($setting['default_challan']) &&  $setting['default_challan'] == 'own_vehicle_up_down') ? 'selected':'' }}>@lang('cmn.own_vehicle_up_down_challan')</option>
                                            <option value="out_commission_transection" {{ (isset($setting['default_challan']) && $setting['default_challan'] == 'out_commission_transection') ? 'selected':'' }}>@lang('cmn.rental_vehicle_transection_with_commission_challan')</option>
                                            <option value="out_commission" {{ (isset($setting['default_challan']) &&  $setting['default_challan'] == 'out_commission') ? 'selected':'' }}>@lang('cmn.rental_vehicle_only_commission_challan')</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">@lang('cmn.default_oil_rate')</label>
                                        <input type="number" min="0" class="form-control" id="" placeholder="80" name="oil_rate" value="{{ $setting['oil_rate']??'' }}">
                                    </div>
                                </div>
                            </div> 
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('cmn.how_many_days_before_you_want_to_receive_notification')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.for_document')</label>
                                                <input type="number" min="0" class="form-control" placeholder="@lang('cmn.7')" name="notify_days_for_document" value="{{ $setting['notify_days_for_document']??7 }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.for_mobil')</label>
                                                <input type="number" min="0" class="form-control" placeholder="@lang('cmn.7')" name="notify_days_for_mobil" value="{{ $setting['notify_days_for_mobil']??7 }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('cmn.for_tyre')</label>
                                                <input type="number" min="0" class="form-control" placeholder="@lang('cmn.7')" name="notify_days_for_tyre" value="{{ $setting['notify_days_for_tyre']??7 }}">
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