<div class="modal fade" id="area_add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('settings/areas') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('cmn.area_add')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('cmn.division')</label>
                        <select name="division_id" class="form-control" required>
                            <option value="">@lang('cmn.please_select')</option>
                            @if(isset($divisions))
                            @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{old('division_id')?'selected':''}}>{{ $division->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>@lang('cmn.point_name')</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.point_name_example')" required>
                    </div>
                    {{-- <div class="form-group">
                        <label>@lang('cmn.distance_to_meghna_bridge')</label>
                        <input type="number" class="form-control" name="distance" value="{{ old('distance', 0)}}" placeholder="Distance to Meghna bridge (km)" required>
                    </div> --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="distance" value="0">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>