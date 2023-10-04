<div class="invoice-box">
    <table class="table-design" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20%" class="text-center">@lang('cmn.primary_info')</td>
            <td width="20%" class="text-center">@lang('cmn.up_challan')</td>
            <td width="20%" class="text-center">@lang('cmn.down_challan')</td>
            <td width="20%" class="text-center">@lang('cmn.income')</td>
            <td width="20%" class="text-center">@lang('cmn.expense')</td>
        </tr>
        <tr class="text-center">
            <td class="text-left">
                
                    @if($up_trip->meter->previous_reading)
                    @lang('cmn.start') @lang('cmn.km') <b>{{ number_format($trip->meter->previous_reading) }}</b>
                    <br>

                    @lang('cmn.end') @lang('cmn.km') <b>{{ number_format($trip->meter->current_reading) }}</b>
                    <br>

                    @lang('cmn.used') @lang('cmn.km') <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b>
                    <br>

                    @php $tripOilLiterSumByTripId = tripOilLiterSumByTripId($trip->id); @endphp 
                    @lang('cmn.used_fuel'): <b>{{ number_format($tripOilLiterSumByTripId) }}</b> @lang('cmn.liter')
                    <br>
                    @if($tripOilLiterSumByTripId > 0)
                        @lang('cmn.mileage') @lang('cmn.km') <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByTripId, 2) }}</b>
                        <br>
                    @endif
                @endif

                @if($up_trip->challanHistoryReceived)
                    @lang('cmn.challan_received'):
                    <br>
                    <b>{{ $up_trip->challanHistoryReceived->receiver_name }} ({{ date('d M, Y', strtotime($up_trip->challanHistoryReceived->received_date)) }})</b>
                    @if($up_trip->challanHistoryReceived->note)
                        <br>
                        @lang('cmn.note'): <b>{{ $up_trip->challanHistoryReceived->note }}</b>
                    @endif
                @else
                    @lang('cmn.challan_received'): ---
                @endif

                @if($up_trip && $up_trip->note)
                    <br>
                    @lang('cmn.note'): <b>{{ $up_trip->note }}</b>
                @endif

            </td>
            <!-- up trip -->
            <td class="text-left">
                @lang('cmn.challan_no'): <b>{{ $up_trip->number }}</b>
                <br>

                @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($up_trip->account_take_date)) }}</b>
                <br>

                @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($up_trip->date)) }}</b>
                <br>

                @lang('cmn.vehicle'): <b>{{ $up_trip->provider->vehicle->number_plate }}</b>
                <br>

                @lang('cmn.driver'):
                @if ($up_trip->provider->driver->name)
                    <b>{{ $up_trip->provider->driver->name??'---' }}</b>
                @else
                    <b>---</b>
                @endif
                <br>

                @lang('cmn.helper'):
                @if ($up_trip->provider->helper->name)
                    <b>{{ $up_trip->provider->helper->name??'---' }}</b>
                @else
                    <b>---</b>
                @endif
                <br>

                @lang('cmn.load_point'):
                @if($up_trip->points)
                    @php $lastKey = count($up_trip->points); @endphp
                    @foreach($up_trip->points as $key => $point)
                        @if($point->pivot->point == 'load')
                        <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                        @endif
                    @endforeach
                @endif
                <br>

                @lang('cmn.unload_point'):
                @if($up_trip->points)
                    @php $lastKey = count($trip->points); @endphp
                    @foreach($up_trip->points as $key => $point)
                        @if($point->pivot->point == 'unload')
                        <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                        @endif
                    @endforeach
                @endif
                <br>

                @if($up_trip->buyer_name)
                    @lang('cmn.buyer_name'): <b>{{ $up_trip->buyer_name }}</b>
                    <br>
                @endif
    
                @if($up_trip->buyer_code)
                    @lang('cmn.buyer_code'): <b>{{ $up_trip->buyer_code }}</b>
                    <br>
                @endif
    
                @if($up_trip->order_no)
                    @lang('cmn.order_no'): <b>{{ $up_trip->order_no }}</b>
                    <br>
                @endif
    
                @if($up_trip->depu_change_bill)
                    @lang('cmn.depu_change_bill'): <b>{{ number_format($up_trip->depu_change_bill) }}</b>
                    <br>
                @endif
    
                @if($up_trip->gate_pass_no)
                    @lang('cmn.gate_pass_no'): <b>{{ $up_trip->gate_pass_no }}</b>
                    <br>
                @endif
    
                @if($up_trip->lock_no)
                    @lang('cmn.lock_no'): <b>{{ $up_trip->lock_no }}</b>
                    <br>
                @endif
    
                @if($up_trip->load_point_reach_time)
                    @lang('cmn.load_point_reach_time'): <b>{{ date('d M, Y H:m A', strtotime($up_trip->load_point_reach_time)) }}</b>
                    <br>
                @endif

                @if($up_trip->goods)
                    @lang('cmn.goods'): <b>{{ $up_trip->goods??'---' }}</b>
                    <br>
                @endif

                @if($up_trip->box)
                    @lang('cmn.box_qty'): <b>{{ number_format($up_trip->box) }}</b>
                    <br>
                @endif

                @if($up_trip->weight)
                    @lang('cmn.weight'): <b>{{ number_format($up_trip->weight) }}</b> @lang('cmn.' . $trip->unit->name)
                    <br>
                @endif
                <hr>

                <b>{{ $up_trip->company->company->name }}</b>
                <br>

                @lang('cmn.contract_rent'): <b>{{ number_format($up_trip->company->contract_fair) }}</b>
                <br>

                @lang('cmn.addv_recev'): <b>{{ number_format($up_trip->company->advance_fair) }}</b>
                <br>
                
                @if($up_trip->company->due_fair>0)
                    @lang('cmn.challan_due'): <b>{{ number_format($up_trip->company->due_fair) }}</b><br>
                @else
                    @lang('cmn.challan_due'): <b>{{ number_format($up_trip->company->due_fair) }}</b><br>
                @endif

                @if($up_trip->company->demarage > $up_trip->company->demarage_received)
                    @lang('cmn.demurrage_charge'): <b>{{ number_format($up_trip->company->demarage) }}</b>
                    <br>
                @else
                    @lang('cmn.demurrage_charge'): <b>{{ number_format($up_trip->company->demarage) }}</b>
                    <br>
                @endif

                @if($up_trip->company->demarage_due > 0)
                    @lang('cmn.demurrage_due'): <b>{{ number_format($up_trip->company->demarage_due) }}</b>
                @else
                    @lang('cmn.demurrage_due'): <b>{{ number_format($up_trip->company->demarage_due) }}</b>
                @endif
                <br>

                @lang('cmn.demurrage_received'): <b>{{ number_format($up_trip->company->demarage_received) }}</b>
                
                <hr>

                @if($up_trip->company->deduction_fair > 0)
                    <br>
                    @lang('cmn.discount'): <b>{{ number_format($up_trip->company->deduction_fair) }}</b>
                @endif

                @lang('cmn.posted_by'): 
                <br>
                <b>{{ $up_trip->user->first_name}} ({{ $up_trip->created_at->format('d M, Y h:i A') }})</b>
                @if($up_trip->updated_at > $up_trip->created_at)
                    <br>
                    @if($up_trip->updated_by)
                        @lang('cmn.post_updated_by'): <br>
                        <b>{{ $up_trip->user_update->first_name}} ({{ $up_trip->updated_at->format('d M, Y h:i A') }})</b>
                    @endif
                @endif
            </td>
            <!-- down trip -->
            <td class="text-left">

                @if($down_trip)
                    @lang('cmn.challan_no'): <b>{{ $down_trip->number }}</b>
                    <br>

                    @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($down_trip->account_take_date)) }}</b>
                    <br>

                    @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($down_trip->date)) }}</b>
                    <br>
                
                    @lang('cmn.vehicle'): <b>{{ $down_trip->provider->vehicle->number_plate }}</b>
                    <br>
                
                    @lang('cmn.driver'):
                    @if ($down_trip->provider->driver->name)
                        <b>{{ $down_trip->provider->driver->name??'---' }}</b>
                    @else
                        <b>---</b>
                    @endif
                    <br>
                
                    @lang('cmn.helper'):
                    @if ($down_trip->provider->helper->name)
                        <b>{{ $down_trip->provider->helper->name??'---' }}</b>
                    @else
                        <b>---</b>
                    @endif
                    <br>
                
                    @lang('cmn.load_point'):
                    @if($down_trip->points)
                        @php $lastKey = count($up_trip->points); @endphp
                        @foreach($down_trip->points as $key => $point)
                            @if($point->pivot->point == 'load')
                            <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                            @endif
                        @endforeach
                    @endif
                    <br>
                
                    @lang('cmn.unload_point'):
                    @if($down_trip->points)
                        @php $lastKey = count($trip->points); @endphp
                        @foreach($down_trip->points as $key => $point)
                            @if($point->pivot->point == 'unload')
                            <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                            @endif
                        @endforeach
                    @endif
                    <br>

                    @if($down_trip->buyer_name)
                        @lang('cmn.buyer_name'): <b>{{ $down_trip->buyer_name }}</b>
                        <br>
                    @endif
        
                    @if($down_trip->buyer_code)
                        @lang('cmn.buyer_code'): <b>{{ $down_trip->buyer_code }}</b>
                        <br>
                    @endif
        
                    @if($down_trip->order_no)
                        @lang('cmn.order_no'): <b>{{ $down_trip->order_no }}</b>
                        <br>
                    @endif
        
                    @if($down_trip->depu_change_bill)
                        @lang('cmn.depu_change_bill'): <b>{{ number_format($down_trip->depu_change_bill) }}</b>
                        <br>
                    @endif
        
                    @if($down_trip->gate_pass_no)
                        @lang('cmn.gate_pass_no'): <b>{{ $down_trip->gate_pass_no }}</b>
                        <br>
                    @endif
        
                    @if($down_trip->lock_no)
                        @lang('cmn.lock_no'): <b>{{ $down_trip->lock_no }}</b>
                        <br>
                    @endif
        
                    @if($down_trip->load_point_reach_time)
                        @lang('cmn.load_point_reach_time'): <b>{{ date('d M, Y H:m A', strtotime($trip->load_point_reach_time)) }}</b>
                        <br>
                    @endif

                    @if($down_trip->goods)
                        @lang('cmn.goods'): <b>{{ $down_trip->goods??'---' }}</b>
                        <br>
                    @endif
                
                    @if($down_trip->box)
                        @lang('cmn.box_qty'): <b>{{ number_format($down_trip->box) }}</b>
                        <br>
                    @endif
                
                    @if($down_trip->weight)
                        @lang('cmn.weight'): <b>{{ number_format($down_trip->weight) }}</b> @lang('cmn.' . $trip->unit->name)
                        <br>
                    @endif
                    
                    <hr>
                
                    <b>{{ $down_trip->company->company->name }}</b><br>
                    @lang('cmn.contract_rent'): <b>{{ number_format($down_trip->company->contract_fair) }}</b><br>
                    @lang('cmn.addv_recev'): <b>{{ number_format($down_trip->company->advance_fair) }}</b><br>
                    
                    @if($down_trip->company->due_fair>0)
                        @lang('cmn.challan_due'): <b>{{ number_format($down_trip->company->due_fair) }}</b><br>
                    @else
                        @lang('cmn.challan_due'): <b>{{ number_format($down_trip->company->due_fair) }}</b><br>
                    @endif

                    @if($down_trip->company->demarage > $down_trip->company->demarage_received)
                        @lang('cmn.demurrage_charge'): <b>{{ number_format($down_trip->company->demarage) }}</b>
                        <br>
                    @else
                        @lang('cmn.demurrage_charge'): <b>{{ number_format($down_trip->company->demarage) }}</b>
                        <br>
                    @endif
                    
                    @if($down_trip->company->demarage_due > 0)
                        @lang('cmn.demurrage_due'): <b>{{ number_format($down_trip->company->demarage_due) }}</b>
                    @else
                        @lang('cmn.demurrage_due'): <b>{{ number_format($down_trip->company->demarage_due) }}</b>
                    @endif
                    <br>

                    @lang('cmn.demurrage_received'): <b>{{ number_format($down_trip->company->demarage_received) }}</b>
                    
                    @if($down_trip->company->deduction_fair > 0)
                        <br>
                        @lang('cmn.discount'): <b>{{ number_format($down_trip->company->deduction_fair) }}</b>
                    @endif

                    <hr>

                    @lang('cmn.posted_by'): 
                    <br>
                    <b>{{ $down_trip->user->first_name}} ({{ $down_trip->created_at->format('d M, Y h:i A') }})</b>
                    @if($down_trip->updated_at > $down_trip->created_at)
                        <br>
                        @if($down_trip->updated_by)
                            @lang('cmn.post_updated_by'): <br>
                            <b>{{ $down_trip->user_update->first_name}} ({{ $down_trip->updated_at->format('d M, Y h:i A') }})</b>
                        @endif
                    @endif
                @else
                    @lang('cmn.down_challan_did_not_added')
                @endif
            </td>

            @if($up_trip)
                @php
                    // for total deposit here we consider two trip seperatly
                    if($down_trip){
                        $total_received_rent = ($up_trip->company->advance_fair + $up_trip->company->received_fair) + ($down_trip->company->advance_fair + $down_trip->company->received_fair);
                    } else {
                        $total_received_rent = ($up_trip->company->advance_fair + $up_trip->company->received_fair);
                    }
                    
                    // we only consider here only up trip because (first trip id) this
                    $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($up_trip->id);
                    $total_general_expense_sum = tripExpenseSumByTripId($up_trip->id);
                    $total_oil_bill_sum =  tripOilBillSumByTripId($up_trip->id);
                    $trip_general_exp_lists = tripExpenseListSumByTripId($up_trip->id);

                @endphp
                <td class="text-right">
                    @lang('cmn.total_deposit') = <b>{{ number_format($total_received_rent) }}</b>
                    <br>

                    @php
                        $demarage_received = 0;
                        $demarage_received = $up_trip->company->demarage_received;
                        if($down_trip && $down_trip->company->demarage_received){
                            $demarage_received += $down_trip->company->demarage_received;
                        }
                    @endphp
                    @lang('cmn.total_demurrage') = (+) <b>{{ number_format($demarage_received) }}</b>
                    <br>

                    @lang('cmn.total_expense') = (-) <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                    <br>
                    <hr>
                    @lang('cmn.balance') = <b>{{ $net_income = number_format(($total_received_rent + $demarage_received) - ($total_general_expense_sum + $total_oil_bill_sum)) }}</b><br>
                </td>
                <td class="text-right">
                    <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))
                    <br>
                    
                    @if($trip_general_exp_lists)
                        @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                        <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}
                        <br>
                        @endforeach
                    @endif
                    <hr>

                    <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                </td>
            @endif
        </tr>
    </table>
</div>