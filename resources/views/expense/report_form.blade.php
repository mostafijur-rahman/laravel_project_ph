@extends('layout')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- first format -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.first') @lang('cmn.format')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('expense-report') }}" target="_blank">
                    <input type="hidden" name="format" value="first_format">
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
                                <select name="date_range_status" id="range_status_1" onchange="dateRangeVisibility('1')" class="form-control">
                                    <option value="all_time" {{ old('all_time',$request->date_range_status)=='all_time' ? 'selected':'' }}>@lang('cmn.all_time')</option>
                                    <option value="monthly_report" {{ old('monthly_report',$request->date_range_status)=='monthly_report' ? 'selected':'' }}>@lang('cmn.monthly_report')</option>
                                    <option value="yearly_report" {{ old('yearly_report',$request->date_range_status)=='yearly_report' ? 'selected':'' }}>@lang('cmn.yearly_report')</option>
                                    <option value="date_wise" {{ old('date_wise',$request->date_range_status)=='date_wise' ? 'selected':'' }}>@lang('cmn.date_wise')</option>                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="month_field_1" style="display: none;">
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
                                    <option value="12" {{ old('month',$request->month)==12 ? 'selected':'' }}>@lang('cmn.december')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="year_field_1" style="display: none;">
                            <div class="form-group">
                                <select name="year" class="form-control">
                                    <option value="">@lang('cmn.select_year')</option>
                                    @foreach(range(date('Y'), 2010) as $year)
                                    <option value="{{$year}}" {{ old('year',$request->year)==$year? 'selected':'' }}>@lang('cmn.'.$year.'')</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="daterange_field_1" style="display: none;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation_1" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="expense_id" class="form-control select2">
                                    <option value="">@lang('cmn.all_expense')</option>
                                    @foreach($expenses as $expense)
                                    <option value="{{ $expense->id }}">{{ $expense->head }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="vehicle_id" class="form-control select2">
                                    <option value="">@lang('cmn.all_vehicle')</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->number_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="expense_scope">
                                    <option value="">@lang('cmn.inside_and_outside_of_challan')</option>
                                    <option value="inside_of_challan" {{ ($request->expense_scope == 'inside_of_challan')?'selected':'' }}>@lang('cmn.inside_of_challan')</option>
                                    <option value="outside_of_challan" {{ ($request->expense_scope == 'outside_of_challan')?'selected':'' }}>@lang('cmn.outside_of_challan')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="size">
                                    <option value="A4-L">@lang('cmn.a4') - @lang('cmn.landscape')</option>
                                    <option value="A4-P">@lang('cmn.a4') - @lang('cmn.portrait')</option>
                                    <option value="Legal-P">@lang('cmn.legal') - @lang('cmn.portrait')</option>
                                    <option value="Legal-L">@lang('cmn.legal') - @lang('cmn.landscape')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="page_header">
                                    <option value="only_company_name_in_header">@lang('cmn.only_company_name_in_header')</option>
                                    <option value="all_info_in_header">@lang('cmn.all_info_in_header')</option>
                                    <option value="">@lang('cmn.blank_header')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('1','false')"><i class="fa fa-search"></i> @lang('cmn.report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('1','true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf_1" value="false">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- second format -->
        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.second') @lang('cmn.format')</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('expense-report') }}" target="_blank">
                    <input type="hidden" name="format" value="second_format">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="expense_scope">
                                    <option value="">@lang('cmn.inside_and_outside_of_challan')</option>
                                    <option value="inside_of_challan" {{ ($request->expense_scope == 'inside_of_challan')?'selected':'' }}>@lang('cmn.inside_of_challan')</option>
                                    <option value="outside_of_challan" {{ ($request->expense_scope == 'outside_of_challan')?'selected':'' }}>@lang('cmn.outside_of_challan')</option>
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
                        <div class="col-md-3" id="month_field_2" style="display: none;">
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
                                    <option value="12" {{ old('month',$request->month)==12 ? 'selected':'' }}>@lang('cmn.december')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="year_field_2" style="display: none;">
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
                                <select class="form-control" name="size">
                                    <option value="A4-L">@lang('cmn.a4') - @lang('cmn.landscape')</option>
                                    <option value="A4-P">@lang('cmn.a4') - @lang('cmn.portrait')</option>
                                    <option value="Legal-P">@lang('cmn.legal') - @lang('cmn.portrait')</option>
                                    <option value="Legal-L">@lang('cmn.legal') - @lang('cmn.landscape')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="page_header">
                                    <option value="only_company_name_in_header">@lang('cmn.only_company_name_in_header')</option>
                                    <option value="all_info_in_header">@lang('cmn.all_info_in_header')</option>
                                    <option value="">@lang('cmn.blank_header')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>

                    <h5>@lang('cmn.expenses') (<small class="text-danger">(@lang('cmn.required'))</small>)</h5>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="select_all_expense" onchange="selectedDeselectAll('select_all_expense', 'expense_ids[]')" checked>
                        <label for="select_all_expense" class="custom-control-label">@lang('cmn.select_all')</label>
                    </div>
                    <hr>

                    <div class="row">
                        @if(count($expenses) > 0)
                            @foreach($expenses as $expense_key => $expense)
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="expense_ids[]" value="{{ $expense->id }}" id="expenseCheckBox{{ $expense_key }}" checked>
                                    <label for="expenseCheckBox{{ $expense_key }}" class="custom-control-label">{{ $expense->head }}</label>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <br>
                    <br>

                    <h5>@lang('cmn.vehicles')</h5>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="select_all_vehicle" onchange="selectedDeselectAll('select_all_vehicle', 'vehicle_ids[]')">
                        <label for="select_all_vehicle" class="custom-control-label">@lang('cmn.select_all')</label>
                    </div>
                    <hr>
                    <div class="row">
                        @if(count($vehicles) > 0)
                            @foreach($vehicles as $vehicle_key => $vehicle)
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="vehicle_ids[]" value="{{ $vehicle->id }}" id="vehicleCheckBox{{ $vehicle_key }}">
                                    <label for="vehicleCheckBox{{ $vehicle_key }}" class="custom-control-label">{{ $vehicle->number_plate }}</label>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <br>
                    <br>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('2','false')"><i class="fa fa-search"></i> @lang('cmn.report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('2','true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf_2" value="false">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- third format -->
        <div class="card collapsed-card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
                <h3 class="card-title">@lang('cmn.third') @lang('cmn.format') (@lang('cmn.according_to_date'))</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('expense-report') }}" target="_blank">
                    <input type="hidden" name="format" value="third_format">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="expense_scope">
                                    <option value="">@lang('cmn.inside_and_outside_of_challan')</option>
                                    <option value="inside_of_challan" {{ ($request->expense_scope == 'inside_of_challan')?'selected':'' }}>@lang('cmn.inside_of_challan')</option>
                                    <option value="outside_of_challan" {{ ($request->expense_scope == 'outside_of_challan')?'selected':'' }}>@lang('cmn.outside_of_challan')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="date_range_status" id="range_status_3" onchange="dateRangeVisibility('3')" class="form-control">
                                    {{-- <option value="all_time" {{ old('all_time',$request->date_range_status)=='all_time' ? 'selected':'' }}>@lang('cmn.all_time')</option> --}}
                                    <option value="monthly_report" {{ old('monthly_report',$request->date_range_status)=='monthly_report' ? 'selected':'' }}>@lang('cmn.monthly_report')</option>
                                    <option value="yearly_report" {{ old('yearly_report',$request->date_range_status)=='yearly_report' ? 'selected':'' }}>@lang('cmn.yearly_report')</option>
                                    <option value="date_wise" {{ old('date_wise',$request->date_range_status)=='date_wise' ? 'selected':'' }}>@lang('cmn.date_wise')</option>                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="month_field_3" style="display: block;">
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
                                    <option value="12" {{ old('month',$request->month)==12 ? 'selected':'' }}>@lang('cmn.december')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="year_field_3" style="display: block;">
                            <div class="form-group">
                                <select name="year" class="form-control">
                                    <option value="">@lang('cmn.select_year')</option>
                                    @foreach(range(date('Y'), 2010) as $year)
                                    <option value="{{$year}}" {{ old('year',$request->year)==$year? 'selected':'' }}>@lang('cmn.'.$year.'')</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="daterange_field_3" style="display: none;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation_3" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="size">
                                    <option value="A4-L">@lang('cmn.a4') - @lang('cmn.landscape')</option>
                                    <option value="A4-P">@lang('cmn.a4') - @lang('cmn.portrait')</option>
                                    <option value="Legal-P">@lang('cmn.legal') - @lang('cmn.portrait')</option>
                                    <option value="Legal-L">@lang('cmn.legal') - @lang('cmn.landscape')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="page_header">
                                    <option value="only_company_name_in_header">@lang('cmn.only_company_name_in_header')</option>
                                    <option value="all_info_in_header">@lang('cmn.all_info_in_header')</option>
                                    <option value="">@lang('cmn.blank_header')</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <br>

                    <h5>@lang('cmn.expenses') (<small class="text-danger">(@lang('cmn.required'))</small>)</h5>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="select_all_expense_3" onchange="selectedDeselectAll('select_all_expense_3', 'expense_ids_3[]')" checked>
                        <label for="select_all_expense_3" class="custom-control-label">@lang('cmn.select_all')</label>
                    </div>
                    <hr>

                    <div class="row">
                        @if(count($expenses) > 0)
                            @foreach($expenses as $expense_key => $expense)
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="expense_ids_3[]" value="{{ $expense->id }}" id="expense_check_box_3{{ $expense_key }}" checked>
                                    <label for="expense_check_box_3{{ $expense_key }}" class="custom-control-label">{{ $expense->head }}</label>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <br>
                    <br>

                    <h5>@lang('cmn.vehicles')</h5>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="select_all_vehicle_3" onchange="selectedDeselectAll('select_all_vehicle_3', 'vehicle_ids_3[]')">
                        <label for="select_all_vehicle_3" class="custom-control-label">@lang('cmn.select_all')</label>
                    </div>
                    <hr>
                    <div class="row">
                        @if(count($vehicles) > 0)
                            @foreach($vehicles as $vehicle_key => $vehicle)
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="vehicle_ids_3[]" value="{{ $vehicle->id }}" id="vehicle_check_box_3{{ $vehicle_key }}">
                                    <label for="vehicle_check_box_3{{ $vehicle_key }}" class="custom-control-label">{{ $vehicle->number_plate }}</label>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <br>
                    <br>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('3','false')"><i class="fa fa-search"></i> @lang('cmn.report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('3','true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf_3" value="false">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- four format -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.fourth') @lang('cmn.format') (@lang('cmn.voucher_wise'))</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('expense-report') }}" target="_blank">
                    <input type="hidden" name="format" value="four_format">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="date_range_status" id="range_status_4" onchange="dateRangeVisibility('4')" class="form-control">
                                    <option value="all_time" {{ old('all_time',$request->date_range_status)=='all_time' ? 'selected':'' }}>@lang('cmn.all_time')</option>
                                    <option value="monthly_report" {{ old('monthly_report',$request->date_range_status)=='monthly_report' ? 'selected':'' }}>@lang('cmn.monthly_report')</option>
                                    <option value="yearly_report" {{ old('yearly_report',$request->date_range_status)=='yearly_report' ? 'selected':'' }}>@lang('cmn.yearly_report')</option>
                                    <option value="date_wise" {{ old('date_wise',$request->date_range_status)=='date_wise' ? 'selected':'' }}>@lang('cmn.date_wise')</option>                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="month_field_4" style="display: none;">
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
                                    <option value="12" {{ old('month',$request->month)==12 ? 'selected':'' }}>@lang('cmn.december')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="year_field_4" style="display: none;">
                            <div class="form-group">
                                <select name="year" class="form-control">
                                    <option value="">@lang('cmn.select_year')</option>
                                    @foreach(range(date('Y'), 2010) as $year)
                                    <option value="{{$year}}" {{ old('year',$request->year)==$year? 'selected':'' }}>@lang('cmn.'.$year.'')</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="daterange_field_4" style="display: none;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation_4" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="size">
                                    <option value="A4-L">@lang('cmn.a4') - @lang('cmn.landscape')</option>
                                    <option value="A4-P">@lang('cmn.a4') - @lang('cmn.portrait')</option>
                                    <option value="Legal-P">@lang('cmn.legal') - @lang('cmn.portrait')</option>
                                    <option value="Legal-L">@lang('cmn.legal') - @lang('cmn.landscape')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="page_header">
                                    <option value="only_company_name_in_header">@lang('cmn.only_company_name_in_header')</option>
                                    <option value="all_info_in_header">@lang('cmn.all_info_in_header')</option>
                                    <option value="">@lang('cmn.blank_header')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('4','false')"><i class="fa fa-search"></i> @lang('cmn.report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('4','true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf_4" value="false">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    function dateRangeVisibility(formType){
        // console.log('form_type: '+formType);
        // variable assign
        let range_status_type = "range_status_"+formType;
        let month = "month_field_"+formType;
        let year = "year_field_"+formType;
        let daterange = "daterange_field_"+formType;
        let reservation = "#reservation_"+formType;

        let range_status = document.getElementById(range_status_type).value;

        // console.log('range_status: '+range_status);

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
    function downloadPdf(formType, value){
        let download_pdf = "download_pdf_"+formType;
        document.getElementById(download_pdf).value = value;
    }

    function selectedDeselectAll(selectedField, inputName){  
        if (document.getElementById(selectedField).checked) {
            for(i=0; i<document.getElementsByName(inputName).length; i++){
                document.getElementsByName(inputName)[i].checked = true;
            }
        }
        else {
            for(i=0; i<document.getElementsByName(inputName).length;i++){
                document.getElementsByName(inputName)[i].checked = false;
            }
        }
   }


</script>
@endpush