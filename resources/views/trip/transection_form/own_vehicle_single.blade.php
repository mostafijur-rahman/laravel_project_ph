@if($trip->company->due_fair > 0 || $trip->company->demarage_due > 0)
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary"><b>@lang('cmn.transactions') @lang('cmn.form')</b></h3>
        </div>
        <div class="card-body">
            <form method="POST" id="transection_action" action="trips/transection-save-for-single-challan">
                @csrf
                {{-- <input type="hidden" name="payment_type" id="payment_type"> --}}
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                <input type="hidden" name="company_id" value="{{ $trip->company->company_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.transection_type') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <select class="form-control {{ $errors->has('transection_type') ? 'is-invalid' : '' }}" id="transection_type" name="transection_type" required>
                                @if($trip->company->due_fair > 0)
                                <option value="receive_challan_due_from_company">@lang('cmn.receive_challan_due_bill_from_company')</option>
                                @endif
                                @if($trip->company->demarage_due > 0)
                                <option value="receive_demurrage_due_from_company">@lang('cmn.receive_demurrage_due_bill_from_company')</option>
                                @endif
                            </select>
                            @if ($errors->has('transection_type'))
                                <span class="error invalid-feedback">{{ $errors->first('transection_type') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.payment_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <div class="input-group date" id="transection_date" data-target-input="nearest">
                                <input type="text" name="date" class="form-control datetimepicker-input {{ $errors->has('date') ? 'is-invalid' : '' }}" value="{{ date('d/m/Y') }}" data-target="#reservationdate" required>
                                <div class="input-group-append" data-target="#transection_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @if ($errors->has('date'))
                                <span class="error invalid-feedback">{{ $errors->first('date') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.payment_method')</label>
                            <select class="form-control {{ $errors->has('account_id') ? 'is-invalid' : '' }}" name="account_id" required>
                                @if(isset($accounts))
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }} ) = {{(number_format($account->balance))}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('account_id'))
                                <span class="error invalid-feedback">{{ $errors->first('account_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.voucher_id')</label>
                            <input type="text" name="voucher_id" class="form-control {{ $errors->has('voucher_id') ? 'is-invalid' : '' }}" value="{{ old('voucher_id') }}" placeholder="@lang('cmn.write_voucher_id_here')">
                            @if ($errors->has('voucher_id'))
                                <span class="error invalid-feedback">{{ $errors->first('voucher_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.balance') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <input type="number" min="0" name="amount" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" value="0" value="{{ old('amount') }}" placeholder="@lang('cmn.amount_here')" required>
                            @if ($errors->has('amount'))
                                <span class="error invalid-feedback">{{ $errors->first('amount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.recipients_name')</label>
                            <input type="text" name="recipients_name" list="unique_recipients_name_else" class="form-control {{ $errors->has('recipients_name') ? 'is-invalid' : '' }}" value="{{ old('recipients_name') }}" placeholder="@lang('cmn.write_recipients_name_here')">
                            @if ($errors->has('recipients_name'))
                                <span class="error invalid-feedback">{{ $errors->first('recipients_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.recipients_phone')</label>
                            <input type="number" name="recipients_phone" list="unique_recipients_phone_else" class="form-control {{ $errors->has('recipients_phone') ? 'is-invalid' : '' }}" value="{{ old('recipients_phone') }}" placeholder="@lang('cmn.write_recipients_phone_here')">
                            @if ($errors->has('recipients_phone'))
                                <span class="error invalid-feedback">{{ $errors->first('recipients_phone') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" id="trans_show_btn1" class="form-control btn btn-sm btn-success" onclick="submitTransection()">
                                <i id="trans_load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                <i id="trans_show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('include.unique_recipients_names')
@include('include.unique_recipients_phones')
@endif