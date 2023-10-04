@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"></section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>Date</th>
                            <th>Head</th>
                            <th>Cash In</th>
                            <th>Cash Out</th>
                            <th>Balance</th>
                            <th>User Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty(count($account_data)))
                        @foreach($account_data as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->moment }}</td>
                            <td>{{ str_replace("_", " ", $list->head) }}</td>
                            <td>{{ number_format($list->cash_in)?: 0 }}</td>
                            <td>{{ number_format($list->cash_out)?: 0 }}</td>
                            <td>{{ number_format($list->balance)?: 0 }}</td>
                            <td>{{ $list->user->first_name ." ". $list->user->last_name }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="paginate" style="float: right; margin-top: 10px; margin-right: 10px;">
                    {!! $account_data->links() !!}
                </div>
            </div>
            
            <!-- /.card-body -->
        </div>
        
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection