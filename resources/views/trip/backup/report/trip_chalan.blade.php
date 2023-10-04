@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-9">
                    <h5 class="element-header text-left"><strong>{{$title}}</strong></h5>
                </div>
                <div class="col-sm-3">
                    <h6 class="element-header text-right"><strong>{{(isset($date_show))?$date_show:''}}</strong></h6>
                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td width="20%" class="text-center">@lang('cmn.primary_info')</td>
                            <td width="25%" class="text-center">@lang('cmn.trip_details')</td>
                            <td width="25%" class="text-center">@lang('cmn.income')</td>
                            <td width="20%" class="text-center">@lang('cmn.expense')</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if($trips)
                            @foreach($trips as $trip)
                            @php $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id) @endphp
                            <tr class="text-center">
                                <td class="text-left">
                                    @if($trip->account_take_date)
                                    @lang('cmn.account_receiving'): {{ date('d M, Y', strtotime($trip->account_take_date)) }}<br>
                                    @endif
                                    @lang('cmn.vehicle'): {{ $trip->vehicle->vehicle_number }}<br>
                                    @if($trip->number)
                                    @lang('cmn.trip_number'): {{ $trip->number }}<br>
                                    @endif
                                    @lang('cmn.driver'): {{ $trip->vehicle->driver->name }}<br>
                                    @if($trip->meter->previous_reading)
                                        @lang('cmn.previous_meter'): {{  number_format($trip->meter->previous_reading) }}<br>
                                        @lang('cmn.running_meter'): {{ number_format($trip->meter->current_reading) }}<br>
                                        @lang('cmn.total') @lang('cmn.km'): {{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}<br>
                                        @lang('cmn.total') @lang('cmn.fuel'): {{ number_format($tripOilLiterSumByGroupId) }}<br>
                                        @lang('cmn.liter_per_km'): {{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}<br>
                                    @endif
                                    @lang('cmn.created'): {{ $trip->user->first_name .' '.$trip->user->last_name}}<br>
                                </td>
                                <td class="text-left">
                                    @if($trip->getTripsByGroupId)
                                        @php $tripLastKey = count($trip->getTripsByGroupId); @endphp
                                        @foreach($trip->getTripsByGroupId as $tripKey => $trip_info)
                                            @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip_info->date)) }}</b><br>
                                            @lang('cmn.route'): <b>{{ $trip_info->load_data->name }}</b> @lang('cmn.from') <b>{{ $trip_info->unload->name }} ({{ $trip_info->trip_distance + $trip_info->empty_distance }} @lang('cmn.km'))</b><br>
                                            @lang('cmn.client'): <b>{{ $trip_info->company->name }}</b>
                                            @if($trip_info->goods)
                                                <br>@lang('cmn.goods'): <b>{{ $trip_info->goods }}</b><br>
                                            @endif
                                            @lang('cmn.rent'): <b>{{ number_format($trip_info->contract_fair) }}</b><br>
                                            @lang('cmn.addv_rent'): <b>{{ number_format($trip_info->advance_fair) }}</b><br>
                                            @lang('cmn.due'): <b>{{ number_format($trip_info->due_fair) }}</b><br>
                                            @if(($tripKey+1) != $tripLastKey)
                                                <br>
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
                                    (@lang('cmn.due') = {{ number_format($trip->getTripsByGroupId->sum('due_fair')) }}, @lang('cmn.discount') = {{ number_format($trip->getTripsByGroupId->sum('deduction_fair')) }})
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
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>
@endsection