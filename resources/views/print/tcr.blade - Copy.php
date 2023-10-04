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
                        {{-- @if(isset($cbs_going))
                        @php
                        $total_going_fair = 0;
                        $total_going_advance_fair = 0;
                        $total_going_due_fair = 0;
                        $total_going_expense_sum = 0;
                        $total_cash=0;
                        @endphp
                        @foreach($cbs_going as $i=>$cb) --}}
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">ভাড়া</td>
                            <td class="text-center">40,000</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">কমিশন</td>
                            <td class="text-center"></td>
                            <td class="text-center">1300</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">তেল খরচ</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">25,500</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">বেতন</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">2,000</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">অন্যান খরচ</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">1,000</td>
                            <td class="text-center"></td>
                        </tr>
                        {{-- @foreach(get_expenses_by_trip_id_counter_id($trip->trip_id, $cb->counter_id) as $exp_list) --}}
                        {{-- @endforeach --}}
                        
                        {{-- @php 
                        $tes[$i] = get_expense_sum_by_counter_id($cb->td_id,$cb->counter_id);
                        $total_expense_total_sum += $tes[$i];
                        $total_cash += $tc[$i];
                        @endphp
                        @endforeach
                        @endif --}}
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
                            <td class="text-center">40,000</td>
                            <td class="text-center">1300</td>
                            <td class="text-center">28500</td>
                            <td class="text-center">10,200</td>
                        </tr>
                        {{-- loop end --}}
                        <tr>
                            <td colspan="6">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="6"  style="font-weight: bold;" class="text-center">আসার হিসাব</td>
                        </tr>
                        <!-- loop -->
                        {{-- @if(isset($cbs_coming))
                        @php
                        $ctotal_ticket_qty=0;
                        $ctotal_ticket_sale_total=0;
                        $ctotal_ticket_commission_total=0;
                        $ctotal_expense_total_sum = 0;
                        $ctotal_cb_ticket_price_less_total=0;
                        $ctotal_cash=0;
                        @endphp
                        @foreach($cbs_coming as $c=>$cbc) --}}
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">ভাড়া</td>
                            <td class="text-center">45,000</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">কমিশন</td>
                            <td class="text-center"></td>
                            <td class="text-center">4,000</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">বেতন</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">1800</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">তেল</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">24000</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">টোল</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">1500</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">পুলিশ</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">500</td>
                            <td class="text-center"></td>
                        </tr>
                        {{-- @foreach(get_expenses_by_trip_id_counter_id($trip->trip_id, $cbc->counter_id) as $cexp_list) --}}
                        
                        {{-- @endforeach --}}
                        
                        {{-- @php
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
                        @endif --}}
                        <tr style="border-top: 3px solid black; font-weight: bold">
                            <td class="text-center" colspan="2">আসার মোট</td>
                            <td class="text-center">45,000</td>
                            <td class="text-center">4,000</td>
                            <td class="text-center">27,800</td>
                            <td class="text-center">13,200</td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-center" colspan="6">&nbsp;</td>
                        </tr>
                        
                        {{-- @php
                        $trip_expense=0;
                        @endphp
                        @foreach(get_expenses_by_trip_id($trip->trip_id) as $t=>$trip_exp_list) --}}
                        
                        {{-- @php
                        $trip_expense+=$trip_e[$t];
                        @endphp
                        @endforeach --}}
                        <tr style="border-top: 3px solid black; font-weight: bold">
                            <td class="text-center" colspan="2">যাওয়ার ও আসার মোট</td>
                            <td class="text-center">85,000</td>
                            <td class="text-center">5,300</td>
                            <td class="text-center">56,300</td>
                            <td class="text-center">23,400</td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-center" colspan="6">&nbsp;</td>
                        </tr>
                        {{-- <tr style="border-top: 3px solid black; font-weight: bold">
                            <td class="text-right" colspan="4">মোট আয় =</td>
                            <td class="text-center">---</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-right" colspan="4">মোট খরচ (কমিশন + খরচ) =</td>
                            <td class="text-center"></td>
                            <td class="text-center">---</td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-right" colspan="4">নীট লাভ =</td>
                            <td class="text-center">---</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="text-right" colspan="4">নীট ক্ষতি =</td>
                            <td class="text-center">0</td>
                            <td class="text-center">---</td>
                        </tr> --}}
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>  
        </div>
    </div>
</div>
@endsection