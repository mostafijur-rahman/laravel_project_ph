@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <form method="GET" name="form">
                    <div class="row">
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                               <select  class="form-control" name="status">
                                <option value="attached" {{ ($request->status == 'attached') ? 'selected':'' }}>@lang('cmn.attached')</option>
                                <option value="not_attached" {{ ($request->status == 'not_attached') ? 'selected':'' }}>@lang('cmn.not_attached')</option>
                                </select>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" value="{{ old('name',$request->name) }}" placeholder="@lang('cmn.name')">
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                {{-- <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button> --}}
                                {{-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#buy_tyre" title="@lang('cmn.buy_tyre')"><i class="fas fa-plus"></i> @lang('cmn.buy_tyre')</button> --}}
                                {{-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#buy_mobil" title="@lang('cmn.buy_mobil')"><i class="fas fa-plus"></i> @lang('cmn.buy_mobil')</button> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- buy mobil -->
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="update_action" action="" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.attache_with_vehicle_form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.attach_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" name="date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.vehicle') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <select name="vehicle_id" class="form-control" id="vehicle_id" required>
                                                <option value="">@lang('cmn.please_select')</option>
                                                @if(isset($vehicles))
                                                @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_number }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.notify_km') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="number" class="form-control" id="notify_km" name="notify_km" value="{{ old('notify_km')}}" placeholder="@lang('cmn.notify_km')" required>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.notify_date')</label>
                                            <input type="date" class="form-control" id="notify_date" name="notify_date" value="{{ old('notify_date')}}" placeholder="@lang('cmn.notify_date')">
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th>@lang('cmn.short_description')</th>
                            <th>@lang('cmn.about_usage')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($tyres) > 0)
                            @foreach($tyres as $key => $tyre)
                            <tr>
                                <td class="text-left">
                                    <small>@lang('cmn.tyre_number'):</small> <strong>{{ $tyre->tyre_number }}</strong><br>
                                    <small>
                                        @lang('cmn.purchase_date'): <strong>{{ date('d M, Y', strtotime($tyre->purchase->date )) }}</strong><br>
                                        @lang('cmn.supplier'): <strong>{{ $tyre->purchase->supplier->name }}</strong><br>
                                        @lang('cmn.brand'): <strong>{{ $tyre->brand->name }}</strong><br>
                                        @if($tyre->warranty_km)
                                            @lang('cmn.warrenty_km'): <strong>{{ number_format($tyre->warranty_km) }}</strong><br>
                                        @endif
                                        @lang('cmn.created'): <strong>{{ $tyre->created_user->full_name }}</strong>
                                    </small>    
                                </td>
                                <td class="text-left">
                                    @if($tyre->attach_date)
                                        @php 
                                            $presentRunning = getRunningKmByVehicleIdAndDateRange($tyre->vehicle_id, $tyre->attach_date, date('Y-m-d'));
                                            $kmWillRun=null;
                                            $excessRunning=null;
                                            if($presentRunning < $tyre->notify_km){
                                                $kmWillRun = $tyre->notify_km - $presentRunning;
                                            } else {
                                                $excessRunning = $presentRunning - $tyre->notify_km;
                                            }
                                        @endphp
                                        @if(!$tyre->notify_date)
                                            @if($kmWillRun)
                                            <span class="badge badge-success">{{ number_format($kmWillRun) }} @lang('cmn.km_will_run')</span><br>
                                            @endif
                                            @if($excessRunning)
                                            <span class="badge badge-danger">{{ number_format($excessRunning) }} @lang('cmn.km_excess_running')</span><br>
                                            @endif
                                        @endif
                                        @lang('cmn.attach_date'): <strong>{{ date('d M, Y', strtotime($tyre->attach_date )) }}</strong><br>
                                        @lang('cmn.vehicle'): <strong>{{ $tyre->vehicle->vehicle_number }}</strong><br>
                                        @if($tyre->position_id)
                                            @lang('cmn.position'): <strong>{{ $tyre->position_id }}</strong><br>
                                        @endif
                                        @lang('cmn.present_running'): <strong>{{ number_format($presentRunning) }}</strong> <small>@lang('cmn.km')</small><br>
                                        @if($tyre->notify_km)
                                            @lang('cmn.notification'): <strong>{{ number_format($tyre->notify_km) }}</strong> <small>@lang('cmn.km')</small><br>
                                        @endif
                                        @if($tyre->notify_date)
                                            @lang('cmn.notification'): <strong>{{ date('d M, Y', strtotime($tyre->notify_date)) }}</strong> <small>@lang('cmn.date')</small><br>
                                        @endif
                                        <button class="btn btn-primary btn-xs" onclick="addIt({{json_encode($tyre) }})" type="button" title="@lang('cmn.do_edit')"><i class="fas fa-plus"></i> @lang('cmn.do_edit')</button>
                                    @else
                                        @lang('cmn.not_attached_yet')<br>
                                        <button class="btn btn-success btn-xs" onclick="addIt({{json_encode($tyre) }})" type="button" title="@lang('cmn.do_attache_with_vehicle')"><i class="fas fa-plus"></i> @lang('cmn.do_attache_with_vehicle')</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{ $tyres->appends(Request::input())->links() }}
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
    function addIt(value){
        $("#addModal").modal("show");
        $("#attach_date").val(value.attach_date)
        $("#vehicle_id").val(value.vehicle_id)
        $("#notify_km").val(value.notify_km)
        $("#notify_date").val(value.notify_date)
        $('#update_action').attr('action', 'tyres/' + value.id)
    }
</script>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    $('#reservationdate').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
</script> 
@endpush