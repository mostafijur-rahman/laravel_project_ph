@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">


        <!-- need to show validation  -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <div class="row">


            @if($request->page== 'edit' || $request->page== 'details' || $request->page== 'transection')
            <!-- trip info box  (thinking for include) -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-center text-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th width="30%">@lang('cmn.primary_info')</th>
                                    <th width="30%">গাড়ীর লেনদেন</th>
                                    <th width="20%">কোম্পানীর লেনদেন</th>
                                    <th width="20%">কমিশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-left">
                                        <small>
                                            @if($trip->account_take_date)
                                                @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                            @endif
                                            @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
                                            @if ($trip->provider->vehicle_id)
                                                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->vehicle_number }}</b> <span class="badge badge-success">@lang('cmn.own')</span><br>
                                                @lang('cmn.driver'): <b>{{ $trip->provider->vehicle->driver->name }} ({{ $trip->provider->vehicle->driver->phone }})</b><br>
                                            @else
                                                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> <span class="badge badge-warning">@lang('cmn.from_market')</span><br>
                                                @lang('cmn.driver'): <b>{{ $trip->provider->driver_name??'---' }} {{ $trip->provider->driver_phone?'('.$trip->provider->driver_phone.')':'' }}</b><br>
                                                @lang('cmn.owner'): <b>{{ $trip->provider->owner_name??'---' }} {{ $trip->provider->owner_phone?'('.$trip->provider->owner_phone.')':'' }}</b><br>
                                                @lang('cmn.reference'): <b>{{ $trip->provider->reference_name??'---' }} {{ $trip->provider->reference_phone?'('.$trip->provider->reference_phone.')':'' }}</b><br>
                                            @endif
                                            @if($trip->meter->previous_reading)
                                                @lang('cmn.start_reading'): <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
                                                @lang('cmn.last_reading'): <b>{{ number_format($trip->meter->current_reading) }}</b><br>
                                                @lang('cmn.total') @lang('cmn.km'): <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
                                                @php $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id); @endphp 
                                                @lang('cmn.total') @lang('cmn.fuel'): <b>{{ number_format($tripOilLiterSumByGroupId) }}</b><br>
                                                @if($tripOilLiterSumByGroupId > 0)
                                                    @lang('cmn.liter_per_km'): <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}</b><br>
                                                @endif
                                            @endif
                                            @lang('cmn.posted_by'): <b>{{ $trip->user->first_name}}</b><br>
                                            @if($trip->updated_at > $trip->created_at)
                                                @if ($trip->updated_by)
                                                    @lang('cmn.post_updated_by'): <b>{{ $trip->user_update->first_name}}</b><br>
                                                @endif
                                                @lang('cmn.posting_update_date'): <b>{{ date('d M, Y - h:m a', strtotime($trip->updated_at)) }}</b><br>
                                            @endif
                                            <div class="row">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-warning btn-xs mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                                                    <a href="{{ url('trips?page=edit&group_id='. $trip->group_id) }}" class="btn btn-info btn-xs mr-1" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>
                                                    <a href="{{ url('trips?page=details&group_id='. $trip->group_id) }}" class="btn btn-secondary btn-xs mr-1" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                                                    <a href="{{ url('trips?page=transection&group_id='. $trip->group_id) }}" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                                                    <a href="{{ url('trips?page=copy&group_id='. $trip->group_id) }}" class="btn btn-success btn-xs" aria-label="@lang('cmn.copy')">@lang('cmn.copy')</a>
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
                                                @lang('cmn.load_point'):<br>
                                                @if($trip_info->points)
                                                @php $lastKey = count($trip_info->points); @endphp
                                                @foreach($trip_info->points as $key => $point)
                                                    @if($point->pivot->point == 'load')
                                                    <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                                    @endif
                                                @endforeach
                                                @endif
                                                <br>
                                                @lang('cmn.unload_point'):<br>
                                                @if($trip_info->points)
                                                @php $lastKey = count($trip_info->points); @endphp
                                                @foreach($trip_info->points as $key => $point)
                                                    @if($point->pivot->point == 'unload')
                                                    <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                                    @endif
                                                @endforeach
                                                @endif
                                                <br>
                                                @lang('cmn.contract_rent'): <b>{{ number_format($trip_info->provider->contract_fair) }}</b><br>
                                                @lang('cmn.addv_pay'): <b>{{ number_format($trip_info->provider->advance_fair) }}</b><br>
                                                
                                                @if($trip_info->provider->due_fair>0)
                                                </small>
                                                <span class="text-danger"> 
                                                    @lang('cmn.challan_due'): <b>{{ number_format($trip_info->provider->due_fair) }}</b><br>
                                                </span>
                                                <small>
                                                @else
                                                @lang('cmn.challan_due'): <b>{{ number_format($trip_info->provider->due_fair) }}</b><br>
                                                @endif

                                                @lang('cmn.demarage_fixed'): <b>{{ number_format($trip_info->provider->demarage) }}</b><br>
                                                @lang('cmn.demarage_paid'): <b>{{ number_format($trip_info->provider->demarage_received) }}</b><br>
                                                @if($trip_info->provider->demarage_due>0)
                                                </small>
                                                <span class="text-danger"> 
                                                    @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->provider->demarage_due) }}</b><br>
                                                </span>
                                                <small>
                                                @else
                                                @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->provider->demarage_due) }}</b><br>
                                                @endif
                                                @lang('cmn.discount'): <b>{{ number_format($trip_info->provider->deduction_fair) }}</b><br>
                                                @lang('cmn.goods'): <b>{{ $trip_info->goods??'---' }}</b><br>
                                                {{-- @if(($tripKey+1) != $tripLastKey)
                                                    <a class="btn btn-xs btn-danger" href="{{ url('trip-delete', $trip_info->id) }}" onclick="return confirm(`@lang('cmn.are_you_sure')`);" title="@lang('cmn.delete')">@lang('cmn.delete')</a>
                                                    <br><br>
                                                @endif --}}
                                                {{-- @if($tripKey == 0 && $tripKey+1 == $tripLastKey)
                                                @endif --}}
                                                <button type="button" class="btn btn-xs btn-danger"  onclick="return deleteCertification({{ $trip_info->id  }})" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                                                <form id="delete-form-{{$trip_info->id }}" method="POST" action="{{ url('trip-delete-all', $trip_info->id ) }}" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endforeach
                                        @endif
                                        </small>
                                    </td>
                                    <td class="text-left">
                                        <small>
                                            @lang('cmn.company'): <b>{{ $trip_info->company->company->name }}</b><br>
                                            @lang('cmn.contract_rent'): <b>{{ number_format($trip_info->company->contract_fair) }}</b><br>
                                            @lang('cmn.addv_recev'): <b>{{ number_format($trip_info->company->advance_fair) }}</b><br>
                                            
                                            @if($trip_info->company->due_fair>0)
                                            </small>
                                            <span class="text-danger"> 
                                                @lang('cmn.challan_due'): <b>{{ number_format($trip_info->company->due_fair) }}</b><br>
                                            </span>
                                            <small>
                                            @else
                                            @lang('cmn.challan_due'): <b>{{ number_format($trip_info->company->due_fair) }}</b><br>
                                            @endif
                                            @if($trip_info->company->demarage > $trip_info->company->demarage_received)
                                            </small>
                                            <span class="text-danger"> 
                                                @lang('cmn.demarage_charge'): <b>{{ number_format($trip_info->company->demarage) }}</b><br>
                                            </span>
                                            <small>
                                            @else
                                            @lang('cmn.demarage_charge'): <b>{{ number_format($trip_info->company->demarage) }}</b><br>
                                            @endif
                                            @lang('cmn.demarage_received'): <b>{{ number_format($trip_info->company->demarage_received) }}</b><br>
                                            @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->company->demarage_due) }}</b><br>
                                            @lang('cmn.discount'): <b>{{ number_format($trip_info->company->deduction_fair) }}</b><br>
                                            কার্টুন সংখ্যা: <b>{{ number_format($trip_info->box) }}</b> টি<br>
                                            ওজন: <b>{{ number_format($trip_info->weight) }}</b> {{ $trip_info->unit->name }}<br>
                                        </small>
                                    </td>
                                    <td class="text-right">
                                        <small>
                                            @lang('cmn.contract_commission') = <b>{{ number_format($trip_info->company->contract_fair - $trip_info->provider->contract_fair) }}</b><br>
                                            <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                                কোম্পানী থেকে গ্রহণ = <b>{{ number_format($trip_info->company->advance_fair+$trip_info->company->received_fair) }}</b><br>
                                                ভাড়া বাবদ প্রদান = <b>{{ number_format($trip_info->provider->advance_fair+$trip_info->provider->received_fair) }}</b><br>
                                            </div>
                                            <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                                @lang('cmn.commission_received') = <b>{{ number_format(($trip_info->company->advance_fair+$trip_info->company->received_fair) - ($trip_info->provider->advance_fair+$trip_info->provider->received_fair)) }}</b><br>
                                                @lang('cmn.demarage_commission') = <b>{{ number_format($trip_info->company->demarage_received - $trip_info->provider->demarage_received) }}</b><br>
                                            </div>
                                            @lang('cmn.total_commission') = <b>{{ number_format(($trip_info->company->advance_fair+$trip_info->company->received_fair+$trip_info->company->demarage_received) - ($trip_info->provider->advance_fair+$trip_info->provider->received_fair+$trip_info->provider->demarage_received)) }}</b><br>
                                            {{-- (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>) --}}
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- transection info box  (thinking for include) -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-center text-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th width="25%">@lang('cmn.account_info')</th>
                                    <th width="35%">@lang('cmn.reason')</th>
                                    <th width="20%">@lang('cmn.in')</th>
                                    <th width="20%">@lang('cmn.out')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $in_sum = 0; $out_sum = 0; @endphp
                            @if($trip->expenses)
                            @foreach($trip->expenses as $expense)
                                @php 
                                    $in_sum += ($expense->transaction->type=='in')?$expense->transaction->amount:0; 
                                    $out_sum += ($expense->transaction->type=='out')?$expense->transaction->amount:0;
                                @endphp
                                <tr>
                                    <td><small>{{ $expense->transaction->account->user_name }} ({{ $expense->transaction->account->account_number??__('cmn.cash') }}) ({{ $expense->transaction->date }})</small></td>
                                    <td><small>{{ $expense->expense->head }}</small></td>
                                    <td><small><b class='text-green'>{{ ($expense->transaction->type=='in')?number_format($expense->transaction->amount):'---' }}</b></small></td>
                                    <td><small><b class='text-danger'>{{ ($expense->transaction->type=='out')?number_format($expense->transaction->amount):'---' }}</b></small></td>
                                </tr>
                            @endforeach
                            @endif
                            @if($trip->oilExpenses)
                            @foreach($trip->oilExpenses as $oilExpense)
                                @php 
                                    $in_sum += ($oilExpense->transaction->type=='in')?$oilExpense->transaction->amount:0; 
                                    $out_sum += ($oilExpense->transaction->type=='out')?$oilExpense->transaction->amount:0;
                                @endphp
                                <tr>
                                    <td><small>{{ $oilExpense->transaction->account->user_name}} ({{ $oilExpense->transaction->account->account_number??__('cmn.cash') }}) ({{ $oilExpense->transaction->date }})</small></td>
                                    <td><small>{{ __('cmn.'.$oilExpense->transaction->for) }}</small></td>
                                    <td><small><b class='text-green'>{{ ($oilExpense->transaction->type=='in')?number_format($oilExpense->transaction->amount):'---' }}</b></small></td>
                                    <td><small><b class='text-danger'>{{ ($oilExpense->transaction->type=='out')?number_format($oilExpense->transaction->amount):'---' }}</b></small></td>
                                </tr>
                            @endforeach
                            @endif
                            @if($trip->transactions)
                            @foreach($trip->transactions as $trans)
                                @php 
                                    $in_sum += ($trans->type=='in')?$trans->amount:0; 
                                    $out_sum += ($trans->type=='out')?$trans->amount:0;
                                @endphp
                                <tr>
                                    <td><small>{{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})</small></td>
                                    <td><small>{{ __('cmn.'.$trans->for) }}</small></td>
                                    <td><small><b class='text-green'>{{ ($trans->type=='in')?number_format($trans->amount):'---' }}</b></small></td>
                                    <td><small><b class='text-danger'>{{ ($trans->type=='out')?number_format($trans->amount):'---' }}</b></small></td>
                                </tr>
                            @endforeach
                            @endif
                            <tr>
                                <td class="text-right" colspan="2"><small><b>@lang('cmn.total') = </b></small></td>
                                <td><small><b class='text-green'>{{ number_format($in_sum) }}</b></small></td>
                                <td><small><b class='text-danger'>{{ number_format($out_sum) }}</b></small></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- own trip deposit expense (thinking for include) -->
            @if($trip && $trip->provider->ownership == 'own')
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered text-center text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th width="30%">ট্রিপের জমা</th>
                                        <th width="30%">ট্রিপের খরচ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($trip)
                                        @php
                                            $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id);
                                            $total_general_expense_sum = tripExpenseSumByGroupId($trip->group_id);
                                            $total_oil_bill_sum =  tripOilBillSumByGroupId($trip->group_id);
                                            $total_received_rent =  $trip->provider->advance_fair + $trip->provider->received_fair;
                                            $trip_general_exp_lists = tripExpenseListSumByGroupId($trip->group_id);
                                        @endphp
                                        <tr class="text-center">
                                            <td class="text-right">
                                                <small>
                                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                                        @lang('cmn.contract_rent') = <b>{{ number_format($trip->provider->contract_fair) }}</b><br>
                                                        @lang('cmn.rent_received') = <b>{{ number_format($total_received_rent) }}</b><br>
                                                        @lang('cmn.total_expense') = <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
                                                    </div>
                                                    @lang('cmn.net_income') = <b>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</b><br>
                                                    (@lang('cmn.challan_due') = <b>{{ number_format($trip->provider->due_fair) }}</b>, @lang('cmn.discount') = <b>{{ number_format($trip->provider->deduction_fair) }}</b>)
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
                                                        @lang('cmn.contract_rent') = <b>---</b><br>
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
                </div>
            @endif
            @endif






            <div class="col-md-12">
                <div id="accordion">

                    <!-- trip form -->
                    @if($request->page== 'create' || (($request->page== 'edit' || $request->page== 'copy') && $request->group_id))
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne"><b>@lang('cmn.challan_form')</b></a>
                            </h4> 
                        </div>
                        <div id="collapseOne" class="collapse {{ ($step=='trip')?'show':'' }}" data-parent="#accordion">
                            <div class="card-body">
                                <form action="{{ url($action_url) }}" method="post" id="trip_form">
                                    @csrf
                                    <input type="hidden" name="main_trip_id" value="{{ isset($trip)?$trip->id:'' }}">
                                    <input type="hidden" value="{{$group_id}}" name="group_id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                    <h3 class="card-title">@lang('cmn.trip_info')</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.challan_no') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <input type="text" class="form-control" name="number" value="{{ old('number', $trip->number??'') }}" placeholder="@lang('cmn.write_challan_no_here')" required>
                                                            </div>
                                                        </div>
                                                        @if($request->page == 'create' || $request->page == 'copy')
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.posting_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <div class="input-group date" id="account_take_date" data-target-input="nearest">
                                                                    <input type="text" name="account_take_date" value="{{ (isset($trip->account_take_date))?date('d/m/Y', strtotime($trip->account_take_date)):date('d/m/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                                                    <div class="input-group-append" data-target="#account_take_date" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <input type="hidden" name="account_take_date" value="{{ date('d/m/Y', strtotime($trip->account_take_date)) }}">
                                                        @endif
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.trip_starting_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <div class="input-group date" id="trip_starting_date" data-target-input="nearest">
                                                                    <input type="text" name="date" value="{{ (isset($trip->date))?date('d/m/Y', strtotime($trip->date)):date('d/m/Y') }}" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                                                    <div class="input-group-append" data-target="#trip_starting_date" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.load_point') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <select id="start" class="form-control select2" multiple="multiple" data-placeholder="@lang('cmn.please_select')" style="width: 100%;" name="load_id[]" required>
                                                                    @if(isset($areas))
                                                                    @foreach($areas as $area)
                                                                    <option value="{{ $area->id }}" {{ (isset($load))?in_array($area->id, $load)?'selected':'':'' }}>{{ $area->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.unload_point') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <select id="end" class="form-control select2" multiple="multiple" data-placeholder="@lang('cmn.please_select')" style="width: 100%;" name="unload_id[]" required>
                                                                    @if(isset($areas))
                                                                    @foreach($areas as $area)
                                                                    <option value="{{ $area->id }}" {{ (isset($unload))?in_array($area->id, $unload)?'selected':'':'' }}>{{ $area->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @if($setComp['trip_booking_time'] > 0)
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.distance')</label>
                                                                <input type="number" id="distanceCal"  min="0" value="{{ old('distance',$trip->distance??'') }}" class="form-control" name="distance" placeholder="distance" required readonly>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.box_qty')</label>
                                                                <input type="number" min="0" step="1" class="form-control" name="box" value="{{ old('box',$trip->box??'') }}" placeholder="@lang('cmn.amount_here')">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.weight')</label>
                                                                <input type="number" min="0" step="1" class="form-control" name="weight" value="{{ old('weight',$trip->weight??'') }}" placeholder="@lang('cmn.qty')">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.unit')</label>
                                                                <select id="end" class="form-control" style="width: 100%;" name="unit_id">
                                                                    @if(isset($units))
                                                                    @foreach($units as $unit)
                                                                    <option value="{{ $unit->id }}" {{ old('unit_id',$trip->unit_id??'')==$unit->id ? 'selected':'' }}>{{ $unit->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>মালের সংক্ষিপ্ত বিবরণ</label>
                                                                <textarea class="form-control" name="goods" rows="1" placeholder="মালের সংক্ষিপ্ত বিবরণ">{{ old('goods',$trip->goods??'') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.note')</label>
                                                                <textarea class="form-control" name="note" rows="1" placeholder="@lang('cmn.you_can_write_any_note_here')">{{ old('note',$trip->note??'') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                    <h3 class="card-title">@lang('cmn.vehicle_provider')</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.ownership')</label>
                                                                <select  class="form-control" id="ownership" onchange="supplierHideShow()"  name="ownership" required>
                                                                    <option value="out" {{ (isset($trip)&&$trip->provider->ownership == 'out')?'selected':'' }}>@lang('cmn.from_market')</option>
                                                                    <option value="own" {{ (isset($trip)&&$trip->provider->ownership == 'own')?'selected':'' }}>@lang('cmn.own')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="vehicle_id" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: block':'display: none' }}">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.vehicle_select') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <select  class="form-control select2" style="width: 100%;" name="vehicle_id" id="vehicle_id">
                                                                    <option value="">@lang('cmn.please_select')</option>
                                                                    @if(isset($vehicles))
                                                                    @foreach($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id',isset($trip->provider->vehicle_id)?$trip->provider->vehicle_id:'')==$vehicle->id ? 'selected':'' }}>{{ $vehicle->number_plate }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="vehilce_number" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}">
                                                            <div class="form-group">
                                                                <label>গাড়ীর নম্বর <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <input type="text" class="form-control" name="vehicle_number" value="{{ old('vehicle_number',$trip->provider->vehicle_number??'') }}" placeholder="21-9098">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="driver_name" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}">
                                                            <div class="form-group">
                                                                <label>ড্রাইভারের নাম</label>
                                                                <input type="text" class="form-control" name="driver_name" value="{{ old('driver_name', $trip->provider->driver_name??'') }}" placeholder="এখানে নাম লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="driver_phone" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}">
                                                            <div class="form-group">
                                                                <label>ফোন নম্বর</label>
                                                                <input type="number" class="form-control" name="driver_phone" value="{{ old('driver_phone',$trip->provider->driver_phone??'') }}" placeholder="0171-xxxx-xxx">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="owner_name" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}">
                                                            <div class="form-group">
                                                                <label>মালিকের নাম</label>
                                                                <input type="text" class="form-control" name="owner_name" value="{{ old('owner_name',$trip->provider->owner_name??'') }}" placeholder="এখানে নাম লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="owner_phone" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}">
                                                            <div class="form-group">
                                                                <label>ফোন নম্বর</label>
                                                                <input type="number" class="form-control" name="owner_phone" value="{{ old('owner_phone',$trip->provider->owner_phone??'') }}" placeholder="0171-xxxx-xxx">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="reference_name" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}">
                                                            <div class="form-group">
                                                                <label>রেফারেন্সের নাম</label>
                                                                <input type="text" class="form-control" name="reference_name" value="{{ old('reference_name',$trip->provider->reference_name??'') }}" placeholder="এখানে নাম লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="reference_phone" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}">
                                                            <div class="form-group">
                                                                <label>ফোন নম্বর</label>
                                                                <input type="number" class="form-control" name="reference_phone" value="{{ old('reference_phone',$trip->provider->reference_phone??'') }}" placeholder="0171-xxxx-xxx">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.contract_rent') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <input type="number" min="0" class="form-control" name="contract_fair" value="{{ old('contract_fair',$trip->provider->contract_fair??'') }}" placeholder="@lang('cmn.amount_here')" required {{ ($request->page =='edit')?'readonly':''}}>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>অগ্রিম প্রদান <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <input type="number" min="0" class="form-control" name="advance_fair" value="{{ old('advance_fair',$trip->provider->advance_fair??'') }}" placeholder="@lang('cmn.amount_here')" required {{ ($request->page =='edit')?'readonly':''}}>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.payment_method') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <select class="form-control select2" style="width: 100%;" name="account_id" required {{ ($request->page =='edit')?'disabled':''}}>
                                                                    @if(isset($accounts))
                                                                    @foreach($accounts as $account)
                                                                    <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                                </div>
                                            </div>
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                    <h3 class="card-title">@lang('cmn.company')</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.company') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                                <select  class="form-control select2" style="width: 100%;" name="company_id" required>
                                                                    @if(isset($companies))
                                                                    @foreach($companies as $company)
                                                                    <option value="{{ $company->id }}" {{ old('company_id',($trip->company->company_id)??'')==$company->id ? 'selected':'' }}>{{ $company->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.contract_rent')</label>
                                                                <input type="number" min="0" class="form-control" name="com_contract_fair" value="{{ old('com_contract_fair', $trip->company->contract_fair??'') }}" placeholder="@lang('cmn.amount_here')" {{ ($request->page =='edit')?'readonly':''}}>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>অগ্রিম গ্রহণ</label>
                                                                <input type="number" min="0" class="form-control" name="com_advance_fair" value="{{ old('com_advance_fair', $trip->company->advance_fair??'') }}" placeholder="@lang('cmn.amount_here')" {{ ($request->page =='edit')?'readonly':''}}>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('cmn.payment_method')</label>
                                                                <select class="form-control select2" style="width: 100%;" name="com_account_id" {{ ($request->page =='edit')?'disabled':''}}>
                                                                    @if(isset($accounts))
                                                                    @foreach($accounts as $account)
                                                                    <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="button" id="show_btn1" class="btn btn-success" onclick="submitTrip()">
                                                        <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                                        <i id="show_icon1" class="fas fa-save"></i>
                                                        @if($request->page == 'create' || $request->page == 'copy')
                                                            @lang('cmn.do_posting')
                                                        @else
                                                            @lang('cmn.update_post')
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- transection section (include) -->
                    @if($request->page== 'transection')
                    
                        <!-- transection form (include)  -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary"><b>ট্রানজেকশন ফর্ম</b></h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="transection_action" action="due-payment-to-provider">
                                        @csrf
                                        <input type="hidden" name="payment_type" id="payment_type">
                                        <div id="div_of_trip_ids">
                                            <input type="hidden" name="trip_id[]" value="{{ $trip->id }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ট্রানজেকশনের ধরণ</label>
                                                    <select class="form-control" id="transection_type" name="transection_type" onclick="changeTransectionAction()" required>
                                                        <option value="">@lang('cmn.please_select')</option>
                                                        <option value="porvider_challan_due">গাড়ী প্রদানকারীকে চালান বাকী পরিশোধ</option>
                                                        <option value="porvider_demarage_due">গাড়ী প্রদানকারীকে ডেমারেজ বাকী পরিশোধ</option>
                                                        <option value="company_challan_due">কোম্পানী থেকে চালান বাকী গ্রহণ</option>
                                                        <option value="company_demarage_due">কোম্পানী থেকে ডেমারেজ বাকী গ্রহণ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>@lang('cmn.payment_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                    <div class="input-group date" id="transection_date" data-target-input="nearest">
                                                        <input type="text" name="date" class="form-control datetimepicker-input" value="{{ date('d/m/Y') }}" data-target="#reservationdate" required>
                                                        <div class="input-group-append" data-target="#transection_date" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>@lang('cmn.payment_method')</label>
                                                    <select class="form-control" name="account_id" required>
                                                        @if(isset($accounts))
                                                        @foreach($accounts as $account)
                                                        <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }} ) = {{(number_format($account->balance))}}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>@lang('cmn.balance') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                    <input type="number" min="0" name="amount" class="form-control" value="0" value="{{ old('amount') }}" placeholder="@lang('cmn.amount_here')" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>@lang('cmn.recipients_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                    <input type="text" name="recipients_name" class="form-control" value="{{ old('recipients_name') }}" placeholder="@lang('cmn.write_recipients_name_here')" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>@lang('cmn.recipients_phone') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                                    <input type="number" name="recipients_phone" class="form-control" value="{{ old('recipients_phone') }}" placeholder="@lang('cmn.write_recipients_phone_here')" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" id="trans_show_btn1" class="form-control btn btn-sm btn-success" onclick="submitTransection()">
                                                        <i id="trans_load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                                        <i id="trans_show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    @if($trip && $trip->provider->ownership == 'own')
                        <!-- expense form (include)  -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo"><b>@lang('cmn.expenses')</b></a>
                                </h4> 
                            </div>
                            {{-- class="collapse {{ ($trip)?'show':'' }}" --}}
                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    @if($trip)
                                    <div class="row">
                                        @php  $tripGeneralExpenseLists = tripExpenseListsByGroupId($trip->group_id); @endphp
                                        @if($tripGeneralExpenseLists)
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-striped text-center table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Sl</th>
                                                        <th width="20%">@lang('cmn.expense_head')</th>
                                                        <th width="20%">@lang('cmn.taka')</th>
                                                        <th width="45%">@lang('cmn.note')</th>
                                                        <th width="10%">@lang('cmn.action')</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="expense_tbody">
                                                    @php $total_general_exp=0; @endphp
                                                    @foreach($tripGeneralExpenseLists as $expenseKey => $expense)
                                                    <tr>
                                                        <td>{{ ++$expenseKey }}</td>
                                                        <td>{{ $expense->head }}</td>
                                                        <td>
                                                            {{ number_format($expense->amount) }}
                                                            @php $total_general_exp += $expense->amount @endphp
                                                        </td>
                                                        <td>{{ $expense->note }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $expense->id  }})" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                                            <form id="delete-form-{{$expense->id }}" method="POST" action="{{ url('expenses', $expense->id ) }}" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr style="font-weight: bold;">
                                                        <td colspan="2">@lang('cmn.total') =</td>
                                                        <td>{{ number_format($total_general_exp) }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>    
                                            </table>
                                        </div>
                                        @endif
                                        <div class="col-md-12">
                                            <div class="card card-secondary">
                                                <form action="{{ url('trip-expense-save') }}" method="POST" id="ex_form">
                                                    @csrf
                                                    <div class="card-header">
                                                        <h3 class="card-title">@lang('cmn.expense')</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.expense_head')</label>
                                                                    <select class="form-control select2" style="width: 100%;" name="expense_id[]" required>
                                                                        <option value="">@lang('cmn.please_select')</option>
                                                                        @foreach($expenses as $expense)
                                                                        <option value="{{$expense->id}}">{{$expense->head}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.payment_method')</label>
                                                                    <select class="form-control select2" style="width: 100%;" name="account_id">
                                                                        @if(isset($accounts))
                                                                        @foreach($accounts as $account)
                                                                        <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.taka')</label>
                                                                    <input type="number" class="form-control" name="amount[]" min="0" value="0" placeholder="@lang('cmn.amount')" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.note')</label>
                                                                    <textarea class="form-control" name="note[]" rows="1" placeholder="@lang('cmn.note')"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <button type="button" id="ex_show_btn1" class="form-control btn btn-sm btn-success" onclick="submitExpense()">
                                                                        <i id="ex_load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                                                        <i id="ex_show_icon1" class="fa fa-save"></i> @lang('cmn.do_posting')
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                                            <input type="hidden" name="vehicle_id" value="{{ $trip->provider->vehicle_id }}">
                                                            <input type="hidden" name="trip_date" value="{{ $trip->date }}">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @if(count($trip->oilExpenses)>0)
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-striped text-center table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">@lang('cmn.no')</th>
                                                        <th width="20%">@lang('cmn.pump_name')</th>
                                                        <th width="10%">@lang('cmn.liter')</th>
                                                        <th width="10%">@lang('cmn.rate')</th>
                                                        <th width="10%">@lang('cmn.taka')</th>
                                                        <th width="25%">@lang('cmn.note')</th>
                                                        <th width="10%">@lang('cmn.action')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $total_oil_liter=0; $total_oil_bill=0; @endphp
                                                    @foreach($trip->oilExpenses as $oil_exp_key => $oil_expense)
                                                    <tr>
                                                        <td>{{ ++$oil_exp_key }}</td>
                                                        <td>{{ $oil_expense->pump->name }}</td>
                                                        <td>{{ $oil_liter[$oil_exp_key]= $oil_expense->liter }}</td>
                                                        <td>{{ $oil_expense->rate }}</td>
                                                        <td>
                                                            {{ number_format($oil_expense->bill) }}
                                                            @php $oil_exp[$oil_exp_key] = $oil_expense->bill @endphp
                                                        </td>
                                                        <td>{{ $oil_expense->note }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $expense->id  }})" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                                            <form id="delete-form-{{$expense->id }}" method="POST" action="{{ url('trip-oil-expense-delete', $oil_expense->id ) }}" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $total_oil_liter += $oil_liter[$oil_exp_key];
                                                        $total_oil_bill += $oil_exp[$oil_exp_key];
                                                    @endphp
                                                    @endforeach
                                                    <tr style="font-weight: bold;">
                                                        <td colspan="2">@lang('cmn.total') =</td>
                                                        <td>{{ number_format($total_oil_liter) }}</td>
                                                        <td></td>
                                                        <td>{{ number_format($total_oil_bill) }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        <div class="col-md-12">
                                            <div class="card card-secondary">
                                                <form action="{{ url('/trip-oil-expense-save') }}" method="POST" id="pump_form">
                                                    @csrf
                                                    <div class="card-header">
                                                        <h3 class="card-title">@lang('cmn.pump')</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.pump_name')</label>
                                                                    <select name="pump_id" class="form-control select2" style="width: 100%;">
                                                                        <option value="">ক্যাশ প্রদান করা হয়েছিল</option>
                                                                        @foreach($pumps as $pump)
                                                                        <option value="{{ $pump->id }}">{{ $pump->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.payment_method')</label>
                                                                    <select class="form-control select2" style="width: 100%;" name="account_id">
                                                                        @if(isset($accounts))
                                                                        @foreach($accounts as $account)
                                                                        <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                                                                        @endforeach
                                                                        @endif
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
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>@lang('cmn.note')</label>
                                                                    <textarea class="form-control" name="note" rows="1" placeholder="@lang('cmn.note')"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>&nbsp;</label>
                                                                    <button type="button" id="pump_show_btn1" class="form-control btn btn-sm btn-success" onclick="submitPump()">
                                                                        <i id="pump_load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                                                        <i id="pump_show_icon1" class="fa fa-save"></i> @lang('cmn.do_posting')
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="trip_date" value="{{ $trip->date }}">
                                                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                                            <input type="hidden" name="vehicle_id" value="{{ $trip->provider->vehicle_id }}">
                                                        </div>
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
                            </div>
                        </div>


                        <!-- meter form (include)  -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree"><b>@lang('cmn.meter_info')</b></a>
                                </h4> 
                            </div>
                            <div id="collapseThree" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-secondary">
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
                                                                <td><a class="btn btn-xs btn-danger" href="{{ url('trip-meter-delete', $trip->meter->id) }}" onclick="return confirm(`@lang('cmn.are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                    @if($trip)
                                                    <form  action="{{ url('/trip-meter-save') }}" method="POST">
                                                        @csrf
                                                        <div class="card-header">
                                                            <h3 class="card-title">@lang('cmn.meter_info')</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>@lang('cmn.start_meter_reading_of_trip')</label>
                                                                        <input type="number" min="0" class="form-control" name="previous_reading" value="0" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>@lang('cmn.last_meter_reading_of_trip')</label>
                                                                        <input type="number" min="0" class="form-control" name="current_reading" value="0" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label>&nbsp;</label>
                                                                        <button type="submit" class="form-control btn btn-sm btn-success"><i class="fa fa-save"></i> @lang('cmn.do_posting')</button>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                                            </div>
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
                    @endif


                    @endif
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
<script type="text/javascript">
    $('#account_take_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    $('#trip_starting_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    $('#transection_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });

    $(function () {
        $('.select2').select2()
    });

    function supplierHideShow(){
        let ownership = document.getElementById('ownership').value;
        if(ownership == 'out'){
            document.getElementById('vehilce_number').style.display = "block";
            document.getElementById('driver_name').style.display = "block";
            document.getElementById('driver_phone').style.display = "block";
            document.getElementById('owner_name').style.display = "block";
            document.getElementById('owner_phone').style.display = "block";
            document.getElementById('reference_name').style.display = "block";
            document.getElementById('reference_phone').style.display = "block";
            document.getElementById('vehicle_id').style.display = "none";
        }

        if(ownership == 'own'){
            document.getElementById('vehilce_number').style.display = "none";
            document.getElementById('driver_name').style.display = "none";
            document.getElementById('driver_phone').style.display = "none";
            document.getElementById('owner_name').style.display = "none";
            document.getElementById('owner_phone').style.display = "none";
            document.getElementById('reference_name').style.display = "none";
            document.getElementById('reference_phone').style.display = "none";
            document.getElementById('vehicle_id').style.display = "block";
        }

    }

    function submitTrip(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('trip_form').submit();
    }

    function submitExpense(){
        document.getElementById("ex_load_icon1").style.display = "inline-block";
        document.getElementById("ex_show_icon1").style.display = "none";
        document.getElementById("ex_show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('ex_form').submit();
    }

    function submitPump(){
        document.getElementById("pump_load_icon1").style.display = "inline-block";
        document.getElementById("pump_show_icon1").style.display = "none";
        document.getElementById("pump_show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('pump_form').submit();
    }

    function changeTransectionAction(){
        $('#transection_action').attr('action', '');
        let transectionType = document.getElementById('transection_type').value;
        if(transectionType == 'porvider_challan_due'){
            $('#transection_action ').attr('action', 'due-payment-to-provider');
            document.getElementById('payment_type').value = 'challan_due';
        } else if (transectionType == 'porvider_demarage_due'){
            $('#transection_action ').attr('action', 'due-payment-to-provider');
            document.getElementById('payment_type').value = 'demarage_due';
        } else if (transectionType == 'company_challan_due'){
            $('#transection_action ').attr('action', 'due-payment-received-from-company');
            document.getElementById('payment_type').value = 'challan_due';
        } else if (transectionType == 'company_demarage_due'){
            $('#transection_action ').attr('action', 'due-payment-received-from-company');
            document.getElementById('payment_type').value = 'demarage_due';
        }
    }

    function submitTransection(){
        document.getElementById("trans_load_icon1").style.display = "inline-block";
        document.getElementById("trans_show_icon1").style.display = "none";
        document.getElementById("trans_show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('transection_action').submit();
    }
 

</script>
@endpush