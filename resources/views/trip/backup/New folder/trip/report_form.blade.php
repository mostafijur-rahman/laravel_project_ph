@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <section class="content">
        <form method="GET" action="{{ url('trip-report') }}" target="_blank">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ট্রিপ @lang('cmn.report_form') (চালানের ফরম্যাট)</h3>
                </div>
                <div class="card-body">
                    <input type="hidden" name="report_name" value="challan">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="order_by" class="form-control">
                                    <option value="asc" {{ old('asc',$request->order_by)=='asc' ? 'selected':'' }}>@lang('cmn.from_start')</option>
                                    <option value="desc" {{ old('desc',$request->order_by)=='desc' ? 'selected':'' }}>@lang('cmn.from_end')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="paid_status" class="form-control">
                                    <option value="">@lang('cmn.all_challan')</option>
                                    <option value="due_challan" {{ old('challan_due',$request->paid_status)=='due_challan' ? 'selected':'' }}>@lang('cmn.due_challan')</option>
                                    <option value="paid_challan" {{ old('challan_received',$request->paid_status)=='paid_challan' ? 'selected':'' }}>@lang('cmn.paid_challan')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="date_range_status" id="range_status_all" onchange="dateRangeVisibility('all')" class="form-control">
                                    <option value="all_time" {{ old('all_time',$request->date_range_status)=='all_time' ? 'selected':'' }}>@lang('cmn.all_time')</option>
                                    <option value="monthly_report" {{ old('monthly_report',$request->date_range_status)=='monthly_report' ? 'selected':'' }}>@lang('cmn.monthly_report')</option>
                                    <option value="yearly_report" {{ old('yearly_report',$request->date_range_status)=='yearly_report' ? 'selected':'' }}>@lang('cmn.yearly_report')</option>
                                    <option value="date_wise" {{ old('date_wise',$request->date_range_status)=='date_wise' ? 'selected':'' }}>@lang('cmn.date_wise')</option>                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="month_field_all" style="display: none;">
                            <div class="form-group">
                                <select name="month" class="form-control">
                                    <option value="">@lang('cmn.select_month')</option>
                                    <option value="1" {{ old('month',$request->month)==1 ? 'selected':'' }}>@lang('cmn.january')</option>
                                    <option value="2" {{ old('month',$request->month)==2 ? 'selected':'' }}>@lang('cmn.february')</option>
                                    <option value="3" {{ old('month',$request->month)==3 ? 'selected':'' }}>@lang('cmn.march')</option>
                                    <option value="4" {{ old('month',$request->month)==4 ? 'selected':'' }}>@lang('cmn.april')</option>
                                    <option value="5" {{ old('month',$request->month)==5 ? 'selected':'' }}>@lang('cmn.may')</option>
                                    <option value="6" {{ old('month',$request->month)==6 ? 'selected':'' }}>@lang('cmn.june')</option>
                                    <option value="7" {{ old('month',$request->month)==7 ? 'selected':'' }}>@lang('cmn.july')</option>
                                    <option value="8" {{ old('month',$request->month)==8 ? 'selected':'' }}>@lang('cmn.august')</option>
                                    <option value="9" {{ old('month',$request->month)==9 ? 'selected':'' }}>@lang('cmn.september')</option>
                                    <option value="10" {{ old('month',$request->month)==10 ? 'selected':'' }}>@lang('cmn.october')</option>
                                    <option value="11" {{ old('month',$request->month)==11 ? 'selected':'' }}>@lang('cmn.november')</option>
                                    <option value="12" {{ old('month',$request->month)==12 ? 'selected':'' }}>@lang('cmn.devember')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="year_field_all" style="display: none;">
                            <div class="form-group">
                                <select name="year" class="form-control">
                                    <option value="">@lang('cmn.select_year')</option>
                                    @foreach(range(date('Y'), 2010) as $year)
                                    <option value="{{$year}}" {{ old('year',$request->year)==$year? 'selected':'' }}>@lang('cmn.'.$year.'')</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="daterange_field_all" style="display: none;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation_all" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" list="challan_number_else" name="trip_number" value="{{ old('number', $request->trip_number) }}" placeholder="@lang('cmn.write_trip_number_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" list="vehicle_number_else" name="vehicle_number" value="{{ old('vehicle_number', $request->vehicle_number) }}" placeholder="@lang('cmn.write_vehicle_number_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="provider_driver" list="provider_driver_name_else" value="{{ old('provider_driver', $request->provider_driver) }}" placeholder="@lang('cmn.write_driver_name_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="provider_owner" list="provider_owner_name_else" value="{{ old('provider_owner', $request->provider_owner) }}" placeholder="@lang('cmn.write_owner_name_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="provider_reference" list="provider_reference_name_else" value="{{ old('provider_reference', $request->provider_reference) }}" placeholder="@lang('cmn.write_reference_name_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2" name="vehicle_id">
                                    <option value="">@lang('cmn.all_vehicle')</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->number_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2" name="company_id">
                                    <option value="">@lang('cmn.all_company')</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="primary_info" checked>
                                    <label class="form-check-label">প্রাথমিক তথ্য</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="vehicle_transection" checked>
                                    <label class="form-check-label">গাড়ীর লেনদেন</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="company_transection" checked>
                                    <label class="form-check-label">কোম্পানীর লেনদেন</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="comission" checked>
                                    <label class="form-check-label">কমিশন</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="trip_deposit_expense" checked>
                                    <label class="form-check-label">নিজেস্ব ট্রিপের জমা - খরচ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success" onclick="downloadPdf('false')">
                            <i class="fa fa-print"></i> @lang('cmn.show_report')
                        </button>
                        <button type="submit" class="btn btn-sm btn-warning" onclick="downloadPdf('true')">
                            <i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')
                        </button>
                        <a href="{{ url('trip-report-form') }}" class="btn btn-sm btn-info">
                            <i class="fa fa-times"></i> @lang('cmn.clear')
                        </a>
                        <input type="hidden" name="download_pdf" id="download_pdf" value="false">
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ট্রিপ @lang('cmn.report_form') (এক লাইনে সমস্ত রিপোর্ট)</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url('trip-report') }}" id="form" target="_blank">
                    <div class="row">
                        <input type="hidden" name="report_name" value="all_info_in_single_row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="order_by" class="form-control">
                                    <option value="asc" {{ old('asc',$request->order_by)=='asc' ? 'selected':'' }}>@lang('cmn.from_start')</option>
                                    <option value="desc" {{ old('desc',$request->order_by)=='desc' ? 'selected':'' }}>@lang('cmn.from_end')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="date_range_status" id="range_status_2" onchange="dateRangeVisibility('2')" class="form-control">
                                    <option value="all_time" {{ old('all_time',$request->date_range_status)=='all_time' ? 'selected':'' }}>@lang('cmn.all_time')</option>
                                    <option value="monthly_report" {{ old('monthly_report',$request->date_range_status)=='monthly_report' ? 'selected':'' }}>@lang('cmn.monthly_report')</option>
                                    <option value="yearly_report" {{ old('yearly_report',$request->date_range_status)=='yearly_report' ? 'selected':'' }}>@lang('cmn.yearly_report')</option>
                                    <option value="date_wise" {{ old('date_wise',$request->date_range_status)=='date_wise' ? 'selected':'' }}>@lang('cmn.date_wise')</option>                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="month_field_2" style="display: none;">
                            <div class="form-group">
                                <select name="month" class="form-control">
                                    <option value="">@lang('cmn.select_month')</option>
                                    <option value="1" {{ old('month',$request->month)==1 ? 'selected':'' }}>@lang('cmn.january')</option>
                                    <option value="2" {{ old('month',$request->month)==2 ? 'selected':'' }}>@lang('cmn.february')</option>
                                    <option value="3" {{ old('month',$request->month)==3 ? 'selected':'' }}>@lang('cmn.march')</option>
                                    <option value="4" {{ old('month',$request->month)==4 ? 'selected':'' }}>@lang('cmn.april')</option>
                                    <option value="5" {{ old('month',$request->month)==5 ? 'selected':'' }}>@lang('cmn.may')</option>
                                    <option value="6" {{ old('month',$request->month)==6 ? 'selected':'' }}>@lang('cmn.june')</option>
                                    <option value="7" {{ old('month',$request->month)==7 ? 'selected':'' }}>@lang('cmn.july')</option>
                                    <option value="8" {{ old('month',$request->month)==8 ? 'selected':'' }}>@lang('cmn.august')</option>
                                    <option value="9" {{ old('month',$request->month)==9 ? 'selected':'' }}>@lang('cmn.september')</option>
                                    <option value="10" {{ old('month',$request->month)==10 ? 'selected':'' }}>@lang('cmn.october')</option>
                                    <option value="11" {{ old('month',$request->month)==11 ? 'selected':'' }}>@lang('cmn.november')</option>
                                    <option value="12" {{ old('month',$request->month)==12 ? 'selected':'' }}>@lang('cmn.devember')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="year_field_2" style="display: none;">
                            <div class="form-group">
                                <select name="year" class="form-control">
                                    <option value="">@lang('cmn.select_year')</option>
                                    @foreach(range(date('Y'), 2010) as $year)
                                    <option value="{{$year}}" {{ old('year',$request->year)==$year? 'selected':'' }}>@lang('cmn.'.$year.'')</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="daterange_field_2" style="display: none;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation_2" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" list="challan_number_else" name="trip_number" value="{{ old('number', $request->trip_number) }}" placeholder="@lang('cmn.write_trip_number_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" list="vehicle_number_else" name="vehicle_number" value="{{ old('vehicle_number', $request->vehicle_number) }}" placeholder="@lang('cmn.write_vehicle_number_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="provider_driver" list="provider_driver_name_else" value="{{ old('provider_driver', $request->provider_driver) }}" placeholder="@lang('cmn.write_driver_name_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="provider_owner" list="provider_owner_name_else" value="{{ old('provider_owner', $request->provider_owner) }}" placeholder="@lang('cmn.write_owner_name_here')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="provider_reference" list="provider_reference_name_else" value="{{ old('provider_reference', $request->provider_reference) }}" placeholder="@lang('cmn.write_reference_name_here')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2" name="vehicle_id">
                                    <option value="">@lang('cmn.all_vehicle')</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->number_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2" name="company_id">
                                    <option value="">@lang('cmn.all_company')</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('false')">
                                    <i class="fa fa-file-alt"></i> @lang('cmn.show_report')
                                </button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('true')">
                                    <i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')
                                </button>
                                <input type="hidden" name="download_pdf" id="download_pdf" value="false">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@include('include.unique_challan_numbers')
@include('include.unique_vehicle_numbers')
@include('include.unique_provider_driver_names')
@include('include.unique_provider_owner_names')
@include('include.unique_provider_reference_names')
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    function dateRangeVisibility(formType){
        // variable assign
        let range_status_type = "range_status_"+formType;
        let month = "month_field_"+formType;
        let year = "year_field_"+formType;
        let daterange = "daterange_field_"+formType;
        let reservation = "#reservation_"+formType;

        let range_status = document.getElementById(range_status_type).value;
        if(range_status == 'monthly_report'){
            document.getElementById(month).style.display = "block";
            document.getElementById(year).style.display = "block";
            document.getElementById(daterange).style.display = "none";
            // reservation
            $(function () {
                $(reservation).daterangepicker();
            })
        } else if(range_status == 'yearly_report'){
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "block";
            document.getElementById(daterange).style.display = "none";
            // reservation
            $(function () {
                $(reservation).daterangepicker();
            })
        } else if(range_status == 'date_wise'){
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "none";
            document.getElementById(daterange).style.display = "block";
            // reservation
            $(function () {
                $(reservation).daterangepicker();
            })
        }else{
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "none";
            document.getElementById(daterange).style.display = "none";
        }
    }
    function downloadPdf(value){
        $("#download_pdf").val(value)

        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;

        document.getElementById("load_icon2").style.display = "inline-block";
        document.getElementById("show_icon2").style.display = "none";
        document.getElementById("show_btn2").disabled=true;

        event.preventDefault();
        document.getElementById('form').submit();
    }

</script>
@endpush