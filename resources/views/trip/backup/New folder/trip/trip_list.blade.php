@extends('layout')
@push('css')
<!-- daterange -->
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (page_name header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            @include('trip.trip_list.filter')
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th width="30%">@lang('cmn.primary_info')</th>
                            <th width="30%">@lang('cmn.transection_with_vehicle')</th>
                            <th width="20%">@lang('cmn.transection_with_company')</th>
                            <th width="20%">@lang('cmn.commission')</th>
                            <th width="20%">@lang('cmn.own_trip_deposit_expense')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($trips)>0)
                            @foreach($trips as $trip)
                                @if($trip->type)
                                    @switch($trip->type)
                                        @case('out_nagad_commission')
                                            @include('trip.trip_list.out_nagad_commission')
                                        @break

                                        @case('out_from_market')
                                            @include('trip.trip_list.out_from_market')
                                        @break

                                        @case('own_vehicle')
                                            @include('trip.trip_list.own_vehicle')
                                        @break
                            
                                        @default
                                            @include('trip.trip_list.common')
                                    @endswitch
                                @else
                                    @include('trip.trip_list.common')
                                @endif
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $trips->appends(Request::input())->links() }}
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="challan_received">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action=""  method="post" id="aciton_edit">
                @csrf
                @method('put')
                <input type="hidden" name="challan_received_trip_id" value="">
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
                        <label for="">@lang('cmn.date')</label>
                        <input type="date" class="form-control" name="date" id="date_edit">
                    </div>
                    <div class="form-group" id="challan_received_trans">
                        <label>@lang('cmn.received_account')</label>
                        <select class="form-control select2" width="100%">
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
                    <button type="button" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.do_posting')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('include.unique_challan_numbers')
@include('include.unique_vehicle_numbers')

@include('include.unique_provider_driver_names')
@include('include.unique_provider_owner_names')
@include('include.unique_provider_reference_names')

@endsection
@push('js')
<!-- toastr -->
<script src="{{ asset('assets/dist/cdn/toastr.min.js') }}"></script>
<!-- daterange -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    function dateRangeVisibility(formType){
        // variable assign
        let range_status_type = "range_status_"+formType;
        let month = "month_field_"+formType;
        let year = "year_field_"+formType;
        let daterange = "daterange_field_"+formType;

        let range_status = document.getElementById(range_status_type).value;
        if(range_status == 'monthly_report'){
            document.getElementById(month).style.display = "block";
            document.getElementById(year).style.display = "block";
            document.getElementById(daterange).style.display = "none";
        } else if(range_status == 'yearly_report'){
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "block";
            document.getElementById(daterange).style.display = "none";
        } else if(range_status == 'date_wise'){
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "none";
            document.getElementById(daterange).style.display = "block";
        }else{
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "none";
            document.getElementById(daterange).style.display = "none";
        }
    }
    $(function () {
        $('#reservation_all').daterangepicker();
    })

    // delete notice
    function deleteCertification(id){
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
                document.getElementById('delete-form-'+id).submit();
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