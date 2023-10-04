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
                            <td class="text-center">যাওয়ার তারিখ</td>
                            <td class="text-center">ট্রিপ নম্বর</td>
                            <td class="text-center">গাড়ি নম্বর</td>
                            <td class="text-center" colspan="4">বুকিং</td>
                            <td class="text-center" >লেস মূল্য</td>
                            <td class="text-center" >মোট আয়</td>
                            <td class="text-center" >মোট কমিশন</td>
                            <td class="text-center" >মোট খরচ</td>
                            <td class="text-center" >নীট আয়</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center"></td>
                            <td class="text-center">আসন সংখ্যা</td>
                            <td class="text-center">বিক্রয়</td>
                            <td class="text-center">সৌজন্য</td>
                            <td class="text-center">মোট বুকিং</td>
                            <td class="text-center"></td>
                            <td colspan="5" class="text-center"></td>
                        </tr>
                        <!-- loop -->
                        @if(isset($trips))
                        @php
                        $total_seat=0;
                        $total_sale=0;
                        $total_courtesy=0;
                        $total_booking=0;
                        $total_mullo_less=0;
                        $total_income=0;
                        $total_comission=0;
                        $total_expense=0;
                        $net_total=0;
                        @endphp
                        @foreach($trips as $i=>$trip)
                        <tr>
                            <td class="text-center">{{ get_gi_date_of_a_trip($trip->trip_id,1) }}</td>
                            <td class="text-center">{{$trip->trip_number}}</td>
                            <td class="text-center">{{$trip->car_number}}</td>
                            <td class="text-center">{{$ts[$i] = $trip->car_seats*2}}</td>
                            <td class="text-center">{{ $tsale[$i] = get_total_booking_of_a_trip($trip->trip_id) }}</td>
                            <td class="text-center">{{ $tc[$i] = get_total_courtesy_of_a_trip($trip->trip_id) }}</td>
                            <td class="text-center">{{ $tbook[$i] = $tsale[$i]+$tc[$i]}}</td>
                            <td class="text-center">{{ $tml[$i] = get_mullo_less_sum_by_trip_id($trip->trip_id) }}</td>
                            <td class="text-center">{{ $ti[$i] = get_total_income_of_a_trip($trip->trip_id) }}</td>
                            <td class="text-center">{{ $tcom[$i] = get_total_comission_of_a_trip($trip->trip_id) }}</td>
                            <td class="text-center">{{ $te[$i] = get_total_expense_of_a_trip($trip->trip_id) }}</td>
                            <td class="text-center">{{ $nt[$i] = $ti[$i]-($tcom[$i]+$te[$i]) }}</td>
                        </tr>
                        @php
                        $total_seat += $ts[$i];
                        $total_sale += $tsale[$i];
                        $total_courtesy += $tc[$i];
                        $total_booking += $tbook[$i];
                        $total_mullo_less += $tml[$i];
                        $total_income += $ti[$i];
                        $total_comission += $tcom[$i];
                        $total_expense += $te[$i];
                        $net_total=$nt[$i];
                        @endphp
                        @endforeach
                        @endif
                        {{-- loop end --}}
                        <tr style="font-weight: bold; border-top: 2px">
                            <td colspan="3" class="text-center">সর্বোমোট</td>
                            <td class="text-center">{{$total_seat}}</td>
                            <td class="text-center">{{$total_sale}}</td>
                            <td class="text-center">{{$total_courtesy}}</td>
                            <td class="text-center">{{$total_booking}}</td>
                            <td class="text-center">{{$total_mullo_less}}</td>
                            <td class="text-center">{{$total_income}}</td>
                            <td class="text-center">{{$total_comission}}</td>
                            <td class="text-center">{{$total_expense}}</td>
                            <td class="text-center">{{$net_total}}</td>
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