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
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#mobil_attach" title="@lang('cmn.mobil_attach')"><i class="fas fa-plus"></i> @lang('cmn.mobil_attach')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- attach mobil -->
            <div class="modal fade" id="mobil_attach">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('/mobils') }}" method="post">
                            @csrf
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
                                            <label>@lang('cmn.liter')</label>
                                            <input type="number" class="form-control" name="liter" value="{{ old('liter')}}" placeholder="@lang('cmn.liter')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.notify_km') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="number" class="form-control" id="notify_km" name="notify_km" value="{{ old('notify_km')}}" placeholder="@lang('cmn.notify_km')" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.brand')</label>
                                            <select name="brand_id" class="form-control" required>
                                                @if(isset($brands))
                                                @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
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
                            <th>@lang('cmn.about_usage')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($mobils) > 0)
                            @foreach($mobils as $key => $mobil)
                            <tr>
                                <td class="text-left">
                                    @php 
                                        $presentRunning = getRunningKmByVehicleIdAndDateRange($mobil->vehicle_id, $mobil->attach_date, date('Y-m-d'));
                                        $kmWillRun=null;
                                        $excessRunning=null;
                                        if($presentRunning < $mobil->notify_km){
                                            $kmWillRun = $mobil->notify_km - $presentRunning;
                                        } else {
                                            $excessRunning = $presentRunning - $mobil->notify_km;
                                        }
                                    @endphp
                                    @if(!$mobil->notify_date)
                                        @if($kmWillRun)
                                        <span class="badge badge-success">{{ number_format($kmWillRun) }} @lang('cmn.km_will_run')</span><br>
                                        @endif
                                        @if($excessRunning)
                                        <span class="badge badge-danger">{{ number_format($excessRunning) }} @lang('cmn.km_excess_running')</span><br>
                                        @endif
                                    @endif
                                    @lang('cmn.attach_date'): <strong>{{ date('d M, Y', strtotime($mobil->attach_date )) }}</strong><br>
                                    @lang('cmn.vehicle'): <strong>{{ $mobil->vehicle->vehicle_number }}</strong><br>
                                    @lang('cmn.present_running'): <strong>{{ number_format($presentRunning) }}</strong> <small>@lang('cmn.km')</small><br>
                                    @if($mobil->notify_km)
                                        @lang('cmn.notification'): <strong>{{ number_format($mobil->notify_km) }}</strong> <small>@lang('cmn.km')</small><br>
                                    @endif
                                    @if($mobil->notify_date)
                                        @lang('cmn.notification'): <strong>{{ date('d M, Y', strtotime($mobil->notify_date)) }}</strong> <small>@lang('cmn.date')</small><br>
                                    @endif
                                    <button type="button" class="btn btn-xs btn-danger" onclick="return deleteCertification(<?php echo $mobil->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                    <form id="delete-form-{{$mobil->id}}" action="{{ url('mobils', $mobil->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{ $mobils->appends(Request::input())->links() }}
    </section>
    <!-- /.content -->
</div>
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