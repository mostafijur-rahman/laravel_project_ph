@if(Auth::user()->role->create)
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('cmn.expense_form')</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form id="ex_form" method="POST" action="{{ url('expenses') }}">
            @csrf
            <input type="hidden" id="request_type" name="" value="">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>@lang('cmn.payment_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="date" value="{{ old('date', date('d/m/Y')) }}" placeholder="@lang('cmn.date')" class="form-control datetimepicker-input {{ $errors->has('date') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
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
                        <label>@lang('cmn.payment_method') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <select class="form-control select2 {{ $errors->has('account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="account_id" required>
                            @if(isset($accounts))
                            @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ (old('account_id') == $account->id)?'selected':'' }}>{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }} )= {{(number_format($account->balance))}}</option>
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
                        <label>@lang('cmn.vehicle_number')</label>
                        <select class="form-control select2 {{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}" name="vehicle_id">
                            <option value="">@lang('cmn.vehicle_not_included')</option>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ (old('vehicle_id') == $vehicle->id)?'selected':'' }}>{{ $vehicle->number_plate }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('vehicle_id'))
                            <span class="error invalid-feedback">{{ $errors->first('vehicle_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>@lang('cmn.expense_head') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <select class="form-control select2 {{ $errors->has('expense_id') ? 'is-invalid' : '' }}" name="expense_id" required>
                            @foreach($expenses as $expense)
                            <option value="{{ $expense->id }}" {{ (old('expense_id') == $expense->id)?'selected':'' }}>{{ $expense->head }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('expense_id'))
                            <span class="error invalid-feedback">{{ $errors->first('expense_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>@lang('cmn.amount') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="number" name="amount" value="{{ old('amount', 0) }}" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" placeholder="@lang('cmn.amount_here')" required>
                        @if ($errors->has('amount'))
                            <span class="error invalid-feedback">{{ $errors->first('amount') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>@lang('cmn.note')</label>
                        <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" rows="1" name="note" placeholder="@lang('cmn.write_note_here')">{{ old('note')}}</textarea>
                        @if ($errors->has('note'))
                            <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" id="ex_show_btn1" class="form-control btn btn-sm btn-success" onclick="submitExpense()">
                            <i id="ex_load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                            <i id="ex_show_icon1" class="fa fa-save"></i> @lang('cmn.do_posting')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.content -->

<div class="modal fade" id="expense_edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action=""  method="post" id="aciton_edit">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h4 class="modal-title">@lang('cmn.edit') @lang('cmn.form')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="request_type" name="" value="">
                    <div class="form-group">
                        <label>@lang('cmn.payment_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <div class="input-group date" id="editDate" data-target-input="nearest">
                            <input type="text" id="date" name="date" value="{{ old('date', date('d/m/Y')) }}" placeholder="@lang('cmn.date')" class="form-control datetimepicker-input {{ $errors->has('date') ? 'is-invalid' : '' }}" data-target="#editDate" required>
                            <div class="input-group-append" data-target="#editDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @if ($errors->has('date'))
                                <span class="error invalid-feedback">{{ $errors->first('date') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('cmn.payment_method') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <select class="form-control select2 {{ $errors->has('account_id') ? 'is-invalid' : '' }}" style="width: 100%;" id="account_id" name="account_id" required>
                            @if(isset($accounts))
                            @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }} )= {{(number_format($account->balance))}}</option>
                            @endforeach
                            @endif
                        </select>
                        @if ($errors->has('account_id'))
                            <span class="error invalid-feedback">{{ $errors->first('account_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>@lang('cmn.voucher_id')</label>
                        <input type="text" id="voucher_id" name="voucher_id" class="form-control {{ $errors->has('voucher_id') ? 'is-invalid' : '' }}" value="{{ old('voucher_id') }}" placeholder="@lang('cmn.write_voucher_id_here')">
                        @if ($errors->has('voucher_id'))
                            <span class="error invalid-feedback">{{ $errors->first('voucher_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>@lang('cmn.vehicle_number')</label>
                        <select class="form-control select2 {{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}" id="vehicle_id" name="vehicle_id">
                            <option value="">@lang('cmn.vehicle_not_included')</option>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->number_plate }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('vehicle_id'))
                            <span class="error invalid-feedback">{{ $errors->first('vehicle_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>@lang('cmn.expense_head') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <select class="form-control select2 {{ $errors->has('expense_id') ? 'is-invalid' : '' }}" id="expense_id" name="expense_id" required>
                            @foreach($expenses as $expense)
                            <option value="{{ $expense->id }}">{{ $expense->head }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('expense_id'))
                            <span class="error invalid-feedback">{{ $errors->first('expense_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>@lang('cmn.amount') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', 0) }}" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" placeholder="@lang('cmn.amount_here')" required>
                        @if ($errors->has('amount'))
                            <span class="error invalid-feedback">{{ $errors->first('amount') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>@lang('cmn.note')</label>
                        <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" rows="1" id="note" name="note" placeholder="@lang('cmn.write_note_here')">{{ old('note')}}</textarea>
                        @if ($errors->has('note'))
                            <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.update_post')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


