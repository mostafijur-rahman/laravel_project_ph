@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"></section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add {{ $title }}</button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Transection Date</th>
                            <th>Client</th>
                            <th>Loan Received</th>
                            <th>Loan Paid</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->date }}</td>
                            <td>
                                {{ $list->client_id }} <br>
                                <small><strong>Entry: {{ $list->created_by }}</strong></small>
                            </td>
                            <td>{{ $list->cash_in }}</td>
                            <td>{{ $list->cash_out }}</td>
                            <td>{{ $list->balance }}</td>
                            <td>---</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!-- loan Collection Modal -->
            <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ url('loans') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Date <span class="required">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Client <span class="required">*</span></label>
                                    <select  class="form-control" name="client" required>
                                        @if($clients)
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->client_id  }}">{{ $client->client_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Type <span class="required">*</span></label>
                                    <select  class="form-control" name="trans" required>
                                        <option value="cash_in">Loan Received</option>
                                        <option value="cash_out">Loan Paid</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Amount <span class="required">*</span></label>
                                    <input type="number" name="amount" value="0" class="form-control" placeholder="Enter Amount" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Due Collection Modal end-->

        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection