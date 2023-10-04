@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

<div class="col-md-3">
    <div class="form-group">
        <select name="per_page" class="form-control">
            <option value="50" {{ old('50', $request->per_page)=='50' ? 'selected':'' }}>@lang('cmn.5')@lang('cmn.0') @lang('cmn.results')</option>
            <option value="100" {{ old('100', $request->per_page)=='100' ? 'selected':'' }}>@lang('cmn.1')@lang('cmn.0')@lang('cmn.0') @lang('cmn.results')</option>
            <option value="500" {{ old('500', $request->per_page)=='500' ? 'selected':'' }}>@lang('cmn.5')@lang('cmn.0')@lang('cmn.0') @lang('cmn.results')</option>
            <option value="1000" {{ old('1000', $request->per_page)=='1000' ? 'selected':'' }}>@lang('cmn.1')@lang('cmn.0')@lang('cmn.0')@lang('cmn.0') @lang('cmn.results')</option>
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <select name="order_by" class="form-control">
            <option value="desc" {{ old('desc',$request->order_by)=='desc' ? 'selected':'' }}>@lang('cmn.from_end') (@lang('cmn.date_wise'))</option>
            <option value="asc" {{ old('asc',$request->order_by)=='asc' ? 'selected':'' }}>@lang('cmn.from_start') (@lang('cmn.date_wise'))</option>
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
@php
    $monthly_field_status = ($request->date_range_status == 'monthly_report')?'block':'none';
@endphp
<div class="col-md-3" id="month_field_all" style="display: {{ $monthly_field_status }};">
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
@php
    $year_field_status = ($request->date_range_status == 'monthly_report' || $request->date_range_status == 'yearly_report')?'block':'none';
@endphp
<div class="col-md-3" id="year_field_all" style="display: {{ $year_field_status }};">
    <div class="form-group">
        <select name="year" class="form-control">
            <option value="">@lang('cmn.select_year')</option>
            @foreach(range(date('Y'), 2010) as $year)
            <option value="{{$year}}" {{ old('year',$request->year)==$year? 'selected':'' }}>@lang('cmn.'.$year.'')</option>
            @endforeach
        </select>
    </div>
</div>
@php
    $daterange_field_status = ($request->date_range_status == 'date_wise')?'block':'none';
@endphp
<div class="col-md-3" id="daterange_field_all" style="display: {{ $daterange_field_status }};">
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

@push('js')
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
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

    // datarange visible after reload papge
    $( document ).ready(function() {
        $(function () {
            $('#reservation_all').daterangepicker();
        })
    });
</script>
@endpush