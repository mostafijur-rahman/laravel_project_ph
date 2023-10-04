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
                <h3 class="card-title">@lang('cmn.due') @lang('cmn.and') @lang('cmn.paid') @lang('cmn.report')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('clinet-wise-paid-due-report') }}" target="_blank" target="_blank">
                    <div class="row">
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="paid_due_report" value="1" name="date" {{ old('date',$request->date)==1 ? 'checked':'' }}>
                                <label for="paid_due_report"></label>
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
                                    <input type="text" class="form-control float-right reservation" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="client" required>
                                    <option value="">@lang('cmn.client')</option>
                                    @if(isset($clients))
                                    @foreach($clients as $client)
                                    <option value="{{ $client->client_id  }}" {{ (old('client',$request->client)==$client->client_id)?'selected':'' }}>{{ $client->client_name }}</option>
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
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.last') @lang('cmn.due') @lang('cmn.report')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('due-report') }}" target="_blank">
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
                                    <input type="text" class="form-control float-right reservation" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="car">
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
                                <select  class="form-control" name="client">
                                    <option value="">@lang('cmn.client')</option>
                                    @if(isset($clients))
                                    @foreach($clients as $client)
                                    <option value="{{ $client->client_id  }}" {{ (old('client',$request->client)==$client->client_id)?'selected':'' }}>{{ $client->client_name }}</option>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.paid') @lang('cmn.due') @lang('cmn.report')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('paid-due-report') }}" target="_blank">
                    <div class="row">
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="paidDueReport" value="1" name="date" {{ old('date',$request->date)==1 ? 'checked':'' }}>
                                <label for="paidDueReport"></label>
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
                                    <input type="text" class="form-control float-right reservation" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="client" required="">
                                    <option value="">@lang('cmn.client')</option>
                                    @if(isset($clients))
                                    @foreach($clients as $client)
                                    <option value="{{ $client->client_id  }}" {{ (old('client',$request->client)==$client->client_id)?'selected':'' }}>{{ $client->client_name }}</option>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.due') @lang('cmn.history') @lang('cmn.report')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('due-history-report') }}" target="_blank">
                    <div class="row">
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="dueHistoryReport" value="1" name="date" {{ old('date',$request->date)==1 ? 'checked':'' }}>
                                <label for="dueHistoryReport"></label>
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
                                    <input type="text" class="form-control float-right reservation" name="daterange" value="{{old('daterange', $request->daterange)}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="car">
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
                                <select  class="form-control" name="client">
                                    <option value="">@lang('cmn.client')</option>
                                    @if(isset($clients))
                                    @foreach($clients as $client)
                                    <option value="{{ $client->client_id  }}" {{ (old('client',$request->client)==$client->client_id)?'selected':'' }}>{{ $client->client_name }}</option>
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
        $('.reservation').daterangepicker();
    })
</script>
@endpush