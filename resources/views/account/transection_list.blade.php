<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-bordered text-center table-hover text-nowrap">
            <thead>
                <tr>
                    <th width="30%">@lang('cmn.account_details')</th>
                    <th width="30%">@lang('cmn.transactions')</th>
                    <th width="20%">@lang('cmn.cash_in')</th>
                    <th width="20%">@lang('cmn.cash_out')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($lists)>0)
                @php $total_cash_in=0; $total_cash_out=0; @endphp
                @foreach($lists as $key => $list)
                    <tr>
                        <td class="text-left">
                            <small>
                                @if($list->investor_id)
                                @lang('cmn.investor') : <b>{{ $list->investor->name }}</b><br>
                                @endif
                                @lang('cmn.user_name') : <b>{{ $list->account->user_name }}</b><br>
                                @if($list->account->bank_id)
                                @lang('cmn.bank') : <b>{{ $list->account->bank->name }}</b><br>
                                @lang('cmn.account_number') : <b>{{ $list->account->account_number }}</b><br>
                                @lang('cmn.holder_name') : <b>{{ $list->account->holder_name }}</b><br>
                                @else
                                <b>@lang('cmn.cash_account')</b><br>
                                @endif
                                @lang('cmn.connected_system_user') :
                                <b>{{ $account->user_id ? $account->connected_user->first_name : '---' }}</b><br>
                                @lang('cmn.posted_by') :<br>
                                <b>{{ $list->user->first_name }} ({{ date('d M, Y H:m A', strtotime($list->created_at)) }})</b>
                                @if($list->updated_at)
                                    <br>
                                    @if($list->updated_by)
                                        @lang('cmn.post_updated_by'): <br>
                                        <b>{{ $list->user_update->first_name}} ({{ date('d M, Y H:m A', strtotime($list->updated_at)) }})</b>
                                    @endif
                                @endif
                            </small>
                        </td>
                        <td class="text-left">
                            <small>
                            @lang('cmn.date') : <b>{{ $list->date }}</b><br>
                            @lang('cmn.id') : <b>{{ $list->encrypt }}</b><br>
                            @if($list->for)
                            @lang('cmn.reason') : <b>{{ __('cmn.'.$list->for) }}</b><br>
                            @endif
                            @if($list->transactionable)
                                @if($list->transactionable->expense_id)
                                    @lang('cmn.expense_id') : <b>{{ $list->transactionable->id }}</b><br>
                                @endif
                                @if($list->transactionable->number)
                                    @lang('cmn.trip_number') : <b>{{ $list->transactionable->number }}</b><br>
                                @endif
                            @endif
                            @if($list->note)
                            @lang('cmn.note') : <b>{{ $list->note }}</b><br>
                            @endif
                            </small>
                            @if($list->transactionable_type == null && ($list->for == 'cash_in' || $list->for == 'cash_out'))
                            <div class="row mt-2">
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-xs mr-1" onclick="editData({{ json_encode($list) }})" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</button>
                                </div>
                            </div>
                            @endif
                        </td>
                        <td>
                            @if($list->type=='in')
                            <b class='text-green'>{{ number_format($list->amount) }}</b>
                            @php $total_cash_in+=$list->amount; @endphp
                            @else
                            ---
                            @endif
                        </td>
                        <td>
                            @if($list->type=='out')
                            <b class='text-danger'>{{ number_format($list->amount) }}</b>
                            @php $total_cash_out+=$list->amount; @endphp
                            @else
                            ---
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-right"><b>@lang('cmn.total') =</b></td>
                    <td><b class='text-green'>{{ number_format($total_cash_in) }}</b></td>
                    <td><b class='text-danger'>{{ number_format($total_cash_out) }}</b></td>
                </tr>
                @else
                <tr>
                    <td colspan="4">@lang('cmn.no_data')</td>
                </tr>
                @endif
            </tbody>
        </table>
        <!-- edit modal start -->
        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" id="update_action"  method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h4 class="modal-title">@lang('cmn.do_update')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                                <label for="">@lang('cmn.transection') @lang('cmn.date') <span class="text-danger">(@lang('cmn.required'))</span></label>
                                <input type="date" class="form-control" id="date_field" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="">@lang('cmn.note')</label>
                                <textarea class="form-control" id="note_field" name="note" rows="1" placeholder="@lang('cmn.write_here')"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.update_post')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $lists->appends(Request::input())->links() }}
    </div>
</div>

@push('js')
<script type="text/javascript">
    function editData(value){
        // console.log(value)
        $("#editModal").modal("show");

        let date_js_format = moment(value.date).format('YYYY-MM-DD');
        $("#date_field").val(date_js_format);

        $("#note_field").val(value.note);
        $('#update_action').attr('action', 'account-transections/' + value.id);                       
    }
</script>
@endpush