<!-- vehicle add modal -->
<div class="modal fade" id="vehicle_add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('/vehicle') }}"  method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('cmn.vehicle_add')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">@lang('cmn.ownership_type')</label>
                        <select name="ownership_type" onchange="getOwner(this.value)" class="form-control" required>
                            <option value="1">@lang('cmn.own')</option>
                            <option value="2">@lang('cmn.transport')</option>
                        </select>
                    </div>
                    <div class="form-group" id="transport_supp">
                        <label>@lang('cmn.transport') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <select class="form-control select2" name="transport">
                            <option value="">@lang('cmn.please_select')</option>
                            @foreach($suppliers as $supp)
                            <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.vehicle') @lang('cmn.no')</label>
                        <input type="text" class="form-control" name="car_no" value="{{ old('car_no', 0)}}" placeholder="@lang('cmn.vehicle') @lang('cmn.no')">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.vehicle') @lang('cmn.number') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="text" class="form-control" name="car_number" value="{{ old('car_number')}}" placeholder="@lang('cmn.vehicle') @lang('cmn.number')" required>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.driver')</label>
                        <select name="car_driver_id" class="form-control select2" style="width: 100%;">
                            <option value="">@lang('cmn.please_select')</option>
                            @if(isset($drivers))
                            @foreach($drivers as $driver)
                            <option value="{{ $driver->people_id }}" {{old('car_driver_id')==$driver->people_id ? 'selected':''}}>{{ $driver->people_name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.helper')</label>
                        <select name="car_helper_id"  class="form-control select2" style="width: 100%;">
                            <option value="">@lang('cmn.please_select')</option>
                            @if(isset($helpers))
                            @foreach($helpers as $helper)
                            <option value="{{ $helper->people_id }}" {{old('car_helper_id')==$helper->people_id ? 'selected':''}}>{{ $helper->people_name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.description')</label>
                        <textarea class="form-control" name="car_details" rows="3" placeholder="@lang('cmn.description')">{{ old('car_details')}}</textarea>
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
        $('#edit_transport_supp').hide();
    });
    function getOwner(value){
        if(value == 2){
            $('#transport_supp').show();
        }else{
            $('#transport_supp').hide();
        }
    }
    function editGetOwner(value){
        if(value == 2){
            $('#edit_transport_supp').show();
        }else{
            $('#edit_transport_supp').hide();
        }
    }
    function editData(value){
        $("#editModal").modal("show");
        if(value.supplier_id){
            $('#edit_transport_supp').show();
            $('#transport').val(value.supplier_id);
            $('#ownership_type').val(2);
        }else{
            $('#edit_transport_supp').hide();
        }
        $("#car_encrypt").val(value.car_encrypt)
        $("#car_no").val(value.car_no)
        $("#car_number").val(value.car_number)
        $("#car_driver_id").val(value.car_driver_id)
        $("#car_helper_id").val(value.car_helper_id)
        $("#car_details").val(value.car_details)
        $(".select2").select2();
    }
</script>
@endpush