<tr>
    <td class="text-left">
        <small>
            
            @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b>
            <br>

            @if($trip->meter->previous_reading)
                @lang('cmn.start') @lang('cmn.km') <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
                @lang('cmn.end') @lang('cmn.km') <b>{{ number_format($trip->meter->current_reading) }}</b><br>
                @lang('cmn.used') @lang('cmn.km') <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
                @php $tripOilLiterSumByTripId = tripOilLiterSumByTripId($trip->id); @endphp 
                @lang('cmn.used_fuel'): <b>{{ number_format($tripOilLiterSumByTripId) }}</b> @lang('cmn.liter')<br>
                @if($tripOilLiterSumByTripId > 0)
                    @lang('cmn.mileage') @lang('cmn.km') <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByTripId, 2) }}</b><br>
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
                @lang('cmn.challan_received'): ---
            @endif

            @if($trip && $trip->note)
                <br>
                @lang('cmn.note'): <b>{{ $trip->note }}</b>
            @endif

            <div class="row mt-2">
                <div class="btn-group">
                    <a href="{{ url('trips?page_name=print&type='. $trip->type .'&group_id='. $trip->group_id) }}" target="_blank" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                    <a href="{{ url('trips?page_name=details&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="btn btn-xs mr-1 btn-primary" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                    <a href="{{ url('trips?page_name=transection&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="btn btn-xs mr-1 btn-primary" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                </div>
            </div>
           <div class="row mt-2">
                <div class="btn-group">
                    <a href="{{ url('trips?page_name=demarage&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="btn btn-xs mr-1 btn-primary" aria-label="@lang('cmn.demurrage')">@lang('cmn.demurrage')</a>
                    <a href="{{ url('trips?page_name=general_expense&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="btn btn-xs mr-1 btn-primary" aria-label="@lang('cmn.general_expense')">@lang('cmn.general_expense')</a>
                    <a href="{{ url('trips?page_name=oil_expense&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="btn btn-xs mr-1 btn-primary" aria-label="@lang('cmn.oil_expense')">@lang('cmn.oil_expense')</a>
                    <a href="{{ url('trips?page_name=meter&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="btn btn-xs btn-primary" aria-label="@lang('cmn.meter_info')">@lang('cmn.meter_info')</a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="btn-group">
                    @if(!$trip->challanHistoryReceived)
                        <button class="btn btn-xs mr-1 btn-primary" onclick="challanReceived({{ json_encode($trip) }})" title="@lang('cmn.challan_received')">@lang('cmn.challan_received')</button>
                    @endif
                    @if(Auth::user()->role->delete)
                        <button type="button" class="btn btn-xs btn-danger"  onclick="return deleteCertification({{ $trip->id  }})" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                        <form id="delete-form-{{$trip->id }}" method="POST" action="{{ url('trip-delete-all', $trip->id ) }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
            
        </small>
    </td>

    <td class="text-left">
        <small>
            @lang('cmn.challan_no'): <b>{{ $trip->number }}</b>
            <br>

            @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->date)) }}</b>
            <br>

            @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->number_plate }}</b>
            <br>

            @lang('cmn.driver'):
            @if ($trip->provider->driver->name)
                <b>{{ $trip->provider->driver->name??'---' }}</b>
                {{-- ({{ $trip->provider->driver->phone }}) --}}
            @else
                <b>---</b>
            @endif
            <br>

            @lang('cmn.helper'):
            @if ($trip->provider->helper->name)
                <b>{{ $trip->provider->helper->name??'---' }}</b>
                {{-- ({{ $trip->provider->helper->phone }}) --}}
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

            @if($trip->goods)
            @lang('cmn.goods'): <b>{{ $trip->goods??'---' }}</b>
            <br>
            @endif

            @if($trip->box)
            @lang('cmn.box_qty'): <b>{{ number_format($trip->box) }}</b> টি
            <br>
            @endif

            @if($trip->weight)
            @lang('cmn.weight'): <b>{{ number_format($trip->weight) }}</b> {{ $trip->unit->name }}
            <br>
            @endif
            
            <hr>

            <b>{{ $trip->company->company->name }}</b>
            <br>
            @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b><br>
            @lang('cmn.addv_recev'): <b>{{ number_format($trip->company->advance_fair) }}</b><br>
            
            @if($trip->company->due_fair>0)
                </small>
                <span class="text-danger"> 
                    @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b>
                </span>
                <small>
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

            @if($trip->company->demarage_due > 0)
                </small>
                <span class="text-danger"> 
                    @lang('cmn.demurrage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b>
                </span>
                <small>
            @else
                @lang('cmn.demurrage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b>
            @endif
            <br>

            @lang('cmn.demurrage_received'): <b>{{ number_format($trip->company->demarage_received) }}</b>
            <br>

            @lang('cmn.posted_by'): <br>
            <b>{{ $trip->user->first_name}} ({{ $trip->created_at->format('d M, Y h:i A') }})</b>
            @if($trip->updated_at > $trip->created_at)
                <br>
                @if($trip->updated_by)
                    @lang('cmn.post_updated_by'): <br>
                    <b>{{ $trip->user_update->first_name}} ({{ $trip->updated_at->format('d M, Y h:i A') }})</b>
                @endif
            @endif
            {{-- @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b><br> --}}
            <div class="row mt-2">
                @if(Auth::user()->role->edit)
                <a href="{{ url('trips/own-vehicle-up-down?page_name=edit&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-primary btn-xs" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>
                @endif
            </div>
        </small>
    </td>

    <td class="text-left">
        @if($trip->down_trip)
        <small>
            @lang('cmn.challan_no'): <b>{{ $trip->down_trip->number }}</b>
            <br>

            @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->down_trip->date)) }}</b>
            <br>

            @lang('cmn.vehicle'): <b>{{ $trip->down_trip->provider->vehicle->number_plate }}</b>
            <br>

            @lang('cmn.driver'):
            @if ($trip->down_trip->provider->driver->name)
                <b>{{ $trip->down_trip->provider->driver->name??'---' }}</b>
                {{-- ({{ $up_trip->provider->driver->phone }}) --}}
            @else
                <b>---</b>
            @endif
            <br>

            @lang('cmn.helper'):
            @if ($trip->down_trip->provider->helper->name)
                <b>{{ $trip->down_trip->provider->helper->name??'---' }}</b>
                {{-- ({{ $up_trip->provider->helper->phone }}) --}}
            @else
                <b>---</b>
            @endif
            <br>

            @lang('cmn.load_point'):
            @if($trip->down_trip->points)
            @php $lastKey = count($trip->down_trip->points); @endphp
            @foreach($trip->down_trip->points as $key => $point)
                @if($point->pivot->point == 'load')
                <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                @endif
            @endforeach
            @endif
            <br>

            @lang('cmn.unload_point'):
            @if($trip->down_trip->points)
            @php $lastKey = count($trip->down_trip->points); @endphp
            @foreach($trip->down_trip->points as $key => $point)
                @if($point->pivot->point == 'unload')
                <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                @endif
            @endforeach
            @endif
            <br>

            @if($trip->down_trip->buyer_name)
                @lang('cmn.buyer_name'): <b>{{ $trip->down_trip->buyer_name }}</b>
                <br>
            @endif

            @if($trip->down_trip->buyer_code)
                @lang('cmn.buyer_code'): <b>{{ $trip->down_trip->buyer_code }}</b>
                <br>
            @endif

            @if($trip->down_trip->order_no)
                @lang('cmn.order_no'): <b>{{ $trip->down_trip->order_no }}</b>
                <br>
            @endif

            @if($trip->down_trip->depu_change_bill)
                @lang('cmn.depu_change_bill'): <b>{{ number_format($trip->down_trip->depu_change_bill) }}</b>
                <br>
            @endif

            @if($trip->down_trip->gate_pass_no)
                @lang('cmn.gate_pass_no'): <b>{{ $trip->down_trip->gate_pass_no }}</b>
                <br>
            @endif

            @if($trip->down_trip->lock_no)
                @lang('cmn.lock_no'): <b>{{ $trip->down_trip->lock_no }}</b>
                <br>
            @endif

            @if($trip->down_trip->load_point_reach_time)
                @lang('cmn.load_point_reach_time'): <b>{{ date('d M, Y H:m A', strtotime($trip->down_trip->load_point_reach_time)) }}</b>
                <br>
            @endif

            @if($trip->down_trip->goods)
            @lang('cmn.goods'): <b>{{ $trip->down_trip->goods??'---' }}</b>
            <br>
            @endif

            @if($trip->down_trip->box)
            @lang('cmn.box_qty'): <b>{{ number_format($trip->down_trip->box) }}</b> টি
            <br>
            @endif

            @if($trip->down_trip->weight)
            @lang('cmn.weight'): <b>{{ number_format($trip->down_trip->weight) }}</b> {{ $trip->down_trip->unit->name }}
            <br>
            @endif
            
            <hr>

            <b>{{ $trip->down_trip->company->company->name }}</b>
            <br>
            @lang('cmn.contract_rent'): <b>{{ number_format($trip->down_trip->company->contract_fair) }}</b>
            <br>

            @lang('cmn.addv_recev'): <b>{{ number_format($trip->down_trip->company->advance_fair) }}</b>
            <br>
            
            @if($trip->down_trip->company->due_fair>0)
                </small>
                <span class="text-danger"> 
                    @lang('cmn.challan_due'): <b>{{ number_format($trip->down_trip->company->due_fair) }}</b>
                </span>
                <small>
            @else
                @lang('cmn.challan_due'): <b>{{ number_format($trip->down_trip->company->due_fair) }}</b>
            @endif
            <br>

            @if($trip->down_trip->company->demarage > $trip->down_trip->company->demarage_received)
                @lang('cmn.demurrage_charge'): <b>{{ number_format($trip->down_trip->company->demarage) }}</b>
            @else
                @lang('cmn.demurrage_charge'): <b>{{ number_format($trip->down_trip->company->demarage) }}</b>
            @endif
            <br>

            @if($trip->down_trip->company->demarage_due > 0)
                </small>
                <span class="text-danger"> 
                    @lang('cmn.demurrage_due'): <b>{{ number_format($trip->down_trip->company->demarage_due) }}</b>
                </span>
                <small>
            @else
                @lang('cmn.demurrage_due'): <b>{{ number_format($trip->down_trip->company->demarage_due) }}</b>
            @endif
            <br>

            @lang('cmn.demurrage_received'): <b>{{ number_format($trip->down_trip->company->demarage_received) }}</b>
            <br>

            {{-- @lang('cmn.discount'): <b>{{ number_format($trip->down_trip->company->deduction_fair) }}</b><br> --}}

            @lang('cmn.posted_by'): 
            <br>
            <b>{{ $trip->down_trip->user->first_name}} ({{ $trip->down_trip->created_at->format('d M, Y h:i A') }})</b>
            @if($trip->down_trip->updated_at > $trip->down_trip->created_at)
                <br>
                @if($trip->down_trip->updated_by)
                    @lang('cmn.post_updated_by'): <br>
                    <b>{{ $trip->down_trip->user_update->first_name}} ({{ $trip->down_trip->updated_at->format('d M, Y h:i A') }})</b>
                @endif
            @endif
            <div class="row mt-2">
                @if(Auth::user()->role->edit)
                <a href="{{ url('trips/own-vehicle-up-down?page_name=edit&type='. $trip->type .'&trip_id='. $trip->down_trip->id) }}" class="btn btn-primary btn-xs" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>
                @endif
            </div>
        </small>
        @else
            @lang('cmn.down_challan_did_not_added')
            <br>
            <a href="{{ url('trips/own-vehicle-up-down?page_name=create&type=own_vehicle_up_down&group_id='. $trip->group_id . '&number=' . $trip->number) }}" class="btn btn-xs btn-primary" aria-label="@lang('cmn.meter_info')"><i class="fa fa-plus"></i> @lang('cmn.add_challan')</a>
        @endif
    </td>

    @if($trip)
        @php
            // for total deposit here we consider two trip seperatly
            if($trip->down_trip){
                $total_received_rent =  ($trip->company->advance_fair + $trip->company->received_fair) + ($trip->down_trip->company->advance_fair + $trip->down_trip->company->received_fair);
            } else {
                $total_received_rent =  ($trip->company->advance_fair + $trip->company->received_fair);
            }
            // we only consider here only up trip because (first trip id) this
            $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
            $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
            $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
            $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);
        @endphp
        <td class="text-right">
            <small>
                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                    @lang('cmn.total_deposit') = <b>{{ number_format($total_received_rent) }}</b>
                    <br>
                    @php
                        $demarage_received = 0;
                        $demarage_received = $trip->company->demarage_received;
                        if($trip->down_trip && $trip->down_trip->company->demarage_received){
                            $demarage_received += $trip->down_trip->company->demarage_received;
                        }
                    @endphp

                    @lang('cmn.total_demurrage') = (+) <b>{{ number_format($demarage_received) }}</b>
                    <br>
                    
                    @lang('cmn.total_expense') = (-) <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
                </div>
                @lang('cmn.balance') = <b>{{ $net_income = number_format(($total_received_rent + $demarage_received) - ($total_general_expense_sum + $total_oil_bill_sum)) }}</b><br>
            
        
            </small>
        </td>
        <td class="text-right">
            <small>
                <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))
                <br>
                
                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                    @if($trip_general_exp_lists)
                        @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                        <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}
                        <br>
                        @endforeach
                </div>
                <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                    @endif
            </small>
        </td>
    @endif
</tr>