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
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('vehicle-document-update', $list->car_encrypt) }}"  method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Reg. Number</label>
                                    <input type="text" class="form-control" name="car_reg_number" value="{{ old('car_reg_number', $list->car_reg_number)}}" placeholder="reg. number">
                                </div>
                                <div class="form-group">
                                    <label for="">Reg. Date</label>
                                    <input type="date" class="form-control" name="car_reg_date" value="{{ old('car_reg_date', $list->car_reg_date)}}" placeholder="reg. date">
                                </div>
                                <div class="form-group">
                                    <label for="">Engine Number</label>
                                    <input type="text" class="form-control" name="car_engine" value="{{ old('car_engine', $list->car_engine)}}" placeholder="engine number">
                                </div>
                                <div class="form-group">
                                    <label for="">Chassis Number</label>
                                    <input type="text" class="form-control" name="car_chassis" value="{{ old('car_chassis', $list->car_chassis)}}" placeholder="chassis number">
                                </div>
                                <div class="form-group">
                                    <label for="">Model</label>
                                    <input type="text" class="form-control" name="car_model" value="{{ old('car_model', $list->car_model)}}" placeholder="model">
                                </div>
                                <div class="form-group">
                                    <label for="">CC</label>
                                    <input type="text" class="form-control" name="car_cc" value="{{ old('car_cc', $list->car_cc)}}" placeholder="CC">
                                </div>
                                <div class="form-group">
                                    <label for="">Horse Power</label>
                                    <input type="text" class="form-control" name="car_horse" value="{{ old('car_horse', $list->car_horse)}}" placeholder="horse power">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script>
    $("#logo").attr('type', 'file'); 
    $("#favicon").attr('type', 'file'); 
</script>
@endpush