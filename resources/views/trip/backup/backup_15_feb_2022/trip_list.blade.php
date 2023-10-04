@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <form method="get" action="">
                    <input type="hidden" name="page" value="list">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="trip_number" value="{{ old('number', $request->trip_number) }}" placeholder="@lang('cmn.write_trip_number_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="vehicle_number" value="{{ old('vehicle_number', $request->vehicle_number) }}" placeholder="@lang('cmn.write_vehicle_number_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2" name="vehicle_id">
                                    <option value="">@lang('cmn.all_vehicle')</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->number_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                <a href="{{ url('trips?page=create') }}" class="btn btn-md btn-success">@lang('cmn.challan_create')</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th width="30%">@lang('cmn.primary_info')</th>
                            <th width="30%">গাড়ীর লেনদেন</th>
                            <th width="20%">কোম্পানীর লেনদেন</th>
                            <th width="20%">কমিশন</th>
                            <th width="20%">ট্রিপের জমা - খরচ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($trips)>0)
                            @foreach($trips as $trip)
                            <tr>
                                <td class="text-left">
                                    <small>
                                        @if($trip->account_take_date)
                                            @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                        @endif
                                        @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
                                        @if ($trip->provider->vehicle_id)
                                        @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->vehicle_number }}</b> <span class="badge badge-success">@lang('cmn.own')</span><br>
                                        @lang('cmn.driver'): <b>{{ $trip->provider->vehicle->driver->name }} ({{ $trip->provider->vehicle->driver->phone }})</b><br>
                                        @else
                                        @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> <span class="badge badge-warning">@lang('cmn.from_market')</span><br>
                                        @lang('cmn.driver'): <b>{{ $trip->provider->driver_name??'---' }} {{ $trip->provider->driver_phone?'('.$trip->provider->driver_phone.')':'' }}</b><br>
                                        @lang('cmn.owner'): <b>{{ $trip->provider->owner_name??'---' }} {{ $trip->provider->owner_phone?'('.$trip->provider->owner_phone.')':'' }}</b><br>
                                        @lang('cmn.reference'): <b>{{ $trip->provider->reference_name??'---' }} {{ $trip->provider->reference_phone?'('.$trip->provider->reference_phone.')':'' }}</b><br>
                                        @endif
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
                                        @lang('cmn.created'): <b>{{ $trip->user->first_name}}</b><br>
                                        <div class="row">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-warning btn-xs mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                                                <a href="{{ url('trips?page=edit&group_id='. $trip->group_id) }}" class="btn btn-info btn-xs mr-1" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>
                                                <a href="{{ url('trips?page=details&group_id='. $trip->group_id) }}" class="btn btn-secondary btn-xs mr-1" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                                                <a href="{{ url('trips?page=transection&group_id='. $trip->group_id) }}" class="btn btn-primary btn-xs mr-1" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                                                <a href="{{ url('trips?page=copy&group_id='. $trip->group_id) }}" class="btn btn-success btn-xs" aria-label="@lang('cmn.copy')">@lang('cmn.copy')</a>
                                            </div>
                                        </div>
                                    </small>
                                </td>
                                <td class="text-left">
                                    <small>
                                    @if($trip->getTripsByGroupId)
                                        @php $tripLastKey = count($trip->getTripsByGroupId); @endphp
                                        @foreach($trip->getTripsByGroupId as $tripKey => $trip_info)
                                            @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip_info->date)) }}</b><br>
                                            @lang('cmn.load_point'): <br>
                                            @if($trip_info->points)
                                            @php $lastKey = count($trip_info->points); @endphp
                                            @foreach($trip_info->points as $key => $point)
                                                @if($point->pivot->point == 'load')
                                                <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                                @endif
                                            @endforeach
                                            @endif
                                            <br>
                                            @lang('cmn.unload_point'): <br>
                                            @if($trip_info->points)
                                            @php $lastKey = count($trip_info->points); @endphp
                                            @foreach($trip_info->points as $key => $point)
                                                @if($point->pivot->point == 'unload')
                                                <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                                @endif
                                            @endforeach
                                            @endif
                                            <br>
                                            @lang('cmn.contract_rent'): <b>{{ number_format($trip_info->provider->contract_fair) }}</b><br>
                                            @if($trip_info->provider->received_fair==0)
                                            @lang('cmn.addv_pay'): <b>{{ number_format($trip_info->provider->advance_fair) }}</b><br>
                                            @else
                                            @lang('cmn.total_pay'): <b>{{ number_format($trip_info->provider->advance_fair+$trip_info->provider->received_fair) }}</b><br>
                                            @endif
                                            @if($trip_info->provider->due_fair>0)
                                            </small>
                                            <span class="text-danger"> 
                                                @lang('cmn.challan_due'): <b>{{ number_format($trip_info->provider->due_fair) }}</b><br>
                                            </span>
                                            <small>
                                            @else
                                            @lang('cmn.challan_due'): <b>{{ number_format($trip_info->provider->due_fair) }}</b><br>
                                            @endif
                                            @lang('cmn.demarage_fixed'): <b>{{ number_format($trip_info->provider->demarage) }}</b><br>
                                            @lang('cmn.demarage_paid'): <b>{{ number_format($trip_info->provider->demarage_received) }}</b><br>
                                            @if($trip_info->provider->demarage_due>0)
                                            </small>
                                            <span class="text-danger"> 
                                                @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->provider->demarage_due) }}</b><br>
                                            </span>
                                            <small>
                                            @else
                                            @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->provider->demarage_due) }}</b><br>
                                            @endif
                                            @lang('cmn.discount'): <b>{{ number_format($trip_info->provider->deduction_fair) }}</b><br>
                                            @lang('cmn.goods'): <b>{{ $trip_info->goods }}</b><br>
                                            {{-- @if(($tripKey+1) != $tripLastKey)
                                                <a class="btn btn-xs btn-danger" href="{{ url('new-trip-delete', $trip_info->id) }}" onclick="return confirm(`@lang('cmn.are_you_sure')`);" title="@lang('cmn.delete')">@lang('cmn.delete')</a>
                                                <br><br>
                                            @endif--}}
                                            {{-- @if($tripKey == 0 && $tripKey+1 == $tripLastKey)
                                            @endif --}}
                                            <button type="button" class="btn btn-xs btn-danger"  onclick="return deleteCertification({{ $trip_info->id  }})" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                                            <form id="delete-form-{{$trip_info->id }}" method="POST" action="{{ url('trip-delete-all', $trip_info->id ) }}" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form><br>
                                        @endforeach
                                    @endif
                                    </small>
                                </td>
                                <td class="text-left">
                                    <small>
                                        @lang('cmn.company'): <b>{{ $trip_info->company->company->name }}</b><br>
                                        @lang('cmn.contract_rent'): <b>{{ number_format($trip_info->company->contract_fair) }}</b><br>
                                        @if($trip_info->company->received_fair==0)
                                        @lang('cmn.addv_recev'): <b>{{ number_format($trip_info->company->advance_fair) }}</b><br>
                                        @else
                                        @lang('cmn.total_recev'): <b>{{ number_format($trip_info->company->advance_fair+$trip_info->company->received_fair) }}</b><br>
                                        @endif
                                        @if($trip_info->company->due_fair>0)
                                        </small>
                                        <span class="text-danger"> 
                                            @lang('cmn.challan_due'): <b>{{ number_format($trip_info->company->due_fair) }}</b><br>
                                        </span>
                                        <small>
                                        @else
                                        @lang('cmn.challan_due'): <b>{{ number_format($trip_info->company->due_fair) }}</b><br>
                                        @endif
                                        @if($trip_info->company->demarage > $trip_info->company->demarage_received)
                                        </small>
                                        <span class="text-danger"> 
                                            @lang('cmn.demarage_charge'): <b>{{ number_format($trip_info->company->demarage) }}</b><br>
                                        </span>
                                        <small>
                                        @else
                                        @lang('cmn.demarage_charge'): <b>{{ number_format($trip_info->company->demarage) }}</b><br>
                                        @endif
                                        @lang('cmn.demarage_received'): <b>{{ number_format($trip_info->company->demarage_received) }}</b><br>
                                        @if($trip_info->company->demarage_due>0)
                                        </small>
                                        <span class="text-danger"> 
                                            @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->company->demarage_due) }}</b><br>
                                        </span>
                                        <small>
                                        @else
                                        @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->company->demarage_due) }}</b><br>
                                        @endif
                                        @lang('cmn.discount'): <b>{{ number_format($trip_info->company->deduction_fair) }}</b><br>
                                        কার্টুন সংখ্যা: <b>{{ number_format($trip_info->box) }} টি</b><br>
                                        ওজন: <b>{{ number_format($trip_info->weight) }} {{ $trip_info->unit->name }}</b><br>
                                    </small>
                                </td>
                                <td class="text-right">
                                    <small>
                                        @lang('cmn.contract_commission') = <b>{{ number_format($trip_info->company->contract_fair - $trip_info->provider->contract_fair) }}</b><br>
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            কোম্পানী থেকে গ্রহণ = <b>{{ number_format($trip_info->company->advance_fair+$trip_info->company->received_fair) }}</b><br>
                                            ভাড়া বাবদ প্রদান = <b>{{ number_format($trip_info->provider->advance_fair+$trip_info->provider->received_fair) }}</b><br>
                                        </div>
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            @lang('cmn.commission_received') = <b>{{ number_format(($trip_info->company->advance_fair+$trip_info->company->received_fair) - ($trip_info->provider->advance_fair+$trip_info->provider->received_fair)) }}</b><br>
                                            @lang('cmn.demarage_commission') = <b>{{ number_format($trip_info->company->demarage_received - $trip_info->provider->demarage_received) }}</b><br>
                                        </div>
                                        @lang('cmn.total_commission') = <b>{{ number_format(($trip_info->company->advance_fair+$trip_info->company->received_fair+$trip_info->company->demarage_received) - ($trip_info->provider->advance_fair+$trip_info->provider->received_fair+$trip_info->provider->demarage_received)) }}</b><br>
                                        {{-- (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>) --}}
                                    </small>
                                </td>
                                <td class="text-right">
                                    @if($trip->provider->ownership == 'own')
                                        @php
                                            $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id);
                                            $total_general_expense_sum = tripExpenseSumByGroupId($trip->group_id);
                                            $total_oil_bill_sum =  tripOilBillSumByGroupId($trip->group_id);
                                            $total_received_rent =  $trip->provider->advance_fair + $trip->provider->received_fair;
                                            $trip_general_exp_lists = tripExpenseListSumByGroupId($trip->group_id);
                                        @endphp
                                        <small>
                                            @if ($total_oil_bill_sum>0)
                                            <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                                            @endif
                                            <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                                @if($trip_general_exp_lists)
                                                    @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                                                    <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}<br>
                                                    @endforeach
                                            </div>
                                            <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
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
                                        <small>মার্কেট থেকে গাড়ি ভাড়া নেয়া হয়েছিল</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
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
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('#reservation').daterangepicker();
    })
</script>
@endpush