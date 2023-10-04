<tr>
    <td class="text-left">
        <small>
            @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b>
            <br>

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

            @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b>
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

            <br>
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
                @lang('cmn.note'): <b>{{ $trip->note }}</b>
            @endif

            <div class="row mt-2">
                <div class="btn-group">
                    <a href="{{ url('trips?page_name=print&type='. $trip->type .'&trip_id='. $trip->id) }}" target="_blank" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                    @if(Auth::user()->role->edit)
                        <a href="{{ url('trips/out-commission-transection?page_name=edit&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>
                    @endif
                    <a href="{{ url('trips/out-commission-transection?page_name=copy&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.copy')">@lang('cmn.copy')</a>
                    <a href="{{ url('trips?page_name=details&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                    @if(!$trip->challanHistoryReceived)
                    <button class="btn btn-primary btn-xs" onclick="challanReceived({{ json_encode($trip) }})" title="@lang('cmn.challan_received')">@lang('cmn.challan_received')</button>
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="btn-group">
                    <a href="{{ url('trips?page_name=transection&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                    <a href="{{ url('trips?page_name=general_expense&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 btn-primary" aria-label="@lang('cmn.general_expense')">@lang('cmn.general_expense')</a>
                    <a href="{{ url('trips?page_name=demarage&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs" aria-label="@lang('cmn.demurrage')">@lang('cmn.demurrage')</a>
                </div>
            </div>
        </small>
    </td>
    <td class="text-left">
        <small>
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
                </small>
                <span class="text-danger"> 
                    @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b>
                    <br>
                </span>
                <small>
            @else
                @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b>
                <br>
            @endif

            @lang('cmn.demurrage_fixed'): <b>{{ number_format($trip->provider->demarage) }}</b>
            <br>

            @lang('cmn.demurrage_paid'): <b>{{ number_format($trip->provider->demarage_received) }}</b>
            <br>

            @if($trip->provider->demarage_due>0)
                </small>
                <span class="text-danger"> 
                    @lang('cmn.demurrage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b><br>
                </span>
                <small>
            @else
                @lang('cmn.demurrage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b><br>
            @endif

            @lang('cmn.discount'): <b>{{ number_format($trip->provider->deduction_fair) }}</b>
            <br>

            @lang('cmn.goods'): <b>{{ $trip->goods }}</b>
            <br>
            @if(Auth::user()->role->delete)
                <button type="button" class="btn btn-xs btn-danger"  onclick="return deleteCertification({{ $trip->id  }})" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                <form id="delete-form-{{$trip->id }}" method="POST" action="{{ url('trip-delete-all', $trip->id ) }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </small>
    </td>
    <td class="text-left">
        <small>
            <b>{{ $trip->company->company->name }}</b>
            <br>

            @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b>
            <br>

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
                @lang('cmn.demurrage_charge'): <b>{{ number_format($trip->company->demarage) }}</b>
            @else
                @lang('cmn.demurrage_charge'): <b>{{ number_format($trip->company->demarage) }}</b>
            @endif
            <br>

            @lang('cmn.demurrage_received'): <b>{{ number_format($trip->company->demarage_received) }}</b>
            <br>

            @if($trip->company->demarage_due>0)
                </small>
                <span class="text-danger"> 
                    @lang('cmn.demurrage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b><br>
                </span>
                <small>
            @else
                @lang('cmn.demurrage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b><br>
            @endif

            @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b>
            <br>

            @lang('cmn.box_qty'): <b>{{ number_format($trip->box) }}</b>
            <br>

            @lang('cmn.weight'): <b>{{ number_format($trip->weight) }} @lang('cmn.' . $trip->unit->name)</b>
            <br>
        </small>
    </td>
    <td class="text-right">
        <small>
            (@lang('cmn.contract_commission') = <b>{{ number_format($trip->company->contract_fair - $trip->provider->contract_fair) }}</b>)
            <br>
            <br>
            
            <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                @lang('cmn.received_from_company') = <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b>
                <br>
                @lang('cmn.rental_paid') = (-) <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b>
                <br>
            </div>

            <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                @lang('cmn.commission') @lang('cmn.balance') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair) - ($trip->provider->advance_fair+$trip->provider->received_fair)) }}</b><br>
                @lang('cmn.demurrage_commission') = (+)<b>{{ number_format($trip->company->demarage_received - $trip->provider->demarage_received) }}</b><br>
            </div>

            @lang('cmn.total_commission') @lang('cmn.balance') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair+$trip->company->demarage_received) - ($trip->provider->advance_fair+$trip->provider->received_fair+$trip->provider->demarage_received)) }}</b><br>
            {{-- (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>) --}}
        </small>
    </td>
    <td class="text-right">
        @if($trip->provider->ownership == 'own')
            @php
                $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
                $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
                $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
                $total_received_rent =  $trip->provider->advance_fair + $trip->provider->received_fair;
                $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);
            @endphp
            <small>
                @if ($total_oil_bill_sum>0)
                <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                @endif
                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                    @if($trip_general_exp_lists)
                        @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                        {{ $trip_general_exp_list->head }} = <b>{{ number_format($trip_general_exp_list->trip_single_expense_sum) }}</b><br>
                        @endforeach
                </div>
                @lang('cmn.total_expense') = <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                    @endif
            </small>
            @if ($total_oil_bill_sum>0 || $total_general_expense_sum>0)
            <br>
            <hr>
            @endif
            <small>
                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                    @lang('cmn.rent') = <b>{{ number_format($total_received_rent) }}</b><br>
                    @lang('cmn.total_expense') = <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
                </div>
                @lang('cmn.net_income') = <b>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</b><br>
                (@lang('cmn.challan_due') = <b>{{ number_format($trip->provider->due_fair) }}</b>, @lang('cmn.discount') = <b>{{ number_format($trip->provider->deduction_fair) }}</b>)
            </small>
        @else
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
</tr>