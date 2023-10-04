@extends('layout')
@push('css')
<style type="text/css">
    .inner{
        background: #fff;
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        border-radius: 10px;
    }
</style>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"></section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="GET" >
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="month" class="form-control">
                            <option value="">@lang('cmn.today')</option>
                            <option value="">@lang('cmn.yesterday')</option>
                            <option value="">@lang('cmn.last_one_week')</option>
                            <option value="">@lang('cmn.last_fifteen_days')</option>
                            <option value="">@lang('cmn.last_one_month')</option>
                            <option value="">@lang('cmn.last_three_month')</option>
                            <option value="">@lang('cmn.last_six_month')</option>
                            <option value="">@lang('cmn.last_one_year')</option>
                            <option value="">@lang('cmn.life_time')</option>
                        </select>
                    </div>
                </div>
            </form>
            <!-- first row -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <h1 class="text-success"><strong>0</strong></h1>
                                <h4 style="color: black"><strong>@lang('cmn.total_deposit')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <h1 class="text-success"><strong>0</strong></h1>
                                <h4 style="color: black"><strong>@lang('cmn.total_expense')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <h1 class="text-success"><strong>{{ $total_company_count }}</strong></h1>
                                <h4 style="color: black"><strong>@lang('cmn.total') @lang('cmn.company')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="#" class="disabled">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <h1 class="text-success"><strong>{{ $total_own_vehicle_count }}</strong></h1>
                                <h4 style="color: black"><strong>@lang('cmn.own') @lang('cmn.vehicle')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
      

                {{-- <div class="col-lg-3 col-6">
                    <a href="{{ url('vehicle') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-truck fa-4x" style="color: #3498DB"></i>
                                <h4 style="color: black"><strong>@lang('nav.vehicle')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div> --}}

                <div class="col-lg-3 col-6">
                    <a href="{{ url('new-trips/create') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-truck fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.challan_create')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- <div class="col-lg-3 col-6">
                    <a href="{{ url('dues') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-handshake fa-4x" style="color: #3498DB"></i>
                                <h4 style="color: black"><strong>@lang('cmn.due')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <!-- ./col -->
                {{-- <div class="col-lg-3 col-6">
                    <a href="{{ url('pump') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-gas-pump fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('nav.pump')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <div class="col-lg-3 col-6">
                    <a href="{{ url('expenses/expenses') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-money-bill-alt fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.expenses')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{ url('purchases') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-shopping-cart fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.purchases')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{ url('tyres?status=attached') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-bell fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.tyre_notification')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{ url('mobils') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-bell fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.mobil_notification')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{ url('documents') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-bell fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.document_notification')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{ url('payments?type=company') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-handshake fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.company_billing')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{ url('user/lists') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-user-lock fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.system_user')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>

                


                <div class="col-lg-3 col-6">
                    <a href="{{ url('daily-accounts-report-form') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-file-alt fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.reports')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-6">
                    <a href="{{ url('transactions') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-list fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.transactions')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-6">
                    <a href="{{ url('accounts') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-money-check-alt fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.bank_accounts')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>




                {{-- <div class="col-lg-3 col-6">
                    <a href="{{ url('installment') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-suitcase fa-4x" style="color: #D35400"></i>
                                <h4 style="color: black"><strong>@lang('cmn.installment')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div> --}}
                {{-- <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-tools fa-4x" style="color: #D35400"></i>
                                <h4 style="color: black"><strong>@lang('nav.garage')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div> --}}
                {{-- <div class="col-lg-3 col-6">
                    <a href="{{ url('activity-logs') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-exchange-alt fa-4x" style="color: Sienna"></i>
                                <h4 style="color: black"><strong>@lang('cmn.transactions')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <!-- ./col -->
                {{-- <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-video fa-4x" style="color: #28B463"></i>
                                <h4 style="color: black"><strong>@lang('nav.activity')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <!-- ./col -->
                {{-- <div class="col-lg-3 col-6">
                    <a href="#" data-toggle="modal" data-target="#backupModal">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-download fa-4x" style="color: #5499C7"></i>
                                <h4 style="color: black"><strong>@lang('nav.backup')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <div class="col-lg-3 col-6">
                    <a href="{{ url('help') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-heart fa-4x" style="color: DeepPink"></i>
                                <h4 style="color: black"><strong>@lang('nav.help')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.third row -->
        </div>
    </section>
    <!-- /.Main content -->
</div>
@endsection
@push("js")

@endpush