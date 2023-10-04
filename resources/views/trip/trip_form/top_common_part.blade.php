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
        
        @if($request->group_id && $request->page_name=='create' && $request->type=='own_vehicle_up_down')
            <input type="hidden" name="group_id" value="{{ $trip_add->group_id }}">
            {{-- <input type="hidden" name="number" value="{{ $trip_add->number }}"> --}}
        @endif

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
                <label>@lang('cmn.trip_starting_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                <div class="input-group date" id="trip_starting_date" data-target-input="nearest">
                    <input type="text" name="date" value="{{ (isset($trip->date))?date('d/m/Y', strtotime($trip->date)):date('d/m/Y') }}" class="form-control datetimepicker-input {{ $errors->has('date') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                    <div class="input-group-append" data-target="#trip_starting_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    @if ($errors->has('date'))
                        <span class="error invalid-feedback">{{ $errors->first('date') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.load_point') <small class="text-danger">(@lang('cmn.required'))</small></label>
                <select id="start" class="form-control select2 {{ $errors->has('load_id') ? 'is-invalid' : '' }}" multiple="multiple" data-placeholder="@lang('cmn.please_select')" style="width: 100%;" name="load_id[]" required>
                    @if(isset($areas))
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ (isset($load))?in_array($area->id, $load)?'selected':'':'' }}>{{ $area->name }}</option>
                    @endforeach
                    @endif
                </select>
                @if ($errors->has('load_id'))
                    <span class="error invalid-feedback">{{ $errors->first('load_id') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.unload_point') <small class="text-danger">(@lang('cmn.required'))</small></label>
                <select id="end" class="form-control select2 {{ $errors->has('unload_id') ? 'is-invalid' : '' }}" multiple="multiple" data-placeholder="@lang('cmn.please_select')" style="width: 100%;" name="unload_id[]" required>
                    @if(isset($areas))
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ (isset($unload))?in_array($area->id, $unload)?'selected':'':'' }}>{{ $area->name }}</option>
                    @endforeach
                    @endif
                </select>
                @if ($errors->has('unload_id'))
                    <span class="error invalid-feedback">{{ $errors->first('unload_id') }}</span>
                @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.buyer_name')</label>
                <input type="text" class="form-control {{ $errors->has('buyer_name') ? 'is-invalid' : '' }}" name="buyer_name" value="{{ old('buyer_name',$trip->buyer_name??'') }}" placeholder="@lang('cmn.buyer_name')">
                @if ($errors->has('buyer_name'))
                    <span class="error invalid-feedback">{{ $errors->first('buyer_name') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.buyer_code')</label>
                <input type="text" class="form-control {{ $errors->has('buyer_code') ? 'is-invalid' : '' }}" name="buyer_code" value="{{ old('buyer_code',$trip->buyer_code??'') }}" placeholder="@lang('cmn.buyer_code')">
                @if ($errors->has('buyer_code'))
                    <span class="error invalid-feedback">{{ $errors->first('buyer_code') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.order_no')</label>
                <input type="text" class="form-control {{ $errors->has('order_no') ? 'is-invalid' : '' }}" name="order_no" value="{{ old('order_no',$trip->order_no??'') }}" placeholder="@lang('cmn.order_no')">
                @if ($errors->has('order_no'))
                    <span class="error invalid-feedback">{{ $errors->first('order_no') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.depu_change_bill')</label>
                <input type="number" min="0" step="1" class="form-control {{ $errors->has('depu_change_bill') ? 'is-invalid' : '' }}" name="depu_change_bill" value="{{ old('depu_change_bill', (($trip && $trip->depu_change_bill) ? (float) $trip->depu_change_bill:0)) }}" placeholder="@lang('cmn.depu_change_bill')">
                @if ($errors->has('depu_change_bill'))
                    <span class="error invalid-feedback">{{ $errors->first('depu_change_bill') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.gate_pass_no')</label>
                <input type="text" class="form-control {{ $errors->has('gate_pass_no') ? 'is-invalid' : '' }}" name="gate_pass_no" value="{{ old('gate_pass_no',$trip->gate_pass_no??'') }}" placeholder="@lang('cmn.gate_pass_no')">
                @if ($errors->has('gate_pass_no'))
                    <span class="error invalid-feedback">{{ $errors->first('gate_pass_no') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.lock_no')</label>
                <input type="text" class="form-control {{ $errors->has('lock_no') ? 'is-invalid' : '' }}" name="lock_no" value="{{ old('lock_no',$trip->lock_no??'') }}" placeholder="@lang('cmn.lock_no')">
                @if ($errors->has('lock_no'))
                    <span class="error invalid-feedback">{{ $errors->first('lock_no') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.load_point_reach_time')</label>
                <input type="datetime-local" class="form-control {{ $errors->has('load_point_reach_time') ? 'is-invalid' : '' }}" name="load_point_reach_time" value="{{ old('load_point_reach_time',$trip->load_point_reach_time??'') }}" placeholder="@lang('cmn.load_point_reach_time')">
                @if ($errors->has('load_point_reach_time'))
                    <span class="error invalid-feedback">{{ $errors->first('load_point_reach_time') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.box_qty')</label>
                <input type="number" min="0" step="1" class="form-control {{ $errors->has('box') ? 'is-invalid' : '' }}" name="box" value="{{ old('box',$trip->box??'') }}" placeholder="@lang('cmn.amount_here')">
                @if ($errors->has('box'))
                    <span class="error invalid-feedback">{{ $errors->first('box') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.weight')</label>
                <input type="number" min="0" step="1" class="form-control {{ $errors->has('weight') ? 'is-invalid' : '' }}" name="weight" value="{{ old('weight',$trip->weight??'') }}" placeholder="@lang('cmn.qty')">
                @if ($errors->has('weight'))
                    <span class="error invalid-feedback">{{ $errors->first('weight') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.unit')</label>
                <select id="end" class="form-control {{ $errors->has('unit_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="unit_id">
                    @if(isset($units))
                    @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id',$trip->unit_id??'')==$unit->id ? 'selected':'' }}>@lang('cmn.' . $unit->name)</option>
                    @endforeach
                    @endif
                </select>
                @if ($errors->has('unit_id'))
                    <span class="error invalid-feedback">{{ $errors->first('unit_id') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.about_goods')</label>
                <textarea class="form-control {{ $errors->has('goods') ? 'is-invalid' : '' }}" name="goods" rows="1" placeholder="@lang('cmn.about_goods')">{{ old('goods',$trip->goods??'') }}</textarea>
                @if ($errors->has('goods'))
                    <span class="error invalid-feedback">{{ $errors->first('goods') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.note')</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" rows="1" placeholder="@lang('cmn.you_can_write_any_note_here')">{{ old('note',$trip->note??'') }}</textarea>
                @if ($errors->has('note'))
                    <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
@include('trip.trip_form.common_js')