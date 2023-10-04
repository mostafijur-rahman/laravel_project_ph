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
                @if($trip->updated_at > $trip->created_at)
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
                @lang('cmn.addv_pay'): <b>{{ number_format($trip->provider->advance_fair) }}</b><br>
                
                @if($trip->provider->due_fair>0)
                </small>
                <span class="text-danger"> 
                    @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b><br>
                </span>
                <small>
                @else
                @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b><br>
                @endif

                @lang('cmn.demarage_fixed'): <b>{{ number_format($trip->provider->demarage) }}</b><br>
                @lang('cmn.demarage_paid'): <b>{{ number_format($trip->provider->demarage_received) }}</b><br>
                @if($trip->provider->demarage_due>0)
                </small>
                <span class="text-danger"> 
                    @lang('cmn.demarage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b><br>
                </span>
                <small>
                @else
                @lang('cmn.demarage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b><br>
                @endif
                @lang('cmn.discount'): <b>{{ number_format($trip->provider->deduction_fair) }}</b><br>
                @lang('cmn.goods'): <b>{{ $trip->goods??'---' }}</b><br>
            </td>
            <td class="text-left">
                <b>{{ $trip->company->company->name }}</b><br>
                @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b><br>
                @lang('cmn.addv_recev'): <b>{{ number_format($trip->company->advance_fair) }}</b><br>
                
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
                @lang('cmn.demarage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b><br>
                @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b><br>
                কার্টুন সংখ্যা: <b>{{ number_format($trip->box) }}</b> টি<br>
                ওজন: <b>{{ number_format($trip->weight) }}</b> {{ $trip->unit->name }}<br>
            </td>
            <td class="text-right">
                @lang('cmn.contract_commission') = <b>{{ number_format($trip->company->contract_fair - $trip->provider->contract_fair) }}</b><br>
                কোম্পানী থেকে গ্রহণ = <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b><br>
                ভাড়া বাবদ প্রদান = <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b><br>
                <hr>
                @lang('cmn.commission_received') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair) - ($trip->provider->advance_fair+$trip->provider->received_fair)) }}</b><br>
                @lang('cmn.demarage_commission') = <b>{{ number_format($trip->company->demarage_received - $trip->provider->demarage_received) }}</b><br>
                <hr>
                @lang('cmn.total_commission') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair+$trip->company->demarage_received) - ($trip->provider->advance_fair+$trip->provider->received_fair+$trip->provider->demarage_received)) }}</b><br>
            </td>
        </tr>
    </table>
</div>