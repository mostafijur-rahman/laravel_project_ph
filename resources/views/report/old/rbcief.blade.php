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
                            <form method="get" action="{{ url('rbcier') }}">
                                <div class="col-md-4">
                                    <label>তারিখ</label>
                                    <input type="text" class="form-control" name="date" value="{{old('date')}}" id="reservation" required>
                                </div>
                                <div class="col-md-4">
                                    <label>রুটের নাম</label>
                                    <select  class="form-control" name="route_id">
                                        <option value="">নির্বাচন করুন</option>
                                        @if(isset($routes))
                                        @foreach($routes as $route)
                                        <option value="{{ $route->route_id }}" {{ old('route_id')==$route->route_id ? 'selected':'' }}>{{ $route->route_name }}</option>
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