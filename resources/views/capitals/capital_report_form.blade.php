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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.capitals') @lang('cmn.report')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('capital-report') }}">
                    <div class="row">
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxDate" value="1" name="date">
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
                                <select  class="form-control" name="business_type">
                                    <option value="">@lang('cmn.all_business')</option>
                                    <option value="1" {{ (old('business_type',$request->business_type)==1)?'selected':'' }}>@lang('cmn.transport')</option>
                                    <option value="2" {{ (old('business_type',$request->business_type)==2)?'selected':'' }}>@lang('cmn.vehicle')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="investor">
                                    <option value="">@lang('cmn.all_investor')</option>
                                    @if(isset($investors))
                                    @foreach($investors as $investor)
                                    <option value="{{ $investor->id }}" {{ (old('investor',$request->id)==$investor->id)?'selected':'' }}>{{ $investor->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="invest_type">
                                    <option value="">@lang('cmn.all_type')</option>
                                    <option value="1" {{ (old('invest_type',$request->invest_type)==1)?'selected':'' }}>@lang('cmn.invest')</option>
                                    <option value="2" {{ (old('invest_type',$request->invest_type)==2)?'selected':'' }}>@lang('cmn.drawing')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="car">
                                    <option value="">@lang('cmn.all_vehicle')</option>
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