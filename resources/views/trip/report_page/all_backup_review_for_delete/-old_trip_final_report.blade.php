@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="element-header text-center"><b>{{$title}}</b></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td width="10%" class="text-center">Trip No</td>
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
                                <td class="text-center">{{$list->trip_no}}</td>
                                <td class="text-left">
                                    {{-- মার্কেটিং: <b>{{ hybrid_first('users','id',$list->trip_marketing_by,'name')}}</b><br> --}}
                                    Trip number : <b>{{$list->trip_no}}</b><br>
                                    Vehicle no : <b>{{ hybrid_first('cars','car_id',$list->trip_car_id,'car_no')}}</b><br>
                                    Vehicle number : <b>{{ hybrid_first('cars','car_id',$list->trip_car_id,'car_number')}}</b><br>
                                    {{-- ড্রাইভার: <b>{{ hybrid_first('people','people_id',$list->trip_driver_id,'people_name')}}</b> --}}
                                </td>
                                <td class="text-left">
                                    @foreach(hybrid_get('trips','trip_no',$list->trip_no,'*','trip_date','desc') as $trip_info) 
                                    Trip : <b>{{ date('d M, Y', strtotime($trip_info->trip_date)) }} ({{ hybrid_first('time_sheets','time_id',$trip_info->trip_time,'time')}})</b><br>
                                    Route : <b>{{ hybrid_first('setting_areas','id',$trip_info->trip_load,'name')}}</b> থেকে <b>{{ hybrid_first('setting_areas','id',$trip_info->trip_unload,'name')}} ({{$trip_info->trip_distance + $trip_info->empty_distance}} কিঃ মিঃ)</b><br>
                                    Client : <b>{{ hybrid_first('people','people_id',$trip_info->trip_client_id,'people_name')}}</b><br>
                                    Product : <b>{{$trip_info->trip_product}}</b><br><hr>
                                    @endforeach
                                </td>
                                @php
                                    $oil_bill_sum = trip_oil_bill_sum_by_trip_no($list->trip_no)
                                @endphp
                                <!-- calculate trip expense -->
                                @php
                                    $total_exp_sum = 0;
                                    $trip_cmn_exp_lists[$key] = trip_common_expense_list_by_trip_no($list->trip_no);
                                    $total_cmn_exp_sum = trip_common_expense_sum_by_trip_no($list->trip_no);
                                @endphp
                                <td class="text-right">
                                    @foreach(hybrid_get('trips','trip_no',$list->trip_no,'*','trip_date','desc') as $trip_info) 
                                    <b>{{ hybrid_first('setting_areas','id',$trip_info->trip_load,'name')}}</b> থেকে <b>{{ hybrid_first('setting_areas','id',$trip_info->trip_unload,'name')}} =</b> {{ $trip_info->trip_received_fair }}<br>
                                    @endforeach
                                    {{-- <b>ভাড়া =</b> {{ $fair = trip_received_fair_sum_by_trip_no($list->trip_no) }}<br> --}}
                                    <?php $fair = trip_received_fair_sum_by_trip_no($list->trip_no); ?>
                                    <b>Total expense =</b> {{$total_cmn_exp_sum+$oil_bill_sum}}<br>
                                    ----------------------------<br>
                                    <b>Net Income = {{ $net_income = $fair-($total_cmn_exp_sum+$oil_bill_sum)}}</b>
                                </td>
                                <td class="text-right">
                                <!-- +"trip_no": 215
                                +"exp_head": "চাঁদা/দারোয়ান"
                                +"trip_cmn_single_exp_sum": "900.00" -->
                                    <b>Oil =</b> {{ $oil_bill_sum }} ({{trip_oil_liter_sum_by_trip_no($list->trip_no)}} লিঃ)<br>
                                    @if($trip_cmn_exp_lists[$key])
                                        @php
                                            $total_trip_cmn_exp = 0;
                                        @endphp
                                        @foreach($trip_cmn_exp_lists[$key] as $i => $trip_cmn_exp_list)
                                        <b>{{ $trip_cmn_exp_list->exp_head }} =</b> {{ $single_trip_cmn_exp[$i] = $trip_cmn_exp_list->trip_cmn_single_exp_sum }}<br>
                                        @php 
                                            $total_trip_cmn_exp += $single_trip_cmn_exp[$i];
                                        @endphp
                                        @endforeach
                                    ----------------------------------<br>
                                    <b>Total expense = {{$total_trip_cmn_exp+$oil_bill_sum}}</b>
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