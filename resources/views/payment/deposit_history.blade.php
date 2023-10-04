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
                <h3 class="card-title">@lang('cmn.deposit_history') : <strong>{{ $company->name }}</strong></h3>
                <div class="card-tools">
                    <a href="{{ url('payments?type=company&id='.$company->encrypt.'&page=trip-deposit') }}" class="btn btn-xs btn-success" title="@lang('cmn.receive_deposit_of_trip')"><i class="fa fa-plus"></i> @lang('cmn.receive_deposit_of_trip')</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center table-hover" id="expense_table">
                    <thead>
                        <tr align="center">
                            <th>#</th>
                            <th colspan="2">@lang('cmn.details')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($deposits)>0)
                        @foreach($deposits as $key => $deposit)
                        <tr>
                            <td class="text-center">{{ ++$key }}</td>
                            <td class="text-left">
                                @lang('cmn.deposit_date') : {{ $deposit->date }} <br>
                                @lang('cmn.total') @lang('cmn.deposit'): <strong>{{ number_format($deposit->amount) }}</strong><br>
                                <a class="btn btn-xs btn-danger" href="{{ url('payment-collection-histories-delete', $deposit->encrypt) }}" onclick="return confirm(`@lang('cmn.all_information_will_delete_are_you_sure')`);" title="@lang('cmn.delete')"><i class="fa fa-trash"></i></a>
                            </td>
                            <td>
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
                            </td>
                        </tr>
                        @endforeach
                        {{-- <tfoot>
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
                        </tfoot> --}}
                        @else
                        <tr>
                            <td colspan="3">@lang('cmn.empty_table')</td>
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