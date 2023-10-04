<tr>
    @if($request->has('primary_info') && $request->has('primary_info') == 'on')
    <td class="text-left">
        @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
        @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
        @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->vehicle_number }}</b> (@lang('cmn.own_vehicle'))<br>
        @lang('cmn.driver'): <b>{{ $trip->provider->vehicle->driver->name }} ({{ $trip->provider->vehicle->driver->phone }})</b><br>
        @if($trip->meter->previous_reading)
            @lang('cmn.start_reading'): <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
            @lang('cmn.last_reading'): <b>{{ number_format($trip->meter->current_reading) }}</b><br>
            @lang('cmn.total') @lang('cmn.km'): <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
            @php $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id); @endphp 
            @lang('cmn.total') @lang('cmn.fuel'): <b>{{ number_format($tripOilLiterSumByGroupId) }}</b><br>
            @if($tripOilLiterSumByGroupId > 0)
                @lang('cmn.liter_per_km'): <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}</b><br>
            @endif
        @endif
        @lang('cmn.posted_by'): <br>
        <b>{{ $trip->user->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->created_at)) }})</b>
        @if($trip->updated_at)
            <br>
            @if($trip->updated_by)
                @lang('cmn.post_updated_by'): <br>
                <b>{{ $trip->user_update->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->updated_at)) }})</b>
            @endif
        @endif
        @if($trip && $trip->note)
        <div class="row mt-2">
            @lang('cmn.note'): <b>{{ $trip->note }}</b>
        </div>
        @endif
    </td>
    @endif
    @if($request->has('vehicle_transection') && $request->has('vehicle_transection') == 'on')
    <td class="text-left">
        @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->date)) }}</b><br>
        @lang('cmn.load_point'): <br>
        @if($trip->points)
        @php $lastKey = count($trip->points); @endphp
        @foreach($trip->points as $key => $point)
            @if($point->pivot->point == 'load')
            <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
            @endif
        @endforeach
        @endif
        <br>
        @lang('cmn.unload_point'): <br>
        @if($trip->points)
        @php $lastKey = count($trip->points); @endphp
        @foreach($trip->points as $key => $point)
            @if($point->pivot->point == 'unload')
            <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
            @endif
        @endforeach
        @endif
        <br>
        @lang('cmn.goods'): <b>{{ $trip->goods }}</b><br>
    </td>
    @endif
    @if($request->has('company_transection') && $request->has('company_transection') == 'on')
        <td class="text-left">
            <b>{{ $trip->company->company->name }}</b><br>
            @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b><br>
            @if($trip->company->received_fair==0)
            @lang('cmn.addv_recev'): <b>{{ number_format($trip->company->advance_fair) }}</b><br>
            @else
            @lang('cmn.total_recev'): <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b><br>
            @endif
            @if($trip->company->due_fair>0)
            </small>
            <span class="text-danger"> 
                @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b><br>
            </span>
            <small>
            @else
            @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b><br>
            @endif
            @if($trip->company->demarage > $trip->company->demarage_received)
            </small>
            <span class="text-danger"> 
                @lang('cmn.demarage_charge'): <b>{{ number_format($trip->company->demarage) }}</b><br>
            </span>
            <small>
            @else
            @lang('cmn.demarage_charge'): <b>{{ number_format($trip->company->demarage) }}</b><br>
            @endif
            @lang('cmn.demarage_received'): <b>{{ number_format($trip->company->demarage_received) }}</b><br>
            @if($trip->company->demarage_due>0)
            </small>
            <span class="text-danger"> 
                @lang('cmn.demarage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b><br>
            </span>
            <small>
            @else
            @lang('cmn.demarage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b><br>
            @endif
            @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b><br>
            @lang('cmn.box_qty'):  <b>{{ number_format($trip->box) }} টি</b><br>
            @lang('cmn.weight'): <b>{{ number_format($trip->weight) }} {{ $trip->unit->name }}</b><br>
        </td>
    @endif
    @if($request->has('comission') && $request->has('comission') == 'on')
        <td class="text-right">
            @php
                $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
                $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
                $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
                $total_received_rent =  $trip->company->advance_fair + $trip->company->received_fair;
                $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);
            @endphp
            <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                @lang('cmn.total_deposit') = <b>{{ number_format($total_received_rent) }}</b><br>
                @if($trip->company->demarage_received > 0)
                    @lang('cmn.total_demarage') = (+) <b>{{ number_format($trip->company->demarage_received) }}</b><br>
                @endif
                @lang('cmn.total_expense') = (-) <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
            </div>
            @lang('cmn.net_income') = <b>{{ $net_income = number_format(($total_received_rent+ $trip->company->demarage_received) - ($total_general_expense_sum+$total_oil_bill_sum)) }}</b><br>
        </td>
    @endif
    @if($request->has('trip_deposit_expense') && $request->has('trip_deposit_expense') == 'on')
    <td class="text-right">
        <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
            @if($trip_general_exp_lists)
                @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}<br>
                @endforeach
        </div>
        <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
            @endif
    </td>
    @endif
</tr>