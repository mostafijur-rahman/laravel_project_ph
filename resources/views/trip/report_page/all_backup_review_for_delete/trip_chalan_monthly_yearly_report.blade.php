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
                            @if(!$request->trip_number)
                            <td width="10%" class="text-center">Trip No</td>
                            @endif
                            <td width="20%" class="text-center">Primary Details</td>
                            <td width="25%" class="text-center">Trip Details</td>
                            <td width="25%" class="text-center">Income</td>
                            <td width="20%" class="text-center">Expense</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($trip_nos[0]))
                            @foreach($trip_nos as $key => $list)
                            <tr>
                                @if(!$request->trip_number)
                                <td class="text-center">{{$list->trip_no}}</td>
                                @endif
                                <td class="text-left">
                                    @lang('cmn.created') : <b>{{ hybrid_first('users','id',$list->trip_marketing_by,'first_name') .' '. hybrid_first('users','id',$list->trip_marketing_by,'last_name')}}</b><br>
                                    @lang('nav.trip') @lang('cmn.number') : <b>{{$list->trip_no}}</b><br>
                                    @lang('cmn.no') : <b>{{ hybrid_first('cars','car_id',$list->trip_car_id,'car_no')}}</b><br>
                                    @lang('cmn.number') : <b>{{ hybrid_first('cars','car_id',$list->trip_car_id,'car_number')}}</b><br>
                                    @lang('cmn.driver') : <b>{{ hybrid_first('people','people_id',$list->trip_driver_id,'people_name')}}</b>
                                </td>
                                <td class="text-left">
                                    @foreach(hybrid_get('trips','trip_no',$list->trip_no,'*','trip_date','desc') as $trip_info) 
                                    @lang('nav.trip') : <b>{{ date('d M, Y', strtotime($trip_info->trip_date)) }} ({{ hybrid_first('time_sheets','time_id',$trip_info->trip_time,'time')}})</b><br>
                                    @lang('cmn.route') : <b>{{ hybrid_first('setting_areas','id',$trip_info->trip_load,'name')}}</b> থেকে <b>{{ hybrid_first('setting_areas','id',$trip_info->trip_unload,'name')}} ({{$trip_info->trip_distance + $trip_info->empty_distance}} কিঃ মিঃ)</b><br>
                                    @lang('cmn.client') : <b>{{ hybrid_first('clients','client_id',$trip_info->trip_client_id,'client_name')}}</b><br>
                                    @lang('cmn.goods') : <b>{{$trip_info->trip_product}}</b><br><hr>
                                    @endforeach
                                </td>
                                @php
                                    $oil_bill_sum = ($list->trip_oil_expense_by_trip_no)?$list->trip_oil_expense_by_trip_no->sum('trip_oil_exp_bill'):0;
                                    $total_cmn_exp_sum = ($list->trip_common_expense_by_trip_no)?$list->trip_common_expense_by_trip_no->sum('trip_comn_exp_amount'):0;
                                    $total_received_rent = ($list->trip_details)?$list->trip_details->sum('trip_received_fair'):0;
                                    $total_exp_sum = 0;
                                    $trip_cmn_exp_lists[$key] = trip_common_expense_list_by_trip_no($list->trip_no);
                                @endphp
                                <td class="text-right">
                                    @if($list->trip_details)
                                    @foreach($list->trip_details as $trip_info)
                                    <strong>{{ $trip_info->load_data->name }}</b> থেকে <b>{{ $trip_info->unload->name }}</strong> = <strong>{{ number_format($trip_info->trip_received_fair) }}</strong><br>
                                    </a>
                                    @endforeach
                                    @endif
                                    <b>@lang('cmn.total_expense') = </b>{{number_format($total_cmn_exp_sum+$oil_bill_sum)}}<br>
                                    ----------------------------<br>
                                    @lang('cmn.net_income') = <strong>{{ $net_income = number_format($total_received_rent-($total_cmn_exp_sum+$oil_bill_sum)) }}</strong><br>
                                    (@lang('cmn.due') = {{ number_format($list->trip_details->sum('trip_due_fair')) }}, @lang('cmn.discount') = {{ number_format($list->trip_details->sum('trip_deduction_fair')) }})
                                </td>
                                <td class="text-right">
                                    <b>@lang('cmn.fuel') =</b> {{ number_format($oil_bill_sum) }} ({{  number_format($list->trip_oil_expense_by_trip_no->sum('trip_oil_exp_liter')) }} লিঃ)<br>
                                    @if($trip_cmn_exp_lists[$key])
                                    @foreach($trip_cmn_exp_lists[$key] as $i => $trip_cmn_exp_list)
                                    <b>{{ $trip_cmn_exp_list->exp_head }} =</b> {{ $single_trip_cmn_exp[$i] = number_format($trip_cmn_exp_list->trip_cmn_single_exp_sum) }}<br>
                                    @endforeach
                                    ----------------------------------<br>
                                    <b>@lang('cmn.total_expense') = {{ number_format($total_cmn_exp_sum+$oil_bill_sum) }}</b>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>  
        </div>
    </div>
</div>
@endsection