<div class="card-header">
    <form method="GET">
        <input type="hidden" name="page_name" value="{{ $page_name }}">
        <div class="row">
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
                    <select class="form-control" name="show_type">
                        <option value="trip_number_wise" {{ ($request->show_type == 'trip_number_wise')?'selected':'' }} >@lang('cmn.trip_wise')</option>
                        <option value="trip_date_wise" {{ ($request->show_type == 'trip_date_wise')?'selected':'' }} >@lang('cmn.date_wise')</option>
                    </select>
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
                    <input type="text" class="form-control" name="voucher_id" list="voucher_id_else" value="{{ old('voucher_id', $request->voucher_id) }}" placeholder="@lang('cmn.write_voucher_id_here')">
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