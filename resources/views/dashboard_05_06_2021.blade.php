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
            @if(count($notices))
            @include('notice')
            @endif
            <!-- first row -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    {{-- {{ url('live') }} --}}
                    <a href="#" class="disabled">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <h1 class="text-success"><strong>53</strong></h1>
                                <h4 style="color: black"><strong>@lang('cmn.total') @lang('cmn.vehicle')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('reports') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-file-invoice fa-4x" style="color: #F5B041"></i>
                                <h4 style="color: black"><strong>@lang('nav.reports')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('booking') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-home fa-4x" style="color: #9B59B6";></i>
                                <h4 style="color: black"><strong>@lang('nav.transport')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('trip') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-map-marker-alt fa-4x" style="color: #16A085"></i>
                                <h4 style="color: black"><strong>@lang('nav.trip')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.first row -->
            <!-- second row -->
            <div class="row">
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
                    <a href="{{ url('dues') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-handshake fa-4x" style="color: #3498DB"></i>
                                <h4 style="color: black"><strong>@lang('cmn.due')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
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
                    <a href="{{ url('expenses/general-expenses') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-money-bill-alt fa-4x" style="color: #27AE60"></i>
                                <h4 style="color: black"><strong>@lang('cmn.expense')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('installment') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-suitcase fa-4x" style="color: #D35400"></i>
                                <h4 style="color: black"><strong>@lang('cmn.installment')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
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
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{ url('activity-logs') }}">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-exchange-alt fa-4x" style="color: Sienna"></i>
                                <h4 style="color: black"><strong>@lang('cmn.transactions')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.second row -->
            <!-- third row -->
            <div class="row">
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-video fa-4x" style="color: #28B463"></i>
                                <h4 style="color: black"><strong>@lang('nav.activity')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="#" data-toggle="modal" data-target="#backupModal">
                        <div class="small-box bg-default text-center">
                            <div class="inner">
                                <i class="fas fa-download fa-4x" style="color: #5499C7"></i>
                                <h4 style="color: black"><strong>@lang('nav.backup')</strong></h4>
                            </div>
                        </div>
                    </a>
                </div>
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