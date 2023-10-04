<!-- supplier add modal -->
<div class="modal fade" id="supplier_add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('settings/suppliers') }}"  method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('cmn.supplier_add')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">@lang('cmn.name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.suppliers') @lang('cmn.name')" required>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.phone') </label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone')}}" placeholder="@lang('cmn.phone')">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.previous_balance') (@lang('cmn.our_receivable'))</label>
                        <input type="number" class="form-control" name="receivable_amount" value="{{ old('receivable_amount', 0)}}" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.previous_balance') (@lang('cmn.supplier_payable'))</label>
                        <input type="number" class="form-control" name="payable_amount" value="{{ old('payable_amount', 0)}}" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.address') </label>
                        <textarea class="form-control" rows="2" name="address" placeholder="@lang('cmn.address')">{{ old('address')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.note') </label>
                        <textarea class="form-control" rows="2" name="note" placeholder="@lang('cmn.note')">{{ old('note')}}</textarea>
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