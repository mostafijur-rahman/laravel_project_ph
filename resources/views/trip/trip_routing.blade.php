@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- need to show validation  -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            @switch($request->page_name)

                @case('details')
                    @include('trip.trip_details.trip_details')
                    @include('trip.transection_list')
                    @break

                @case('transection')
                    @include('trip.trip_details.trip_details')
                    @include('trip.transection_list')

                    @if($trip && ($trip->type == 'own_vehicle_single'))

                        @include('trip.transection_form.own_vehicle_single')

                    @elseif($trip && ($trip->type == 'own_vehicle_up_down'))

                        @include('trip.transection_form.own_vehicle_up_down')

                    @elseif($trip && ($trip->type == 'out_commission_transection'))

                        @include('trip.transection_form.out_commission_transection')
                        
                    @endif

                    @break

                @case('demarage')
                    @include('trip.trip_details.trip_details')

                        @if($trip && ($trip->type == 'own_vehicle_single'))

                            @include('trip.demurrage_form.own_vehicle_single')

                        @elseif($trip && ($trip->type == 'own_vehicle_up_down'))

                            @include('trip.demurrage_form.own_vehicle_up_down')
                        
                        @elseif($trip && ($trip->type == 'out_commission_transection' || $trip->type == 'out_commission'))
                            
                            @include('trip.demurrage_form.out_commission_transection')
                            
                        @endif

                    @break

                @case('general_expense')
                    @include('trip.trip_details.trip_details')
                    @include('trip.trip_general_expense_form')
                    @break

                {{-- own vehicle --}}
                @case('oil_expense')
                    @include('trip.trip_details.trip_details')
                    @include('trip.trip_oil_expense_form')
                    @break

                @case('meter')
                    @include('trip.trip_details.trip_details')  
                    @include('trip.trip_meter_form')
                    @break

                {{-- for create, edit, copy --}}
                @case('create')
                    @include('trip.trip_form.trip_form')
                    @break
                @case('edit')
                    @include('trip.trip_form.trip_form')
                    @break
                @case('copy')
                    @include('trip.trip_form.trip_form')
                    @break

            @endswitch

            {{-- @if($trip && ($trip->type == 'own_vehicle_single' || $trip->type == 'own_vehicle_up_down'))
                
                @switch($request->page_name)

                    @case('oil_expense')
                        
                        @break

                    @case('meter')
                        
                        @break

                @endswitch
            @endif --}}
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    // payment date
    $('#reservationdate').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    $('#account_take_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    $('#trip_starting_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    $('#transection_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    $('#trip_starting_date_down').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });

    $(function () {
        $('.select2').select2()
    });

    function submitTrip(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('trip_form').submit();
    }

    function submitExpense(){
        document.getElementById("ex_load_icon1").style.display = "inline-block";
        document.getElementById("ex_show_icon1").style.display = "none";
        document.getElementById("ex_show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('ex_form').submit();
    }

    function submitPump(){
        document.getElementById("pump_load_icon1").style.display = "inline-block";
        document.getElementById("pump_show_icon1").style.display = "none";
        document.getElementById("pump_show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('pump_form').submit();
    }

    function changeTransectionAction(){
        $('#transection_action').attr('action', '');
        let transectionType = document.getElementById('transection_type').value;
        if(transectionType == 'porvider_challan_due'){
            $('#transection_action ').attr('action', 'due-payment-to-provider');
            document.getElementById('payment_type').value = 'challan_due';
        } else if (transectionType == 'porvider_demarage_due'){
            $('#transection_action ').attr('action', 'due-payment-to-provider');
            document.getElementById('payment_type').value = 'demarage_due';
        } else if (transectionType == 'company_challan_due'){
            $('#transection_action ').attr('action', 'due-payment-received-from-company');
            document.getElementById('payment_type').value = 'challan_due';
        } else if (transectionType == 'company_demarage_due'){
            $('#transection_action ').attr('action', 'due-payment-received-from-company');
            document.getElementById('payment_type').value = 'demarage_due';
        }
    }

    function submitTransection(){
        document.getElementById("trans_load_icon1").style.display = "inline-block";
        document.getElementById("trans_show_icon1").style.display = "none";
        document.getElementById("trans_show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('transection_action').submit();
    }

    function submitMeter(){
        document.getElementById("meter_load_icon1").style.display = "inline-block";
        document.getElementById("meter_show_icon1").style.display = "none";
        document.getElementById("meter_show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('meter_form').submit();
    }

    // demarage start
    function rowCheck(tripId){
        const checkbox = document.getElementById('checkbox_trip_id_'+ tripId);
        if (checkbox.checked) {
            var html = `<input type="hidden" id="trip_id_${tripId}" name="trip_id" value="${tripId}">`;
            $("#div_of_trip_ids").append(html);
        } else {
            $('#trip_id_'+tripId).remove();
        }
    };
    function addRow(){
        var rowCount = ($('#expense_tbody row').length);
        var html = `
            <div class="row" id="tr_row_${rowCount}">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="date" name="date[]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="number" name="amount[]" class="form-control" value="0" value="{{ old('amount') }}" placeholder="@lang('cmn.amount_here')" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="text"  class="form-control" name="note[]" placeholder="@lang('cmn.note')">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-sm btn-danger" onclick="return removeRow(${rowCount})" title="@lang('cmn.add')"><i class="fa fa-trash"></i></button>
                </div>
            </div>`;
        $("#expense_tbody").append(html);
    }
    function removeRow(row_count){
        if(confirm("Do you really want to do this?")) {
            $('#expense_tbody #tr_row_'+row_count).remove();
        }else{
            return false;
        }
    }
    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;
        event.preventDefault();
        document.getElementById('action').submit();
    }
    // demarage end
</script>
@endpush