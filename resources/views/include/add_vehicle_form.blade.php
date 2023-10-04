<!-- vehicle add modal -->
<div class="modal fade" id="vehicle_add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('settings/vehicles') }}"  method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('cmn.vehicle_add')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($menu != 'transport')
                        <div class="form-group">
                            <label for="">@lang('cmn.ownership_type')</label>
                            <select name="ownership_type" onchange="getOwner(this.value)" class="form-control" required>
                                <option value="1">@lang('cmn.own')</option>
                                <option value="2">@lang('cmn.transport')</option>
                            </select>
                        </div>
                        <div class="form-group" id="transport_supp">
                            <label>@lang('cmn.transport') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <select class="form-control select2" name="supplier_id">
                                <option value="">@lang('cmn.please_select')</option>
                                @foreach($suppliers as $supp)
                                <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <label>@lang('cmn.transport') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <select class="form-control select2" name="supplier_id" required>
                                <option value="">@lang('cmn.please_select')</option>
                                @foreach($suppliers as $supp)
                                <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">@lang('cmn.vehicle') @lang('cmn.no')</label>
                        <input type="text" class="form-control" name="vehicle_serial" value="{{ old('vehicle_serial', 0)}}" placeholder="@lang('cmn.vehicle') @lang('cmn.no')">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.vehicle') @lang('cmn.number') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="text" class="form-control" name="vehicle_number" value="{{ old('vehicle_number')}}" placeholder="@lang('cmn.vehicle') @lang('cmn.number')" required>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.driver')</label>
                        <select name="driver_id" class="form-control select2" style="width: 100%;">
                            <option value="">@lang('cmn.please_select')</option>
                            @if(isset($drivers))
                            @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{old('driver_id')==$driver->id ? 'selected':''}}>{{ $driver->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.helper')</label>
                        <select name="helper_id"  class="form-control select2" style="width: 100%;">
                            <option value="">@lang('cmn.please_select')</option>
                            @if(isset($helpers))
                            @foreach($helpers as $helper)
                            <option value="{{ $helper->id }}" {{old('helper_id')==$helper->id ? 'selected':''}}>{{ $helper->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.description')</label>
                        <textarea class="form-control" name="details" rows="3" placeholder="@lang('cmn.description')">{{ old('details')}}</textarea>
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
@push('js')
<script type="text/javascript">
    // for vehicle add 
    $(document).ready(function(){
        $('#transport_supp').hide();
    });
    function getOwner(value){
        if(value == 2){
            $('#transport_supp').show();
        }else{
            $('#transport_supp').hide();
        }
    }
</script>
@endpush