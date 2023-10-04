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

                    <form action="{{ url('staffs', $data->id) }}"  method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="setting_staff_id" value="{{ $data->id }}">

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">@lang('cmn.personal_information')</h3>
                                <a href="{{ url('staffs') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i> @lang('cmn.staff') @lang('cmn.list')</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.gender')</label>
                                            <select name="gender" class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" required>
                                                <option value="male" {{ old('gender', $data->gender)=='male' ? 'selected':'' }}>@lang('cmn.male')</option>
                                                <option value="female" {{ old('gender', $data->gender)=='female' ? 'selected':'' }}>@lang('cmn.female')</option>
                                                <option value="third_gender" {{ old('gender', $data->gender)=='third_gender' ? 'selected':'' }}>@lang('cmn.third_gender')</option>
                                            </select>
                                            @if ($errors->has('gender'))
                                                <span class="error invalid-feedback">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name', $data->name) }}" placeholder="@lang('cmn.name')" required>
                                            @if ($errors->has('name'))
                                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.phone') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', $data->phone) }}" placeholder="0171 xxx xxx" required>
                                            @if ($errors->has('phone'))
                                                <span class="error invalid-feedback">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.email')</label>
                                            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $data->email) }}" placeholder="examaple@gmail.com">
                                            @if ($errors->has('email'))
                                                <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                                            <label for="">@lang('cmn.father_name')</label>
                                            <input type="text" class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" id="father_name" name="father_name" value="{{ old('father_name', $data->father_name) }}" placeholder="@lang('cmn.father_name')">
                                            @if ($errors->has('father_name'))
                                                <span class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.mother_name')</label>
                                            <input type="text" class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" id="mother_name" name="mother_name" value="{{ old('mother_name', $data->mother_name) }}" placeholder="@lang('cmn.mother_name')">
                                            @if ($errors->has('mother_name'))
                                                <span class="error invalid-feedback">{{ $errors->first('mother_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.spouse_name')</label>
                                            <input type="text" class="form-control {{ $errors->has('spouse_name') ? 'is-invalid' : '' }}" id="spouse_name" name="spouse_name" value="{{ old('spouse_name', $data->spouse_name) }}" placeholder="@lang('cmn.spouse_name')">
                                            @if ($errors->has('spouse_name'))
                                                <span class="error invalid-feedback">{{ $errors->first('spouse_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                                            <label for="">@lang('cmn.present_address')</label>
                                            <textarea  class="form-control {{ $errors->has('present_address') ? 'is-invalid' : '' }}" id="present_address" name="present_address" rows="1" placeholder="@lang('cmn.present_address')">{{ old('present_address', $data->present_address) }}</textarea>
                                            @if ($errors->has('present_address'))
                                                <span class="error invalid-feedback">{{ $errors->first('present_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                                            <label for="">@lang('cmn.permanent_address')</label>
                                            <textarea  class="form-control {{ $errors->has('permanent_address') ? 'is-invalid' : '' }}" id="permanent_address" name="permanent_address" rows="1" placeholder="@lang('cmn.permanent_address')">{{ old('permanent_address', $data->permanent_address) }}</textarea>
                                            @if ($errors->has('permanent_address'))
                                                <span class="error invalid-feedback">{{ $errors->first('permanent_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.date_of_birth') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <div class="input-group date" id="dob" data-target-input="nearest">
                                                <input type="text" name="dob" value="{{ (isset($data->dob))?date('d/m/Y', strtotime($data->dob)):date('d/m/Y') }}" class="form-control datetimepicker-input {{ $errors->has('dob') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                                                <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                @if ($errors->has('dob'))
                                                    <span class="error invalid-feedback">{{ $errors->first('dob') }}</span>
                                                @endif
                                            </div>
                                            @if ($errors->has('dob'))
                                                <span class="error invalid-feedback">{{ $errors->first('dob') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.blood_group')</label>
                                            <select id="blood_group" class="form-control {{ $errors->has('blood_group') ? 'is-invalid' : '' }}" name="blood_group" required>
                                                <option value="A+" {{ old('blood_group', $data->blood_group)=='A+' ? 'selected':'' }}>A+</option>
                                                <option value="A-" {{ old('blood_group', $data->blood_group)=='A-' ? 'selected':'' }}>A-</option>
                                                <option value="B+" {{ old('blood_group', $data->blood_group)=='B+' ? 'selected':'' }}>B+</option>
                                                <option value="B-" {{ old('blood_group', $data->blood_group)=='B-' ? 'selected':'' }}>B-</option>
                                                <option value="AB+" {{ old('blood_group', $data->blood_group)=='AB+' ? 'selected':'' }}>AB+</option>
                                                <option value="AB-" {{ old('blood_group', $data->blood_group)=='AB-' ? 'selected':'' }}>AB-</option>
                                                <option value="o+" {{ old('blood_group', $data->blood_group)=='o+' ? 'selected':'' }}>o+</option>
                                                <option value="o-" {{ old('blood_group', $data->blood_group)=='o-' ? 'selected':'' }}>o-</option>
                                            </select>
                                            @if ($errors->has('blood_group'))
                                                <span class="error invalid-feedback">{{ $errors->first('blood_group') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.note')</label>
                                            <textarea  class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" id="note" name="note" rows="1" placeholder="@lang('cmn.note')">{{ old('note', $data->note) }}</textarea>
                                            @if ($errors->has('note'))
                                                <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFile">@lang('cmn.image')</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input {{ $errors->has('image') ? 'is-invalid' : '' }}" id="inputFile" name="image">
                                                    <label class="custom-file-label" for="inputFile">@lang('cmn.choose_file')</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">@lang('cmn.upload')</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('image'))
                                                <span class="error invalid-feedback">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">@lang('cmn.document')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                                            <label for="">@lang('cmn.company_id')</label>
                                            <input type="text" class="form-control {{ $errors->has('company_id') ? 'is-invalid' : '' }}" id="company_id" name="company_id" value="{{ old('company_id', $data->company_id) }}" placeholder="@lang('cmn.company_id')">
                                            @if ($errors->has('company_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('company_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.joining_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <div class="input-group date" id="joining_date" data-target-input="nearest">
                                                <input type="text" name="joining_date" value="{{ (isset($data->joining_date))?date('d/m/Y', strtotime($data->joining_date)):date('d/m/Y') }}" class="form-control datetimepicker-input {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                                                <div class="input-group-append" data-target="#joining_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                @if ($errors->has('joining_date'))
                                                    <span class="error invalid-feedback">{{ $errors->first('joining_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.designation')</label>
                                            <select name="designation_id" class="form-control {{ $errors->has('designation_id') ? 'is-invalid' : '' }}" required>
                                                @if(count($desigs) > 0)
                                                @foreach($desigs as $desig)
                                                <option value="{{ $desig->id }}" {{ old('designation_id', $data->designation_id)==$desig->id ? 'selected':'' }}>@lang('cmn.'.$desig->name)</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('designation_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('designation_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                                            <label for="">@lang('cmn.nid_number')</label>
                                            <input type="text" class="form-control {{ $errors->has('nid_number') ? 'is-invalid' : '' }}" id="nid_number" name="nid_number" value="{{ old('nid_number', $data->nid_number) }}" placeholder="@lang('cmn.nid_number')">
                                            @if ($errors->has('nid_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('nid_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.driving_license_number')</label>
                                            <input type="text" class="form-control {{ $errors->has('driving_license_number') ? 'is-invalid' : '' }}" id="driving_license_number" name="driving_license_number" value="{{ old('driving_license_number', $data->driving_license_number) }}" placeholder="@lang('cmn.driving_license_number')">
                                            @if ($errors->has('driving_license_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('driving_license_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.passport_number')</label>
                                            <input type="text" class="form-control" {{ $errors->has('passport_number') ? 'is-invalid' : '' }} id="passport_number" name="passport_number" value="{{ old('passport_number', $data->passport_number) }}" placeholder="@lang('cmn.passport_number')">
                                            @if ($errors->has('passport_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('passport_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.birth_certificate_number')</label>
                                            <input type="text" class="form-control {{ $errors->has('birth_certificate_number') ? 'is-invalid' : '' }}" id="birth_certificate_number" name="birth_certificate_number" value="{{ old('birth_certificate_number', $data->birth_certificate_number) }}" placeholder="@lang('cmn.birth_certificate_number')">
                                            @if ($errors->has('birth_certificate_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('birth_certificate_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.port_id')</label>
                                            <input type="text" class="form-control {{ $errors->has('port_id') ? 'is-invalid' : '' }}" id="port_id" name="port_id" value="{{ old('port_id', $data->port_id) }}" placeholder="@lang('cmn.port_id')">
                                            @if ($errors->has('port_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('port_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.bank') @lang('cmn.please_select')</label>
                                            <select name="bank_id" class="form-control {{ $errors->has('bank_id') ? 'is-invalid' : '' }}">
                                                @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ ( old('bank_id', $data->bank_id) == $bank->id)?'selected':'' }}>{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('bank_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('bank_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.bank_account_number')</label>
                                            <input type="text" class="form-control {{ $errors->has('bank_account_number') ? 'is-invalid' : '' }}" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $data->bank_account_number) }}" placeholder="@lang('cmn.bank_account_number')">
                                            @if ($errors->has('bank_account_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('bank_account_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.salary_amount')</label>
                                            <input type="number" class="form-control {{ $errors->has('salary_amount') ? 'is-invalid' : '' }}" id="salary_amount" name="salary_amount" value="{{ old('salary_amount', $data->salary_amount) }}" placeholder="@lang('cmn.salary_amount')">
                                            @if ($errors->has('salary_amount'))
                                                <span class="error invalid-feedback">{{ $errors->first('salary_amount') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>@lang('cmn.termination_date')</label> 
                                            <input type="date" class="form-control {{ $errors->has('termination_date') ? 'is-invalid' : '' }}"  name="termination_date" value="{{ old('termination_date', $data->termination_date) }}">
                                            @if ($errors->has('termination_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('termination_date') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">@lang('cmn.reference')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                                            <label for="">@lang('cmn.reference')</label>
                                            <input type="text" class="form-control {{ $errors->has('reference_name') ? 'is-invalid' : '' }}" id="reference_name" name="reference_name" value="{{ old('reference_name', $data->reference_name) }}" placeholder="@lang('cmn.name')">
                                            @if ($errors->has('reference_name'))
                                                <span class="error invalid-feedback">{{ $errors->first('reference_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <small class="text-danger">(@lang('cmn.required'))</small> --}}
                                            <label for="">@lang('cmn.phone')</label>
                                            <input type="text" class="form-control {{ $errors->has('reference_phone') ? 'is-invalid' : '' }}" id="reference_phone" name="reference_phone" value="{{ old('reference_phone', $data->reference_phone) }}" placeholder="0171 xxx xxx">
                                            @if ($errors->has('reference_phone'))
                                                <span class="error invalid-feedback">{{ $errors->first('reference_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.nid_number')</label>
                                            <input type="text" class="form-control {{ $errors->has('reference_nid_number') ? 'is-invalid' : '' }}" id="reference_nid_number" name="reference_nid_number" value="{{ old('reference_nid_number', $data->reference_nid_number) }}" placeholder="@lang('cmn.nid_number')">
                                            @if ($errors->has('reference_nid_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('reference_nid_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('cmn.present_address')</label>
                                            <textarea  class="form-control {{ $errors->has('reference_present_address') ? 'is-invalid' : '' }}" id="reference_present_address" name="reference_present_address" rows="1" placeholder="@lang('cmn.present_address')">{{ old('reference_present_address', $data->reference_present_address) }}</textarea>
                                            @if ($errors->has('reference_present_address'))
                                                <span class="error invalid-feedback">{{ $errors->first('reference_present_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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
        $('#joining_date').datetimepicker({
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