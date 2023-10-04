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
                <form method="GET" name="form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name_phone" value="{{ old('name_phone') }}" placeholder="Name or Phone">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:25%">@lang('cmn.client') @lang('cmn.name')</th>
                            <th style="width:15%">@lang('cmn.previous_due') (@lang('cmn.due'))</th>
                            <th style="width:15%">@lang('cmn.entry') @lang('cmn.due')</th>
                            <th style="width:15%">@lang('cmn.total') @lang('cmn.due')</th>
                            <th style="width:20%">@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sum_prev_due = 0;
                            $sum_entry_due = 0;
                            $sum_total_due = 0;
                        @endphp
                        @foreach($clients as $key=>$list)
                        @php
                            $client_trans_due = (count($list->due_transports))? $list->due_transports->sum('trans_client_due_fair') : 0;
                            $client_total = (count($list->due_trips))? $list->due_trips->sum('trip_due_fair') : 0;
                            // summation previous
                            $sum_prev_due += $list->client_prev_due;
                            // summation entry
                            $sum_entry_due += $client_total;
                            $sum_entry_due += $client_trans_due;
                            // summation total
                            $sum_total_due += $client_total;
                            $sum_total_due += $client_trans_due;
                            $sum_total_due += $list->client_prev_due;
                        @endphp
                        <tr>
                       		<td>{{ ++$key }}</td>
                       		<td>{{ $list->client_name }}</td>
                       		<td class="text-danger"><strong>{{ number_format($list->client_prev_due) }}</strong></td>
                            <td class="text-danger"><strong>{{ number_format($client_total + $client_trans_due) }}</strong></td>
                            <td class="text-danger"><strong>{{ number_format($client_total + $client_trans_due+$list->client_prev_due) }} </strong></td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ url('due-histories', $list->client_encrypt ) }}" title="পেমেন্ট ইতিহাস">বকেয়া ইতিহাস</a>
                                <a class="btn btn-sm btn-success" href="{{ url('collection-histories', $list->client_encrypt ) }}" title="কালেকশন ইতিহাস">কালেকশন ইতিহাস</a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-right">মোট = </td>
                            <td class="text-danger"><strong>{{ number_format($sum_prev_due) }}</strong></td>
                            <td class="text-danger"><strong>{{ number_format($sum_entry_due) }}</strong></td>
                            <td class="text-danger"><strong>{{ number_format($sum_total_due) }}</strong></td>
                            <td></td>
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