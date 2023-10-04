@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                {{-- <form method="GET" name="form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name_phone" value="{{ old('name_phone') }}" placeholder="Name or Phone">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                            </div>
                        </div>
                    </div>
                </form> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.company_name')</th>
                            <th>@lang('cmn.previous_trip_balance')</th>
                            <th>@lang('cmn.present_trip_due')</th>
                            {{-- <th>@lang('cmn.previous_transport_balance')</th> --}}
                            {{-- <th>@lang('cmn.present_transport_due')</th> --}}
                            {{-- <th>@lang('cmn.total')</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $trip_receivable_total = 0;
                            $trip_present_due_total = 0;
                            $transport_receivable_total = 0;
                            $transport_present_total = 0;
                        @endphp
                        @foreach($lists as $key => $list)
                        @php
                            $trip_receivable_total += $list->trip_receivable_amount;  
                            $trip_present_due_sum = (count($list->tripDueFairHistories))? $list->tripDueFairHistories->sum('due_fair') : 0;
                            $trip_present_due_total += $trip_present_due_sum;
                        @endphp
                        <tr class="text-center">
                       		<td>{{ ++$key }}</td>
                       		<td class="text-left">
                                <small>{{ $list->name }}</small>
                                <br>
                                <div class="row">
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-primary" style="margin-right: 3px" href="{{ url('payments?type=company&id='.$list->encrypt.'&history=deposit') }}" title="@lang('cmn.deposit_history')"><i class="fa fa-list"></i> @lang('cmn.deposit_history')</a>
                                        <a class="btn btn-xs btn-success" href="{{ url('payments?type=company&id='.$list->encrypt.'&page=trip-deposit') }}" title="@lang('cmn.receive_deposit_of_trip')"><i class="fa fa-plus"></i> @lang('cmn.receive_deposit_of_trip')</a>
                                    </div>
                                </div>
                            </td>
                       		<td>
                               {{ number_format($list->trip_receivable_amount) }}<br>
                               @if($list->trip_receivable_date)
                                <small>
                                    @lang('cmn.date'): ({{ date('d M, Y', strtotime($list->trip_receivable_date)) }})
                                </small>
                                @endif
                            </td>
                            <td>
                                {{ number_format($trip_present_due_sum) }}
                            </td>
                            {{-- <td>
                                {{ number_format($list->transport_receivable_amount) }}<br>
                                @if($list->transport_receivable_date)
                                <small>
                                    @lang('cmn.date'): ({{ date('d M, Y', strtotime($list->transport_receivable_date)) }})
                                </small>
                                @endif
                            </td>
                            <td>
                                0
                            </td> --}}
                            {{-- <td>0</td> --}}
                        </tr>
                        @endforeach
                        <tr class="text-center">
                            <td colspan="2" class="text-right">
                                <strong>@lang('cmn.total') =</strong>
                            </td>
                            <td>
                                <strong>{{ number_format($trip_receivable_total) }}</strong>
                            </td>
                            <td>
                                <strong>{{ number_format($trip_present_due_total) }}</strong>
                            </td>
                            {{-- <td>
                                <strong>{{ number_format($transport_receivable_total) }}</strong>
                            </td>
                            <td>
                                <strong>{{ number_format($transport_present_total) }}</strong>
                            </td> --}}
                            {{-- <td>0</td> --}}
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection