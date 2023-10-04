<div class="card">
    <div class="card-header">
        <h4 class="card-title w-100 text-primary">
            <b>@lang('cmn.company')</b>
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.company') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select  class="form-control select2 {{ $errors->has('company_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="company_id" required>
                        @if(isset($companies))
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id',($trip->company->company_id)??'')==$company->id ? 'selected':'' }}>{{ $company->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('company_id'))
                        <span class="error invalid-feedback">{{ $errors->first('company_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.contract_rent')</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('com_contract_fair') ? 'is-invalid' : '' }}" name="com_contract_fair" value="{{ old('com_contract_fair', (($trip && $trip->company->contract_fair) ? (float) $trip->company->contract_fair:0)) }}" placeholder="@lang('cmn.amount_here')">
                    @if ($errors->has('com_contract_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('com_contract_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.addv_recev')</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('com_advance_fair') ? 'is-invalid' : '' }}" name="com_advance_fair" value="{{ old('com_advance_fair', (($trip && $trip->company->advance_fair) ? (float) $trip->company->advance_fair:0)) }}" placeholder="@lang('cmn.amount_here')">
                    @if ($errors->has('com_advance_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('com_advance_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.received_account')</label>
                    <select class="form-control select2 {{ $errors->has('com_account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="com_account_id">
                        @if(isset($accounts))
                        @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ old('com_account_id', ($advance_received_account_id)??'') == $account->id ? 'selected':'' }}>{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('com_account_id'))
                        <span class="error invalid-feedback">{{ $errors->first('com_account_id') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" id="show_btn1" class="btn btn-success" onclick="submitTrip()">
            <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
            <i id="show_icon1" class="fas fa-save"></i>
            @if($request->page_name == 'create' || $request->page_name == 'copy')
                @lang('cmn.do_posting')
            @else
                @lang('cmn.update_post')
            @endif
        </button>
    </div>
</div>