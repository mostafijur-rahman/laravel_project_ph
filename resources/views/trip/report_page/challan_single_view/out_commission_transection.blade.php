<div class="invoice-box">
    <table class="table-design" cellpadding="0" cellspacing="0">
        <tr>
            <th width="20%">@lang('cmn.primary_info')</th>
            <th width="20%">@lang('cmn.transection_with_vehicle')</th>
            <th width="20%">@lang('cmn.transection_with_company')</th>
            <th width="20%">@lang('cmn.commission')</th>
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
                    @lang('cmn.load_point_reach_time'): <b>{{ date('d M, Y H:m A', strtotime($trip->load_point_reach_time)) }}</b>
                    <br>
                @endif
    
                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> <span class="btn btn-warning btn-xs">@lang('cmn.from_market')</span>
                <br>
    
                @lang('cmn.driver'): <b>{{ $trip->provider->driver_name??'---' }} {{ $trip->provider->driver_phone?'('.$trip->provider->driver_phone.')':'' }}</b>
                <br>
    
                @lang('cmn.owner'): <b>{{ $trip->provider->owner_name??'---' }} {{ $trip->provider->owner_phone?'('.$trip->provider->owner_phone.')':'' }}</b>
                <br>
    
                @lang('cmn.reference'): <b>{{ $trip->provider->reference_name??'---' }} {{ $trip->provider->reference_phone?'('.$trip->provider->reference_phone.')':'' }}</b>
                <br>
    
                @lang('cmn.posted_by'): <br>
                <b>{{ $trip->user->first_name}} ({{ $trip->created_at->format('d M, Y h:i A') }})</b>
                @if($trip->updated_at)
                    <br>
                    @if($trip->updated_by)
                        @lang('cmn.post_updated_by'): <br>
                        <b>{{ $trip->user_update->first_name}} ({{ $trip->updated_at->format('d M, Y h:i A') }})</b>
                    @endif
                @endif
    
                @if($trip->challanHistoryReceived)
                    @lang('cmn.challan_received'): <br>
                    <b>{{ $trip->challanHistoryReceived->receiver_name }} ({{ date('d M, Y', strtotime($trip->challanHistoryReceived->received_date)) }})</b>
                    
                    @if($trip->challanHistoryReceived->note)
                        <br>@lang('cmn.note'): <b>{{ $trip->challanHistoryReceived->note }}</b>
                    @endif
                @else
                    @lang('cmn.challan_received'): --- <br>
                @endif
    
                @if($trip->note)
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
    
                @lang('cmn.contract_rent'): <b>{{ number_format($trip->provider->contract_fair) }}</b>
                <br>
    
                @if($trip->provider->received_fair==0)
                    @lang('cmn.addv_pay'): <b>{{ number_format($trip->provider->advance_fair) }}</b>
                <br>
                @else
                    @lang('cmn.total_pay'): <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b>
                    <br>
                @endif
                
                @if($trip->provider->due_fair>0)
                    @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b>
                @else
                    @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b>
                @endif
                <br>
    
                @lang('cmn.demurrage_fixed'): <b>{{ number_format($trip->provider->demarage) }}</b>
                <br>
    
                @lang('cmn.demurrage_paid'): <b>{{ number_format($trip->provider->demarage_received) }}</b>
                <br>
    
                @if($trip->provider->demarage_due>0)
                    @lang('cmn.demurrage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b>
                @else
                    @lang('cmn.demurrage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b>
                @endif
                <br>
    
                @lang('cmn.discount'): <b>{{ number_format($trip->provider->deduction_fair) }}</b>
                <br>
    
                @lang('cmn.goods'): <b>{{ $trip->goods }}</b>
            </td>

            <td class="text-left">

                <b>{{ $trip->company->company->name }}</b>
                <br>
    
                @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b>
                <br>
    
                @if($trip->company->received_fair==0)
                    @lang('cmn.addv_recev'): <b>{{ number_format($trip->company->advance_fair) }}</b>
                @else
                    @lang('cmn.total_recev'): <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b>
                @endif
                <br>
    
                @if($trip->company->due_fair>0)
                    @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b>
                @else
                    @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b>
                @endif
                <br>
    
                @if($trip->company->demarage > $trip->company->demarage_received)
                    @lang('cmn.demurrage_charge'): <b>{{ number_format($trip->company->demarage) }}</b>
                @else
                    @lang('cmn.demurrage_charge'): <b>{{ number_format($trip->company->demarage) }}</b>
                @endif
                <br>
    
                @lang('cmn.demurrage_received'): <b>{{ number_format($trip->company->demarage_received) }}</b>
                <br>
    
                @if($trip->company->demarage_due>0)
                    @lang('cmn.demurrage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b>
                @else
                    @lang('cmn.demurrage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b>
                @endif
                <br>
    
                @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b>
                <br>
    
                @lang('cmn.box_qty'): <b>{{ number_format($trip->box) }}</b>
                <br>
    
                @lang('cmn.weight'): <b>{{ number_format($trip->weight) }} @lang('cmn.' . $trip->unit->name)</b>
                <br>
                
            </td>

            <td class="text-right">
                (@lang('cmn.contract_commission') = <b>{{ number_format($trip->company->contract_fair - $trip->provider->contract_fair) }}</b>)
                <br>
                <br>

                @lang('cmn.received_from_company') = <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b>
                <br>
                @lang('cmn.rental_paid') = (-) <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b>
                <hr>
            
                @lang('cmn.commission') @lang('cmn.balance') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair) - ($trip->provider->advance_fair+$trip->provider->received_fair)) }}</b>
                <br>
                @lang('cmn.demurrage_commission') = (+) <b>{{ number_format($trip->company->demarage_received - $trip->provider->demarage_received) }}</b>
                <br>
                <hr>
                @lang('cmn.total_commission') @lang('cmn.balance') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair+$trip->company->demarage_received) - ($trip->provider->advance_fair+$trip->provider->received_fair+$trip->provider->demarage_received)) }}</b>
                {{-- (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>) --}}
            </td>

        </tr>
    </table>
</div>