@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#"><strong>{{ $title }}</strong></a></li>
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
                <h3 class="card-title">General Report</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('pump-general-report') }}">
                    <div class="row">
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxDate" value="1" name="date" {{ old('date',$request->date)==1 ? 'checked':'' }}>
                                <label for="checkboxDate"></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="pump">
                                    <option value="" >Select Pump</option>
                                    @if(isset($pumps))
                                    @foreach($pumps as $pump)
                                    <option value="{{ $pump->pump_id }}" {{ ($request->has('pump') && $request->pump == $pump->pump_id)?'selected':'' }}>{{ $pump->pump_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="car">
                                    <option value="">Select vehicle</option>
                                    @if(isset($cars))
                                    @foreach($cars as $car)
                                    <option value="{{ $car->car_id }}" {{ (old('car',$request->car)==$car->car_id)?'selected':'' }}>{{ $car->car_number }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="people">
                                    <option value="">Select Driver</option>
                                    @if(isset($drivers))
                                    @foreach($drivers as $driver)
                                    <option value="{{ $driver->people_id }}" {{ old('people',$request->people)==$driver->people_id ? 'selected':'' }}>{{ $driver->people_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control" name="trip_number" value="{{old('trip_number')}}" placeholder="Trip Number">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> Report</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Monthly/Yearly Report</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('pump-monthly-yearly-report') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="month" class="form-control">
                                    <option value="">Select Month</option>
                                    <option value="1" {{ old('month',$request->month)==1 ? 'selected':'' }}>January</option>
                                    <option value="2" {{ old('month',$request->month)==2 ? 'selected':'' }}>February</option>
                                    <option value="3" {{ old('month',$request->month)==3 ? 'selected':'' }}>March</option>
                                    <option value="4" {{ old('month',$request->month)==4 ? 'selected':'' }}>April</option>
                                    <option value="5" {{ old('month',$request->month)==5 ? 'selected':'' }}>May</option>
                                    <option value="6" {{ old('month',$request->month)==6 ? 'selected':'' }}>June</option>
                                    <option value="7" {{ old('month',$request->month)==7 ? 'selected':'' }}>July</option>
                                    <option value="8" {{ old('month',$request->month)==8 ? 'selected':'' }}>August</option>
                                    <option value="9" {{ old('month',$request->month)==9 ? 'selected':'' }}>September</option>
                                    <option value="10" {{ old('month',$request->month)==10 ? 'selected':'' }}>October</option>
                                    <option value="11" {{ old('month',$request->month)==11 ? 'selected':'' }}>November</option>
                                    <option value="12" {{ old('month',$request->month)==12 ? 'selected':'' }}>Devember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="year" class="form-control">
                                    <option value="">Select Year</option>
                                    <option value="2020" {{ old('year',$request->year)==2020 ? 'selected':'' }}>2020</option>
                                    <option value="2019" {{ old('year',$request->year)==2019 ? 'selected':'' }}>2019</option>
                                    <option value="2018" {{ old('year',$request->year)==2018 ? 'selected':'' }}>2018</option>
                                    <option value="2017" {{ old('year',$request->year)==2017 ? 'selected':'' }}>2017</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="pump">
                                    <option value="">Select Pump</option>
                                    @if(isset($pumps))
                                    @foreach($pumps as $pump)
                                    <option value="{{ $pump->pump_id }}" {{ ($request->has('pump') && $request->pump == $pump->pump_id)?'selected':'' }}>{{ $pump->pump_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="car">
                                    <option value="">Select vehicle</option>
                                    @if(isset($cars))
                                    @foreach($cars as $car)
                                    <option value="{{ $car->car_id }}" {{ (old('car',$request->car)==$car->car_id)?'selected':'' }}>{{ $car->car_number }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="people">
                                    <option value="">Select Driver</option>
                                    @if(isset($drivers))
                                    @foreach($drivers as $driver)
                                    <option value="{{ $driver->people_id }}" {{ old('people',$request->people)==$driver->people_id ? 'selected':'' }}>{{ $driver->people_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> Report</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    // reservation
    $(function () {
        $('#reservation').daterangepicker();
    })
</script>
@endpush