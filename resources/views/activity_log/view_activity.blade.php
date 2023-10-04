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
                <h3 class="card-title">Activities of {{$user->name}}</h3>
                <div class="card-tools">
                    <a href="{{ url('activity-logs') }}" class="btn btn-md btn-primary pull-right" title="Activity Log"><i class="fas fa-arrow-left"></i> Activity Log</a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>Action</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->action }}</td>
                            <td>{{ $list->created_at }}</td>
                        </tr>
                        @endforeach
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