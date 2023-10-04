<div class="card">
    <div class="card-header">
        <h4 class="card-title w-100 text-primary">
            <b>@lang('cmn.vehicle_provider')</b>
        </h4> 
    </div>
    <div class="card-body">
        <div class="row">
            {{-- id="vehicle_id" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: block':'display: none' }}" --}}
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.vehicle_select') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select  class="form-control select2 {{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="vehicle_id" id="vehicle_id">
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
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.contract_rent') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <input type="number" min="0" class="form-control {{ $errors->has('contract_fair') ? 'is-invalid' : '' }}" name="contract_fair" value="{{ old('contract_fair',(($trip && $trip->provider->contract_fair)? (float) $trip->provider->contract_fair : 0)) }}" placeholder="@lang('cmn.amount_here')" required {{ ($request->page =='edit')?'disabled':''}}>
                    @if ($errors->has('contract_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('contract_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>অগ্রিম প্রদান <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <input type="number" min="0" class="form-control {{ $errors->has('advance_fair') ? 'is-invalid' : '' }}" name="advance_fair" value="{{ old('advance_fair',(($trip && $trip->provider->advance_fair)? (float) $trip->provider->advance_fair : 0)) }}" placeholder="@lang('cmn.amount_here')" required {{ ($request->page =='edit')?'disabled':''}}>
                    @if ($errors->has('advance_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('advance_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.payment_account')</label>
                    <select class="form-control select2 {{ $errors->has('account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="account_id" required {{ ($request->page =='edit')?'disabled':''}}>
                        @if(isset($accounts))
                        @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('account_id'))
                        <span class="error invalid-feedback">{{ $errors->first('account_id') }}</span>
                    @endif
                </div>
            </div>
            {{-- style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: block':'display: none' }}" --}}
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.received_account')</label>
                    <select class="form-control select2 {{ $errors->has('to_account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="to_account_id" {{ ($request->page =='edit')?'disabled':''}}>
                        @if(isset($accounts))
                        @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('to_account_id'))
                        <span class="error invalid-feedback">{{ $errors->first('to_account_id') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>