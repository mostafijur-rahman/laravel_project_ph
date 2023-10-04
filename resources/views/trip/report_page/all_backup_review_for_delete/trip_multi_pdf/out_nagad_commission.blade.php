<tr>
    @if($request->has('primary_info') && $request->has('primary_info') == 'on')
    <td class="text-left">
        @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
        @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
        @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> (@lang('cmn.cash_commission'))<br>
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
        @lang('cmn.contract_rent'): <b>{{ number_format($trip->provider->contract_fair) }}</b><br>
        @if($trip->provider->received_fair==0)
        @lang('cmn.addv_pay'): <b>{{ number_format($trip->provider->advance_fair) }}</b><br>
        @else
        @lang('cmn.total_pay'): <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b><br>
        @endif
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
            কার্টুন সংখ্যা: <b>{{ number_format($trip->box) }} টি</b><br>
            ওজন: <b>{{ number_format($trip->weight) }} {{ $trip->unit->name }}</b><br>
        
    </td>
    @endif
    @if($request->has('comission') && $request->has('comission') == 'on')
    <td class="text-right">
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
        
        <br>
        @if($trip->provider->vehicle_id)
            <b>(শুধু ট্রিপের লেনদেন)</b><br>
           
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
            
        @endif
    </td>
    @endif
    @if($request->has('trip_deposit_expense') && $request->has('trip_deposit_expense') == 'on')
    <td class="text-right">
        @if($trip->provider->ownership == 'own')
            @php
                $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
                $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
                $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
                $total_received_rent =  $trip->provider->advance_fair + $trip->provider->received_fair;
                $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);
            @endphp
           
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
            
            @if ($total_oil_bill_sum>0 || $total_general_expense_sum>0)
            <br>
            <hr>
            @endif
            
                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                    @lang('cmn.rent') = <b>{{ number_format($total_received_rent) }}</b><br>
                    @lang('cmn.total_expense') = <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
                </div>
                @lang('cmn.net_income') = <b>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</b><br>
                (@lang('cmn.challan_due') = <b>{{ number_format($trip->provider->due_fair) }}</b>, @lang('cmn.discount') = <b>{{ number_format($trip->provider->deduction_fair) }}</b>)
          
        @else
            <b>(শুধু ট্রিপের লেনদেন)</b><br>
           
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
            
        @endif
    </td>
    @endif
</tr>