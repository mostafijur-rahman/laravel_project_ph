@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('trip.step')
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">

                <form method="POST" action="">
                    @csrf
                    <div class="row">
                    
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
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th width="30%">@lang('cmn.primary_info')</th>
                            <th width="25%">@lang('cmn.trip_details')</th>
                            <th width="20%">@lang('cmn.income')</th>
                            <th width="20%">@lang('cmn.expense')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($trips)
                            @foreach($trips as $trip)
                            @php $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id) @endphp
                            <tr class="text-center">
                                <td class="text-left">
                                    @if($trip->account_take_date)
                                    @lang('cmn.account_receiving'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                    @endif
                                    @lang('cmn.vehicle'): <b>{{ $trip->vehicle->vehicle_number }}</b><br>
                                    @if($trip->number)
                                    @lang('cmn.trip_number'): <b>{{ $trip->number }}</b><br>
                                    @endif
                                    <small>
                                        @lang('cmn.driver'): {{ $trip->vehicle->driver->name }}<br>
                                    </small>
                                    @if($trip->meter->previous_reading)
                                    <small>
                                        @lang('cmn.start_reading'): {{  number_format($trip->meter->previous_reading) }}<br>
                                        @lang('cmn.last_reading'): {{ number_format($trip->meter->current_reading) }}<br>
                                        @lang('cmn.total') @lang('cmn.km'): {{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}<br>
                                        @if($tripOilLiterSumByGroupId > 0)
                                            @lang('cmn.total') @lang('cmn.fuel'): {{ number_format($tripOilLiterSumByGroupId) }}<br>
                                            @lang('cmn.liter_per_km'): {{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}<br>
                                        @endif
                                    </small>
                                    @endif
                                    <small>
                                        @lang('cmn.created'): <b>{{ $trip->user->first_name .' '.$trip->user->last_name}}</b><br>
                                    </small>
                                    <br>
                                    <div class="row">
                                        <div class="btn-group">
                                            <a href="{{ url('trip-report?type=chalan&group_id='. $trip->group_id) }}" style="margin-right: 3px" class="btn btn-warning btn-xs" target="_blank" aria-label="Trip Chalan"><i class="fa fa-fw fa-print"></i> @lang('cmn.chalan')</a>
                                            <a href="{{ url('new-trips', $trip->group_id) }}" class="btn btn-primary btn-xs" aria-label="Trip Chalan"><i class="fa fa-fw fa-edit"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-left">
                                    @if($trip->getTripsByGroupId)
                                        @php $tripLastKey = count($trip->getTripsByGroupId); @endphp
                                        @foreach($trip->getTripsByGroupId as $tripKey => $trip_info)
                                            @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip_info->date)) }}</b><br>
                                            @lang('cmn.route'): <b>{{ $trip_info->load_data->name }}</b> @lang('cmn.from') <b>{{ $trip_info->unload->name }}
                                                @if($trip_info->trip_distance>0)
                                                ({{ $trip_info->trip_distance + $trip_info->empty_distance }} @lang('cmn.km')))
                                                @endif
                                            </b><br>
                                            @lang('cmn.company'): <b>{{ $trip_info->company->name }}</b><br>
                                            @if($trip_info->goods)
                                                <br>@lang('cmn.goods'): <b>{{ $trip_info->goods }}</b><br>
                                            @endif
                                            @lang('cmn.rent'): <b>{{ number_format($trip_info->contract_fair) }}</b><br>
                                            @lang('cmn.addv_rent'): <b>{{ number_format($trip_info->advance_fair) }}</b><br>
                                            @lang('cmn.due'): <b>{{ number_format($trip_info->due_fair) }}</b><br>
                                            @lang('cmn.discount'): <b>{{ number_format($trip_info->deduction_fair) }}</b><br>
                                            @if(($tripKey+1) != $tripLastKey)
                                                <br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                @php
                                    $total_general_expense_sum =  tripExpenseSumByGroupId($trip->group_id);
                                    $total_oil_bill_sum =  tripOilBillSumByGroupId($trip->group_id);
                                    $total_received_rent =  $trip->getTripsByGroupId->sum('advance_fair') + $trip->getTripsByGroupId->sum('received_fair');
                                    $trip_general_exp_lists = tripExpenseListSumByGroupId($trip->group_id);
                                @endphp
                                <td class="text-right">
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @lang('cmn.rent') = <strong>{{ number_format($total_received_rent) }}</strong><br>
                                        @lang('cmn.total_expense') = <strong>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</strong><br>
                                    </div>
                                    @lang('cmn.net_income') = <strong>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</strong><br>
                                    <small>
                                        (@lang('cmn.due') = <strong>{{ number_format($trip->getTripsByGroupId->sum('due_fair')) }}</strong>,
                                        @lang('cmn.discount') = <strong>{{ number_format($trip->getTripsByGroupId->sum('deduction_fair')) }}</strong>)
                                    </small>
                                </td>
                                <td class="text-right">
                                    <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }}) @lang('cmn.li'))<br>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @if($trip_general_exp_lists)
                                            @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                                            <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}<br>
                                            @endforeach
                                    </div>
                                    <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                                        @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center text-red"><h4>@lang('cmn.at_first_create_chalan')</h4>
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
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    // reservation
    $(function () {
        $('#reservation').daterangepicker();
    })
    // filter related --------------------------------------------------------------------
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
</script>
@endpush