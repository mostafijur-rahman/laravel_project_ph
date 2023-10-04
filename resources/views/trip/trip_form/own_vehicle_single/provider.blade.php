<div class="card">
    <div class="card-header">
        <h4 class="card-title w-100 text-primary">
            <b>@lang('cmn.vehicle_provider')</b>
        </h4> 
    </div>
    <div class="card-body">
        <div class="row">
            {{-- id="vehicle_id" style="{{ (isset($trip)&&$trip->provider->ownership == 'own')?'display: block':'display: none' }}" --}}
            @if(!$request->group_id)
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.vehicle_select') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select  class="form-control select2 {{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="vehicle_id" id="vehicle_id" onchange="getDriverAndHelper()">
                        <option value="">@lang('cmn.please_select')</option>
                        @if(isset($vehicles))
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id',isset($trip->provider->vehicle_id)?$trip->provider->vehicle_id:'')==$vehicle->id ? 'selected':'' }}>{{ $vehicle->number_plate }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('vehicle_id'))
                        <span class="error invalid-feedback">{{ $errors->first('vehicle_id') }}</span>
                    @endif
                </div>
            </div>
            @else
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.vehicle_select') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select  class="form-control {{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}" style="width: 100%;" disabled>
                        @if(isset($vehicles))
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ (isset($trip_add->provider->vehicle_id) && $trip_add->provider->vehicle_id == $vehicle->id) ? 'selected':'' }}>{{ $vehicle->number_plate }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('vehicle_id'))
                        <span class="error invalid-feedback">{{ $errors->first('vehicle_id') }}</span>
                    @endif
                </div>
            </div>
            <input type="hidden" name="vehicle_id" value="{{ $trip_add->provider->vehicle_id }}">
            @endif
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.driver_select') <small class="text-danger">(@lang('cmn.required'))</small></label>
                    <select  class="form-control select2 {{ $errors->has('driver_id') ? 'is-invalid' : '' }}" name="driver_id" id="driver_id">
                        <option value="">@lang('cmn.please_select')</option>
                        @if(isset($staffs))
                            @foreach($staffs as $staff)
                                @if($staff->designation_id == 1)
                                {{-- <option value="{{ $staff->id }}" {{ (isset($staff_info) && $staff_info->driver_id == $staff->id) ? 'selected':'' }}>{{ $staff->name }}</option> --}}
                                <option value="{{ $staff->id }}" {{ old('driver_id', isset($trip->provider->driver_id)?$trip->provider->driver_id:'')==$staff->id ? 'selected':'' }}>{{ $staff->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('driver_id'))
                        <span class="error invalid-feedback">{{ $errors->first('driver_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.helper_select')</label>
                    <select  class="form-control select2 {{ $errors->has('helper_id') ? 'is-invalid' : '' }}" name="helper_id" id="helper_id">
                        <option value="">@lang('cmn.please_select')</option>
                        @if(isset($staffs))
                            @foreach($staffs as $staff)
                                @if($staff->designation_id == 2)
                                {{-- <option value="{{ $staff->id }}" {{ (isset($staff_info) && $staff_info->helper_id == $staff->id) ? 'selected':'' }}>{{ $staff->name }}</option> --}}
                                <option value="{{ $staff->id }}" {{ old('helper_id', isset($trip->provider->helper_id)?$trip->provider->helper_id:'')==$staff->id ? 'selected':'' }}>{{ $staff->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('helper_id'))
                        <span class="error invalid-feedback">{{ $errors->first('helper_id') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getDriverAndHelper(){
        let vehicleId = document.getElementById("vehicle_id").value
        $.ajax({
            type:'GET',
            url:'/trips/get-driver-and-helper-id/' + vehicleId,
            success:function(data){

                if(data.driver_id){
                    document.getElementById("driver_id").value = data.driver_id;
                } else {
                    document.getElementById("driver_id").value = '';
                }

                if(data.helper_id){
                    document.getElementById("helper_id").value = data.helper_id;
                } else {
                    document.getElementById("helper_id").value = '';
                }

                $(".select2").select2();
            
            },
            error:function(data){
                console.log(data);
            }
        });
    }

</script>