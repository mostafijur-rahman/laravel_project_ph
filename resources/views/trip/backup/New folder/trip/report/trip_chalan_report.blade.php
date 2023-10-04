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
                            <td width="10%" class="text-center">@lang('cmn.no')</td>
                            <td width="20%" class="text-center">@lang('cmn.primary_details')</td>
                            <td width="25%" class="text-center">@lang('cmn.trip_details')</td>
                            <td width="25%" class="text-center">@lang('cmn.income')</td>
                            <td width="20%" class="text-center">@lang('cmn.expense')</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($trip_nos[0]))
                            @foreach($trip_nos as $key => $list)
                            <tr>
                                <td class="text-center">{{ ++$key }}</td>
                                <td class="text-left">
                                    @lang('cmn.created'): <b>{{ $list->user->first_name .' '.$list->user->last_name}}</b><br>
                                    @lang('cmn.account_receiving'): <b>{{ date('d M, Y', strtotime($list->account_take_date)) }}</b><br>
                                    @lang('cmn.trip_number'): <b>{{ $list->number }}</b><br>
                                    @lang('cmn.vehicle'): {{ $list->vehicle->vehicle_number }}, @lang('cmn.driver'): {{ $list->vehicle->driver->name }}<br>
                                </td>
                                <td class="text-left">
                                    @if($list->getTripsByNumber)
                                        @php $tripLastKey = key($list->getTripsByNumber); @endphp
                                        @foreach($list->getTripsByNumber as $tripKey => $trip_info)
                                            @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip_info->date)) }}</b><br>
                                            @lang('cmn.route'): <b>{{ $trip_info->load_data->name }}</b> @lang('cmn.from') <b>{{ $trip_info->unload->name }} ({{ $trip_info->trip_distance + $trip_info->empty_distance }} কিঃ মিঃ)</b><br>
                                            @lang('cmn.client'): <b>{{ $trip_info->company->name }}</b>
                                            @if($trip_info->goods)
                                                <br>@lang('cmn.goods'): <b>{{ $trip_info->goods }}</b>
                                            @endif
                                            <br>
                                            @if($tripKey == $tripLastKey)
                                                <br><br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                @php
                                    $total_oil_bill_sum =  tripOilBillSumByTripNumber($list->number);
                                    $total_general_expense_sum =  tripGeneralExpenseSumByTripNumber($list->number);
                                    $total_received_rent =  $list->getTripsByNumber->sum('advance_fair') + $list->getTripsByNumber->sum('received_fair');
                                    $trip_general_exp_lists[$key] = tripGeneralExpenseListByTripNumber($list->number);
                                @endphp
                                <td class="text-right">
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @lang('cmn.rent') = <strong>{{ number_format($total_received_rent) }}</strong><br>
                                        @lang('cmn.total_expense') = <strong>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</strong><br>
                                    </div>
                                    @lang('cmn.net_income') = <strong>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</strong><br>
                                    (@lang('cmn.due') = {{ number_format($list->getTripsByNumber->sum('due_fair')) }}, @lang('cmn.discount') = {{ number_format($list->getTripsByNumber->sum('deduction_fair')) }})
                                </td>
                                <td class="text-right">
                                    <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($list->oilExpenses->sum('liter')) }} লিঃ)<br>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @if($trip_general_exp_lists[$key])
                                            @foreach($trip_general_exp_lists[$key] as $i => $trip_general_exp_list)
                                            <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_general_single_expense_sum) }}<br>
                                            @endforeach
                                    </div>
                                    <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>
@endsection