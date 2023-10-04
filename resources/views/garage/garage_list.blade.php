@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
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
                                <input type="text" class="form-control" name="name" value="{{ old('name',$request->name) }}" placeholder="pump name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> Search</button>
                                <a href="{{ url('pump/create') }}" class="btn btn-md btn-success" title="Add"><i class="fas fa-plus"></i> Add</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>Vehicle</th>
                            <th>Date</th>
                            <th>Expense</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>

                            <td class="text-left">
                                No: <b>{{ hybrid_first('cars','car_id',$list->trip_car_id,'car_no')}}</b><br>
                                Number: <b>{{ hybrid_first('cars','car_id',$list->trip_car_id,'car_number')}}</b><br>
                                Driver: <b>{{ hybrid_first('people','people_id',$list->trip_driver_id,'people_name')}}</b>
                            </td>


                            
                            <td>{{ $list->garage_car_id }}</td>
                            <td>{{ $list->garage_expense_date }}</td>
                            <td>{{ $list->garage_expense_id }}</td>
                            <td>{{ $list->garage_expense_amount }}</td>
                            <td>{{ $list->garage_expense_note }}</td>
                            <td>{{ $list->expense_type_created_by }}</td>
                        </tr>
                        @endforeach
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