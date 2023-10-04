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
            <div class="col-md-12">
                <div class="card">
                    @include('company.filter')
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-bordered text-center text-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">#</th>
                                    <th>@lang('cmn.vehicle_number')</th>
                                    <th>@lang('cmn.trip_number')</th>
                                    <th>@lang('cmn.voucher_id')</th>
                                    <th>@lang('cmn.payment_date')</th>
                                    <th>@lang('cmn.payment_method')</th>
                                    <th>@lang('cmn.amount')</th>
                                    <th>@lang('cmn.receiver_name')</th>
                                    <th>@lang('cmn.receiver_phone')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($challans)>0)
                                    @foreach($challans as $key => $challan)
                                    <tr class="text-center">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $challan->trip->provider->vehicle_number }}</td>
                                        <td>{{ $challan->trip->number }}</td>
                                        <td>{{ $challan->voucher_id??'---' }}</td>
                                        <td>{{ $challan->date }}</td>
                                        <td>{{ $challan->transection->account->account_number }} ({{ $challan->transection->account->user_name }})</td>
                                        <td>{{ number_format($challan->amount) }}</td>
                                        <td>{{ $challan->recipients_name??'---' }}</td>
                                        <td>{{ $challan->recipients_phone??'---' }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{ $challans->appends(Request::input())->links() }}
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@include('include.unique_challan_numbers')
@include('include.unique_vehicle_numbers')
@include('include.unique_voucher_id')
@endsection