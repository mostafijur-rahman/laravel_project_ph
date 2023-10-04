<!-- add modal -->
<div class="modal fade" id="add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('settings/staffs') }}"  method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">@lang('cmn.staff_add')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">@lang('cmn.designation')</label>
                        <select name="designation_id" class="form-control" required>
                            @if(isset($desigs))
                            @foreach($desigs as $desig)
                            <option value="{{ $desig->id }}" {{ old('designation_id')==$desig->id ? 'selected':'' }}>@lang('cmn.'.$desig->name)</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('cmn.name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@lang('cmn.name')" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('cmn.phone')</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="0171 xxx xxx">
                    </div>
                    <div class="form-group">
                        <label for="father">@lang('cmn.father_name')</label>
                        <input type="text" class="form-control" name="father_name" value="{{ old('father_name') }}" placeholder="@lang('cmn.father_name')">
                    </div>
                    <div class="form-group">
                        <label for="mother">@lang('cmn.mother_name')</label>
                        <input type="text" class="form-control" name="mother_name" value="{{ old('mother_name') }}" placeholder="@lang('cmn.mother_name')">
                    </div>
                    <div class="form-group">
                        <label for="spouse">@lang('cmn.spouse_name')</label>
                        <input type="text" class="form-control" name="spouse_name" value="{{ old('spouse_name') }}" placeholder="@lang('cmn.spouse_name')">
                    </div>
                    <div class="form-group">
                        <label for="present">@lang('cmn.present_address')</label>
                        <textarea  class="form-control" name="present_address" rows="2" placeholder="@lang('cmn.present_address')">{{ old('present_address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="permanent">@lang('cmn.permanent_address')</label>
                        <textarea  class="form-control" name="permanent_address" rows="2" placeholder="@lang('cmn.permanent_address')">{{ old('permanent_address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="nid">@lang('cmn.nid_serial')</label>
                        <input type="text" class="form-control" name="nid_number" value="{{ old('nid_number') }}" placeholder="@lang('cmn.nid_serial')">
                    </div>
                    <div class="form-group">
                        <label for="license">@lang('cmn.license_serial')</label>
                        <input type="text" class="form-control" name="license_number" value="{{ old('license_number') }}" placeholder="@lang('cmn.license_serial')">
                    </div>
                    {{-- <div class="form-group">
                        <label for="">@lang('cmn.nid_scan_copy')</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">@lang('cmn.choose_file')</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.license_scan_copy')</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">@lang('cmn.choose_file')</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">@lang('cmn.photo')</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">@lang('cmn.choose_file')</label>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label for="">@lang('cmn.note')</label>
                        <textarea  class="form-control" name="details" rows="2" placeholder="@lang('cmn.note')">{{ old('details') }}</textarea>
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