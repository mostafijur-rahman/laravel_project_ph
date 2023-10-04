@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            {{-- @include('report_submenu') --}}
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="trip-report" target="_blank">
                    <div class="row">
                        <input type="hidden" name="stage" value="{{ $request->stage }}">
                        <input type="hidden" name="type" value="chalan">
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <select name="date_range_status" id="range_status_all" onchange="dateRangeVisibility('all')" class="form-control">
                                    <option value="all_time" {{ old('all_time',$request->date_range_status)=='all_time' ? 'selected':'' }}>@lang('cmn.all_time')</option>
                                    <option value="monthly_report" {{ old('monthly_report',$request->date_range_status)=='monthly_report' ? 'selected':'' }}>@lang('cmn.monthly_report')</option>
                                    <option value="yearly_report" {{ old('yearly_report',$request->date_range_status)=='yearly_report' ? 'selected':'' }}>@lang('cmn.yearly_report')</option>
                                    <option value="date_wise" {{ old('date_wise',$request->date_range_status)=='date_wise' ? 'selected':'' }}>@lang('cmn.date_wise')</option>                                
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-2" id="month_field_all" style="display: none;">
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
                        <div class="col-md-2" id="year_field_all" style="display: none;">
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
                                <select  class="form-control" name="company">
                                    <option value="">@lang('cmn.select_company')</option>
                                    @if(isset($companies))
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company',$request->company)==$company->id ? 'selected':'' }}>{{ $company->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select  class="form-control" name="vehicle">
                                    <option value="">@lang('cmn.select_vehicle')</option>
                                    @if(isset($vehicles))
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ (old('vehicle',$request->vehicle)==$vehicle->id)?'selected':'' }}>{{ $vehicle->number_plate }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select  class="form-control" name="staff">
                                    <option value="">@lang('cmn.select_driver')</option>
                                    @if(isset($staffs))
                                    @foreach($staffs as $staff)
                                    <option value="{{ $staff->id }}" {{ old('staff',$request->staff)==$staff->id ? 'selected':'' }}>{{ $staff->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('false')"><i class="fa fa-file-alt"></i> @lang('cmn.show_report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf" value="false">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
{{-- <script type="text/javascript">
    // reservation
    $(function () {
        $('#reservation').daterangepicker();
    })
</script> --}}

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
            // reservation
            $(function () {
                $('#reservation_all').daterangepicker();
            })
        } else if(range_status == 'yearly_report'){
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "block";
            document.getElementById(daterange).style.display = "none";
            // reservation
            $(function () {
                $('#reservation_company').daterangepicker();
            })
        } else if(range_status == 'date_wise'){
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "none";
            document.getElementById(daterange).style.display = "block";
            // reservation
            $(function () {
                $('#reservation_supplier').daterangepicker();
            })
        }else{
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "none";
            document.getElementById(daterange).style.display = "none";
        }
    }
    function downloadPdf(value){
        $("#download_pdf").val(value)
    }
</script>
@endpush