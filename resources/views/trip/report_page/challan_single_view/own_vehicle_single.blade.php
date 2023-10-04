<div class="invoice-box">
    <table class="table-design" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20%" class="text-center">@lang('cmn.primary_info')</td>
            <td width="20%" class="text-center">@lang('cmn.vehicle_info')</td>
            <td width="20%" class="text-center">@lang('cmn.transection_with_company')</td>
            <td width="20%" class="text-center">@lang('cmn.income')</td>
            <td width="20%" class="text-center">@lang('cmn.expense')</td>
        </tr>
        <tr class="text-center">

            <td class="text-left">

                @lang('cmn.challan_no'): <b>{{ $trip->number }}</b>
                <br>

                @if($trip->buyer_name)
                    @lang('cmn.buyer_name'): <b>{{ $trip->buyer_name }}</b>
                    <br>
                @endif

                @if($trip->buyer_code)
                    @lang('cmn.buyer_code'): <b>{{ $trip->buyer_code }}</b>
                    <br>
                @endif

                @if($trip->order_no)
                    @lang('cmn.order_no'): <b>{{ $trip->order_no }}</b>
                    <br>
                @endif

                @if($trip->depu_change_bill)
                    @lang('cmn.depu_change_bill'): <b>{{ number_format($trip->depu_change_bill) }}</b>
                    <br>
                @endif

                @if($trip->gate_pass_no)
                    @lang('cmn.gate_pass_no'): <b>{{ $trip->gate_pass_no }}</b>
                    <br>
                @endif

                @if($trip->lock_no)
                    @lang('cmn.lock_no'): <b>{{ $trip->lock_no }}</b>
                    <br>
                @endif

                @if($trip->load_point_reach_time)
                    @lang('cmn.load_point_reach_time'): 
                    <br>
                    <b>{{ date('d M, Y H:m A', strtotime($trip->load_point_reach_time)) }}</b>
                    <br>
                @endif

                @lang('cmn.posted_by'):
                <br>
                <b>{{ $trip->user->first_name}} ({{ $trip->created_at->format('d M, Y h:i A') }})</b>
                <br>

                @if($trip->updated_at > $trip->created_at)
                    @if($trip->updated_by)
                        @lang('cmn.post_updated_by'): <br>
                        <b>{{ $trip->user_update->first_name}} ({{ $trip->updated_at->format('d M, Y h:i A') }})</b>
                        <br>
                    @endif
                @endif

                @if($trip->challanHistoryReceived)
                    @lang('cmn.challan_received'): 
                    <br>
                    <b>{{ $trip->challanHistoryReceived->receiver_name }} ({{ date('d M, Y', strtotime($trip->challanHistoryReceived->received_date)) }})</b>
                    @if($trip->challanHistoryReceived->note)
                        @lang('cmn.note'): <b>{{ $trip->challanHistoryReceived->note }}</b>
                        <br>
                    @endif
                @else
                    @lang('cmn.challan_received'): --- <br>
                @endif

                @if($trip && $trip->note)
                    <div class="row mt-2">
                        @lang('cmn.note'): <b>{{ $trip->note }}</b>
                    </div>
                @endif

            </td>

            <td class="text-left">

                @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b>
                <br>
                
                @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->date)) }}</b>
                <br>

                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->vehicle_number }}</b> (@lang('cmn.own_vehicle'))
                <br>

                @lang('cmn.driver'):
                @if ($trip->provider->driver->name)
                    <b>{{ $trip->provider->driver->name??'---' }} ({{ $trip->provider->driver->phone }})</b>
                @else
                    <b>---</b>
                @endif
                <br>

                @lang('cmn.helper'):
                @if ($trip->provider->helper->name)
                    <b>{{ $trip->provider->helper->name??'---' }} ({{ $trip->provider->helper->phone }})</b>
                @else
                    <b>---</b>
                @endif
                <br>
                
                @lang('cmn.load_point'):
                @if($trip->points)
                    @php $lastKey = count($trip->points); @endphp
                    @foreach($trip->points as $key => $point)
                        @if($point->pivot->point == 'load')
                        <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                        @endif
                    @endforeach
                @endif
                <br>

                @lang('cmn.unload_point'):
                @if($trip->points)
                    @php $lastKey = count($trip->points); @endphp
                    @foreach($trip->points as $key => $point)
                        @if($point->pivot->point == 'unload')
                        <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                        @endif
                    @endforeach
                @endif
                <br>

                @if($trip->meter->previous_reading)
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
                    @endif
                @endif
            </td>

            <td class="text-left">

                <b>{{ $trip->company->company->name }}</b>
                <br>

                @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b>
                <br>

                @lang('cmn.addv_recev'): <b>{{ number_format($trip->company->advance_fair) }}</b>
                <br>
                
                @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b>
                <br>

                @lang('cmn.demurrage_charge'): <b>{{ number_format($trip->company->demarage) }}</b>
                <br>

                @lang('cmn.demurrage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b>
                <br>

                @lang('cmn.demurrage_received'): <b>{{ number_format($trip->company->demarage_received) }}</b>
                <br>
                
                {{-- @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b>
                <br> --}}

                @lang('cmn.box_qty'): <b>{{ number_format($trip->box) }}</b>
                <br>

                @lang('cmn.weight'): <b>{{ number_format($trip->weight) }}</b> {{ __('cmn.' . $trip->unit->name) }}
                <br>
                
                @if($trip->goods)
                    @lang('cmn.goods'): <b>{{ $trip->goods }}</b>
                @endif
                
            </td>

            <td class="text-right">
                @if($trip)
                    @php
                        $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
                        $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
                        $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
                        $total_received_rent =  $trip->company->advance_fair + $trip->company->received_fair;
                        $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);     
                    @endphp

                    @lang('cmn.total_deposit') = <b>{{ number_format($total_received_rent) }}</b>
                    <br>
                    @lang('cmn.total_demurrage') = (+) <b>{{ number_format($trip->company->demarage_received) }}</b>
                    <br>
                    @lang('cmn.total_expense') = (-) <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                    <hr>
                    @lang('cmn.balance') = <b>{{ $net_income = number_format(($total_received_rent+ $trip->company->demarage_received) - ($total_general_expense_sum+$total_oil_bill_sum)) }}</b>
                @endif
            </td>

            <td class="text-right">
                @if($trip)
                    <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                    
                    @if($trip_general_exp_lists)
                        @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                            <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}
                            <br>
                        @endforeach
                        <hr>
                    @else
                        <b>@lang('cmn.general_expenses') = </b> 0
                        <hr>
                    @endif
                    <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                @endif
            </td>

        </tr>
    </table>
</div>