@extends('layout')
@section('content')
<style type="text/css">
    .required{
        color: red;
        font-weight: bold;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h4>"{{ $client->client_name}}" বকেয়া হিসাব </h4>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
            <div class="card">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Trip Due History</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-bordered text-center table-hover" id="expense_table">
                        <thead>
                            <tr align="center">
                                <th>Sl</th>
                                <th>তারিখ</th>
                                <th>Vehicle no</th>
                                <th>Trip no</th>
                                <th>amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($client->dues))
                            @foreach($client->dues as $key => $list)
                            <tr align="center">
                                <td>{{ ++$key }}</td>
                                <td>{{ $list->date }}</td>
                                <td>
                                    @if($list->table_name  == "trips")
                                    {{ get_trip_by_id($list->table_id)->car->car_number }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($list->table_name  == "trips")
                                    {{ get_trip_by_id($list->table_id)->trip_no }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ number_format($list->amount) }}</td>
                            </tr>
                            
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><b>Total</b></td>
                                    <td>{{ number_format($client->dues->sum("amount")) }}</td>
                                </tr>
                            </tfoot>
                            @else
                            <tr>
                                <td colspan="5">Opps!!, No due history found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="card">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Transport Due History</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-bordered text-center table-hover" id="expense_table">
                        <thead>
                            <tr align="center">
                                <th>Sl</th>
                                <th>তারিখ</th>
                                <th>Vehicle no</th>
                                <th>Transport no</th>
                                <th>amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($client->due_transports))
                            @foreach($client->due_transports as $key => $trans_due)
                            <tr align="center">
                                <td>{{ ++$key }}</td>
                                <td>{{ $trans_due->trans_date }}</td>
                                <td>{{ $trans_due->car->car_number }}</td>
                                <td>{{ ($trans_due->trans_no)?: '---' }}</td>
                                <td>{{ number_format($trans_due->trans_client_due_fair) }}</td>
                            </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><b>Total</b></td>
                                    <td>{{ number_format($client->due_transports->sum("trans_client_due_fair")) }}</td>
                                </tr>
                            </tfoot>
                            @else
                            <tr>
                                <td colspan="5">Opps!!, No due history found.</td>
                            </tr>
                            @endif
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