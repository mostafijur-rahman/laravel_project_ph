<div class="card-body">
    <div class="row">

        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.challan_no') <small class="text-danger">(@lang('cmn.required'))</small></label>
                <div class="input-group">
                    <input type="text" id="challan_number" list="challan_number_else" class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" name="number" value="{{ old('number', $trip->number??'') }}" placeholder="@lang('cmn.write_challan_no_here')" required>
                    <span class="input-group-append">
                        <button type="button" class="btn btn-primary" onclick="uniqueChallanValidation()">@lang('cmn.verify')</button>
                    </span>
                    <span id="validationMessage"></span>
                    @if ($errors->has('number'))
                        <span class="error invalid-feedback">{{ $errors->first('number') }}</span>
                    @endif
                </div>
            </div>
        </div>

        @if($request->page_name == 'create' || $request->page_name == 'copy')
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.posting_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                <div class="input-group date" id="account_take_date" data-target-input="nearest">
                    <input type="text" name="account_take_date" value="{{ (isset($trip->account_take_date))?date('d/m/Y', strtotime($trip->account_take_date)):date('d/m/Y') }}" class="form-control datetimepicker-input {{ $errors->has('account_take_date') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                    <div class="input-group-append" data-target="#account_take_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    @if ($errors->has('account_take_date'))
                        <span class="error invalid-feedback">{{ $errors->first('account_take_date') }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.vehicle_select') <small class="text-danger">(@lang('cmn.required'))</small></label>
                <select  class="form-control {{ $errors->has('vehicle_id') ? 'is-invalid' : '' }} select2" style="width: 100%;" name="vehicle_id" id="vehicle_id" onchange="getDriverAndHelper()">
                    <option value="">@lang('cmn.please_select')</option>
                    @if(isset($vehicles))
                    @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id',isset($trip->provider->vehicle_id)?$trip->provider->vehicle_id:'')==$vehicle->id ? 'selected':'' }}>{{ $vehicle->number_plate }}</option>
                    @endforeach
                    @endif
                </select>
                @if ($errors->has('vehicle_id'))
                    <span class="error invalid-feedback">{{ $errors->first('vehicle_id') }}</span>
                @endif
            </div>
        </div>

    </div>
</div>