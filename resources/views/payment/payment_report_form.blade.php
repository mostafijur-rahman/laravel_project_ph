@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            {{-- @include('report_submenu') --}}
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.report_form_of_company_billing')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('payment-report') }}" target="_blank">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="company_id" class="form-control select2" required>
                                    <option value="">@lang('cmn.please_select')</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('false')"><i class="fa fa-file-alt"></i> @lang('cmn.show_report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf" value="false">
                                <input type="hidden" name="type" value="bill">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.report_form_of_company_deposit')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('payment-report') }}" target="_blank">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="company_id" class="form-control select2" required>
                                    <option value="">@lang('cmn.please_select')</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('false')"><i class="fa fa-file-alt"></i> @lang('cmn.show_report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf" value="false">
                                <input type="hidden" name="type" value="deposit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ট্রান্সপোর্টের চালান</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('payment-report') }}" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('false')"><i class="fa fa-file-alt"></i> @lang('cmn.show_report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf" value="false">
                                <input type="hidden" name="type" value="transport_challan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ট্রান্সপোর্টের ট্রিপের রিপোর্ট</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('payment-report') }}" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('false')"><i class="fa fa-file-alt"></i> @lang('cmn.show_report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf" value="false">
                                <input type="hidden" name="type" value="transport_trip_list">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ট্রান্সপোর্টের গাড়ীর প্রদান কারীর চালান বাকী রিপোর্ট</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('payment-report') }}" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('false')"><i class="fa fa-file-alt"></i> @lang('cmn.show_report')</button>
                                <button type="submit" class="btn btn-md btn-primary" onclick="downloadPdf('true')"><i class="fa fa-cloud-download-alt"></i> @lang('cmn.download')</button>
                                <input type="hidden" name="download_pdf" id="download_pdf" value="false">
                                <input type="hidden" name="type" value="transport_supplier_challan_report">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        


    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script type="text/javascript">
function downloadPdf(value){
    $("#download_pdf").val(value)
}
</script>
@endpush