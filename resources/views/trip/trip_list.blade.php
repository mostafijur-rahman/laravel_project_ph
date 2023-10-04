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
                {{-- <table class="table table-striped table-bordered text-center text-nowrap"> --}}
                <table class="table table-bordered text-nowrap">

                    @switch($request->type)
                        @case('out_commission')
                            <thead>
                                <tr class="text-center">
                                    <th width="20%">@lang('cmn.primary_info')</th>
                                    <th width="20%">@lang('cmn.transection_with_vehicle')</th>
                                    <th width="20%">@lang('cmn.transection_with_company')</th>
                                    <th width="20%">@lang('cmn.commission')</th>
                                    <th width="20%">@lang('cmn.transection')</th>
                                </tr>
                            </thead>
                            @break

                        @case('out_commission_transection')
                            <thead>
                                <tr class="text-center">
                                    <th width="20%">@lang('cmn.primary_info')</th>
                                    <th width="20%">@lang('cmn.transection_with_vehicle')</th>
                                    <th width="20%">@lang('cmn.transection_with_company')</th>
                                    <th width="20%">@lang('cmn.commission')</th>
                                    <th width="20%">@lang('cmn.transection')</th>
                                </tr>
                            </thead>
                            @break

                        @case('own_vehicle_single')
                            <thead>
                                <tr class="text-center">
                                    <th width="20%">@lang('cmn.primary_info')</th>
                                    <th width="20%">@lang('cmn.vehicle_info')</th>
                                    <th width="20%">@lang('cmn.transection_with_company')</th>
                                    <th width="20%">@lang('cmn.income')</th>
                                    <th width="20%">@lang('cmn.expense')</th>
                                </tr>
                            </thead>
                            @break

                        @case('own_vehicle_up_down')
                            <thead>
                                <tr class="text-center">
                                    <th width="20%">@lang('cmn.primary_info')</th>
                                    <th width="20%">@lang('cmn.up_export_challan')</th>
                                    <th width="20%">@lang('cmn.down_import_challan')</th>
                                    <th width="20%">@lang('cmn.income')</th>
                                    <th width="20%">@lang('cmn.expense')</th>
                                </tr>
                            </thead>
                            @break

                        @case('own_vehicle_up_down_new')
                            <thead>
                                <tr class="text-center">

                                    <th>@lang('cmn.vehicle')</th>
                                    <th>@lang('cmn.start_date')</th>
                                    <th>@lang('cmn.challan_no')</th>

                                    {{-- <th>@lang('cmn.company')</th> --}}
                                    <th>@lang('cmn.contract_rent')</th>
                                    <th>@lang('cmn.addv_recev')</th>
                                    <th>@lang('cmn.challan_due')</th>

                                    
                                    <th>@lang('cmn.deposit')</th>
                                    <th>@lang('cmn.demurrage')</th>
                                    <th>@lang('cmn.expense')</th>
                                    <th>@lang('cmn.balance')</th>

                                    <th>@lang('cmn.liter')</th>
                                    <th>@lang('cmn.distance_without_km')</th>
                                    <th>@lang('cmn.mileage')</th>

                                </tr>
                            </thead>
                            @break
                            
                        @default
                            @include('trip.trip_list.common')
                    @endswitch

                    <tbody>
                        @if(count($trips)>0)
                            @foreach($trips as $trip)
                                @if($trip->type)
                                    @switch($trip->type)
                                        @case('out_commission')
                                            @include('trip.trip_list.out_commission')
                                            @break

                                        @case('out_commission_transection')
                                            @include('trip.trip_list.out_commission_transection')
                                            @break

                                        @case('own_vehicle_single')
                                            @include('trip.trip_list.own_vehicle_single')
                                            @break

                                        @case('own_vehicle_up_down')
                                                @if($request->type == 'own_vehicle_up_down_new')
                                                    @include('trip.trip_list.own_vehicle_up_down_new')
                                                @else
                                                    @include('trip.trip_list.own_vehicle_up_down')
                                                @endif
                                            @break

                                        @default
                                            @include('trip.trip_list.common')
                                    @endswitch
                                @else
                                    @include('trip.trip_list.common')
                                @endif
                            @endforeach

                            <!-- summary -->                            
                            {{-- <tr>
                                <td colspan="6"> total = </td>
                            
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                            
                            </tr> --}}

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
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        @lang('cmn.showing') {{ $trips->firstItem() }} @lang('cmn.to') {{ $trips->lastItem() }} @lang('cmn.counting_of') {{ $trips->total() }}  @lang('cmn.results')
                        &nbsp; <small>(@lang('cmn.database_query_execution_time') = {{ $execution_time }} @lang('cmn.seconds'))</small> 
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="float-right">
                            {{ $trips->appends(Request::input())->links() }}
                        </div>
                    </div>
                </div>
            </div> 
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>

@include('trip.trip_form.challan_received_form')
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

    // trip delete notice
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

</script>
@endpush