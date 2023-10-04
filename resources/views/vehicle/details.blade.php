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
                <div class="col-12 col-sm-6 col-md-6 d-flex align-items-stretch flex-column">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">@lang('cmn.personal_information')</h3>
                            <a href="{{ url('staffs') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i> @lang('cmn.staff') @lang('cmn.list')</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>{{ $data->name }}</b></h2>
                                    <p class="text-muted text-sm"><b>@lang('cmn.phone') : </b> {{ $data->phone }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.email') : </b> {{ $data->email??'---' }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.father_name') : </b> {{ $data->father_name??'---' }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.mother_name') : </b> {{ $data->mother_name??'---' }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.spouse_name') : </b> {{ $data->spouse_name??'---' }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.present_address') : </b> {{ $data->present_address??'---' }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.permanent_address') : </b> {{ $data->permanent_address??'---' }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.date_of_birth') : </b> {{ $data->dob??'---' }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.blood_group') : </b> {{ $data->blood_group??'---' }}</p>
                                    <p class="text-muted text-sm"><b>@lang('cmn.note') : </b> {{ $data->note??'---' }}</p>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">@lang('cmn.document')</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted text-sm"><b>@lang('cmn.joining_date') : </b> {{ $data->joining_date??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.company_id') : </b> {{ $data->company_id??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.designation') : </b> @lang('cmn.' . $data->designation->name)</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.nid_number') : </b> {{ $data->nid_number??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.driving_license_number') : </b> {{ $data->driving_license_number??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.passport_number') : </b> {{ $data->passport_number??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.birth_certificate_number') : </b> {{ $data->birth_certificate_number??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.port_id') : </b> {{ $data->port_id??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.bank') : </b> {{ $data->bank->name??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.bank_account_number') : </b> {{ $data->bank_account_number??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.salary_amount') : </b> {{ $data->salary_amount?number_format($data->salary_amount):'---' }}</p>
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">@lang('cmn.reference')</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted text-sm"><b>@lang('cmn.reference') : </b> {{ $data->reference_name??'--' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.phone') : </b> {{ $data->reference_phone??'--' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.nid_number') : </b> {{ $data->reference_nid_number??'---' }}</p>
                            <p class="text-muted text-sm"><b>@lang('cmn.present_address') : </b> {{ $data->reference_present_address??'---' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection