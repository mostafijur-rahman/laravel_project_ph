@extends('layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"></section>
    <!-- Main content -->
    <section class="content">
        <div class="card">
            @csrf
            <div class="card-header">
                <h3 class="card-title"><strong>{{ $company->name }}</strong> @lang('cmn.from_our_receivable')</h3>
                <div class="card-tools">
                    <a href="{{ url('/payments?type=company') }}" class="btn btn-xs btn-primary">@lang('cmn.payment') @lang('cmn.list')</a>
                    <a class="btn btn-xs btn-success" href="{{ url('payments?type=company&encrypt='.$company->encrypt.'&history=collection') }}" title="@lang('cmn.do_collection')">@lang('cmn.add_collection')</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center table-hover" id="expense_table">
                    <thead>
                        <tr align="center">
                            <th>#</th>
                            <th>@lang('cmn.trip') @lang('cmn.details')</th>
                            <th>@lang('cmn.transection_with_company')</th>
                            <th>@lang('cmn.our_receivable')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($company->transport_due_fair_histories))
                        @foreach($company->transport_due_fair_histories as $key => $transport_due_fair_history)
                        <tr align="center">
                            <td class="text-center">
                                {{ ++$key }} &nbsp;
                            </td>
                            <td class="text-left">
                                <small>
                                    @lang('cmn.start_date'): {{ date('d M, Y', strtotime($transport_due_fair_history->date)) }} @if($setComp['transport_booking_time'] > 0)({{$transport_due_fair_history->load_time->time}})@endif<br>
                                    @lang('cmn.vehicle'): {{ $transport_due_fair_history->vehicle->vehicle_number }}, @lang('cmn.driver'): {{ $transport_due_fair_history->vehicle->driver->name }}<br>
                                    @lang('cmn.route'): <strong>{{ $transport_due_fair_history->load_data->name }}</strong> থেকে <strong>{{ $transport_due_fair_history->unload->name }}</strong> @if($setComp['transport_booking_distance'] > 0)({{$transport_due_fair_history->distance}} @lang('cmn.km'))@endif<br>
                                    @lang('cmn.suppliers'): <strong>{{ $transport_due_fair_history->supplier->name }}</strong><br>
                                    @lang('cmn.market_rate'): <strong>{{ number_format($transport_due_fair_history->supplier_contract_fair) }}</strong>
                                </small>
                            </td>
                            <td class="text-left">
                                <small>
                                    @lang('cmn.contract_rent'): {{number_format($transport_due_fair_history->company_contract_fair)}}<br>
                                    @lang('cmn.total') @lang('cmn.deposit'): {{number_format($transport_due_fair_history->company_received_fair)}}<br>
                                    @lang('cmn.advance'): {{number_format($transport_due_fair_history->company_advance_fair)}}<br>
                                    @lang('cmn.discount') = {{ number_format($transport_due_fair_history->company_deduction_fair) }}
                                </small>
                            </td>
                            <td><strong>{{ number_format($transport_due_fair_history->company_due_fair) }}</strong></td>
                        </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>@lang('cmn.total') =</strong></td>
                                <td>{{ number_format($company->transport_due_fair_histories->sum("company_due_fair")) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>@lang('cmn.previous_balance') =</strong></td>
                                <td>{{ number_format($company->receivable_amount) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>@lang('cmn.total') @lang('cmn.our_receivable') =</strong></td>
                                <td><strong>{{ number_format($company->transport_due_fair_histories->sum("company_due_fair") + $company->receivable_amount) }}</strong></td>
                            </tr>
                        </tfoot>
                        @else
                        <tr>
                            <td colspan="4">@lang('cmn.empty_table')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection