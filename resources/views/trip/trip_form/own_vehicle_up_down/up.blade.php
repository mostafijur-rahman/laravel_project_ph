<div class="card">
    <div class="card-header">
        <h4 class="card-title w-100 text-primary">
            <b>@lang('cmn.up_challan')</b>
        </h4> 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.trip_starting_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <div class="input-group date" id="trip_starting_date" data-target-input="nearest">
                        <input type="text" name="up_date" value="{{ (isset($trip->date))?date('d/m/Y', strtotime($trip->date)):date('d/m/Y') }}" class="form-control datetimepicker-input {{ $errors->has('up_date') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                        <div class="input-group-append" data-target="#trip_starting_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        @if ($errors->has('up_date'))
                            <span class="error invalid-feedback">{{ $errors->first('up_date') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.driver_select') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select  class="form-control select2 {{ $errors->has('up_driver_id') ? 'is-invalid' : '' }}" name="up_driver_id" id="up_driver_id">
                        <option value="">@lang('cmn.please_select')</option>
                        @if(isset($staffs))
                            @foreach($staffs as $staff)
                                @if($staff->designation_id == 1)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('up_driver_id'))
                        <span class="error invalid-feedback">{{ $errors->first('up_driver_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.helper_select')</label>
                    <select  class="form-control select2 {{ $errors->has('up_helper_id') ? 'is-invalid' : '' }}" name="up_helper_id" id="up_helper_id">
                        <option value="">@lang('cmn.please_select')</option>
                        @if(isset($staffs))
                            @foreach($staffs as $staff)
                                @if($staff->designation_id == 2)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('up_helper_id'))
                        <span class="error invalid-feedback">{{ $errors->first('up_helper_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.load_point') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select class="form-control select2 {{ $errors->has('up_load_id') ? 'is-invalid' : '' }}" multiple="multiple" data-placeholder="@lang('cmn.please_select')" style="width: 100%;" name="up_load_id[]" required>
                        @if(isset($areas))
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ (isset($load))?in_array($area->id, $load)?'selected':'':'' }}>{{ $area->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('up_load_id'))
                        <span class="error invalid-feedback">{{ $errors->first('up_load_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.unload_point') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select class="form-control select2 {{ $errors->has('up_unload_id') ? 'is-invalid' : '' }}" multiple="multiple" data-placeholder="@lang('cmn.please_select')" style="width: 100%;" name="up_unload_id[]" required>
                        @if(isset($areas))
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ (isset($unload))?in_array($area->id, $unload)?'selected':'':'' }}>{{ $area->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('up_unload_id'))
                        <span class="error invalid-feedback">{{ $errors->first('up_unload_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.box_qty')</label>
                    <input type="number" min="0" step="1" class="form-control {{ $errors->has('up_box') ? 'is-invalid' : '' }}" name="up_box" value="{{ old('up_box',$trip->box??'') }}" placeholder="@lang('cmn.amount_here')">
                    @if ($errors->has('up_box'))
                        <span class="error invalid-feedback">{{ $errors->first('up_box') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.weight')</label>
                    <input type="number" min="0" step="1" class="form-control {{ $errors->has('up_weight') ? 'is-invalid' : '' }}" name="up_weight" value="{{ old('up_weight',$trip->weight??'') }}" placeholder="@lang('cmn.qty')">
                    @if ($errors->has('up_weight'))
                        <span class="error invalid-feedback">{{ $errors->first('up_weight') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.unit')</label>
                    <select id="end" class="form-control {{ $errors->has('up_unit_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="up_unit_id">
                        @if(isset($units))
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('up_unit_id',$trip->unit_id??'')==$unit->id ? 'selected':'' }}>@lang('cmn.' . $unit->name)</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('up_unit_id'))
                        <span class="error invalid-feedback">{{ $errors->first('up_unit_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.about_goods')</label>
                    <textarea class="form-control {{ $errors->has('up_goods') ? 'is-invalid' : '' }}" name="up_goods" rows="2" placeholder="@lang('cmn.about_goods')">{{ old('up_goods',$trip->goods??'') }}</textarea>
                    @if ($errors->has('up_goods'))
                        <span class="error invalid-feedback">{{ $errors->first('up_goods') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.note')</label>
                    <textarea class="form-control {{ $errors->has('up_note') ? 'is-invalid' : '' }}" name="up_note" rows="2" placeholder="@lang('cmn.you_can_write_any_note_here')">{{ old('up_note', $trip->note??'') }}</textarea>
                    @if ($errors->has('up_note'))
                        <span class="error invalid-feedback">{{ $errors->first('up_note') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.company') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select  class="form-control select2 {{ $errors->has('up_company_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="up_company_id" required>
                        @if(isset($companies))
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id',($trip->company->company_id)??'')==$company->id ? 'selected':'' }}>{{ $company->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('up_company_id'))
                        <span class="error invalid-feedback">{{ $errors->first('up_company_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.contract_rent')</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('up_com_contract_fair') ? 'is-invalid' : '' }}" name="up_com_contract_fair" value="{{ old('up_com_contract_fair', (($trip && $trip->company->contract_fair) ? (float) $trip->company->contract_fair:0)) }}" placeholder="@lang('cmn.amount_here')" {{ ($request->page_name =='edit')?'disabled':''}}>
                    @if ($errors->has('up_com_contract_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('up_com_contract_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>অগ্রিম গ্রহণ</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('up_com_advance_fair') ? 'is-invalid' : '' }}" name="up_com_advance_fair" value="{{ old('up_com_advance_fair', (($trip && $trip->company->advance_fair) ? (float) $trip->company->advance_fair:0)) }}" placeholder="@lang('cmn.amount_here')" {{ ($request->page_name =='edit')?'disabled':''}}>
                    @if ($errors->has('up_com_advance_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('up_com_advance_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.received_account')</label>
                    <select class="form-control select2 {{ $errors->has('up_com_account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="up_com_account_id" {{ ($request->page_name =='edit')?'disabled':''}}>
                        @if(isset($accounts))
                        @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('up_com_account_id'))
                        <span class="error invalid-feedback">{{ $errors->first('up_com_account_id') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>