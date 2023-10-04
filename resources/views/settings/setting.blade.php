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
            <!-- first row -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    {{-- {{ url('live') }} --}}
                    <a href="{{ url('people') }}"  class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-users fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('nav.staff')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('vehicle') }}"  class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-truck fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('nav.vehicle')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('pump') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-gas-pump fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('nav.pump')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('client') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-handshake fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('nav.clients')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.first row -->
            <!-- second row -->
            <div class="row">
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('settings/area') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-map-marker-alt fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('cmn.load_unload_point')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('settings/general-expense') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-money-bill-alt fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('cmn.common_expenses')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('settings/project-expense') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-money-bill-alt fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('cmn.project_expenses')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('settings/providers') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-handshake fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('cmn.installment') @lang('cmn.providers')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.second row -->
            <!-- third row -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <a href="{{ url('setting/suppliers') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-users fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('cmn.suppliers')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('settings/company') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-wrench  fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('cmn.company_setup')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="#" data-toggle="modal" class="text-success" data-target="#backupModal">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-download fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('nav.backup')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('help') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-heart fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('nav.help')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
            </div>
            <!-- fourth row -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <a href="{{ url('settings/investors') }}" class="text-success">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-users fa-3x"></i>
                                <h4 style="color: black"><strong>@lang('cmn.investors')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- /.Main content -->
</div>
@endsection