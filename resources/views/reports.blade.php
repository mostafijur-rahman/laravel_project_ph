@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"></section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- first row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">রিপোর্ট এর ক্যাটাগরি</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="{{ url("trip-report-form") }}" class="btn btn-default btn-block">ট্রিপ সংক্রান্ত রিপোর্ট</a>
                            <a href="{{ url("vehicle-report-form") }}" class="btn btn-default btn-block">গাড়ী সংক্রান্ত রিপোর্ট</a>
                            <a href="{{ url("pump-report-form") }}" class="btn btn-default btn-block">পাম্প সংক্রান্ত রিপোর্ট</a>
                            <a href="{{ url("clients-report-form") }}" class="btn btn-default btn-block">ক্লায়েন্টস সংক্রান্ত রিপোর্ট</a>
                            <a href="{{ url("staff-report-form") }}" class="btn btn-default btn-block">স্টাফ সংক্রান্ত রিপোর্ট</a>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.first row -->
        </div>
    </section>
    <!-- /.Main content -->
</div>
@endsection