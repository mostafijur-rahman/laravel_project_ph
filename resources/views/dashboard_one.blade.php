@extends('layout')
@push('css')
<style type="text/css">
    .inner{
        background: #fff;
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        border-radius: 10px;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        
    </section>
    <section class="content">

        <form action="dashboard" action="get" id="form">

            <input type="hidden" name="dashboard" value="one">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="time_range" id="time_range_id" class="form-control" onchange="form_submit()">
                            <option value="today" {{ ($request->time_range == 'today')?'selected':'' }}>@lang('cmn.today')</option>
                            <option value="yesterday" {{ ($request->time_range == 'yesterday')?'selected':'' }}>@lang('cmn.yesterday')</option>
                            <option value="last_one_week" {{ ($request->time_range == 'last_one_week')?'selected':'' }}>@lang('cmn.last_one_week')</option>
                            <option value="last_fifteen_days" {{ ($request->time_range == 'last_fifteen_days')?'selected':'' }}>@lang('cmn.last_fifteen_days')</option>
                            <option value="last_thirty_days" {{ ($request->time_range == 'last_thirty_days')?'selected':'' }}>@lang('cmn.last_thirty_days')</option>                                
                            <option value="last_ninety_days" {{ ($request->time_range == 'last_ninety_days')?'selected':'' }}>@lang('cmn.last_ninety_days')</option>
                            <option value="all_time" {{ ($request->time_range == 'all_time')?'selected':'' }}>@lang('cmn.all_time')</option>
                            <option value="date_wise" {{ ($request->time_range == 'date_wise')?'selected':'' }}>@lang('cmn.date_wise')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3" id="daterange_field" style="display: {{ $display }};">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation" name="daterange" value="{{old('daterange', $request->daterange)}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="submit_button" style="display: {{ $display }};">
                    <div class="form-group">
                        <button type="button" class="btn btn-md btn-primary" onclick="submit()">
                            @lang('cmn.search')
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <h4>@setting('client_system.company_name') ({{ $title }})</h4>                     
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($challan_qty) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.challan_qty')</strong></h4>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($received_from_company) }}</strong></h2>
                        <h4 style="color: black"><strong>কোম্পানি থেকে গ্রহণ</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($due_bill_of_company) }}</strong></h2>
                        <h4 style="color: black"><strong>কোম্পানির বিল বাকী</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($paid_bill_to_provider) }}</strong></h2>
                        <h4 style="color: black"><strong>ভাড়া বাবদ প্রদান</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($due_bill_of_provider) }}</strong></h2>
                        <h4 style="color: black"><strong>ভাড়া বাবদ বাকী</strong></h4>
                    </div>
                </div>
            </div> --}}

        </div>


        <br>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($single_challan_deposit) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.single_challan_deposit')</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($single_challan_due) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.single_challan_due')</strong></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($up_down_challan_deposit) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.up_down_challan_deposit')</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($up_down_challan_due) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.up_down_challan_due')</strong></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($total_challan_deposit) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.total_challan_deposit')</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($total_challan_due) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.total_challan_due')</strong></h4>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($inside_challan_general_expense) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.challan_general_expense')</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($outside_challan_general_expense) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.other') @lang('cmn.general_expense')</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($total_general_expense) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.total') @lang('cmn.general_expense')</strong></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($inside_challan_oil_expense) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.challan_oil_expense')</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($outside_challan_oil_expense) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.other') @lang('cmn.oil_expense')</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($total_oil_expense) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.total') @lang('cmn.oil_expense')</strong></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($total_expense) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.total_expense')</strong></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-default text-center">
                    <div class="inner">
                        <h2 class="text-success"><strong>{{ number_format($balance) }}</strong></h2>
                        <h4 style="color: black"><strong>@lang('cmn.balance')</strong></h4>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    function form_submit(){
        let time = document.getElementById('time_range_id').value;

        if(time == 'date_wise'){
            document.getElementById('daterange_field').style.display = "block";
            document.getElementById('submit_button').style.display = "block";

        } else {
            document.getElementById('daterange_field').style.display = "none";
            document.getElementById('submit_button').style.display = "none";

            event.preventDefault();
            document.getElementById('form').submit();
        }
    }

    function submit(){
        event.preventDefault();
        document.getElementById('form').submit();
    }
    $(function () {
        $('#reservation').daterangepicker();
    })
</script>
@endpush