<!-- add modal -->
<div class="modal fade" id="company_add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('settings/companies') }}" id="update_action" method="post">
                @csrf
                <input type="hidden" id="request_type" name="" value="">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('cmn.company_add')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">@lang('cmn.company') @lang('cmn.name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.company') @lang('cmn.name')" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('cmn.previous_trip_balance') (@lang('cmn.date'))</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="trip_receivable_date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                            </div>
                            {{-- <div class="form-group">
                                <label for="">@lang('cmn.previous_balance') (@lang('cmn.company_payable'))</label>
                                <input type="number" class="form-control" name="payable_amount" value="{{ old('payable_amount', 0)}}" placeholder="0">
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('cmn.previous_trip_balance') (@lang('cmn.amount'))</label>
                                <input type="number" class="form-control" id="trip_receivable_amount" name="trip_receivable_amount" value="{{ old('receivable_amount', 0)}}" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('cmn.phone') </label>
                                <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone')}}" placeholder="@lang('cmn.phone')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('cmn.address') </label>
                                <textarea class="form-control" rows="2" id="address" name="address" placeholder="@lang('cmn.address')">{{ old('address')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">@lang('cmn.note') </label>
                                <textarea class="form-control" rows="2" id="note" name="note" placeholder="@lang('cmn.note')">{{ old('note')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end add modal -->