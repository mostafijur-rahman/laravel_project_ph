@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ url('vehicles') }}"  method="post">
                        @csrf
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">@lang('cmn.vehicle_info')</h3>
                                <a href="{{ url('vehicles') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i> @lang('cmn.vehicle') @lang('cmn.list')</a>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    {{-- (1) Vehicle No:

                                    (2) Vehicle ownership:
                                    (3) Rental/Company:

                                    (4) Registration No:
                                    (5) Engine No:
                                    (6) Chesis No:
                                    (7) Model:
                                    (8) Manufacturer:Eicher/TATA/OshokLay land:
                                    (9) Registration Year:
                                    (10) Tax Token Expire Date:
                                    (11) Fitness Expire Date:
                                    (12) Insurance Expire Date:

                                    // other
                                    (13) Fuel Tank LTR:
                                    (14) Last Tyre Date:
                                    (15) Last Mobil change:
                                    (16) Last Servicing Date:
                                    (17) Engine down:Half/Full
                                    (18) Body Type: Local/Imported,
                                    (19) GPS ID: --}}

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.ownership')</label>
                                            <select name="ownership" id="ownership"  class="form-control">
                                                <option value="">@lang('cmn.please_select')</option>
                                                <option value="rental" {{old('ownership')=='rental' ? 'selected':''}}>@lang('cmn.rental')</option>
                                                <option value="company" {{old('ownership')=='company' ? 'selected':''}}>@lang('cmn.company')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.vehicle_no')</label>
                                            <input type="text" class="form-control {{ $errors->has('vehicle_serial') ? 'is-invalid' : '' }}" id="vehicle_serial" name="vehicle_serial" value="{{ old('vehicle_serial') }}" placeholder="@lang('cmn.vehicle_no')">
                                            @if ($errors->has('vehicle_serial'))
                                                <span class="error invalid-feedback">{{ $errors->first('vehicle_serial') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.number_plate') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="text" class="form-control {{ $errors->has('number_plate') ? 'is-invalid' : '' }}" id="number_plate" name="number_plate" value="{{ old('number_plate') }}" placeholder="@lang('cmn.number_plate')" required>
                                            @if ($errors->has('number_plate'))
                                                <span class="error invalid-feedback">{{ $errors->first('number_plate') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.registration_number')</label>
                                            <input type="text" class="form-control {{ $errors->has('registration_number') ? 'is-invalid' : '' }}" id="registration_number" name="registration_number" value="{{ old('registration_number') }}" placeholder="@lang('cmn.registration_number')">
                                            @if ($errors->has('registration_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('registration_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.engine_number')</label>
                                            <input type="text" class="form-control {{ $errors->has('engine_number') ? 'is-invalid' : '' }}" id="engine_number" name="engine_number" value="{{ old('engine_number') }}" placeholder="@lang('cmn.engine_number')">
                                            @if ($errors->has('engine_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('engine_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.chassis_number')</label>
                                            <input type="text" class="form-control {{ $errors->has('chassis_number') ? 'is-invalid' : '' }}" id="chassis_number" name="chassis_number" value="{{ old('chassis_number') }}" placeholder="@lang('cmn.chassis_number')">
                                            @if ($errors->has('chassis_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('chassis_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.model')</label>
                                            <input type="text" class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" id="model" name="model" value="{{ old('model') }}" placeholder="@lang('cmn.model')">
                                            @if ($errors->has('model'))
                                                <span class="error invalid-feedback">{{ $errors->first('model') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.manufacturer')</label>
                                            <select name="manufacturer_id" id="manufacturer_id" class="form-control select2">
                                                <option value="">@lang('cmn.please_select')</option>
                                                @if(count($brands) > 0)
                                                @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{old('manufacturer_id')==$brand->id ? 'selected':''}}>{{ $brand->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('manufacturer_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('manufacturer_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.body_type')</label>
                                            <select name="body_type" id="body_type"  class="form-control select2">
                                                <option value="">@lang('cmn.please_select')</option>
                                                <option value="local" {{old('body_type')=='local' ? 'selected':''}}>@lang('cmn.local')</option>
                                                <option value="imported" {{old('body_type')=='imported' ? 'selected':''}}>@lang('cmn.imported')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.engine_down')</label>
                                            <select name="engine_down" id="engine_down"  class="form-control select2">
                                                <option value="">@lang('cmn.please_select')</option>
                                                <option value="half" {{old('engine_down')=='half' ? 'selected':''}}>@lang('cmn.half')</option>
                                                <option value="full" {{old('engine_down')=='full' ? 'selected':''}}>@lang('cmn.full')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.fuel_tank_capacity')</label>
                                            <input type="number" min="0" class="form-control {{ $errors->has('vehicle_serial') ? 'is-invalid' : '' }}" id="fuel_tank_capacity" name="fuel_tank_capacity" value="{{ old('fuel_tank_capacity') }}" placeholder="@lang('cmn.fuel_tank_capacity')">
                                            @if ($errors->has('fuel_tank_capacity'))
                                                <span class="error invalid-feedback">{{ $errors->first('fuel_tank_capacity') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.driver')</label>
                                            <select name="driver_id" id="driver_id" class="form-control select2">
                                                <option value="">@lang('cmn.please_select')</option>
                                                @if(isset($drivers))
                                                @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}" {{old('driver_id')==$driver->id ? 'selected':''}}>{{ $driver->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.helper')</label>
                                            <select name="helper_id" id="helper_id"  class="form-control select2">
                                                <option value="">@lang('cmn.please_select')</option>
                                                @if(isset($helpers))
                                                @foreach($helpers as $helper)
                                                <option value="{{ $helper->id }}" {{old('helper_id')==$helper->id ? 'selected':''}}>{{ $helper->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.gps_id')</label>
                                            <input type="text" class="form-control {{ $errors->has('gps_id') ? 'is-invalid' : '' }}" id="gps_id" name="gps_id" value="{{ old('gps_id') }}" placeholder="@lang('cmn.gps_id')">
                                            @if ($errors->has('gps_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('gps_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.note') </label>
                                            <textarea  class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" id="note" name="note" rows="1" placeholder="@lang('cmn.note')">{{ old('note') }}</textarea>
                                            @if ($errors->has('note'))
                                                <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">@lang('cmn.others_information')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.registration_year')</label>
                                            <select name="registration_year" id="registration_year"  class="form-control select2">
                                                <option value="">@lang('cmn.please_select')</option>
                                                @foreach(range(date('Y'), 2010) as $year)
                                                <option value="{{$year}}" {{ old('year',$request->year)==$year? 'selected':'' }}>@lang('cmn.'.$year.'')</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.tax_token_expire_date')</label>
                                            <input type="date" class="form-control {{ $errors->has('tax_token_expire_date') ? 'is-invalid' : '' }}" id="tax_token_expire_date" name="tax_token_expire_date" value="{{ old('tax_token_expire_date') }}">
                                            @if ($errors->has('tax_token_expire_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('tax_token_expire_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.fitness_expire_date')</label>
                                            <input type="date" class="form-control {{ $errors->has('fitness_expire_date') ? 'is-invalid' : '' }}" id="fitness_expire_date" name="fitness_expire_date" value="{{ old('fitness_expire_date') }}">
                                            @if ($errors->has('fitness_expire_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('fitness_expire_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.insurance_expire_date')</label>
                                            <input type="date" class="form-control {{ $errors->has('insurance_expire_date') ? 'is-invalid' : '' }}" id="insurance_expire_date" name="insurance_expire_date" value="{{ old('insurance_expire_date') }}">
                                            @if ($errors->has('insurance_expire_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('insurance_expire_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.last_tyre_change_date')</label>
                                            <input type="date" class="form-control {{ $errors->has('last_tyre_change_date') ? 'is-invalid' : '' }}" id="last_tyre_change_date" name="last_tyre_change_date" value="{{ old('last_tyre_change_date') }}">
                                            @if ($errors->has('last_tyre_change_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('last_tyre_change_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.last_mobil_change_date')</label>
                                            <input type="date" class="form-control {{ $errors->has('last_mobil_change_date') ? 'is-invalid' : '' }}" id="last_mobil_change_date" name="last_mobil_change_date" value="{{ old('last_mobil_change_date') }}">
                                            @if ($errors->has('last_mobil_change_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('last_mobil_change_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.last_servicing_date')</label>
                                            <input type="date" class="form-control {{ $errors->has('last_servicing_date') ? 'is-invalid' : '' }}" id="last_servicing_date" name="last_servicing_date" value="{{ old('last_servicing_date') }}">
                                            @if ($errors->has('last_servicing_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('last_servicing_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-icon" onclick="submitForm()">
                                    <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                    <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script type="text/javascript">
        $('#dob').datetimepicker({
            defaultDate: "",
            format: 'DD/MM/YYYY'
        });
    </script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush