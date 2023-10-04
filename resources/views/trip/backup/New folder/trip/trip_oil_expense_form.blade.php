@push('css')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
@endpush
@if($trip)
    @if(count($trip->oilExpenses)>0)
    <div class="col-md-8">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped text-center table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="20%">@lang('cmn.pump_name')</th>
                            <th width="10%">@lang('cmn.liter')</th>
                            <th width="10%">@lang('cmn.rate')</th>
                            <th width="10%">@lang('cmn.taka')</th>
                            <th width="10%">@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total_oil_liter=0; $total_oil_bill=0; @endphp
                        @foreach($trip->oilExpenses as $oil_exp_key => $oil_expense)
                        <tr>
                            <td>
                                <small>
                                    {{ $oil_expense->pump->name??'ক্যাশ প্রদান করা হয়েছিল' }}
                                    @if($oil_expense->note){{ $oil_expense->note }}@endif
                                </small>
                            </td>
                            <td>
                                <small>{{ $oil_liter[$oil_exp_key]= $oil_expense->liter }}</small>
                            </td>
                            <td>
                                <small>{{ $oil_expense->rate }}</small>
                            </td>
                            <td>
                                <small>{{ number_format($oil_expense->bill) }}</small>
                                @php $oil_exp[$oil_exp_key] = $oil_expense->bill @endphp
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $oil_expense->id }}, 'oil')" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-oil-{{$oil_expense->id }}" method="POST" action="{{ url('trip-oil-expense-delete', $oil_expense->id ) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @php
                            $total_oil_liter += $oil_liter[$oil_exp_key];
                            $total_oil_bill += $oil_exp[$oil_exp_key];
                        @endphp
                        @endforeach
                        <tr style="font-weight: bold;">
                            <td class="text-right"><small><b>@lang('cmn.total') =</b></small></td>
                            <td><small><b>{{ number_format($total_oil_liter) }}</b></small></td>
                            <td></td>
                            <td><small><b>{{ number_format($total_oil_bill) }}</b></small></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-12">
        <div class="card card-default">
            <form action="{{ url('/trip-oil-expense-save') }}" method="POST" id="pump_form">
                @csrf
                <div class="card-header">
                    <h3 class="card-title text-primary"><b>@lang('cmn.oil_expense')</b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.pump_name')</label>
                                <select name="pump_id" class="form-control select2 {{ $errors->has('pump_id') ? 'is-invalid' : '' }}" style="width: 100%;">
                                    <option value="">ক্যাশ প্রদান করা হয়েছিল</option>
                                    @foreach($pumps as $pump)
                                    <option value="{{ $pump->id }}">{{ $pump->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('pump_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('pump_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.payment_method')</label>
                                <select class="form-control select2 {{ $errors->has('account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="account_id">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.liter')</label>
                                <input type="number" class="form-control {{ $errors->has('liter') ? 'is-invalid' : '' }}" name="liter" min="0" value="0" placeholder="@lang('cmn.liter')" required>
                                @if ($errors->has('liter'))
                                    <span class="error invalid-feedback">{{ $errors->first('liter') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.rate')</label>
                                <input type="number" class="form-control {{ $errors->has('rate') ? 'is-invalid' : '' }}" name="rate" min="0" value="{{ ($setComp['oil_rate'])?$setComp['oil_rate']:0 }}" step="any" class="form-control" placeholder="@lang('cmn.rate')" required>
                                @if ($errors->has('rate'))
                                    <span class="error invalid-feedback">{{ $errors->first('rate') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.note')</label>
                                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" rows="1" placeholder="@lang('cmn.note')"></textarea>
                                @if ($errors->has('note'))
                                    <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" id="pump_show_btn1" class="form-control btn btn-sm btn-success" onclick="submitPump()">
                                    <i id="pump_load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                    <i id="pump_show_icon1" class="fa fa-save"></i> @lang('cmn.do_posting')
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="trip_date" value="{{ $trip->date }}">
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        <input type="hidden" name="vehicle_id" value="{{ $trip->provider->vehicle_id }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
@push('js')
<!-- toastr -->
<script src="{{ asset('assets/dist/cdn/toastr.min.js') }}"></script>
<script type="text/javascript">
// delete notice
function deleteCertification(id, type){
    const swalWithBootstrapButtons = Swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger mr-2',
        buttonsStyling: false,
    })
    swalWithBootstrapButtons({
        title: "{{ __('cmn.are_you_sure') }}",
        text: "{{ __('cmn.for_erase_it') }}",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "{{ __('cmn.yes') }}",
        cancelButtonText: "{{ __('cmn.no') }}",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            if(type){
                document.getElementById('delete-form-' + type +'-'+id).submit();
            } else {
                document.getElementById('delete-form-'+id).submit();
            }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // swalWithBootstrapButtons()
        }
    })
}
</script>
@endpush