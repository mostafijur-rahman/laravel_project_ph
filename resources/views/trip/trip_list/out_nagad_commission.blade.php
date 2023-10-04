<tr>
    <td class="text-left">
        <small>
            @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
            @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
            @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> <span class="btn btn-xs" style="color: #1f2d3d; background-color: #33ff33; border-color: #33ff33; box-shadow: none;">@lang('cmn.cash_commission')</span><br>
            @lang('cmn.driver'): <b>{{ $trip->provider->driver_name??'---' }} {{ $trip->provider->driver_phone?'('.$trip->provider->driver_phone.')':'' }}</b><br>
            @lang('cmn.owner'): <b>{{ $trip->provider->owner_name??'---' }} {{ $trip->provider->owner_phone?'('.$trip->provider->owner_phone.')':'' }}</b><br>
            @lang('cmn.reference'): <b>{{ $trip->provider->reference_name??'---' }} {{ $trip->provider->reference_phone?'('.$trip->provider->reference_phone.')':'' }}</b><br>
            @lang('cmn.posted_by'): <br>
            <b>{{ $trip->user->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->created_at)) }})</b>
            @if($trip->updated_at)
                <br>
                @if($trip->updated_by)
                    @lang('cmn.post_updated_by'): <br>
                    <b>{{ $trip->user_update->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->updated_at)) }})</b>
                @endif
            @endif
            @if($trip->challanHistoryReceived)
                @lang('cmn.challan_received'): <br>
                <b>{{ $trip->challanHistoryReceived->receiver_name }} ({{ date('d M, Y', strtotime($trip->challanHistoryReceived->received_date)) }})</b>
                <button type="button" class="btn btn-xs btn-danger"  onclick="return deleteChallanReceivedCertification({{ $trip->challanHistoryReceived->id  }})" title="@lang('cmn.delete_challan_received')">@lang('cmn.delete_challan_received')</button>
                <form id="delete-challan-received-form-{{ $trip->challanHistoryReceived->id }}" method="POST" action="{{ url('trips/challan-received', $trip->challanHistoryReceived->id) }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
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
            <div class="row mt-2">
                <div class="btn-group">
                    <a href="{{ url('trip-report?trip_id='. $trip->id) }}" target="_blank" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                    <a href="{{ url('trips?page_name=edit&type=out_nagad_commission&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>
                    <a href="{{ url('trips?page_name=copy&type=out_nagad_commission&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.copy')">@lang('cmn.copy')</a>
                    <a href="{{ url('trips?page_name=details&type=out_nagad_commission&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="btn-group">
                    <a href="{{ url('trips?page_name=general_expense&type=out_nagad_commission&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 btn-primary" aria-label="@lang('cmn.general_expense')">@lang('cmn.general_expense')</a>
                    @if(!$trip->challanHistoryReceived)
                    <button class="btn btn-primary btn-xs" onclick="challanReceived({{ json_encode($trip) }})" title="@lang('cmn.challan_received')">@lang('cmn.challan_received')</button>
                    @endif
                </div>
            </div>
        </small>
    </td>
    <td class="text-left">
        <small>
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
            @lang('cmn.contract_rent'): <b>{{ number_format($trip->provider->contract_fair) }}</b><br>
            @lang('cmn.goods'): <b>{{ $trip->goods }}</b><br>
            <button type="button" class="btn btn-xs btn-danger"  onclick="return deleteCertification({{ $trip->id  }})" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
            <form id="delete-form-{{$trip->id }}" method="POST" action="{{ url('trip-delete-all', $trip->id ) }}" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </small>
    </td>
    <td class="text-left">
        <small>
            <b>{{ $trip->company->company->name }}</b><br>
            @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b><br>
            কার্টুন সংখ্যা: <b>{{ number_format($trip->box) }} টি</b><br>
            ওজন: <b>{{ number_format($trip->weight) }} {{ $trip->unit->name }}</b><br>
        </small>
    </td>
    <td class="text-right">
        <small>
            @lang('cmn.contract_commission') = <b>{{ number_format($trip->company->contract_fair - $trip->provider->contract_fair) }}</b><br>
            <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                কোম্পানী থেকে গ্রহণ = <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b><br>
                ভাড়া বাবদ প্রদান = <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b><br>
            </div>
            <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                @lang('cmn.commission_received') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair) - ($trip->provider->advance_fair+$trip->provider->received_fair)) }}</b><br>
                @lang('cmn.demarage_commission') = <b>{{ number_format($trip->company->demarage_received - $trip->provider->demarage_received) }}</b><br>
            </div>
            @lang('cmn.total_commission') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair+$trip->company->demarage_received) - ($trip->provider->advance_fair+$trip->provider->received_fair+$trip->provider->demarage_received)) }}</b><br>
            {{-- (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>) --}}
        </small>
        <br>
        @if($trip->provider->vehicle_id)
            <b>(শুধু ট্রিপের লেনদেন)</b><br>
            <small>
                @php $in_sum = 0; $out_sum = 0; @endphp
                <!-- trip -->
                @if($trip->transactions)
                @foreach($trip->transactions as $trans)
                    @php 
                        $in_sum += ($trans->type=='in')?$trans->amount:0; 
                        $out_sum += ($trans->type=='out')?$trans->amount:0;
                    @endphp
                    {{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})<br>
                    @switch($trans->for)
                        @case('advance_has_been_received_from_the_company_for_the_trip')
                            কোম্পানী থেকে অগ্রীম গ্রহণ =
                            @break
                        @case('challan_bill_has_been_received_from_the_company_for_the_trip')
                            কোম্পানী থেকে চালান বাকী গ্রহণ =
                            @break
                        @case('demarage_has_been_received_from_the_company_for_the_trip')
                            কোম্পানী থেকে ডেমারেজ বিল গ্রহণ =
                            @break
                        @case('the_vehicle_provider_has_been_paid_in_advance_for_the_trip')
                            প্রদানকারীকে অগ্রীম প্রদান =
                            @break
                        @case('the_vehicle_provider_has_been_paid_the_challan_due_for_the_trip')
                            প্রদানকারীকে চালান বাকী প্রদান =
                            @break
                        @case('the_vehicle_provider_has_been_paid_demarage_for_the_trip')
                            প্রদানকারীকে ডেমারেজ বিল প্রদান =
                            @break
                        @default
                            <span>লেনদেনের নাম নেই</span>
                    @endswitch
                    <b class='text-green'>{{ ($trans->type=='in')?number_format($trans->amount):'' }}</b>
                    <b class='text-danger'>{{ ($trans->type=='out')?number_format($trans->amount):'' }}</b>
                    <br>
                @endforeach
                @endif
            </small>
        @endif
    </td>
    <td class="text-right">
        <b>(শুধু ট্রিপের লেনদেন)</b><br>
        <small>
            @php $in_sum = 0; $out_sum = 0; @endphp
            <!-- trip -->
            @if($trip->transactions)
            @foreach($trip->transactions as $trans)
                @php 
                    $in_sum += ($trans->type=='in')?$trans->amount:0; 
                    $out_sum += ($trans->type=='out')?$trans->amount:0;
                @endphp
                {{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})<br>
                @switch($trans->for)
                    @case('advance_has_been_received_from_the_company_for_the_trip')
                        কোম্পানী থেকে অগ্রীম গ্রহণ =
                        @break
                    @case('challan_bill_has_been_received_from_the_company_for_the_trip')
                        কোম্পানী থেকে চালান বাকী গ্রহণ =
                        @break
                    @case('demarage_has_been_received_from_the_company_for_the_trip')
                        কোম্পানী থেকে ডেমারেজ বিল গ্রহণ =
                        @break
                    @case('the_vehicle_provider_has_been_paid_in_advance_for_the_trip')
                        প্রদানকারীকে অগ্রীম প্রদান =
                        @break
                    @case('the_vehicle_provider_has_been_paid_the_challan_due_for_the_trip')
                        প্রদানকারীকে চালান বাকী প্রদান =
                        @break
                    @case('the_vehicle_provider_has_been_paid_demarage_for_the_trip')
                        প্রদানকারীকে ডেমারেজ বিল প্রদান =
                        @break
                    @case('nagad_commission_has_been_received_from_a_trip')
                        @lang('cmn.received_nagad_commission') =
                        @break
                    @default
                        <span>লেনদেনের নাম নেই</span>
                @endswitch
                <b class='text-green'>{{ ($trans->type=='in')?number_format($trans->amount):'' }}</b>
                <b class='text-danger'>{{ ($trans->type=='out')?number_format($trans->amount):'' }}</b>
                <br>
            @endforeach
            @endif
        </small>
    </td>
</tr>