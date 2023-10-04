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
                            <td class="text-center" rowspan="2">বুকিং কাউন্টার</td>
                            <td class="text-center" rowspan="2">বিবরণ</td>
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
                        <tr>
                            <td colspan="9" class="text-center">যাওয়ার মোট</td>
                        </tr>
                        <!-- loop -->
                        @if(isset($cbs_going))
                        @php
                        $i=1;
                        $total_ticket_qty=0;
                        $total_ticket_sale_total=0;
                        $total_ticket_commission_total=0;
                        $total_expense_total_sum = 0;
                        $total_cb_ticket_price_less_total=0;
                        $total_cash=0;
                        @endphp
                        @foreach($cbs_going as $cb)
                        <tr>
                            <td class="text-center">{{$cb->counter_name}}</td>
                            <td></td>
                            <td class="text-center">{{ $ttq[$i] = $cb->sum_ticket_qty}}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">{{ $ttpl[$i] = $cb->sum_cb_ticket_price_less_total}}</td>
                            <td class="text-center">{{ $ttst[$i] = $cb->sum_ticket_sale_total}}</td>
                            <td class="text-center">{{ $ttct[$i] = $cb->sum_ticket_commission_total}}</td>
                            <td class="text-center">{{ $tes[$i] = get_expense_sum_by_counter_id($cb->td_id,$cb->counter_id) }}</td>
                            <td class="text-center">{{ $tc[$i] = $cb->sum_ticket_sale_total-$cb->sum_ticket_commission_total-$tes[$i] }}</td>
                        </tr>
                        @php
                        $total_ticket_qty += $ttq[$i];
                        $total_ticket_sale_total += $ttst[$i];
                        $total_ticket_commission_total += $ttct[$i];
                        $total_expense_total_sum += $tes[$i];
                        $total_cb_ticket_price_less_total += $ttpl[$i];
                        $total_cash += $tc[$i];
                        @endphp
                        @endforeach
                        @endif
                        {{-- loop end --}}
                        <tr>
                            <td colspan="9" class="text-center">আসার মোট</td>
                        </tr>
                        <!-- loop -->
                        @if(isset($cbs_coming))
                        @php
                        $c=1;
                        $ctotal_ticket_qty=0;
                        $ctotal_ticket_sale_total=0;
                        $ctotal_ticket_commission_total=0;
                        $ctotal_expense_total_sum = 0;
                        $ctotal_cb_ticket_price_less_total=0;
                        $ctotal_cash=0;
                        @endphp
                        @foreach($cbs_coming as $cbc)
                        <tr>
                            <td class="text-center">{{$cbc->counter_name}}</td>
                            <td></td>
                            <td class="text-center">{{ $cttq[$i] = $cbc->sum_ticket_qty}}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">{{ $cttpl[$i] = $cbc->sum_cb_ticket_price_less_total}}</td>
                            <td class="text-center">{{ $cttst[$i] = $cbc->sum_ticket_sale_total}}</td>
                            <td class="text-center">{{ $cttct[$i] = $cbc->sum_ticket_commission_total}}</td>
                            <td class="text-center">{{ $ctes[$i] = get_expense_sum_by_counter_id($cbc->td_id,$cb->counter_id) }}</td>
                            <td class="text-center">{{ $ctc[$i] = $cbc->sum_ticket_sale_total-$cbc->sum_ticket_commission_total-$tes[$i] }}</td>
                        </tr>
                        @php
                        $ctotal_ticket_qty += $cttq[$i];
                        $ctotal_ticket_sale_total += $cttst[$i];
                        $ctotal_ticket_commission_total += $cttct[$i];
                        $ctotal_expense_total_sum += $ctes[$i];
                        $ctotal_cb_ticket_price_less_total += $cttpl[$i];
                        $ctotal_cash += $ctc[$i];
                        @endphp
                        @endforeach
                        @endif
                        <tr style="font-weight: bold; border-top: 2px">
                            <td colspan="2" class="text-center" >সর্বোমোট =</td>
                            <td class="text-center">{{$total_ticket_qty+$ctotal_ticket_qty}}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">{{$total_ticket_sale_total+$ctotal_ticket_sale_total}}</td>
                            <td class="text-center">{{$total_ticket_commission_total+$ctotal_ticket_commission_total}}</td>
                            <td class="text-center">{{$total_expense_total_sum+$ctotal_expense_total_sum}}</td>
                            <td class="text-center">{{$total_cb_ticket_price_less_total+$ctotal_cb_ticket_price_less_total}}</td>
                            <td class="text-center">{{$total_cash+$ctotal_cash}}</td>
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