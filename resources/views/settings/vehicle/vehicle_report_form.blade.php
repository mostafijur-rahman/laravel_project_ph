@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('report_submenu')
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
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.vehicle_ledger')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('vehicle-ledger-report') }}">
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
                                <select  class="form-control" name="car" required>
                                    <option value="">@lang('cmn.select_vehicle')</option>
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
                                <select  class="form-control" name="report_type" required>
                                    <option value="">@lang('cmn.report_type')</option>
                                    <option value="total_project" selected>মোট প্রকল্প ব্যয় হিসাব</option>
                                </select>
                                {{-- 
                                <option value="running_project">চলতি প্রকল্প ব্যয় হিসাব</option>    
                                <option value="#">ড্রাইভার, হেলপার বেতন-বোনাস হিসাব</option>
                                <option value="#">গাড়ির আয়-ব্যয় হিসাব</option>
                                <option value="#">মৈত্রী পরিবহনের কমিশন হিসাব</option>
                                <option value="#">মোবিল পাল্টানোর হিসাব</option>
                                <option value="#">কিস্তির হিসাব</option>
                                <option value="#">মাসিক গ্যারাজ হিসাব</option> --}}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success"><i class="fa fa-search"></i> @lang('cmn.report')</button>
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