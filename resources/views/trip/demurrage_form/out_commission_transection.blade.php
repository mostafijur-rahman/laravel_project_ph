@push('css')
    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
@endpush

@if($trip)

    @include('trip.demurrage_form.out_commission_transection_list')

    <div class="col-md-12">
        <div class="card card-default">
            <form action="{{ url('trips/demurrage-save-for-out-commission-transection') }}" method="POST" id="ex_form">
                @csrf
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                <div class="card-header">
                    <h3 class="card-title text-primary"><b>@lang('cmn.demurrage') @lang('cmn.form')</b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                <input type="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date"  value="{{ old('date', date('Y-m-d')) }}" required>
                                @if ($errors->has('date'))
                                    <span class="error invalid-feedback">{{ $errors->first('date') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.demurrage_bill_for_company')</label>
                                <input type="number" class="form-control {{ $errors->has('company_amount') ? 'is-invalid' : '' }}" name="company_amount" min="0" value="0" placeholder="@lang('cmn.amount_here')" required>
                                @if ($errors->has('company_amount'))
                                    <span class="error invalid-feedback">{{ $errors->first('company_amount') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.demurrage_bill_for_vehicle_provider')</label>
                                <input type="number" class="form-control {{ $errors->has('provider_amount') ? 'is-invalid' : '' }}" name="provider_amount" min="0" value="0" placeholder="@lang('cmn.amount_here')" required>
                                @if ($errors->has('provider_amount'))
                                    <span class="error invalid-feedback">{{ $errors->first('provider_amount') }}</span>
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