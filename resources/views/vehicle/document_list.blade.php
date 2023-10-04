@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <form method="GET" name="form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="number_plate" value="{{ old('number_plate', $request->number_plate) }}" placeholder="@lang('cmn.number_plate')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.vehicle')</th>
                            
                            <th>@lang('cmn.registration_year')</th>
                            <th>@lang('cmn.tax_token') @lang('cmn.expire')</th>
                            <th>@lang('cmn.fitness') @lang('cmn.expire')</th>
                            <th>@lang('cmn.insurance') @lang('cmn.expire')</th>

                            {{-- <th>@lang('cmn.road_permit')</th> --}}

                            <th>@lang('cmn.last_tyre_change_date')</th>
                            <th>@lang('cmn.last_mobil_change_date')</th>
                            <th>@lang('cmn.last_servicing_date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($lists) > 0)
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                @lang('cmn.vehicle_no') : <b>{{ $list->vehicle_serial??'---' }}</b><br>
                                @lang('cmn.number_plate') : <b>{{ $list->number_plate }}</b><br>
                                @if($list->ownership)
                                @lang('cmn.ownership') : <b>@lang('cmn.' . $list->ownership)</b>
                                @else
                                @lang('cmn.ownership') : <b>---</b>
                                @endif
                            </td>
                            <td><b>{{ $list->registration_year??'---' }}</b></td>
                            <td><b>{{ $list->tax_token_expire_date?date('d M, Y', strtotime($list->tax_token_expire_date)):'---' }}</b></td>
                            <td><b>{{ $list->fitness_expire_date?date('d M, Y', strtotime($list->fitness_expire_date)):'---' }}</b></td>
                            <td><b>{{ $list->insurance_expire_date?date('d M, Y', strtotime($list->insurance_expire_date)):'---' }}</b></td>

                            <td><b>{{ $list->last_tyre_change_date?date('d M, Y', strtotime($list->last_tyre_change_date)):'---' }}</b></td>
                            <td><b>{{ $list->last_mobil_change_date?date('d M, Y', strtotime($list->last_mobil_change_date)):'---' }}</b></td>
                            <td><b>{{ $list->last_servicing_date?date('d M, Y', strtotime($list->last_servicing_date)):'---' }}</b></td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $lists->appends(Request::input())->links() }}
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection