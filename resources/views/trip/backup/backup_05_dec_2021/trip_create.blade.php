@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- trip box -->
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered text-center text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th width="30%">@lang('cmn.primary_info')</th>
                            <th width="40%">গাড়ীর লেনদেন</th>
                            <th width="30%">কোম্পানীর লেনদেন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($trip)
                            <tr class="text-center">
                                <td class="text-left">
                                    <small>
                                        @if($trip->account_take_date)
                                            @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                        @endif
                                        @lang('cmn.trip_number'): <b>{{ $trip->number }}</b><br>
                                        @lang('cmn.vehicle'): <b>{{ $trip->supplier->vehicle_number }}</b><br>
                                        @lang('cmn.driver'): <b>{{ $trip->supplier->driver_name }}({{ $trip->supplier->driver_phone }})</b><br>
                                        @lang('cmn.owner'): <b>{{ $trip->supplier->owner_name }}({{ $trip->supplier->owner_phone }})</b><br>
                                        @lang('cmn.reference'): <b>{{ $trip->supplier->reference_name }}({{ $trip->supplier->reference_phone }})</b><br>
                                        @if($trip->meter->previous_reading)
                                            @lang('cmn.start_reading'): <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
                                            @lang('cmn.last_reading'): <b>{{ number_format($trip->meter->current_reading) }}</b><br>
                                            @lang('cmn.total') @lang('cmn.km'): <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
                                            @lang('cmn.total') @lang('cmn.fuel'): <b>{{ number_format($tripOilLiterSumByGroupId) }}</b><br>
                                            @if($tripOilLiterSumByGroupId > 0)
                                                @lang('cmn.liter_per_km'): <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}</b><br>
                                            @endif
                                        @endif
                                        @lang('cmn.created'): <b>{{ $trip->user->first_name}}</b><br>
                                        <br>
                                        <div class="row">
                                            <div class="btn-group">
                                                <a href="{{ url('trip-report?type=chalan&group_id='. $trip->group_id) }}" class="btn btn-warning btn-xs" target="_blank" aria-label="Trip Chalan"><i class="fa fa-fw fa-print"></i> @lang('cmn.chalan')</a>
                                            </div>
                                        </div>
                                    </small>
                                </td>
                                <td class="text-left">
                                    <small>
                                    @if($trip->getTripsByGroupId)
                                        @php $tripLastKey = count($trip->getTripsByGroupId); @endphp
                                        @foreach($trip->getTripsByGroupId as $tripKey => $trip_info)
                                            @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip_info->date)) }}</b><br>
                                            @lang('cmn.load_point'): <b>{{ $trip_info->load_data->name }}</b><br>
                                            @lang('cmn.unload_point'): <b>{{ $trip_info->unload->name }}</b><br>
                                            @lang('cmn.rent'): <b>{{ number_format($trip_info->supplier->contract_fair) }}</b><br>
                                            @lang('cmn.addv_pay'): <b>{{ number_format($trip_info->supplier->advance_fair) }}</b><br>
                                            @lang('cmn.challan_due'): <b>{{ number_format($trip_info->supplier->due_fair) }}</b><br>
                                            @if($trip_info->supplier->deduction_fair>0)
                                                @lang('cmn.discount'): <b>{{ number_format($trip_info->supplier->deduction_fair) }}</b><br>
                                            @endif
                                            বাক্স সংখ্যা: <b>{{ number_format($trip_info->box) }}</b><br>
                                            ওজন: <b>{{ number_format($trip_info->weight) }}(টন)</b><br>
                                            @lang('cmn.goods'): <b>{{ $trip_info->goods }}</b><br>
                                            @if(($tripKey+1) != $tripLastKey)
                                                <a class="btn btn-xs btn-danger" href="{{ url('new-trip-delete', $trip_info->id) }}" onclick="return confirm(`@lang('cmn.are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a>
                                                <br><br>
                                            @endif
                                            @if($tripKey == 0 && $tripKey+1 == $tripLastKey)
                                                <a class="btn btn-xs btn-danger" href="{{ url('new-trip-delete-all', $trip_info->id) }}" onclick="return confirm(`@lang('cmn.all_information_will_delete_are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a>
                                            @endif
                                        @endforeach
                                    @endif
                                    </small>
                                </td>
                                <td class="text-left">
                                    <small>
                                        @lang('cmn.company'): <b>{{ $trip_info->company->company->name }}</b><br>
                                        @lang('cmn.rent'): <b>{{ number_format($trip_info->company->contract_fair) }}</b><br>
                                        @lang('cmn.addv_recev'): <b>{{ number_format($trip_info->company->advance_fair) }}</b><br>
                                        @lang('cmn.challan_due'): <b>{{ number_format($trip_info->company->due_fair) }}</b><br>
                                        @if($trip_info->company->deduction_fair>0)
                                        @lang('cmn.discount'): <b>{{ number_format($trip_info->company->deduction_fair) }}</b><br>
                                        @endif
                                    </small>
                                </td>
                            </tr>
                        @else
                        <tr class="text-center">
                            <td class="text-left">
                                <small>
                                    @lang('cmn.posting_date'): <b>---</b><br>
                                    @lang('cmn.trip_number'): <b>---</b><br>
                                    @lang('cmn.vehicle'): <b>---</b><br>
                                    @lang('cmn.driver'): <b>---</b><br>
                                    @lang('cmn.owner'):  <b>---</b><br>
                                    @lang('cmn.reference'): <b>---</b><br>
                                    {{-- @lang('cmn.start_reading'): ---<br>
                                    @lang('cmn.last_reading'): ---<br>
                                    @lang('cmn.total') @lang('cmn.km'): ---<br>
                                    @lang('cmn.total') @lang('cmn.fuel'): ---<br>
                                    @lang('cmn.liter_per_km'):---<br> --}}
                                    @lang('cmn.created'): <b>---</b><br>
                                </small>
                            </td>
                            <td class="text-left">
                                <small>
                                    @lang('cmn.start_date'):<b>---</b><br>
                                    @lang('cmn.load_point'): <b>---</b><br>
                                    @lang('cmn.unload_point'): <b>---</b><br>
                                    @lang('cmn.rent'): <b>---</b><br>
                                    @lang('cmn.addv_pay'): <b>---</b><br>
                                    @lang('cmn.challan_due'): <b>---</b><br>
                                    @lang('cmn.discount'): <b>---</b><br>
                                    @lang('cmn.goods'): <b>---</b><br>
                                </small>
                            </td>
                            <td class="text-left">
                                <small>
                                    @lang('cmn.company'): <b>---</b><br>
                                    @lang('cmn.rent'): <b>---</b><br>
                                    @lang('cmn.addv_recev'): <b>---</b><br>
                                    @lang('cmn.challan_due'): <b>---</b><br>
                                    @lang('cmn.discount'): <b>---</b><br>
                                    বাক্স সংখ্যা: <b>---</b><br>
                                    ওজন: <b>---</b><br>
                            </small>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- summary box -->
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered text-center text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th width="30%">ট্রান্সপোর্ট কমিশন হিসাব</th>
                            <th width="30%">ট্রিপের জমা</th>
                            <th width="30%">ট্রিপের খরচ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($trip)
                            @php
                                $tripOilLiterSumByGroupId = 0;// tripOilLiterSumByGroupId($trip->group_id)
                                $total_general_expense_sum =  0;// tripExpenseSumByGroupId($trip->group_id);
                                $total_oil_bill_sum =  0; // tripOilBillSumByGroupId($trip->group_id);
                                $total_received_rent =  0; // $trip->getTripsByGroupId->sum('advance_fair') + $trip->getTripsByGroupId->sum('received_fair');
                                $trip_general_exp_lists = tripExpenseListSumByGroupId($trip->group_id);
                            @endphp
                            <tr class="text-center">
                                <td class="text-right">
                                    <small>
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            কোম্পানী থেকে গ্রহণ = <b>{{ number_format($trip_info->company->advance_fair) }}</b><br>
                                            (একাউন্ট - 29519) ভাড়া বাবদ প্রদান = <b>{{ number_format($trip_info->supplier->advance_fair) }}</b><br>
                                        </div>
                                        প্রাপ্ত কমিশন = <b>{{ number_format($trip_info->company->advance_fair - $trip_info->supplier->advance_fair) }}</b><br>
                                        {{-- (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>) --}}
                                    </small>
                                </td>
                                <td class="text-right">
                                    <small>
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            @lang('cmn.rent') = <b>{{ number_format($total_received_rent) }}</b><br>
                                            @lang('cmn.total_expense') = <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
                                        </div>
                                        @lang('cmn.net_income') = <b>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</b><br>
                                        (@lang('cmn.challan_due') = <b>{{ number_format($trip->getTripsByGroupId->sum('due_fair')) }}</b>, @lang('cmn.discount') = <b>{{ number_format($trip->getTripsByGroupId->sum('deduction_fair')) }}</b>)
                                    </small>
                                </td>
                                <td class="text-right">
                                    <small>
                                        <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            @if($trip_general_exp_lists)
                                                @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                                                <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}<br>
                                                @endforeach
                                        </div>
                                        <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                                            @endif
                                    </small>
                                </td>
                            </tr>
                        @else
                            <tr class="text-center">
                                <td class="text-right">
                                    <small>
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            কোম্পানী থেকে গ্রহণ = <b>---</b><br>
                                            ভাড়া বাবদ প্রদান = <b>---</b><br>
                                        </div>
                                        প্রাপ্ত কমিশন = <b>---</b><br>
                                        (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>)
                                    </small>
                                </td>
                                <td class="text-right">
                                    <small>
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            @lang('cmn.rent') = <b>---</b><br>
                                            @lang('cmn.total_expense') = <b>---</b><br>
                                        </div>
                                        @lang('cmn.net_income') = <b>---</b><br>
                                        (@lang('cmn.challan_due') = <b>---</b>,
                                        @lang('cmn.discount') = <b>---</b>)
                                    </small>
                                </td>
                                <td class="text-right">
                                    <small>
                                        <b>@lang('cmn.fuel') =</b> --- <br>
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            <b>@lang('cmn.expense') = </b> ---<br>
                                        </div>
                                        <b>@lang('cmn.total_expense') = ---</b>
                                    </small>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- entry box -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body p-0">
                        <div class="bs-stepper">
                            <div class="bs-stepper-header" role="tablist">
                                <div class="step {{ ($step=='trip')?'active':'' }}" data-target="#step_1">
                                    <a href="{{ url()->current().'?step=trip' }}" class="step-trigger" role="tab" aria-controls="logins-part" id="step_1_trigger" aria-selected="{{ ($step=='trip')?'true':'false' }}">
                                        <span class="bs-stepper-circle">@lang('cmn.1')</span>
                                        <span class="bs-stepper-label">@lang('cmn.challan_form')</span>
                                    </a>
                                </div>
                                <div class="line"></div>
                                <div class="step {{ ($step=='expense')?'active':'' }}" data-target="#step_2">
                                    <a href="{{ url()->current().'?step=expense' }}"  class="step-trigger" role="tab" aria-controls="information-part" id="step_2_trigger" aria-selected="{{ ($step=='expense')?'true':'false' }}">
                                        <span class="bs-stepper-circle">@lang('cmn.2')</span>
                                        <span class="bs-stepper-label">@lang('cmn.expenses')</span>
                                    </a>
                                </div>
                                <div class="line"></div>
                                <div class="step {{ ($step=='meter')?'active':'' }}" data-target="#step_3">
                                    <a href="{{ url()->current().'?step=meter' }}"  class="step-trigger" role="tab" aria-controls="information-part" id="step_3_trigger" aria-selected="{{ ($step=='meter')?'true':'false' }}">
                                        <span class="bs-stepper-circle">@lang('cmn.3')</span>
                                        <span class="bs-stepper-label">@lang('cmn.meter_info')</span>
                                    </a>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <div id="step_1" class="content {{ ($step=='trip')?'active dstepper-block':'' }}" role="tabpanel" aria-labelledby="step_1_trigger">
                                    <form action="{{ url('/new-trips') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card card-secondary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">গাড়ী প্রদানকারী</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>মালিকানা</label>
                                                                    <select  class="form-control" style="width: 100%;" name="ownership" required>
                                                                        <option value="out">বাহিরের</option>
                                                                        <option value="own">নিজস্ব</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>গাড়ীর নম্বর</label>
                                                                    <input type="text" value="" class="form-control" name="vehicle_number" placeholder="21-9098">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>ড্রাইভারের নাম</label>
                                                                    <input type="text" value="" class="form-control" name="driver_name" placeholder="এখানে নাম লিখুন">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>ফোন নম্বর</label>
                                                                    <input type="number" value="" class="form-control" name="driver_phone" placeholder="0171-xxxx-xxx">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>মালিকের নাম</label>
                                                                    <input type="text" value="" class="form-control" name="owner_name" placeholder="এখানে নাম লিখুন">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>ফোন নম্বর</label>
                                                                    <input type="number" value="" class="form-control" name="owner_phone" placeholder="0171-xxxx-xxx">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>রেফারেন্সের নাম</label>
                                                                    <input type="text" value="" class="form-control" name="reference_name" placeholder="এখানে নাম লিখুন">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>ফোন নম্বর</label>
                                                                    <input type="number" value="" class="form-control" name="reference_phone" placeholder="0171-xxxx-xxx">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.rent')</label>
                                                                    <input type="number" min="0" class="form-control" name="contract_fair" value="{{ old('contract_fair',0) }}" placeholder="@lang('cmn.amount_here')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>অগ্রিম প্রদান</label>
                                                                    <input type="number" min="0" class="form-control" name="advance_fair" value="{{ old('advance_fair',0) }}" placeholder="@lang('cmn.amount_here')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>ভাড়া প্রদানের একাউন্ট</label>
                                                                    <select id="end" class="form-control" style="width: 100%;" name="" required>
                                                                        <option value="">@lang('cmn.please_select')</option>
                                                                        @if(isset($accounts))
                                                                        @foreach($accounts as $account)
                                                                        <option value="{{ $account->id }}">{{ $account->account_number }} ({{ $account->user_name }})</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card card-secondary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">ট্রিপের তথ্য</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @if(!isset($trip))
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.posting_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                    <div class="input-group date" id="account_take_date" data-target-input="nearest">
                                                                        <input type="text" name="account_take_date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                                                        <div class="input-group-append" data-target="#account_take_date" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="number" value="{{ uniqid() }}">
                                                            @else
                                                            <input type="hidden" name="account_take_date" value="{{ date('d/m/Y', strtotime($trip->account_take_date)) }}">
                                                            <input type="hidden" name="number" value="{{ $trip->number}}">
                                                            @endif
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.trip_starting_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                    <div class="input-group date" id="trip_starting_date" data-target-input="nearest">
                                                                        <input type="text" name="date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                                                        <div class="input-group-append" data-target="#trip_starting_date" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.load_point')</label>
                                                                    <select id="start" class="form-control" style="width: 100%;" name="load_id" required>
                                                                        <option value="">@lang('cmn.please_select')</option>
                                                                        @if(isset($areas))
                                                                        @foreach($areas as $area)
                                                                        <option value="{{ $area->id }}" {{ old('trip_load')==$area->id ? 'selected':'' }}>{{ $area->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.unload_point')</label>
                                                                    <select id="end" class="form-control select2" multiple="multiple" style="width: 100%;" name="unload_id" required>
                                                                        <option value="">@lang('cmn.please_select')</option>
                                                                        @if(isset($areas))
                                                                        @foreach($areas as $area)
                                                                        <option value="{{ $area->id }}" {{ old('trip_unload')==$area->id ? 'selected':'' }}>{{ $area->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @if($setComp['trip_booking_time'] > 0)
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.distance')</label>
                                                                    <input type="number" id="distanceCal"  min="0" value="{{ old('distance',0) }}" class="form-control" name="distance" placeholder="distance" required readonly>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>বাক্স সংখ্যা</label>
                                                                    <input type="number" min="0" class="form-control" name="box" value="{{ old('advance_fair',0) }}" placeholder="@lang('cmn.amount_here')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>ওজন</label>
                                                                    <input type="number" min="0" class="form-control" name="weight" value="{{ old('advance_fair',0) }}" placeholder="" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>ইউনিট</label>
                                                                    <select id="end" class="form-control" style="width: 100%;" name="unit_id" required>
                                                                        <option value="1">টন</option>
                                                                        <option value="2">মন</option>
                                                                        <option value="3">কেজি</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>মালের সংক্ষিপ্ত বিবরণ</label>
                                                                    <textarea class="form-control" name="goods" rows="1" placeholder="মালের সংক্ষিপ্ত বিবরণ">{{ old('goods') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card card-secondary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">কোম্পানী</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.company')</label>
                                                                    <select  class="form-control" style="width: 100%;" name="company_id" required>
                                                                        <option value="">@lang('cmn.please_select')</option>
                                                                        @if(isset($companies))
                                                                        @foreach($companies as $company)
                                                                        <option value="{{ $company->id }}" {{ old('company_id')==$company->id ? 'selected':'' }}>{{ $company->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.rent')</label>
                                                                    <input type="number" min="0" class="form-control" name="com_contract_fair" value="{{ old('contract_fair',0) }}" placeholder="@lang('cmn.amount_here')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>অগ্রিম গ্রহণ</label>
                                                                    <input type="number" min="0" class="form-control" name="com_advance_fair" value="{{ old('advance_fair',0) }}" placeholder="@lang('cmn.amount_here')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.note')</label>
                                                                    <textarea class="form-control" name="note" rows="1" placeholder="@lang('cmn.you_can_write_any_note_here')">{{ old('note') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <input type="hidden" value="{{$group_id}}" name="group_id">
                                                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.challan_create')</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                                <div id="step_2" class="content {{ ($step=='expense')?'active dstepper-block':'' }}" role="tabpanel" aria-labelledby="step_2_trigger">
                                    @if($trip)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-default">
                                                <form action="{{ url('new-trip-expense-save') }}" method="POST">
                                                    @csrf
                                                    <div class="card-header">
                                                        <h3 class="card-title">@lang('cmn.expense')</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.expense_head')</label>
                                                                    <select name="expense_id[]" class="form-control select2" required>
                                                                        <option value="">@lang('cmn.please_select')</option>
                                                                        @foreach($expenses as $expense)
                                                                        <option value="{{$expense->id}}">{{$expense->head}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.amount')</label>
                                                                    <input type="number" class="form-control" name="amount[]" value="0" placeholder="@lang('cmn.amount')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.note')</label>
                                                                    <textarea class="form-control" name="note[]" rows="1" placeholder="@lang('cmn.note')"></textarea>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                                            <input type="hidden" name="vehicle_id" value="{{ $trip->vehicle_id }}">
                                                            <input type="hidden" name="trip_date" value="{{ $trip->date }}">
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-save"></i> @lang('cmn.save')</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-default">
                                                <form action="{{ url('/new-trip-oil-expense-save') }}" method="POST">
                                                    @csrf
                                                    <div class="card-header">
                                                        <h3 class="card-title">@lang('cmn.pump')</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.pump_name')</label>
                                                                    <select name="pump_id" class="form-control" required>
                                                                        @foreach($pumps as $pump)
                                                                        <option value="{{ $pump->id }}">{{ $pump->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.liter')</label>
                                                                    <input type="number" class="form-control" name="liter" min="0" value="0" placeholder="@lang('cmn.liter')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.rate')</label>
                                                                    <input type="number" class="form-control" name="rate" min="0" value="{{ ($setComp['oil_rate'])?$setComp['oil_rate']:0 }}" step="any" class="form-control" placeholder="@lang('cmn.rate')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.note')</label>
                                                                    <textarea class="form-control" name="note" rows="1" placeholder="@lang('cmn.note')"></textarea>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                                            <input type="hidden" name="vehicle_id" value="{{ $trip->vehicle_id }}">
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-save"></i> @lang('cmn.save')</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-warning">
                                        <h5>@lang('cmn.at_first_create_chalan')!</h5>
                                    </div>
                                    @endif
                                </div>
                                <div id="step_3" class="content {{ ($step=='meter')?'active dstepper-block':'' }}" role="tabpanel" aria-labelledby="step_3_trigger">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-default">
                                                @if($trip && $trip->meter && $trip->meter->id)
                                                <div class="card-body">
                                                    <table class="table table-striped text-center table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('cmn.start_meter_reading_of_trip')</th>
                                                                <th>@lang('cmn.last_meter_reading_of_trip')</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ number_format($trip->meter->previous_reading) }}</td>
                                                                <td>{{ number_format($trip->meter->current_reading) }}</td>
                                                                <td><a class="btn btn-xs btn-danger" href="{{ url('new-trip-meter-delete', $trip->meter->id) }}" onclick="return confirm(`@lang('cmn.are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                    @if($trip)
                                                    <form  action="{{ url('/new-trip-meter-save') }}" method="POST">
                                                        @csrf
                                                        <div class="card-header">
                                                            <h3 class="card-title">@lang('cmn.meter_info')</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>@lang('cmn.start_meter_reading_of_trip')</label>
                                                                        <input type="number" min="0" class="form-control" name="previous_reading" value="0" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>@lang('cmn.last_meter_reading_of_trip')</label>
                                                                        <input type="number" min="0" class="form-control" name="current_reading" value="0" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                                            <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-save"></i> @lang('cmn.save')</button>
                                                        </div>
                                                    </form>
                                                    @else
                                                        <div class="alert alert-warning">
                                                            <h5>@lang('cmn.at_first_create_chalan')!</h5>
                                                        </div>
                                                    @endif
                                                @endif 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div id="accordion">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                Collapsible Group Item #1
                                </a>
                            </h4> 
                        </div>
                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                            <div class="card-body"> </div>
                        </div>
                    </div>
                    <div class="card card-danger">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                Collapsible Group Danger
                                </a>
                            </h4> 
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                            <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                        </div>
                    </div>
                    <div class="card card-success">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                Collapsible Group Success
                                </a>
                            </h4> 
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                            <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script type="text/javascript">
    $('#account_take_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    $('#trip_starting_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })
    });
</script>
@endpush