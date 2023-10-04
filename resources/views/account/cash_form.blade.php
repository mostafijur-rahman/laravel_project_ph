@if(!empty($info->id))
<form id="action" method="POST" action="{{ url('accounts', $info->id) }}">
    <input type="hidden" name="_method" value="PUT">
@else
    <form id="action" method="POST" action="{{ url('accounts') }}">
@endif
    @csrf
    <div class="row">
        <input type="hidden" name="type" value="cash">
        <input type="hidden" name="id" value="{{ $info->id??'' }}">
        <div class="col-md-3">
            <label>@lang('cmn.user_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
            <div class="form-group">
                <input type="text"  class="form-control {{ $errors->has('user_name') ? 'is-invalid' : '' }}" name="user_name" value="{{ $info->user_name??'' }}" placeholder="@lang('cmn.user_name')"  required>
                @if ($errors->has('user_name'))
                    <span class="error invalid-feedback">{{ $errors->first('user_name') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>@lang('cmn.note')</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" rows="1" name="note" placeholder="@lang('cmn.write_note_here')">{{ $info->note??'' }}</textarea>
                @if ($errors->has('note'))
                    <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>@lang('cmn.user_selection')</label>
                <select name="user_id" class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}">
                    <option value="">@lang('cmn.please_select')</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (isset($info->user_id) && $info->user_id == $user->id)?'selected':'' }}>{{ $user->full_name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_id'))
                    <span class="error invalid-feedback">{{ $errors->first('user_id') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="button" id="show_btn1" class="form-control btn btn-success" onclick="submitForm()">
                    <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                    <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                </button>
            </div>
        </div>
    </div>
</form>