<div class="invoice-box">
    <table class="table-design" cellpadding="0" cellspacing="0">
        <tr class="text-center">
            <td width="30%">@lang('cmn.primary_info')</td>
            <td width="30%">@lang('cmn.transection_with_vehicle')</td>
            <td width="20%">@lang('cmn.transection_with_company')</td>
            <td width="20%">@lang('cmn.commission')</td>
        </tr>
        <tr class="text-center">
            <td class="text-left">
                @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> (@lang('cmn.cash_commission'))<br>
                @lang('cmn.driver'): <b>{{ $trip->provider->driver_name??'---' }} {{ $trip->provider->driver_phone?'('.$trip->provider->driver_phone.')':'' }}</b><br>
                @lang('cmn.owner'): <b>{{ $trip->provider->owner_name??'---' }} {{ $trip->provider->owner_phone?'('.$trip->provider->owner_phone.')':'' }}</b><br>
                @lang('cmn.reference'): <b>{{ $trip->provider->reference_name??'---' }} {{ $trip->provider->reference_phone?'('.$trip->provider->reference_phone.')':'' }}</b><br>
                @lang('cmn.posted_by'): <br>
                <b>{{ $trip->user->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->created_at)) }})</b>
                @if($trip->updated_at > $trip->created_at)
                    <br>
                    @if($trip->updated_by)
                        @lang('cmn.post_updated_by'): <br>
                        <b>{{ $trip->user_update->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->updated_at)) }})</b>
                    @endif
                @endif
                <br>
                @if($trip->challanHistoryReceived)
                    @lang('cmn.challan_received'): <br>
                    <b>{{ $trip->challanHistoryReceived->receiver_name }} ({{ date('d M, Y', strtotime($trip->challanHistoryReceived->received_date)) }})</b>
                    @if($trip->challanHistoryReceived->note)
                    <br>@lang('cmn.note'): <b>{{ $trip->challanHistoryReceived->note }}</b>
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
                @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->date)) }}</b><br>
                @lang('cmn.load_point'):<br>
                @if($trip->points)
                @php $lastKey = count($trip->points); @endphp
                @foreach($trip->points as $key => $point)
                    @if($point->pivot->point == 'load')
                    <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                    @endif
                @endforeach
                @endif
                <br>
                @lang('cmn.unload_point'):<br>
                @if($trip->points)
                @php $lastKey = count($trip->points); @endphp
                @foreach($trip->points as $key => $point)
                    @if($point->pivot->point == 'unload')
                    <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                    @endif
                @endforeach
                @endif
                <br>
                @lang('cmn.contract_rent'): <b>{{ number_format($trip->provider->contract_fair) }}</b><br>
                @lang('cmn.discount'): <b>{{ number_format($trip->provider->deduction_fair) }}</b><br>
                @lang('cmn.goods'): <b>{{ $trip->goods??'---' }}</b><br>
            </td>
            <td class="text-left">
                <b>{{ $trip->company->company->name }}</b><br>
                @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b><br>
                @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b><br>
                @lang('cmn.box_qty'): <b>{{ number_format($trip->box) }}</b> টি<br>
                @lang('cmn.weight'): <b>{{ number_format($trip->weight) }}</b> @lang('cmn.' . $trip->unit->name)<br>
            </td>
            <td class="text-right">
                @lang('cmn.contract_commission') = <b>{{ number_format($trip->company->contract_fair - $trip->provider->contract_fair) }}</b><br>
                @lang('cmn.received_from_company') = <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b><br>
                @lang('cmn.rental_paid') = <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b><br>
                <hr>
                @lang('cmn.commission_received') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair) - ($trip->provider->advance_fair+$trip->provider->received_fair)) }}</b><br>
                @lang('cmn.demarage_commission') = <b>{{ number_format($trip->company->demarage_received - $trip->provider->demarage_received) }}</b><br>
                <hr>
                @lang('cmn.total_commission') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair+$trip->company->demarage_received) - ($trip->provider->advance_fair+$trip->provider->received_fair+$trip->provider->demarage_received)) }}</b><br>
            </td>
        </tr>
    </table>
</div>