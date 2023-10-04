<div class="col-md-12">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th width="30%">@lang('cmn.primary_info')</th>
                        <th width="30%">@lang('cmn.vehicle_info')</th>
                        <th width="20%">@lang('cmn.transection_with_company')</th>
                        <th width="20%">@lang('cmn.commission')</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class="text-left">
                            <small>

                                @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                

                                @if($trip->meter->previous_reading)
                                    @lang('cmn.start') @lang('cmn.km') <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
                                    @lang('cmn.end') @lang('cmn.km') <b>{{ number_format($trip->meter->current_reading) }}</b><br>
                                    @lang('cmn.used') @lang('cmn.km') <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
                                    @php $tripOilLiterSumByTripId = tripOilLiterSumByTripId($trip->id); @endphp 
                                    @lang('cmn.total') @lang('cmn.fuel'): <b>{{ number_format($tripOilLiterSumByTripId) }}</b><br>
                                    @if($tripOilLiterSumByTripId > 0)
                                        @lang('cmn.mileage') @lang('cmn.km') <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByTripId, 2) }}</b><br>
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
                                @if($trip && $trip->note)
                                <div class="row mt-2">
                                    @lang('cmn.note'): <b>{{ $trip->note }}</b>
                                </div>
                                @endif
                                <div class="row mt-2">
                                    <div class="btn-group">
                                        <a href="{{ url('trip-report?trip_id='. $trip->id) }}" target="_blank" class="btn btn-default btn-xs mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                                        {{-- <a href="{{ url('trips?page_name=edit&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-default btn-xs mr-1" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a> --}}
                                        {{-- <a href="{{ url('trips?page_name=copy&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-default btn-xs mr-1" aria-label="@lang('cmn.copy')">@lang('cmn.copy')</a> --}}
                                        <a href="{{ url('trips?page_name=details&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs {{ ($request['page_name'] == 'details')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="btn-group">
                                        <a href="{{ url('trips?page_name=transection&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'transection')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                                        <a href="{{ url('trips?page_name=demarage&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'demarage')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.demarage')">@lang('cmn.demarage')</a>
                                        @if(!$trip->challanHistoryReceived)
                                        <button class="btn btn-default btn-xs" onclick="challanReceived({{ json_encode($trip) }})" title="@lang('cmn.challan_received')">@lang('cmn.challan_received')</button>
                                        @endif
                                    </div>
                                </div>
                               <div class="row mt-2">
                                    <div class="btn-group">
                                        <a href="{{ url('trips?page_name=general_expense&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'general_expense')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.general_expense')">@lang('cmn.general_expense')</a>
                                        <a href="{{ url('trips?page_name=oil_expense&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'oil_expense')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.oil_expense')">@lang('cmn.oil_expense')</a>
                                        <a href="{{ url('trips?page_name=meter&type='. $trip->type .'&trip_id='. $trip->id) }}" class="btn btn-xs {{ ($request['page_name'] == 'meter')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.meter_info')">@lang('cmn.meter_info')</a>
                                    </div>
                                </div>
                            </small>
                        </td>
                        <td class="text-left">
                            <small>
                                @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->date)) }}</b><br>
                                @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
                                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->vehicle_number }}</b> <span class="btn btn-xs" style="color: #1f2d3d; background-color: #ff33ff; border-color: #ff33ff; box-shadow: none;">@lang('cmn.own_vehicle')</span><br>
                                @lang('cmn.driver'): <b>{{ $trip->provider->driver->name??'---' }} ({{ $trip->provider->driver->phone }})</b><br>
                                @lang('cmn.helper'): <b>{{ $trip->provider->helper->name??'---' }} ({{ $trip->provider->helper->phone }})</b><br>
                                
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

                                @if($trip->provider->contract_fair > 0)
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
                                @endif
                                
                                
                                @lang('cmn.goods'): <b>{{ $trip->goods??'---' }}</b><br>
                                
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
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('trip.trip_form.challan_received_form')