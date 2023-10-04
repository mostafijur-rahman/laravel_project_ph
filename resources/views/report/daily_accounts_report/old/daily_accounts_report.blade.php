@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <h4 class="element-header text-center">
            <b>@lang('cmn.daily_accounts') 
                @if($car_number)
                (@lang('cmn.vehicle') @lang('cmn.no') - {{ ($car_number) }})
                @endif
            {{(isset($date_show))? ' ( '.$date_show .' ) ' : ''}}</b>
        </h4>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="element-header text-center"><b>@lang('cmn.deposit')</b></h4>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td width="5%" class="text-center">@lang('cmn.no')</td>
                        <td width="15%" class="text-center">@lang('cmn.date')</td>
                        <td width="15%" class="text-center">@lang('cmn.deposit_head')</td>
                        <td width="15%" class="text-center">@lang('cmn.money')</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_net_income = 0;
                        $key_data = 1;
                    @endphp
                    <tr>
                        <td colspan="4" class="text-center" style="font-weight: 800;">@lang('cmn.trip')</td>
                    </tr>
                    @if(count($trips) > 0)
                        @foreach($trips as $key => $trip)
                            @php
                                $total_oil_bill_sum =  tripOilBillSumByGroupId($trip->group_id);
                                $total_expense_sum =  tripExpenseSumByGroupId($trip->group_id);
                                $total_trip_expense_sum = $total_oil_bill_sum + $total_expense_sum;
                                $total_received_rent =  $trip->getTripsByGroupId->sum('advance_fair') + $trip->getTripsByGroupId->sum('received_fair');
                                $net_income = $total_received_rent - $total_trip_expense_sum;
                                $total_net_income += $net_income;
                            @endphp
                        <tr align="center">
                            <td>{{ $key_data }}</td>
                            <td>{{ $trip->account_take_date }}</td>
                            <td>{{ $trip->group_id }}</td>
                            <td>{{ number_format($net_income) }}</td>
                        </tr>
                        @php $key_data++; @endphp
                        @endforeach
                    @endif



                    <tr>
                        <td colspan="3" class="text-right">@lang('cmn.total') = </td>
                        <td class="text-center">{{ number_format($total_net_income) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>  
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="element-header text-center"><b>@lang('cmn.expense')</b></h4>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td width="5%" class="text-center">@lang('cmn.no')</td>
                        <td width="15%" class="text-center">@lang('cmn.date')</td>
                        <td width="15%" class="text-center">@lang('cmn.expense_head')</td>
                        <td width="15%" class="text-center">@lang('cmn.money')</td>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $key = 1; 
                        $total_expenses = 0; 
                    @endphp
                    <tr>
                        <td colspan="4" class="text-center" style="font-weight: 800;">@lang('cmn.expense')</td>
                    </tr>
                    @foreach($expenses as $expense)
                    <tr align="center">
                        <td>{{ $key }}</td>
                        <td>{{ $expense->date }}</td>
                        <td>{{ $expense->expense->head }}</td>
                        <td>{{ number_format($expense->amount) }}</td>
                    </tr>
                    @php 
                        $key++; 
                        $total_expenses += $expense->amount;
                    @endphp
                    @endforeach


                    <tr>
                        <td colspan="3" class="text-right">@lang('cmn.total') = </td>
                        <td class="text-center">{{ number_format($total_expenses) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>  
    </div>
</div>
@endsection