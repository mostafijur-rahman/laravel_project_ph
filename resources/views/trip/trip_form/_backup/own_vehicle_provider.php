            
            <div class="col-md-3">
                <div class="form-group">
                    <label>অগ্রিম প্রদান <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <input type="number" min="0" class="form-control {{ $errors->has('advance_fair') ? 'is-invalid' : '' }}" name="advance_fair" value="{{ old('advance_fair',(($trip && $trip->provider->advance_fair)? (float) $trip->provider->advance_fair : 0)) }}" placeholder="@lang('cmn.amount_here')" required {{ ($request->page_name =='edit')?'disabled':''}}>
                    @if ($errors->has('advance_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('advance_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.payment_account')</label>
                    <select class="form-control select2 {{ $errors->has('account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="account_id" required {{ ($request->page_name =='edit')?'disabled':''}}>
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
                    <select class="form-control select2 {{ $errors->has('to_account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="to_account_id" {{ ($request->page_name =='edit')?'disabled':''}}>
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