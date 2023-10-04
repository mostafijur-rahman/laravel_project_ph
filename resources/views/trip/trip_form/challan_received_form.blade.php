<div class="modal fade" id="challan_received">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('trips/challan-received') }}"  method="post">
                @csrf
                <input type="hidden" id="challan_received_trip_id" name="trip_id" value="">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('cmn.challan_received')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">@lang('cmn.name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="text" class="form-control" name="name" list="challan_number_else" id="name_edit" placeholder="@lang('cmn.receiver_name')" required>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.note')</label>
                        <textarea class="form-control" row="1" name="note" placeholder="@lang('cmn.write_note_here')"></textarea>
                    </div>
                    <div class="form-group" id="challan_received_trans">
                        <label>@lang('cmn.received_account')</label>
                        <select class="form-control select2" name="account_id" width="100%">
                            <option value="">@lang('cmn.please_select')</option>
                            @if(isset($accounts))
                            @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.do_posting')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
<script type="text/javascript">

// challan received delete notice
function deleteChallanReceivedCertification(id){
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
            document.getElementById('delete-challan-received-form-'+id).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // swalWithBootstrapButtons()
        }
    })
}

// challan received 
function challanReceived(trip){

    document.getElementById("challan_received_trans").style.display = "none";

    $("#challan_received").modal('show');
    $("#challan_received_trip_id").val(trip.id);
    if(trip.type == 'out_nagad_commission'){
        document.getElementById("challan_received_trans").style.display = "inline-block";
    }

}
</script>
@endpush