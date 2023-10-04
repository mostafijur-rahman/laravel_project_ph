@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form method="POST" id="action" action="{{ url('trip-demarage-save') }}">
                        <div id="div_of_trip_ids"></div>
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">@lang('cmn.demarage_entry') @lang('cmn.form')</h3>
                            <button type="button" class="btn btn-primary btn-sm float-right" onclick="addRow()"><i class="fa fa-plus"></i></button>
                            <button type="button" id="show_btn1" class="btn btn-success btn-sm float-right" style="margin-right: 10px;" onclick="submitForm()">
                                <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                            </button>
                        </div>
                        <div class="card-body">
                            @php $tr_row_no = 1; @endphp
                            <div id="expense_tbody">
                                <div class="row" id="tr_row_{{$tr_row_no}}">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.bill_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <div class="input-group date" id="date" data-target-input="nearest">
                                                <input type="text" name="date[]" class="form-control datetimepicker-input" value="{{ date('d/m/Y') }}" data-target="#reservationdate" required>
                                                <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.amount') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="number" name="amount[]" class="form-control" value="0" value="{{ old('amount') }}" placeholder="@lang('cmn.amount_here')" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>@lang('cmn.note') </label>
                                        <input type="text"  class="form-control" name="note[]" placeholder="@lang('cmn.note')">
                                    </div>
                                    <div class="col-md-3">
                                        <label>@lang('cmn.action')</label><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>গাড়ী প্রদানকারীর ডেমারেজ বিল <small class="text-danger">(@lang('cmn.required'))</small></label>
                                    <input type="number" name="provider_demarage" class="form-control" value="0" value="{{ old('provider_demarage') }}" placeholder="@lang('cmn.amount_here')" required>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                @include('trip.trip_mini_list')
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">


    $('#date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY',
    });

    $('#date_0').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY',
    });

    $('#date_1').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY',
    });

    $('#date_2').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY',
    });

    $('#date_3').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY',
    });

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
                        <div class="input-group date" id="date_${rowCount}" data-target-input="nearest">
                            <input type="text" name="date[]" class="form-control datetimepicker-input" value="{{ date('d/m/Y') }}" data-target="#reservationdate" required>
                            <div class="input-group-append" data-target="#date_${rowCount}" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
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
</script>
@endpush