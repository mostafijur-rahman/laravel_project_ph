@extends('template')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Admin Panel</a></li>
            <li class="active">{{ $title }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        {{-- @include('booking.trip.trip_sub_menu') --}}
        <br>
        <div class="row">
            <div class="col-md-12">
                <!-- box -->
                <div class="box box-success bn">
                    <div class="box-body">
                        <div class="row">
                            <form method="get" action="{{ url('cmn-exp-rpt') }}">
                                <div class="col-md-3">
                                    <label>তারিখ</label>
                                    <input type="text" class="form-control" name="date" value="{{old('date')}}" id="reservation" required>
                                </div>
                                <div class="col-md-3">
                                    <label>গাড়ীর নং:</label>
                                    <select  class="form-control" name="car_id">
                                        <option value="">নির্বাচন করুন</option>
                                        @if(isset($cars))
                                        @foreach($cars as $car)
                                        <option value="{{ $car->car_encrypt }}" {{ old('car_id')==$car->car_encrypt ? 'selected':'' }}>{{ $car->car_no }} (ঢাকা মেট্রো ট - ১১.৯০.৩৯)</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>ট্রিপ নম্বর</label>
                                    <select  class="form-control" name="trip_id">
                                        <option value="">নির্বাচন করুন</option>
                                        @if(isset($trips))
                                        @foreach($trips as $trip)
                                        <option value="{{ $trip->trip_encrypt }}" {{ old('trip_id')==$trip->trip_encrypt ? 'selected':'' }}>{{ $trip->trip_no }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>খরচের হেড</label>
                                    <select  class="form-control" name="cmn_exp_id">
                                        <option value="">নির্বাচন করুন</option>
                                        @if(isset($cmn_exps))
                                        @foreach($cmn_exps as $cmn_exp)
                                        <option value="{{ $cmn_exp->exp_encrypt }}" {{ old('cmn_exp_id')==$cmn_exp->exp_encrypt ? 'selected':'' }}>{{ $cmn_exp->exp_head }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label></label><br>
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-flat btn-success">রিপোর্ট দেখুন <i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /content -->
@endsection