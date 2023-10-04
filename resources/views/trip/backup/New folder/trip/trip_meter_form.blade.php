@push('css')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
@endpush
@if($trip && $trip->meter && $trip->meter->id)
<div class="col-md-8">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr>
                        <th>@lang('cmn.start_meter_reading_of_trip')</th>
                        <th>@lang('cmn.last_meter_reading_of_trip')</th>
                        <th>@lang('cmn.used') @lang('cmn.km')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ number_format($trip->meter->previous_reading) }}  @lang('cmn.km')</td>
                        <td>{{ number_format($trip->meter->current_reading) }}  @lang('cmn.km')</td>
                        <td>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}  @lang('cmn.km')</td>
                        <td>
                            {{-- <a class="btn btn-xs btn-danger" href="{{ url('trip-meter-delete', $trip->meter->id) }}" onclick="return confirm(`@lang('cmn.are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a> --}}
                            <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $trip->meter->id }}, 'meter')" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-meter-{{$trip->meter->id}}" method="POST" action="{{ url('trip-meter-delete', $trip->meter->id ) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
    @if($trip)
    <div class="col-md-12">
        <div class="card card-default">
            <form  action="{{ url('/trip-meter-save') }}" method="POST" id="meter_form">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">@lang('cmn.meter_info')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.start_meter_reading_of_trip')</label>
                                <input type="number" min="0" class="form-control {{ $errors->has('previous_reading') ? 'is-invalid' : '' }}" name="previous_reading" value="0" required>
                                @if ($errors->has('previous_reading'))
                                    <span class="error invalid-feedback">{{ $errors->first('previous_reading') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.last_meter_reading_of_trip')</label>
                                <input type="number" min="0" class="form-control {{ $errors->has('current_reading') ? 'is-invalid' : '' }}" name="current_reading" value="0" required>
                                @if ($errors->has('current_reading'))
                                    <span class="error invalid-feedback">{{ $errors->first('current_reading') }}</span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" id="meter_show_btn1" class="form-control btn btn-sm btn-success" onclick="submitMeter()">
                                    <i id="meter_load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                    <i id="meter_show_icon1" class="fa fa-save"></i> @lang('cmn.do_posting')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else
                <div class="alert alert-warning">
                    <h5>@lang('cmn.at_first_create_chalan')!</h5>
                </div>
            @endif
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