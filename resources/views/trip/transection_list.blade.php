<!-- transection -->
<div class="col-md-12">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th width="25%">@lang('cmn.account_info')</th>
                        <th width="35%">@lang('cmn.reason')</th>
                        <th width="20%">@lang('cmn.in')</th>
                        <th width="20%">@lang('cmn.out')</th>
                    </tr>
                </thead>
                <tbody>
                @php $in_sum = 0; $out_sum = 0; @endphp
                    @if(count($trip->expenses) > 0)
                        @foreach($trip->expenses as $expense)
                            @php 
                                $in_sum += ($expense->transaction->type=='in')?$expense->transaction->amount:0; 
                                $out_sum += ($expense->transaction->type=='out')?$expense->transaction->amount:0;
                            @endphp
                            <tr>
                                <td><small>{{ $expense->transaction->account->user_name }} ({{ $expense->transaction->account->account_number??__('cmn.cash') }}) ({{ $expense->transaction->date }})</small></td>
                                <td><small>{{ $expense->expense->head }}</small></td>
                                <td><small><b class='text-green'>{{ ($expense->transaction->type=='in')?number_format($expense->transaction->amount):'---' }}</b></small></td>
                                <td><small><b class='text-danger'>{{ ($expense->transaction->type=='out')?number_format($expense->transaction->amount):'---' }}</b></small></td>
                            </tr>
                        @endforeach
                    @endif

                    @if(count($trip->oilExpenses) > 0)
                        @foreach($trip->oilExpenses as $oilExpense)
                            @php 
                                $in_sum += ($oilExpense->transaction->type=='in')?$oilExpense->transaction->amount:0; 
                                $out_sum += ($oilExpense->transaction->type=='out')?$oilExpense->transaction->amount:0;
                            @endphp
                            <tr>
                                <td><small>{{ $oilExpense->transaction->account->user_name}} ({{ $oilExpense->transaction->account->account_number??__('cmn.cash') }}) ({{ $oilExpense->transaction->date }})</small></td>
                                <td><small>{{ __('cmn.'.$oilExpense->transaction->for) }}</small></td>
                                <td><small><b class='text-green'>{{ ($oilExpense->transaction->type=='in')?number_format($oilExpense->transaction->amount):'---' }}</b></small></td>
                                <td><small><b class='text-danger'>{{ ($oilExpense->transaction->type=='out')?number_format($oilExpense->transaction->amount):'---' }}</b></small></td>
                            </tr>
                        @endforeach
                    @endif

                    @if(count($trip->transactions) > 0)
                        @foreach($trip->transactions as $trans)
                            @php 
                                $in_sum += ($trans->type=='in')?$trans->amount:0; 
                                $out_sum += ($trans->type=='out')?$trans->amount:0;
                            @endphp
                            <tr>
                                <td><small>{{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})</small></td>
                                <td>
                                    <small>
                                        {{ __('cmn.'.$trans->for) }} 
                                        {{-- <b>(@lang('cmn.up_challan'))</b> --}}
                                        <button type="button" class="btn btn-xs bg-danger" onclick="return deleteCertification({{ $trans->id  }}, 'trans')" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                                        <form id="delete-form-trans-{{$trans->id }}" method="POST" action="{{ url('trips/transection-delete', $trans->id ) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </small>
                                </td>
                                <td><small><b class='text-green'>{{ ($trans->type=='in')?number_format($trans->amount):'---' }}</b></small></td>
                                <td><small><b class='text-danger'>{{ ($trans->type=='out')?number_format($trans->amount):'---' }}</b></small></td>
                            </tr>
                        @endforeach
                    @endif

                    @if(isset($down_trip) && count($down_trip->transactions) > 0)
                        @foreach($down_trip->transactions as $trans)
                            @php 
                                $in_sum += ($trans->type=='in')?$trans->amount:0; 
                                $out_sum += ($trans->type=='out')?$trans->amount:0;
                            @endphp
                            <tr>
                                <td><small>{{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})</small></td>
                                <td>
                                    <small>
                                        {{ __('cmn.'.$trans->for) }} 
                                        <b>(@lang('cmn.down_challan'))</b>
                                    </small>
                                    <button type="button" class="btn btn-xs bg-danger" onclick="return deleteCertification({{ $trans->id  }}, 'trans')" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                                    <form id="delete-form-trans-{{$trans->id }}" method="POST" action="{{ url('trips/transection-delete', $trans->id ) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                                <td><small><b class='text-green'>{{ ($trans->type=='in')?number_format($trans->amount):'---' }}</b></small></td>
                                <td><small><b class='text-danger'>{{ ($trans->type=='out')?number_format($trans->amount):'---' }}</b></small></td>
                            </tr>
                        @endforeach
                    @endif

                    <tr>
                        <td class="text-right" colspan="2"><small><b>@lang('cmn.total') = </b></small></td>
                        <td><small><b class='text-green'>{{ number_format($in_sum) }}</b></small></td>
                        <td><small><b class='text-danger'>{{ number_format($out_sum) }}</b></small></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

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