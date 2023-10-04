@push('css')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
@endpush
@if($trip)
@if(count($trip->demarage)>0)
<div class="col-md-8">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr>
                        <th>@lang('cmn.bill_date')</th>
                        <th>কোম্পানীর ডেমারেজ</th>
                        <th>প্রদানকারীর ডেমারেজ</th>
                        <th>@lang('cmn.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $company_amount_sum = 0; 
                        $provider_amount_sum = 0;
                    @endphp
                    @foreach($trip->demarage as $key => $demarage)
                    <tr>
                        <td>
                            <small>
                            {{ $demarage->date }}
                            @if($demarage->note)<br>{{ $demarage->note }}@endif
                            </small>
                        </td>
                        <td><small>{{ number_format($demarage->company_amount) }}</small></td>
                        <td><small>{{ number_format($demarage->provider_amount) }}</small></td>
                        <td>
                            <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $demarage->id }}, 'demarage')" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-demarage-{{$demarage->id }}" method="POST" action="{{ url('trip-demarage-delete', $demarage->id ) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @php 
                        $company_amount_sum += $demarage->company_amount; 
                        $provider_amount_sum += $demarage->provider_amount; 
                    @endphp
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td><b>@lang('cmn.total') =</b></td>
                        <td><small><b>{{ number_format($company_amount_sum) }}</b></small></td>
                        <td><small><b>{{ number_format($provider_amount_sum) }}</b></small></td>
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
        <form action="{{ url('trip-demarage-save') }}" method="POST" id="ex_form">
            @csrf
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
            <div class="card-header">
                <h3 class="card-title text-primary"><b>@lang('cmn.demarage_entry') @lang('cmn.form')</b></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.date')</label>
                            <input type="date" class="form-control {{ $errors->has('date.*') ? 'is-invalid' : '' }}" name="date[]" required>
                            @if ($errors->has('date.*'))
                                <span class="error invalid-feedback">{{ $errors->first('date.*') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>কোম্পানীর জন্য ডেমারেজ</label>
                            <input type="number" class="form-control {{ $errors->has('company_amount.*') ? 'is-invalid' : '' }}" name="company_amount[]" min="0" value="0" placeholder="@lang('cmn.taka')" required>
                            @if ($errors->has('company_amount.*'))
                                <span class="error invalid-feedback">{{ $errors->first('company_amount.*') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>প্রদানকারীর জন্য ডেমারেজ</label>
                            <input type="number" class="form-control {{ $errors->has('provider_amount.*') ? 'is-invalid' : '' }}" name="provider_amount[]" min="0" value="0" placeholder="@lang('cmn.taka')" required>
                            @if ($errors->has('provider_amount.*'))
                                <span class="error invalid-feedback">{{ $errors->first('provider_amount.*') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.note')</label>
                            <textarea class="form-control {{ $errors->has('note.*') ? 'is-invalid' : '' }}" name="note[]" rows="1" placeholder="@lang('cmn.write_here')"></textarea>
                            @if ($errors->has('note.*'))
                                <span class="error invalid-feedback">{{ $errors->first('note.*') }}</span>
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