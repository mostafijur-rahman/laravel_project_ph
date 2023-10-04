@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="element-header text-center">{{$title}}</h4>
                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center" rowspan="2">তারিখ</td>
                            <td class="text-center" rowspan="2">ট্রিপ সংখ্যা</td>
                            <td  class="text-center" colspan="2">মোট বুকিং</td>
                            <td class="text-center" rowspan="2">লেস মূল্য</td>
                            <td class="text-center" rowspan="2">মোট আয়</td>
                            <td class="text-center" rowspan="2">কমিশন</td>
                            <td class="text-center" rowspan="2">খরচ</td>
                            <td class="text-center" rowspan="2">নীট আয়</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-center">বিক্রয়</td>
                            <td class="text-center">সৌজন্য</td>
                            <td colspan="5"></td>
                        </tr>
                        <!-- loop -->
                        @if(isset($trips))
                        @php
                        $total_trip_qty=0;
                        $total_ticket_sale_qty=0;
                        $total_ticket_courtsy_qty=0;
                        $total_price_less=0;
                        $total_income=0;
                        $total_comission=0;
                        $total_expense=0;
                        $net_total=0;
                        @endphp
                        @foreach($trips as $i=>$trip)
                        <tr>
                            <td class="text-center">{{ $trip->td_date }}</td>
                            <td class="text-center">{{ $ttq[$i] = get_total_trip_qty($request->route_id, $trip->trip_id, $request->counter_id) }}</td>
                            <td class="text-center">{{ $ttsq[$i] = get_total_sale($request->route_id, $trip->trip_id, $request->counter_id) }}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">{{ $tpl[$i] = get_total_mullo_less($request->route_id, $trip->trip_id, $request->counter_id) }}</td>
                            <td class="text-center">{{ $ti[$i] = get_total_income($request->route_id, $trip->trip_id, $request->counter_id) }}</td>
                            <td class="text-center">{{ $tc[$i] = get_total_comission($request->route_id, $trip->trip_id, $request->counter_id) }}</td>
                            <td class="text-center">{{ $te[$i] = get_total_expense($request->route_id, $trip->trip_id, $request->counter_id) }}</td>
                            <td class="text-center">{{ $nt[$i] = $ti[$i]-($tc[$i]+$te[$i]) }}</td>
                        </tr>
                        @php
                        $total_trip_qty += $ttq[$i];
                        $total_ticket_sale_qty += $ttsq[$i];
                        // $total_ticket_courtsy_qty += $ttcq[$i];
                        $total_price_less += $tpl[$i];
                        $total_income += $ti[$i];
                        $total_comission += $tc[$i];
                        $total_expense += $te[$i];
                        $net_total += $nt[$i];
                        @endphp
                        @endforeach
                        @endif
                        <tr style="font-weight: bold; border-top: 2px">
                            <td class="text-center">সর্বোমোট</td>
                            <td class="text-center">{{ $total_trip_qty }}</td>
                            <td class="text-center">{{ $total_ticket_sale_qty }}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">{{ $total_price_less }}</td>
                            <td class="text-center">{{ $total_income }}</td>
                            <td class="text-center">{{ $total_comission }}</td>
                            <td class="text-center">{{ $total_expense }}</td>
                            <td class="text-center">{{ $net_total }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>  
        </div>
    </div>
</div>
@endsection