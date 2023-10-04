<div class="card">
    <div class="card-header">
        <h4 class="card-title w-100 text-primary">
            <b>@lang('cmn.vehicle_provider')</b>
        </h4> 
    </div>
    <div class="card-body">
        <div class="row">
            {{-- id="vehilce_number" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}" --}}
            <div class="col-md-3">
                <div class="form-group">
                    <label>গাড়ীর নম্বর <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <input type="text" id="vehicle_number" list="vehicle_number_else" class="form-control {{ $errors->has('vehicle_number') ? 'is-invalid' : '' }}" name="vehicle_number" value="{{ old('vehicle_number',$trip->provider->vehicle_number??'') }}" placeholder="21-9098" required>
                    @if ($errors->has('vehicle_number'))
                        <span class="error invalid-feedback">{{ $errors->first('vehicle_number') }}</span>
                    @endif
                </div>
            </div>
            {{-- style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}" --}}
            <div class="col-md-3" id="driver_name">
                <div class="form-group">
                    <label>ড্রাইভারের নাম</label>
                    <input type="text" list="provider_driver_name_else" class="form-control {{ $errors->has('driver_name') ? 'is-invalid' : '' }}" name="driver_name" value="{{ old('driver_name', $trip->provider->driver_name??'') }}" placeholder="এখানে নাম লিখুন">
                    @if ($errors->has('driver_name'))
                        <span class="error invalid-feedback">{{ $errors->first('driver_name') }}</span>
                    @endif
                </div>
            </div>
            {{-- style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}" --}}
            <div class="col-md-3" id="driver_phone">
                <div class="form-group">
                    <label>ফোন নম্বর</label>
                    <input type="number" list="provider_driver_phone_else" class="form-control {{ $errors->has('driver_phone') ? 'is-invalid' : '' }}" name="driver_phone" value="{{ old('driver_phone',$trip->provider->driver_phone??'') }}" placeholder="0171-xxxx-xxx">
                    @if ($errors->has('driver_phone'))
                        <span class="error invalid-feedback">{{ $errors->first('driver_phone') }}</span>
                    @endif
                </div>
            </div>
            {{-- style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}" --}}
            <div class="col-md-3" id="owner_name">
                <div class="form-group">
                    <label>মালিকের নাম</label> 
                    <input type="text" list="provider_owner_name_else" class="form-control {{ $errors->has('owner_name') ? 'is-invalid' : '' }}" name="owner_name" value="{{ old('owner_name',$trip->provider->owner_name??'') }}" placeholder="এখানে নাম লিখুন">
                    @if ($errors->has('owner_name'))
                        <span class="error invalid-feedback">{{ $errors->first('owner_name') }}</span>
                    @endif
                </div>
            </div>
            {{-- style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}" --}}
            <div class="col-md-3" id="owner_phone">
                <div class="form-group">
                    <label>ফোন নম্বর</label>
                    <input type="number" list="provider_owner_phone_else" class="form-control {{ $errors->has('owner_phone') ? 'is-invalid' : '' }}" name="owner_phone" value="{{ old('owner_phone',$trip->provider->owner_phone??'') }}" placeholder="0171-xxxx-xxx">
                    @if ($errors->has('owner_phone'))
                        <span class="error invalid-feedback">{{ $errors->first('owner_phone') }}</span>
                    @endif
                </div>
            </div>
            {{-- style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}" --}}
            <div class="col-md-3" id="reference_name">
                <div class="form-group">
                    <label>রেফারেন্সের নাম</label>
                    <input type="text" list="provider_reference_name_else" class="form-control {{ $errors->has('reference_name') ? 'is-invalid' : '' }}" name="reference_name" value="{{ old('reference_name',$trip->provider->reference_name??'') }}" placeholder="এখানে নাম লিখুন">
                    @if ($errors->has('reference_name'))
                        <span class="error invalid-feedback">{{ $errors->first('reference_name') }}</span>
                    @endif
                </div>
            </div>
            {{-- style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: none':'display: block' }}" --}}
            <div class="col-md-3" id="reference_phone">
                <div class="form-group">
                    <label>ফোন নম্বর</label>
                    <input type="number" list="provider_reference_phone_else" class="form-control {{ $errors->has('reference_phone') ? 'is-invalid' : '' }}" name="reference_phone" value="{{ old('reference_phone',$trip->provider->reference_phone??'') }}" placeholder="0171-xxxx-xxx">
                    @if ($errors->has('reference_phone'))
                        <span class="error invalid-feedback">{{ $errors->first('reference_phone') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.contract_rent') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <input type="number" min="0" class="form-control {{ $errors->has('contract_fair') ? 'is-invalid' : '' }}" name="contract_fair" value="{{ old('contract_fair', (($trip && $trip->provider->contract_fair) ? (float) $trip->provider->contract_fair : 0)) }}" placeholder="@lang('cmn.amount_here')" required {{ ($request->page =='edit')?'disabled':''}}>
                    @if ($errors->has('contract_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('contract_fair') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('include.unique_vehicle_numbers')
@include('include.unique_provider_driver_names')
@include('include.unique_provider_driver_phones')
@include('include.unique_provider_owner_names')
@include('include.unique_provider_owner_phones')
@include('include.unique_provider_reference_names')
@include('include.unique_provider_reference_phones')