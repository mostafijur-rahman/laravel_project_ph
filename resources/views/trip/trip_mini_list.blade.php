<div class="card">
    <div class="card-header">
        <form method="GET">
            <input type="hidden" name="page_name" value="challan_due">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="number" list="challan_number_else" value="{{ old('number', $request->number) }}" placeholder="@lang('cmn.write_trip_number_here')">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="vehicle_number" list="vehicle_number_else" value="{{ old('vehicle_number', $request->vehicle_number) }}" placeholder="@lang('cmn.write_vehicle_number_here')">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                    </div>
                </div>
            </div>
        </form> 
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-bordered text-center text-nowrap">
            <thead>
                <tr class="text-center">
                    {{-- <th width="5%">#</th> --}}
                    <th width="30%">@lang('cmn.primary_info')</th>
                    <th width="40%">গাড়ীর লেনদেন</th>
                    <th width="30%">কোম্পানীর লেনদেন</th>
                </tr>
            </thead>
            <tbody>
                @if(count($trips)>0)
                    @foreach($trips as $trip)
                    @php
                        $tripOilLiterSumByTripId = tripOilLiterSumByTripId($trip->id);
                    @endphp
                    <tr class="text-center">
                        {{-- <td>
                            <input type="checkbox" id="checkbox_trip_id_{{$trip->id}}" onclick="rowCheck({{$trip->id}})" name="trip_id" value="{{ $trip->id}}" >
                        </td> --}}
                        <td class="text-left">
                            <small>
                                @if($trip->account_take_date)
                                    @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                @endif
                                @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
                                @if ($trip->provider->vehicle_id)
                                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->vehicle_number }}</b> <span class="btn btn-xs btn-success">@lang('cmn.own')</span><br>
                                @lang('cmn.driver'): <b>{{ $trip->provider->vehicle->driver->name }} ({{ $trip->provider->vehicle->driver->phone }})</b><br>
                                @else
                                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> <span class="btn btn-xs btn-warning">@lang('cmn.from_market')</span><br>
                                @lang('cmn.driver'): <b>{{ $trip->provider->driver_name??'---' }} {{ $trip->provider->driver_phone?'('.$trip->provider->driver_phone.')':'' }}</b><br>
                                @lang('cmn.owner'): <b>{{ $trip->provider->owner_name??'---' }} {{ $trip->provider->owner_phone?'('.$trip->provider->owner_phone.')':'' }}</b><br>
                                @lang('cmn.reference'): <b>{{ $trip->provider->reference_name??'---' }} {{ $trip->provider->reference_phone?'('.$trip->provider->reference_phone.')':'' }}</b><br>
                                @endif
                                @if($trip->meter->previous_reading)
                                    @lang('cmn.start_reading'): <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
                                    @lang('cmn.last_reading'): <b>{{ number_format($trip->meter->current_reading) }}</b><br>
                                    @lang('cmn.total') @lang('cmn.km'): <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
                                    @lang('cmn.total') @lang('cmn.fuel'): <b>{{ number_format($tripOilLiterSumByTripId) }}</b><br>
                                    @if($tripOilLiterSumByTripId > 0)
                                        @lang('cmn.liter_per_km'): <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByTripId, 2) }}</b><br>
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
                                @lang('cmn.goods'): <b>{{ $trip->goods }}</b>



                            </small>
                        </td>
                        <td class="text-left">
                            <small>
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
                            </small>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="4" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        {{ $trips->appends(Request::input())->links() }}
    </div>
    <!-- /.card-footer -->
</div>
@include('include.unique_challan_numbers')
@include('include.unique_vehicle_numbers')