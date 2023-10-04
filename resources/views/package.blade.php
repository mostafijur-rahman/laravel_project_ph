@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('settings.submenu')
            {{-- <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#"><strong>{{ $title }}</strong></a></li>
                    </ol>
                </div>
            </div> --}}
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>বিষয়</th>
                            <th>বিস্তারিত</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>প্যাকেজের নাম</td>
                            <td>Starter Package (5 Vehicle)</td>
                        </tr>
                        <tr>
                            <td>প্যাকেজের মূল্য</td>
                            <td>5,000</td>
                        </tr>
                        <tr>
                            <td>সেবা গ্রহণের তারিখ</td>
                            <td>01 jan 2020</td>
                        </tr>
                        <tr>
                            <td>বাৎসরিক চার্জ</td>
                            <td>5,000</td>
                        </tr>
                        <tr>
                            <td>বাৎসরিক চার্জ দেয়ার তারিখ</td>
                            <td>10 Dec 2020 (120 days)</td>
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