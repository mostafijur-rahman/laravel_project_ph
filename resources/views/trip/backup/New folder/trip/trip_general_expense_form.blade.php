@push('css')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
@endpush
@if($trip)
@php  $tripGeneralExpenseLists = tripExpenseListsByGroupId($trip->group_id); @endphp
@if($tripGeneralExpenseLists)
<div class="col-md-8">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped text-center table-hover text-nowrap">
                <thead>
                    <tr>
                        <th width="5%">Sl</th>
                        <th width="20%">@lang('cmn.expense_head')</th>
                        <th width="20%">@lang('cmn.taka')</th>
                        <th width="10%">@lang('cmn.action')</th>
                    </tr>
                </thead>
                <tbody id="expense_tbody">
                    @php $total_general_exp=0; @endphp
                    @foreach($tripGeneralExpenseLists as $expenseKey => $expense)
                    <tr>
                        <td><small>{{ ++$expenseKey }}</small></td>
                        <td>
                            <small>
                                {{ $expense->head }}
                                @if($expense->note)<br>{{ $expense->note }}@endif
                            </small>
                        </td>
                        <td>
                            <small>{{ number_format($expense->amount) }}</small>
                            @php $total_general_exp += $expense->amount @endphp
                        </td>
                        <td>
                            <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $expense->id  }}, 'expense')" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-expense-{{$expense->id }}" method="POST" action="{{ url('expenses', $expense->id ) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td colspan="2"><small><b>@lang('cmn.total') =</small></b></td>
                        <td><small><b>{{ number_format($total_general_exp) }}</small></b></td>
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
        <form action="{{ url('expenses') }}" method="POST" id="ex_form">
            @csrf
            <div class="card-header">
                <h3 class="card-title text-primary"><b>@lang('cmn.general_expense')</b></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.expense_head')</label>
                            <select class="form-control select2 {{ $errors->has('expense_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="expense_id" required>
                                <option value="">@lang('cmn.please_select')</option>
                                @foreach($expenses as $expense)
                                <option value="{{$expense->id}}">{{$expense->head}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('expense_id'))
                                <span class="error invalid-feedback">{{ $errors->first('expense_id') }}</span>
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
                            <label>@lang('cmn.taka')</label>
                            <input type="number" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" min="0" value="0" placeholder="@lang('cmn.taka')" required>
                            @if ($errors->has('amount'))
                                <span class="error invalid-feedback">{{ $errors->first('amount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.note')</label>
                            <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" rows="1" placeholder="@lang('cmn.write_here')"></textarea>
                            @if ($errors->has('note'))
                                <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="ex_show_btn1" class="form-control btn btn-sm btn-success" onclick="submitExpense()">
                                <i id="ex_load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                <i id="ex_show_icon1" class="fa fa-save"></i> @lang('cmn.do_posting')
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    <input type="hidden" name="vehicle_id" value="{{ $trip->provider->vehicle_id }}">
                    <input type="hidden" name="date" value="{{ date("d/m/Y", strtotime($trip->date)) }}">
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