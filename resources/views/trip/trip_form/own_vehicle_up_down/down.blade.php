<div class="card">
    <div class="card-header">
        <h4 class="card-title w-100 text-primary">
            <b>@lang('cmn.down_challan')</b>
        </h4> 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.trip_starting_date')</label>
                    {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                    <div class="input-group date" id="trip_starting_date_down" data-target-input="nearest">
                        <input type="text" name="down_date" value="{{ (isset($trip->date))?date('d/m/Y', strtotime($trip->date)):date('d/m/Y') }}" class="form-control datetimepicker-input {{ $errors->has('down_date') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                        <div class="input-group-append" data-target="#trip_starting_date_down" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        @if ($errors->has('down_date'))
                            <span class="error invalid-feedback">{{ $errors->first('down_date') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.driver_select')</label>
                    {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                    <select  class="form-control select2 {{ $errors->has('down_driver_id') ? 'is-invalid' : '' }}" name="down_driver_id" id="down_driver_id">
                        <option value="">@lang('cmn.please_select')</option>
                        @if(isset($staffs))
                            @foreach($staffs as $staff)
                                @if($staff->designation_id == 1)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('down_driver_id'))
                        <span class="error invalid-feedback">{{ $errors->first('down_driver_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.helper_select')</label>
                    <select  class="form-control select2 {{ $errors->has('down_helper_id') ? 'is-invalid' : '' }}" name="down_helper_id" id="down_helper_id">
                        <option value="">@lang('cmn.please_select')</option>
                        @if(isset($staffs))
                            @foreach($staffs as $staff)
                                @if($staff->designation_id == 2)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('down_helper_id'))
                        <span class="error invalid-feedback">{{ $errors->first('down_helper_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.load_point')</label>
                    {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                    <select class="form-control select2 {{ $errors->has('down_load_id') ? 'is-invalid' : '' }}" multiple="multiple" data-placeholder="@lang('cmn.please_select')" style="width: 100%;" name="down_load_id[]" required>
                        @if(isset($areas))
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ (isset($load))?in_array($area->id, $load)?'selected':'':'' }}>{{ $area->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('down_load_id'))
                        <span class="error invalid-feedback">{{ $errors->first('down_load_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.unload_point')</label>
                    {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                    <select class="form-control select2 {{ $errors->has('down_unload_id') ? 'is-invalid' : '' }}" multiple="multiple" data-placeholder="@lang('cmn.please_select')" style="width: 100%;" name="down_unload_id[]" required>
                        @if(isset($areas))
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ (isset($unload))?in_array($area->id, $unload)?'selected':'':'' }}>{{ $area->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('down_unload_id'))
                        <span class="error invalid-feedback">{{ $errors->first('down_unload_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.box_qty')</label>
                    <input type="number" min="0" step="1" class="form-control {{ $errors->has('down_box') ? 'is-invalid' : '' }}" name="down_box" value="{{ old('down_box',$trip->box??'') }}" placeholder="@lang('cmn.amount_here')">
                    @if ($errors->has('down_box'))
                        <span class="error invalid-feedback">{{ $errors->first('down_box') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.weight')</label>
                    <input type="number" min="0" step="1" class="form-control {{ $errors->has('down_weight') ? 'is-invalid' : '' }}" name="down_weight" value="{{ old('down_weight',$trip->weight??'') }}" placeholder="@lang('cmn.qty')">
                    @if ($errors->has('down_weight'))
                        <span class="error invalid-feedback">{{ $errors->first('down_weight') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.unit')</label>
                    <select id="end" class="form-control {{ $errors->has('down_unit_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="down_unit_id">
                        @if(isset($units))
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id',$trip->unit_id??'')==$unit->id ? 'selected':'' }}>@lang('cmn.' . $unit->name)</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('down_unit_id'))
                        <span class="error invalid-feedback">{{ $errors->first('down_unit_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.about_goods')</label>
                    <textarea class="form-control {{ $errors->has('down_goods') ? 'is-invalid' : '' }}" name="down_goods" rows="2" placeholder="@lang('cmn.about_goods')">{{ old('down_goods',$trip->goods??'') }}</textarea>
                    @if ($errors->has('down_goods'))
                        <span class="error invalid-feedback">{{ $errors->first('down_goods') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.note')</label>
                    <textarea class="form-control {{ $errors->has('down_note') ? 'is-invalid' : '' }}" name="down_note" rows="2" placeholder="@lang('cmn.you_can_write_any_note_here')">{{ old('down_note',$trip->note??'') }}</textarea>
                    @if ($errors->has('down_note'))
                        <span class="error invalid-feedback">{{ $errors->first('down_note') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.company')</label>
                    {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                    <select  class="form-control select2 {{ $errors->has('down_company_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="down_company_id" required>
                        <option value="">@lang('cmn.please_select')</option>
                        @if(isset($companies))
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id',($trip->company->company_id)??'')==$company->id ? 'selected':'' }}>{{ $company->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('down_company_id'))
                        <span class="error invalid-feedback">{{ $errors->first('down_company_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.contract_rent')</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('down_com_contract_fair') ? 'is-invalid' : '' }}" name="down_com_contract_fair" value="{{ old('down_com_contract_fair', (($trip && $trip->company->contract_fair) ? (float) $trip->company->contract_fair:0)) }}" placeholder="@lang('cmn.amount_here')" {{ ($request->page_name =='edit')?'disabled':''}}>
                    @if ($errors->has('down_com_contract_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('down_com_contract_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>অগ্রিম গ্রহণ</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('down_com_advance_fair') ? 'is-invalid' : '' }}" name="down_com_advance_fair" value="{{ old('down_com_advance_fair', (($trip && $trip->company->advance_fair) ? (float) $trip->company->advance_fair:0)) }}" placeholder="@lang('cmn.amount_here')" {{ ($request->page_name =='edit')?'disabled':''}}>
                    @if ($errors->has('down_com_advance_fair'))
                        <span class="error invalid-feedback">{{ $errors->first('down_com_advance_fair') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>@lang('cmn.received_account')</label>
                    <select class="form-control select2 {{ $errors->has('down_com_account_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="down_com_account_id" {{ ($request->page_name =='edit')?'disabled':''}}>
                        @if(isset($accounts))
                        @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{$account->user_name }} ({{ $account->account_number??__('cmn.cash') }}) = {{(number_format($account->balance))}}</option>
                        @endforeach
                        @endif
                    </select>
                    @if ($errors->has('down_com_account_id'))
                        <span class="error invalid-feedback">{{ $errors->first('down_com_account_id') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" id="show_btn1" class="btn btn-success" onclick="submitTrip()">
            <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
            <i id="show_icon1" class="fas fa-save"></i>
            @if($request->page_name == 'create' || $request->page_name == 'copy')
                @lang('cmn.do_posting')
            @else
                @lang('cmn.update_post')
            @endif
        </button>
    </div>
</div>
@push('js')
<script>
function getDriverAndHelper(){
    let vehicleId = document.getElementById("vehicle_id").value
    $.ajax({
        type:'GET',
        url:'/trips/get-driver-and-helper-id/' + vehicleId,
        success:function(data){

            if(data.driver_id){
                document.getElementById("up_driver_id").value = data.driver_id;
                document.getElementById("down_driver_id").value = data.driver_id;
            } else {
                document.getElementById("up_driver_id").value = '';
                document.getElementById("down_driver_id").value = '';
            }

            if(data.helper_id){
                document.getElementById("up_helper_id").value = data.helper_id;
                document.getElementById("down_helper_id").value = data.helper_id;
            } else {
                document.getElementById("up_helper_id").value = '';
                document.getElementById("down_helper_id").value = '';
            }
        
        },
        error:function(data){
            console.log(data);
        }
    });
}
</script>
@endpush

@include('trip.trip_form.common_js')
