<div class="col-md-12">
    <form action="{{ url($action_url) }}" method="post" id="trip_form">
        @csrf
        {{-- @if(isset($trip) && isset($trip->id))
            <input type="hidden" name="trip_id" value="{{$trip->id}}">
        @endif --}}
        {{-- @if(isset($group_id))
            <input type="hidden" name="group_id" value="{{$group_id}}">
        @endif --}}
        <!-- trip form -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-primary">
                    <b>@lang('cmn.challan_info')</b>
                </h3>
                @if($request->page_name == 'create')
                <div class="card-tools">
                    <a href="{{ url('trips?page_name=create&type=out_from_market') }}" class="btn btn-sm {{ ($request->type == 'out_from_market')?'btn-primary':'btn-default' }}">@lang('cmn.from_market')</a>
                    <a href="{{ url('trips?page_name=create&type=out_nagad_commission') }}" class="btn btn-sm {{ ($request->type == 'out_nagad_commission')?'btn-primary':'btn-default' }}">@lang('cmn.cash_commission')</a>
                    <a href="{{ url('trips?page_name=create&type=own_vehicle') }}" class="btn btn-sm {{ ($request->type == 'own_vehicle')?'btn-primary':'btn-default' }}">@lang('cmn.own_vehicle')</a>
                    <a href="{{ url('#') }}" class="btn btn-sm {{ ($request->type == 'up_down_own_vehicle')?'btn-primary':'btn-default' }}">@lang('cmn.up_down_own_vehicle')</a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.challan_no') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <input type="text" id="challan_number" list="challan_number_else" class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" name="number" value="{{ old('number', $trip->number??'') }}" placeholder="@lang('cmn.write_challan_no_here')" required>
                            @if ($errors->has('number'))
                                <span class="error invalid-feedback">{{ $errors->first('number') }}</span>
                            @endif
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
                                <option value="{{ $unit->id }}" {{ old('unit_id',$trip->unit_id??'')==$unit->id ? 'selected':'' }}>{{ $unit->name }}</option>
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
                            <label>মালের সংক্ষিপ্ত বিবরণ</label>
                            <textarea class="form-control {{ $errors->has('goods') ? 'is-invalid' : '' }}" name="goods" rows="2" placeholder="মালের সংক্ষিপ্ত বিবরণ">{{ old('goods',$trip->goods??'') }}</textarea>
                            @if ($errors->has('goods'))
                                <span class="error invalid-feedback">{{ $errors->first('goods') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.note')</label>
                            <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" rows="2" placeholder="@lang('cmn.you_can_write_any_note_here')">{{ old('note',$trip->note??'') }}</textarea>
                            @if ($errors->has('note'))
                                <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <!-- provider form -->
        @if($request->type == 'out' || (isset($trip->provider->ownership) && $trip->provider->ownership == 'out'))
            <input type="hidden" name="ownership" value="out">
            @include('trip.trip_form.out_provider')
        @endif
        @if($request->type == 'out_nagad_commission' || (isset($trip->provider->ownership) && $trip->provider->ownership == 'out_nagad_commission'))
            <input type="hidden" name="ownership" value="out_nagad_commission">
            @include('trip.trip_form.out_nagad_commission.provider')
        @endif
        @if($request->type == 'own' || (isset($trip->provider->ownership) && $trip->provider->ownership == 'own'))
            <input type="hidden" name="ownership" value="own">
            @include('trip.trip_form.own_provider')
        @endif
        <!-- company form -->
        @if($request->type == 'out_nagad_commission' || (isset($trip->provider->ownership) && $trip->provider->ownership == 'out_nagad_commission'))
            @include('trip.trip_form.out_nagad_commission.company')
        @else
            @include('trip.trip_form.company')
        @endif
    </form>
</div>
@include('include.unique_challan_numbers')