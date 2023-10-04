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
                <h3 class="card-title">@lang('cmn.deposit_expense') @lang('cmn.report') @lang('cmn.form')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('deposit-expense-report') }}">
                    <div class="row">
                        {{-- <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxDate" value="1" name="date" {{ old('date',$request->date)==1 ? 'checked':'' }}>
                                <label for="checkboxDate"></label>
                            </div>
                        </div> --}}
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
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <select  class="form-control" name="accounts" required>
                                    <option value="daily">@lang('cmn.daily')</option>
                                    <option value="weekly">@lang('cmn.weekly')</option>
                                    <option value="monthly">@lang('cmn.monthly')</option>
                                </select>
                            </div>
                        </div> --}}
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