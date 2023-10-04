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
                            <td class="text-center" rowspan="2" width="5%">নং</td>
                            <td class="text-center" rowspan="2" width="30%">বিবরণ</td>
                            <td class="text-center" rowspan="2" width="10%">মোট আয়</td>
                            <td class="text-center" rowspan="2" width="10%">কমিশন</td>
                            <td class="text-center" rowspan="2" width="10%">খরচ</td>
                            <td class="text-center" rowspan="2" width="10%">নীট আয়</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="font-weight: bold;" class="text-center">যাওয়ার হিসাব</td>
                        </tr>
                        <!-- loop -->
                        @if(isset($cbs_going))
                        @php
                        $total_going_fair = 0;
                        $total_going_advance_fair = 0;
                        $total_going_due_fair = 0;
                        $total_going_expense_sum = 0;
                        $total_cash=0;
                        @endphp
                        @foreach($cbs_going as $i=>$cb)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">টিকেট বিক্রয়</td>
                            <td class="text-center">{{ $ttst[$i] = $cb->sum_ticket_sale_total}}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">কমিশন</td>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $ttct[$i] = $cb->sum_ticket_commission_total }}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        @foreach(get_expenses_by_trip_id_counter_id($trip->trip_id, $cb->counter_id) as $exp_list)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $exp_list->expense_name }}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $exp_list->te_amount }}</td>
                            <td class="text-center"></td>
                        </tr>
                        @endforeach
                        <tr style="border-top: 3px solid black;">
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                        </tr>
                        @php 
                        $tes[$i] = get_expense_sum_by_counter_id($cb->td_id,$cb->counter_id);
                        $total_expense_total_sum += $tes[$i];
                        $total_cash += $tc[$i];
                        @endphp
                        @endforeach
                        @endif
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="border-top: 3px solid black; font-weight: bold">
                            <td class="text-center" colspan="2">যাওয়ার মোট</td>
                            <td class="text-center">{{ $total_ticket_sale_total }}</td>
                            <td class="text-center">{{ $total_ticket_commission_total }}</td>
                            <td class="text-center">{{ $total_expense_total_sum }}</td>
                            <td class="text-center">{{ $total_cash }}</td>
                        </tr>
                        {{-- loop end --}}
                        <tr>
                            <td colspan="6">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="6"  style="font-weight: bold;" class="text-center">আসার হিসাব</td>
                        </tr>
                        <!-- loop -->
                        @if(isset($cbs_coming))
                        @php
                        $ctotal_ticket_qty=0;
                        $ctotal_ticket_sale_total=0;
                        $ctotal_ticket_commission_total=0;
                        $ctotal_expense_total_sum = 0;
                        $ctotal_cb_ticket_price_less_total=0;
                        $ctotal_cash=0;
                        @endphp
                        @foreach($cbs_coming as $c=>$cbc)
                        <tr>
                            <td class="text-center">{{$cbc->counter_name}}</td>
                            <td class="text-center">{{ $cttst[$c] = $cbc->sum_ticket_sale_total}}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>


                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">কমিশন</td>
                            <td class="text-center">{{ $cttct[$c] = $cbc->sum_ticket_commission_total }}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        @foreach(get_expenses_by_trip_id_counter_id($trip->trip_id, $cbc->counter_id) as $cexp_list)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $cexp_list->expense_name }}</td>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $cexp_list->te_amount }}</td>
                            <td class="text-center"></td>
                        </tr>
                        @endforeach
                        <tr style="border-top: 3px solid black;">
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                        </tr>
                        @php
                        $cttct[$c] = $cbc->sum_ticket_commission_total;
                        $ctes[$c] = get_expense_sum_by_counter_id($cbc->td_id, $cbc->counter_id);
                        $ctc[$c] = $cbc->sum_ticket_sale_total-$cbc->sum_ticket_commission_total-$tes[$i];
                                            
                        $ctotal_ticket_qty += $cttq[$c];
                        $ctotal_ticket_sale_total += $cttst[$c];
                        $ctotal_ticket_commission_total += $cttct[$c];
                        $ctotal_expense_total_sum += $ctes[$c];
                        $ctotal_cb_ticket_price_less_total += $cttpl[$c];
                        $ctotal_cash += $ctc[$c];
                        @endphp
                        @endforeach
                        @endif
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="border-top: 3px solid black; font-weight: bold">
                            <td class="text-center" colspan="2">আসার মোট</td>
                            <td class="text-center">{{ $ctotal_ticket_sale_total }}</td>
                            <td class="text-center">{{ $ctotal_ticket_commission_total }}</td>
                            <td class="text-center">{{ $ctotal_expense_total_sum }}</td>
                            <td class="text-center">{{ $ctotal_cash }}</td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-center" colspan="6">&nbsp;</td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-center" colspan="6">ট্রিপের অন্যান খরচ</td>
                        </tr>
                        @php
                        $trip_expense=0;
                        @endphp
                        @foreach(get_expenses_by_trip_id($trip->trip_id) as $t=>$trip_exp_list)
                        <tr>
                            <td class="text-center" colspan="2">{{ $trip_exp_list->expense_name}}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $trip_e[$t] = $trip_exp_list->sum_expense}}</td>
                            <td class="text-center"></td>
                        </tr>
                        @php
                        $trip_expense+=$trip_e[$t];
                        @endphp
                        @endforeach
                        <tr style="border-top: 3px solid black; font-weight: bold">
                            <td class="text-center" colspan="2">যাওয়ার ও আসার মোট</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">{{$trip_expense}}</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-center" colspan="6">&nbsp;</td>
                        </tr>
                        <tr style="border-top: 3px solid black; font-weight: bold">
                            <td class="text-right" colspan="4">মোট আয় =</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{ $net_total = $total_cash+$ctotal_cash}}</td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-right" colspan="4">মোট খরচ (কমিশন + খরচ) =</td>
                            <td class="text-center">{{ $total_exp = $total_expense_total_sum+$ctotal_expense_total_sum+$trip_expense }}</td>
                            <td class="text-center">---</td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-right" colspan="4">নীট লাভ =</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{ $net_total-$total_exp }}</td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-right" colspan="4">নীট ক্ষতি =</td>
                            <td class="text-center">0</td>
                            <td class="text-center">---</td>
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

{{-- <tr>
    <td class="text-center">{{$cb->counter_name}}</td>
    <td class="text-center">টিকেট বিক্রয়</td>
    <td class="text-center">{{ $ttq[$i] = $cb->sum_ticket_qty}}</td>
    <td class="text-center">0</td>
    <td class="text-center">{{ $ttpl[$i] = $cb->sum_cb_ticket_price_less_total}}</td>
    <td class="text-center">{{ $ttst[$i] = $cb->sum_ticket_sale_total}}</td>
    <td class="text-center">{{ $ttct[$i] = $cb->sum_ticket_commission_total}}</td>
    <td class="text-center">{{ $tes[$i] = get_expense_sum_by_counter_id($cb->td_id,$cb->counter_id) }}</td>
    <td class="text-center">{{ $tc[$i] = $cb->sum_ticket_sale_total-$cb->sum_ticket_commission_total-$tes[$i] }}</td>
</tr> --}}

