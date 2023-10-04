<div class="col-md-12">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th width="20%">@lang('cmn.primary_info')</th>
                        <th width="20%">@lang('cmn.vehicle_info')</th>
                        <th width="20%">@lang('cmn.transection_with_company')</th>
                        <th width="20%">@lang('cmn.income')</th>
                        <th width="20%">@lang('cmn.expense')</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class="text-left">
                            <small>
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
                                <br>

                                @if($trip && $trip->note)
                                    @lang('cmn.note'): <b>{{ $trip->note }}</b>
                                    <br>
                                @endif

                                <div class="row mt-2">
                                    <div class="btn-group">
                                        <a href="{{ url('trips?page_name=print&type='. $trip->type .'&trip_id='. $trip->id) }}" target="_blank" class="btn btn-default btn-xs mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                                        @if(Auth::user()->role->edit)
                                            <a href="{{ url('trips/own-vehicle-single?page_name=edit&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 btn-default" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>
                                        @endif
                                        <a href="{{ url('trips/own-vehicle-single?page_name=copy&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 btn-default" aria-label="@lang('cmn.copy')">@lang('cmn.copy')</a>
                                        <a href="{{ url('trips?page_name=details&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'details')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                                        <a href="{{ url('trips?page_name=transection&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'transection')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="btn-group">
                                        <a href="{{ url('trips?page_name=demarage&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'demarage')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.demurrage')">@lang('cmn.demurrage')</a>
                                        <a href="{{ url('trips?page_name=general_expense&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'general_expense')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.general_expense')">@lang('cmn.general_expense')</a>
                                        <a href="{{ url('trips?page_name=oil_expense&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'oil_expense')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.oil_expense')">@lang('cmn.oil_expense')</a>
                                        <a href="{{ url('trips?page_name=meter&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs {{ ($request['page_name'] == 'meter')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.meter_info')">@lang('cmn.meter_info')</a>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="btn-group">
                                        @if(!$trip->challanHistoryReceived)
                                        <button class="btn btn-default btn-xs mr-1" onclick="challanReceived({{ json_encode($trip) }})" title="@lang('cmn.challan_received')">@lang('cmn.challan_received')</button>
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
                                @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b>
                                <br>

                                @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->date)) }}</b>
                                <br>

                                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->number_plate }}</b>
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
                                    @lang('cmn.start') @lang('cmn.km'): <b>{{ number_format($trip->meter->previous_reading) }}</b>
                                    <br>

                                    @lang('cmn.end') @lang('cmn.km'): <b>{{ number_format($trip->meter->current_reading) }}</b>
                                    <br>

                                    @lang('cmn.used') @lang('cmn.km'): <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b>
                                    <br>

                                    @php $tripOilLiterSumByTripId = tripOilLiterSumByTripId($trip->id); @endphp 
                                    @lang('cmn.used_fuel'): <b>{{ number_format($tripOilLiterSumByTripId) }}</b> @lang('cmn.liter')
                                    <br>

                                    @if($tripOilLiterSumByTripId > 0)
                                        @lang('cmn.mileage') @lang('cmn.km'): <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByTripId, 2) }}</b>
                                        <br>
                                    @endif
                                @endif
                            </small>
                        </td>
                        <td class="text-left">
                            <small>
                                <b>{{ $trip->company->company->name }}</b>
                                <br>

                                @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b>
                                <br>

                                @lang('cmn.addv_recev'): <b>{{ number_format($trip->company->advance_fair) }}</b>
                                <br>
                                
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
                                
                                {{-- @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b><br> --}}
                                @lang('cmn.box_qty'): <b>{{ number_format($trip->box) }}</b>
                                <br>

                                @lang('cmn.weight'): <b>{{ number_format($trip->weight) }}</b> @lang('cmn.' . $trip->unit->name)
                                <br>

                                @if($trip->goods)
                                    @lang('cmn.goods'): <b>{{ $trip->goods }}</b>
                                @endif
                                
                            </small>
                        </td>
                        @if($trip)
                            @php
                                $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
                                $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
                                $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
                                $total_received_rent =  $trip->company->advance_fair + $trip->company->received_fair;
                                $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);
                            @endphp
                            <td class="text-right">
                                <small>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @lang('cmn.total_deposit') = <b>{{ number_format($total_received_rent) }}</b><br>
                                        @if($trip->company->demarage_received > 0)
                                            @lang('cmn.total_demurrage') = (+) <b>{{ number_format($trip->company->demarage_received) }}</b><br>
                                        @endif
                                        @lang('cmn.total_expense') = (-) <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
                                    </div>
                                    @lang('cmn.balance') = <b>{{ $net_income = number_format(($total_received_rent+$trip->company->demarage_received) - ($total_general_expense_sum+$total_oil_bill_sum)) }}</b><br>
                                </small>
                            </td>
                            <td class="text-right">
                                <small>
                                    <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @if($trip_general_exp_lists)
                                            @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                                            <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}<br>
                                            @endforeach
                                    </div>
                                    <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                                        @endif
                                </small>
                            </td>
                        @else
                            <td class="text-right">
                                <small>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @lang('cmn.contract_rent') = <b>---</b><br>
                                        @lang('cmn.total_expense') = <b>---</b><br>
                                    </div>
                                    @lang('cmn.net_income') = <b>---</b><br>
                                    (@lang('cmn.challan_due') = <b>---</b>,
                                    @lang('cmn.discount') = <b>---</b>)
                                </small>
                            </td>
                            <td class="text-right">
                                <small>
                                    <b>@lang('cmn.fuel') =</b> --- <br>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        <b>@lang('cmn.expense') = </b> ---<br>
                                    </div>
                                    <b>@lang('cmn.total_expense') = ---</b>
                                </small>
                            </td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('trip.trip_form.challan_received_form')