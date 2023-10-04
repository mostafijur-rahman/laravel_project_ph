<!-- /.card-header -->
<div class="card-header">
    <form method="get" action="">
        <input type="hidden" name="page_name" value="list">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <select name="per_page" class="form-control">
                        <option value="50" {{ old('50', $request->per_page)=='50' ? 'selected':'' }}>@lang('cmn.5')@lang('cmn.0')</option>
                        <option value="100" {{ old('100', $request->per_page)=='100' ? 'selected':'' }}>@lang('cmn.1')@lang('cmn.0')@lang('cmn.0')</option>
                        <option value="500" {{ old('500', $request->per_page)=='500' ? 'selected':'' }}>@lang('cmn.5')@lang('cmn.0')@lang('cmn.0')</option>
                        <option value="1000" {{ old('1000', $request->per_page)=='1000' ? 'selected':'' }}>@lang('cmn.1')@lang('cmn.0')@lang('cmn.0')@lang('cmn.0')</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="order_by" class="form-control">
                        <option value="asc" {{ old('asc',$request->order_by)=='asc' ? 'selected':'' }}>@lang('cmn.from_start')</option>
                        <option value="desc" {{ old('desc',$request->order_by)=='desc' ? 'selected':'' }}>@lang('cmn.from_end')</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="type" class="form-control">
                        <option value="own_vehicle_single" {{ old('own_vehicle_single', $request->type)=='own_vehicle_single' ? 'selected':'' }}>@lang('cmn.own_vehicle_single_challan')</option>
                        <option value="own_vehicle_up_down" {{ old('own_vehicle_up_down', $request->type)=='own_vehicle_up_down' ? 'selected':'' }}>@lang('cmn.own_vehicle_up_down_challan')</option>
                        <option value="out_commission_transection" {{ old('out_commission_transection', $request->type)=='out_commission_transection' ? 'selected':'' }}>@lang('cmn.rental_vehicle_transection_with_commission_challan')</option>
                        <option value="out_commission" {{ old('out_commission', $request->type)=='out_commission' ? 'selected':'' }}>@lang('cmn.rental_vehicle_only_commission_challan')</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="date_range_status" id="range_status_all" onchange="dateRangeVisibility('all')" class="form-control">
                        <option value="all_time" {{ old('all_time',$request->date_range_status)=='all_time' ? 'selected':'' }}>@lang('cmn.all_time')</option>
                        <option value="monthly_report" {{ old('monthly_report',$request->date_range_status)=='monthly_report' ? 'selected':'' }}>@lang('cmn.monthly_report')</option>
                        <option value="yearly_report" {{ old('yearly_report',$request->date_range_status)=='yearly_report' ? 'selected':'' }}>@lang('cmn.yearly_report')</option>
                        <option value="date_wise" {{ old('date_wise',$request->date_range_status)=='date_wise' ? 'selected':'' }}>@lang('cmn.date_wise')</option>                                
                    </select>
                </div>
            </div>
            @php
                $monthly_field_status = ($request->date_range_status == 'monthly_report')?'block':'none';
            @endphp
            <div class="col-md-3" id="month_field_all" style="display: {{ $monthly_field_status }};">
                <div class="form-group">
                    <select name="month" class="form-control">
                        <option value="">@lang('cmn.select_month')</option>
                        <option value="1" {{ old('month',$request->month)==1 ? 'selected':'' }}>@lang('cmn.january')</option>
                        <option value="2" {{ old('month',$request->month)==2 ? 'selected':'' }}>@lang('cmn.february')</option>
                        <option value="3" {{ old('month',$request->month)==3 ? 'selected':'' }}>@lang('cmn.march')</option>
                        <option value="4" {{ old('month',$request->month)==4 ? 'selected':'' }}>@lang('cmn.april')</option>
                        <option value="5" {{ old('month',$request->month)==5 ? 'selected':'' }}>@lang('cmn.may')</option>
                        <option value="6" {{ old('month',$request->month)==6 ? 'selected':'' }}>@lang('cmn.june')</option>
                        <option value="7" {{ old('month',$request->month)==7 ? 'selected':'' }}>@lang('cmn.july')</option>
                        <option value="8" {{ old('month',$request->month)==8 ? 'selected':'' }}>@lang('cmn.august')</option>
                        <option value="9" {{ old('month',$request->month)==9 ? 'selected':'' }}>@lang('cmn.september')</option>
                        <option value="10" {{ old('month',$request->month)==10 ? 'selected':'' }}>@lang('cmn.october')</option>
                        <option value="11" {{ old('month',$request->month)==11 ? 'selected':'' }}>@lang('cmn.november')</option>
                        <option value="12" {{ old('month',$request->month)==12 ? 'selected':'' }}>@lang('cmn.devember')</option>
                    </select>
                </div>
            </div>
            @php
                $year_field_status = ($request->date_range_status == 'monthly_report' || $request->date_range_status == 'yearly_report')?'block':'none';
            @endphp
            <div class="col-md-3" id="year_field_all" style="display: {{ $year_field_status }};">
                <div class="form-group">
                    <select name="year" class="form-control">
                        <option value="">@lang('cmn.select_year')</option>
                        @foreach(range(date('Y'), 2010) as $year)
                        <option value="{{$year}}" {{ old('year',$request->year)==$year? 'selected':'' }}>@lang('cmn.'.$year.'')</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @php
                $daterange_field_status = ($request->date_range_status == 'date_wise')?'block':'none';
            @endphp
            <div class="col-md-3" id="daterange_field_all" style="display: {{ $daterange_field_status }};">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="reservation_all" name="daterange" value="{{old('daterange', $request->daterange)}}">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="trip_number" list="challan_number_else" value="{{ old('number', $request->trip_number) }}" placeholder="@lang('cmn.write_trip_number_here')">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="vehicle_number" list="vehicle_number_else" value="{{ old('vehicle_number', $request->vehicle_number) }}" placeholder="@lang('cmn.write_vehicle_number_here')">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="provider_driver" list="provider_driver_name_else" value="{{ old('provider_driver', $request->provider_driver) }}" placeholder="@lang('cmn.write_driver_name_here')">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="provider_owner" list="provider_owner_name_else" value="{{ old('provider_owner', $request->provider_owner) }}" placeholder="@lang('cmn.write_owner_name_here')">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="provider_reference" list="provider_reference_name_else" value="{{ old('provider_reference', $request->provider_reference) }}" placeholder="@lang('cmn.write_reference_name_here')">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control select2" name="company_id">
                        <option value="">@lang('cmn.all_company')</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $request->company_id) == $company->id ? 'selected':'' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control select2" name="vehicle_id">
                        <option value="">@lang('cmn.all_vehicle')</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id',$request->vehicle_id)==$vehicle->id?'selected':'' }}  vehicle_id>{{ $vehicle->number_plate }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>

                    @switch(@setting('client_system.default_challan'))

                        @case('out_commission_transection')
                            <a href="{{ url('trips?page_name=list&type=out_commission_transection&per_page=50&order_by=desc') }}" class="btn btn-sm btn-info"><i class="fa fa-times"></i> @lang('cmn.clear')</a>
                            <a href="{{ url('trips/out-commission-transection?page_name=create&type=out_commission_transection') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> @lang('cmn.challan_create')</a>
                            @break

                        @case('out_commission')
                            <a href="{{ url('trips?page_name=list&type=out_commission&per_page=50&order_by=desc') }}" class="btn btn-sm btn-info"><i class="fa fa-times"></i> @lang('cmn.clear')</a>
                            <a href="{{ url('trips/out-commission?page_name=create&type=out_commission') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> @lang('cmn.challan_create')</a>
                            @break

                        @case('own_vehicle_single')
                            <a href="{{ url('trips?page_name=list&type=own_vehicle_single&per_page=50&order_by=desc') }}" class="btn btn-sm btn-info"><i class="fa fa-times"></i> @lang('cmn.clear')</a>
                            <a href="{{ url('trips/own-vehicle-single?page_name=create&type=own_vehicle_single') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> @lang('cmn.challan_create')</a>
                            @break

                        @case('own_vehicle_up_down')
                            <a href="{{ url('trips?page_name=list&type=own_vehicle_up_down&per_page=50&order_by=desc') }}" class="btn btn-sm btn-info"><i class="fa fa-times"></i> @lang('cmn.clear')</a>
                            <a href="{{ url('trips/own-vehicle-up-down?page_name=create&type=own_vehicle_up_down') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> @lang('cmn.challan_create')</a>
                            @break

                        @default
                            <a href="{{ url('trips?page_name=list&type=out_commission_transection&per_page=50&order_by=desc') }}" class="btn btn-sm btn-info"><i class="fa fa-times"></i> @lang('cmn.clear')</a>
                            <a href="{{ url('trips/out-from-market?page_name=create&type=out_commission_transection') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> @lang('cmn.challan_create')</a>
                    
                    @endswitch
                </div>
            </div>
        </div>
    </form>
</div>