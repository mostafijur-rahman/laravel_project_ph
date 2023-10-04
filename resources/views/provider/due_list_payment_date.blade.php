@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                {{-- <div class="card">
                    <div class="card-body">
                        <form method="POST" id="action" action="{{ $form_url }}">
                            @csrf
                            <input type="hidden" name="payment_type" value="{{ $payment_type }}">
                            <div id="div_of_trip_ids"></div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cmn.payment_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                        <div class="input-group date" id="date" data-target-input="nearest">
                                            <input type="text" name="date" class="form-control datetimepicker-input" value="{{ date('d/m/Y') }}" data-target="#reservationdate" required>
                                            <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cmn.payment_method')</label>
                                        <select class="form-control" name="account_id" required>
                                            @if(isset($accounts))
                                            @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }} ) = {{(number_format($account->balance))}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>@lang('cmn.amount') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                        <input type="number" name="amount" class="form-control" value="0" value="{{ old('amount') }}" placeholder="@lang('cmn.amount_here')" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('cmn.recipients_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                        <input type="text" name="recipients_name" class="form-control" value="{{ old('recipients_name') }}" placeholder="@lang('cmn.write_recipients_name_here')" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('cmn.recipients_phone') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                        <input type="number" name="recipients_phone" class="form-control" value="{{ old('recipients_phone') }}" placeholder="@lang('cmn.write_recipients_phone_here')" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" id="show_btn1" class="form-control btn btn-sm btn-success" onclick="submitForm()">
                                            <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                            <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
                @include('trip.trip_mini_list')
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection