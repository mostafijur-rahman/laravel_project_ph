<div class="card-header">
    <form method="GET">
        <input type="hidden" name="page_name" value="challan_paid">
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
                    <input type="text" class="form-control" name="trip_number" list="challan_number_else" value="{{ old('trip_number', $request->trip_number) }}" placeholder="@lang('cmn.write_trip_number_here')">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="vehicle_number" list="vehicle_number_else" value="{{ old('vehicle_number', $request->vehicle_number) }}" placeholder="@lang('cmn.vehicle_number_from_market')">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control select2" name="vehicle_id">
                        <option value="">@lang('cmn.all_vehicle')</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id',$request->vehicle_id)==$vehicle->id?'selected':'' }}  vehicle_id>{{ $vehicle->vehicle_number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="voucher_id" list="voucher_id_else" value="{{ old('voucher_id', $request->voucher_id) }}" placeholder="@lang('cmn.write_voucher_id_here')">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                    <a href="{{ url('companies?page_name=challan_paid&per_page=100&order_by=desc') }}" class="btn btn-sm btn-info"><i class="fa fa-times"></i> @lang('cmn.clear')</a>
                </div>
            </div>
        </div>
    </form> 
</div>