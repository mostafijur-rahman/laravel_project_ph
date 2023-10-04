@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('trip.step')
        </div>
        <!-- /.container-fluid -->
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
        <!-- Default box -->
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered text-center text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th width="30%">@lang('cmn.primary_info')</th>
                            <th width="25%">@lang('cmn.trip_details')</th>
                            <th width="20%">@lang('cmn.income')</th>
                            <th width="20%">@lang('cmn.expense')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($trip)
                        @php $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id) @endphp
                            <tr class="text-center">
                                <td class="text-left">
                                    @if($trip->account_take_date)
                                        @lang('cmn.account_receiving'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                    @endif
                                    @lang('cmn.vehicle'): <b>{{ $trip->vehicle->vehicle_number }}</b><br>
                                    @if($trip->number)
                                        @lang('cmn.trip_number'): <b>{{ $trip->number }}</b><br>
                                    @endif
                                    <small>
                                        @lang('cmn.driver'): {{ $trip->vehicle->driver->name }}<br>
                                    </small>
                                    @if($trip->meter->previous_reading)
                                    <small>
                                        @lang('cmn.start_reading'): {{  number_format($trip->meter->previous_reading) }}<br>
                                        @lang('cmn.last_reading'): {{ number_format($trip->meter->current_reading) }}<br>
                                        @lang('cmn.total') @lang('cmn.km'): {{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}<br>
                                        @lang('cmn.total') @lang('cmn.fuel'): {{ number_format($tripOilLiterSumByGroupId) }}<br>
                                        @if($tripOilLiterSumByGroupId > 0)
                                        @lang('cmn.liter_per_km'): {{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}<br>
                                        @endif
                                    </small>
                                    @endif
                                    <small>
                                        @lang('cmn.created'): <b>{{ $trip->user->first_name .' '.$trip->user->last_name}}</b><br>
                                    </small>
                                    <br>
                                    <div class="row">
                                        <div class="btn-group">
                                            <a href="{{ url('trip-report?type=chalan&group_id='. $trip->group_id) }}" class="btn btn-warning btn-xs" target="_blank" aria-label="Trip Chalan"><i class="fa fa-fw fa-print"></i> @lang('cmn.chalan')</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-left">
                                    @if($trip->getTripsByGroupId)
                                        @php $tripLastKey = count($trip->getTripsByGroupId); @endphp
                                        @foreach($trip->getTripsByGroupId as $tripKey => $trip_info)
                                            @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip_info->date)) }}</b><br>
                                            @lang('cmn.route'): <b>{{ $trip_info->load_data->name }}</b> @lang('cmn.from') <b>{{ $trip_info->unload->name }} 
                                                @if($trip_info->trip_distance>0)
                                                ({{ $trip_info->trip_distance + $trip_info->empty_distance }} @lang('cmn.km')))
                                                @endif
                                            </b><br>
                                            @lang('cmn.company'): <b>{{ $trip_info->company->name }}</b><br>
                                            @if($trip_info->goods)
                                                @lang('cmn.goods'): <b>{{ $trip_info->goods }}</b><br>
                                            @endif
                                            @lang('cmn.rent'): <b>{{ number_format($trip_info->contract_fair) }}</b><br>
                                            @lang('cmn.addv_rent'): <b>{{ number_format($trip_info->advance_fair) }}</b><br>
                                            @lang('cmn.challan_due'): <b>{{ number_format($trip_info->due_fair) }}</b><br>
                                            @lang('cmn.discount'): <b>{{ number_format($trip_info->deduction_fair) }}</b><br>
                                            @if(($tripKey+1) != $tripLastKey)
                                                <a class="btn btn-xs btn-danger" href="{{ url('new-trip-delete', $trip_info->id) }}" onclick="return confirm(`@lang('cmn.are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a>
                                                <br><br>
                                            @endif
                                            @if($tripKey == 0 && $tripKey+1 == $tripLastKey)
                                                <a class="btn btn-xs btn-danger" href="{{ url('new-trip-delete-all', $trip_info->id) }}" onclick="return confirm(`@lang('cmn.all_information_will_delete_are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                @php
                                    $total_general_expense_sum =  tripExpenseSumByGroupId($trip->group_id);
                                    $total_oil_bill_sum =  tripOilBillSumByGroupId($trip->group_id);
                                    $total_received_rent =  $trip->getTripsByGroupId->sum('advance_fair') + $trip->getTripsByGroupId->sum('received_fair');
                                    $trip_general_exp_lists = tripExpenseListSumByGroupId($trip->group_id);
                                @endphp
                                <td class="text-right">
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @lang('cmn.rent') = <strong>{{ number_format($total_received_rent) }}</strong><br>
                                        @lang('cmn.total_expense') = <strong>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</strong><br>
                                    </div>
                                    @lang('cmn.net_income') = <strong>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</strong><br>
                                    <small>
                                        (@lang('cmn.challan_due') = <strong>{{ number_format($trip->getTripsByGroupId->sum('due_fair')) }}</strong>,
                                        @lang('cmn.discount') = <strong>{{ number_format($trip->getTripsByGroupId->sum('deduction_fair')) }}</strong>)
                                    </small>
                                </td>
                                <td class="text-right">
                                    <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @if($trip_general_exp_lists)
                                            @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                                            <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}<br>
                                            @endforeach
                                    </div>
                                    <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                                        @endif
                                </td>
                            </tr>
                        @else
                        <tr class="text-center">
                            <td class="text-left">
                                <small>
                                    @lang('cmn.account_receiving'): <b>---</b><br>
                                    @lang('cmn.vehicle'): <b>---</b><br>
                                    @lang('cmn.trip_number'): <b>---</b><br>
                                    @lang('cmn.driver'): ---<br>
                                    @lang('cmn.start_reading'): ---<br>
                                    @lang('cmn.last_reading'): ---<br>
                                    @lang('cmn.total') @lang('cmn.km'): ---<br>
                                    @lang('cmn.total') @lang('cmn.fuel'): ---<br>
                                    @lang('cmn.liter_per_km'): ---<br>
                                    @lang('cmn.created'): <b>---</b><br>
                                </small>
                            </td>
                            <td class="text-left">
                                <small>
                                    @lang('cmn.start_date'): <b> ---</b><br>
                                    @lang('cmn.route'): <b>---</b><br>
                                    @lang('cmn.company'): <b>---</b><br>
                                    @lang('cmn.goods'): <b>---</b><br>
                                    @lang('cmn.rent'): <b>---</b><br>
                                    @lang('cmn.addv_rent'): <b>---</b><br>
                                    @lang('cmn.challan_due'): <b>---</b><br>
                                    @lang('cmn.discount'): <b>---</b><br>
                                </small>
                            </td>
                            <td class="text-right">
                                <small>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @lang('cmn.rent') = ---</strong><br>
                                        @lang('cmn.total_expense') = <strong>---</strong><br>
                                    </div>
                                    @lang('cmn.net_income') = <strong>---</strong><br>
                                    (@lang('cmn.challan_due') = <strong>---</strong>,
                                    @lang('cmn.discount') = <strong>---</strong>)
                                </small>
                            </td>
                            <td class="text-right">
                                <small>
                                    <b>@lang('cmn.fuel') =</b> --- <br>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        <b>@lang('cmn.expense') =</b> ---<br>
                                    </div>
                                    <b>@lang('cmn.total_expense') = ---</b>
                                </small>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
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
                                        <div class="card card-default">
                                            <div class="card-header">
                                                <h3 class="card-title">@lang('cmn.challan_form')</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if(!isset($trip))
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.account_receiving') <small class="text-danger">(@lang('cmn.required'))</small></label>
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
                                                    <div class="col-md-6">
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
                                                    @if($setComp['trip_booking_time'] > 0)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.time')</label>
                                                            <select  class="form-control select2" style="width: 100%;" name="time_id">
                                                                @if(isset($time_sheets))
                                                                @foreach($time_sheets as $time_sheet)
                                                                <option value="{{ $time_sheet->id }}" {{ ($time_sheet->id == 5) ? 'selected':'' }}>{{ $time_sheet->time }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.vehicle_select') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            @if($trip && $trip->vehicle_id)
                                                            <input class="form-control" type="text" value="{{ $trip->vehicle->vehicle_number }}" readonly>
                                                            <input class="form-control" type="hidden" value="{{ $trip->vehicle_id }}" name="vehicle_id">
                                                            @else
                                                            <select  class="form-control select2" style="width: 100%;" name="vehicle_id" id="car_id" required>
                                                                <option value="">@lang('cmn.please_select')</option>
                                                                @if(isset($vehicles))
                                                                @foreach($vehicles as $vehicle)
                                                                <option value="{{ $vehicle->id }}" {{ ($trip && $trip->vehicle_id)==$vehicle->id ? 'selected':'' }}>{{ $vehicle->number_plate }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                            <span id="tripValidationMsg" class="form-text text-danger"></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.company') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            <select  class="form-control select2" style="width: 100%;" name="company_id" required>
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
                                                            <label>@lang('cmn.load_point') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            {{-- onchange="calculateDistance()" --}}
                                                            <select id="start" class="form-control select2" style="width: 100%;" name="load_id" required>
                                                                <option value="">@lang('cmn.please_select')</option>
                                                                @if(isset($areas))
                                                                @foreach($areas as $area)
                                                                <option value="{{ $area->id }}" {{ old('trip_load')==$area->id ? 'selected':'' }}>{{ $area->name }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.unload_point') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            {{-- onchange="calculateDistance()" --}}
                                                            <select id="end" class="form-control select2" style="width: 100%;" name="unload_id" required>
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
                                                            <label>@lang('cmn.distance') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            <input type="number" id="distanceCal"  min="0" value="{{ old('distance',0) }}" class="form-control" name="distance" placeholder="distance" required readonly>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.goods')</label>
                                                            <input type="string" class="form-control" name="goods" value="{{ old('goods') }}" placeholder="@lang('cmn.about_goods')">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.rent') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            <input type="number" min="0" class="form-control" name="contract_fair" value="{{ old('contract_fair',0) }}" placeholder="@lang('cmn.amount_here')" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.addv_rent') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                            <input type="number" min="0" class="form-control" name="advance_fair" value="{{ old('advance_fair',0) }}" placeholder="@lang('cmn.amount_here')" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('cmn.note')</label>
                                                    <textarea class="form-control" name="note" rows="2" placeholder="@lang('cmn.you_can_write_any_note_here')">{{ old('note') }}</textarea>
                                                </div>
                                                @if($setComp['trip_booking_distance_calculation'] > 0)
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.to_load_point_distance')</label>
                                                            <input type="number"  min="0" value="{{ old('empty_distance',0) }}" class="form-control" name="empty_distance" placeholder="@lang('cmn.distance')">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.start_point')</label>
                                                            <select class="form-control select2" style="width: 100%;" name="empty_load_id">
                                                                <option value="">@lang('cmn.please_select')</option>
                                                                @if(isset($areas))
                                                                @foreach($areas as $area)
                                                                <option value="{{ $area->id }}" {{ old('empty_start')==$area->id ? 'selected':'' }}>{{ $area->name }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>@lang('cmn.end_point')</label>
                                                            <select class="form-control select2" style="width: 100%;" name="empty_unload_id">
                                                                <option value="">@lang('cmn.please_select')</option>
                                                                @if(isset($areas))
                                                                @foreach($areas as $area)
                                                                <option value="{{ $area->id }}" {{ old('empty_end')==$area->id ? 'selected':'' }}>{{ $area->name }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="card-footer">
                                                <input type="hidden" value="{{$group_id}}" name="group_id">
                                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.challan_create')</button>
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
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    $('#account_take_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    $('#trip_starting_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
</script>
@endpush