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
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.transection') @lang('cmn.report') @lang('cmn.form')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('tyre-report') }}" target="_blank">
                    <div class="row">
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
                                    <input type="text" class="form-control float-right" id="reservation_all" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="attached" {{ old('attached',$request->status)=='attached' ? 'selected':'' }}>@lang('cmn.attached')</option>
                                    <option value="not_attached" {{ old('not_attached',$request->status)=='not_attached' ? 'selected':'' }}>@lang('cmn.not_attached')</option>                               
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
    function downloadPdf(value){
        $("#download_pdf").val(value)
    }
</script>
@endpush