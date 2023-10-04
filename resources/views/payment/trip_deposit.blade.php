@extends('layout')
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


            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <form method="POST" action="{{ url('payment-collection') }}">
                            @csrf
                            <input type="hidden" name="company_id" value="{{ $company->id }}">
                            <input type="hidden" name="business_type" value="trip">
                            <div id="div_of_group_ids"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('cmn.deposit_date')</label>
                                        <input type="date" name="date" class="form-control" required="" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('cmn.deposit_amount')</label>
                                        <input type="number" name="amount" class="form-control" value="0" placeholder="@lang('cmn.amount_here')" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="form-control btn btn-sm btn-success"><i class="fa fa-save"></i> @lang('cmn.receive_deposit')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-bordered text-center text-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">#</th>
                                    <th width="30%">@lang('cmn.primary_info')</th>
                                    <th width="25%">@lang('cmn.trip_details')</th>
                                    {{-- <th width="20%">@lang('cmn.income')</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($trips)>0)
                                    @foreach($trips as $trip)
                                    @php $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id) @endphp
                                    <tr class="text-center">
                                        <td>
                                            <input type="checkbox" id="checkbox_group_id_{{$trip->group_id}}" onclick="rowCheck({{$trip->group_id}})" name="group_id" value="{{ $trip->group_id}}" >
                                        </td>
                                        <td class="text-left">
                                            <small>
                                                @if($trip->account_take_date)
                                                @lang('cmn.account_receiving'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                                @endif
                                                @lang('cmn.vehicle'): <b>{{ $trip->vehicle->vehicle_number }}</b><br>
                                                @if($trip->number)
                                                @lang('cmn.trip_number'): <b>{{ $trip->number }}</b><br>
                                                @endif
                                                @lang('cmn.driver'): {{ $trip->vehicle->driver->name }}<br>
                                                @lang('cmn.created'): <b>{{ $trip->user->first_name .' '.$trip->user->last_name}}</b><br>
                                                <br>
                                                <div class="row">
                                                    <div class="btn-group">
                                                        <a href="{{ url('trip-report?type=chalan&group_id='. $trip->group_id) }}" style="margin-right: 3px" class="btn btn-warning btn-xs" target="_blank" aria-label="Trip Chalan"><i class="fa fa-fw fa-print"></i> @lang('cmn.chalan')</a>
                                                    </div>
                                                </div>
                                            </small>
                                        </td>
                                        <td class="text-left">
                                            @if($trip->getTripsByGroupId)
                                                @php $tripLastKey = count($trip->getTripsByGroupId); @endphp
                                                @foreach($trip->getTripsByGroupId as $tripKey => $trip_info)
                                                <small>
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
                                                </small>
                                                <span class="text-danger">
                                                @lang('cmn.due'): <b>{{ number_format($trip_info->due_fair) }}</b><br>
                                                </span>
                                                <small>
                                                    @lang('cmn.discount'): <b>{{ number_format($trip_info->deduction_fair) }}</b><br>
                                                    @if(($tripKey+1) != $tripLastKey)
                                                        <br>
                                                    @endif
                                                </small>
                                                @endforeach
                                            @endif
                                        </td>
                                        {{-- @php
                                            $total_general_expense_sum =  tripExpenseSumByGroupId($trip->group_id);
                                            $total_oil_bill_sum =  tripOilBillSumByGroupId($trip->group_id);
                                            $total_received_rent =  $trip->getTripsByGroupId->sum('advance_fair') + $trip->getTripsByGroupId->sum('received_fair');
                                            $trip_general_exp_lists = tripExpenseListSumByGroupId($trip->group_id);
                                        @endphp
                                        <td class="text-right">
                                            <small>
                                                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                                    @lang('cmn.rent') = <strong>{{ number_format($total_received_rent) }}</strong><br>
                                                    @lang('cmn.total_expense') = <strong>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</strong><br>
                                                </div>
                                                @lang('cmn.net_income') = <strong>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</strong><br>
                                                (<span class="text-danger">@lang('cmn.due') = <strong>{{ number_format($trip->getTripsByGroupId->sum('due_fair')) }}</strong></span>,
                                                @lang('cmn.discount') = <strong>{{ number_format($trip->getTripsByGroupId->sum('deduction_fair')) }}</strong>)
                                            </small>
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
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
            </div>


            <div class="col-md-4">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped table-bordered text-center text-nowrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>{{ $company->name }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-right">
                                            <small>
                                                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                                    @php $trip_present_due_sum = (count($company->tripDueFairHistories))? $company->tripDueFairHistories->sum('due_fair') : 0; @endphp 
                                                    @if($company->trip_receivable_date)
                                                    @lang('cmn.previous_balance') ({{ date('d M, Y', strtotime($company->trip_receivable_date)) }}) : <strong>{{ number_format($company->trip_receivable_amount) }}</strong> <br>
                                                    @endif
                                                    @lang('cmn.present_trip_due') : <strong>{{ number_format($trip_present_due_sum) }}</strong> <br>
                                                </div>
                                                @lang('cmn.total'): <strong>{{ number_format($company->trip_receivable_amount+$trip_present_due_sum) }}</strong>
                                            </small>
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped table-bordered text-center table-hover" id="expense_table">
                                    <thead>
                                        <tr align="center">
                                            <th>#</th>
                                            <th colspan="2">@lang('cmn.deposit_history')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($deposits)>0)
                                        @foreach($deposits as $key => $deposit)
                                        <tr>
                                            <td class="text-center" width="10%">
                                                {{ ++$key }} <br>
                                                <a class="btn btn-xs btn-danger" href="{{ url('payment-collection-histories-delete', $deposit->encrypt) }}" onclick="return confirm(`@lang('cmn.all_information_will_delete_are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td class="text-left" width="50%">
                                                <small>
                                                    @lang('cmn.deposit_date') : <strong>{{ date('d M, Y', strtotime($deposit->date)) }}</strong><br>
                                                    @lang('cmn.deposit'): <strong>{{ number_format($deposit->amount) }}</strong>
                                                </small>
                                            </td>
                                            <td width="40%">
                                                <small>
                                                    @php $histories = json_decode($deposit->amount_history); @endphp
                                                    @if(count($histories)>0)
                                                        @foreach($histories as $history)
                                                            @if(isset($history->trip_id))
                                                                @lang('cmn.trip') : <small>{{ $history->trip_id }}</small>
                                                            @else
                                                                @lang('cmn.company') : <small>{{ $history->company_id }}</small>
                                                            @endif
                                                            @lang('cmn.amount') : <small>{{ $history->amount }}</small>
                                                        @endforeach
                                                    @endif
                                                </small>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3">
                                                <small>
                                                    @lang('cmn.empty_table')
                                                </small>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script type="text/javascript">
    function rowCheck(groupId){
        const checkbox = document.getElementById('checkbox_group_id_'+ groupId);
        if (checkbox.checked) {
            var html = `<input type="hidden" id="group_id_${groupId}" name="group_id[]" value="${groupId}">`;
            $("#div_of_group_ids").append(html);
        } else {
            $('#group_id_'+groupId).remove();
        }
    };
</script>
@endpush