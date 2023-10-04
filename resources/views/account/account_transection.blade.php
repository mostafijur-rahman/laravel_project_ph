@extends('layout')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- form box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.cash_in')/@lang('cmn.cash_out') @lang('cmn.form')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form id="action" method="POST" action="{{ url('account-transections') }}">
                    @csrf
                    <input type="hidden" id="request_type" name="" value="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.investor')</label>
                                <select name="investor_id" class="form-control {{ $errors->has('investor_id') ? 'is-invalid' : '' }}" required>
                                    @foreach($investors as $investor)
                                    <option value="{{ $investor->id }}">{{$investor->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('investor_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('investor_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('cmn.date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="date" placeholder="@lang('cmn.date')" class="form-control datetimepicker-input {{ $errors->has('date') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('date'))
                                    <span class="error invalid-feedback">{{ $errors->first('date') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.transection')</label>
                                <select name="type" class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" required>
                                    <option value="in">@lang('cmn.cash_in')</option>
                                    <option value="out">@lang('cmn.cash_out')</option>
                                </select>
                                @if ($errors->has('type'))
                                    <span class="error invalid-feedback">{{ $errors->first('type') }}</span>
                                @endif
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.please_select_account')</label>
                                <select name="account_id" class="form-control {{ $errors->has('account_id') ? 'is-invalid' : '' }}" required>
                                    @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }} )= {{(number_format($account->balance))}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('account_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('account_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.balance') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                <input type="number"  class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" placeholder="@lang('cmn.balance') (@lang('cmn.required'))" required>
                                @if ($errors->has('amount'))
                                    <span class="error invalid-feedback">{{ $errors->first('amount') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('cmn.note')</label>
                                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" rows="1" name="note" placeholder="@lang('cmn.write_note_here')"></textarea>
                                @if ($errors->has('note'))
                                    <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" id="show_btn1" class="form-control btn btn-success" onclick="submitForm()">
                                    <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                    <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @include('account.transection_list')
    </section>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    $('#reservationdate').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('action').submit();
    }
</script> 
@endpush