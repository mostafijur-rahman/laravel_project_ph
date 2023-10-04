@extends('template')

@section('content')
<!-- content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1 class="bn">{{$title}}</h1>
        <ol class="breadcrumb bn">
            <li><a href="#"><i class="fa fa-dashboard"></i>{{$title}}</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('notice')
        <div class="row bn">
            <div class="col-md-6 col-xs-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-car"></i>
                        <h3 class="box-title">ট্রিপ সংক্রান্ত রিপোর্ট</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a href="{{ url('trip-final-report-form') }}" class="btn btn-default btn-block">ট্রিপের চূড়ান্ত হিসাব রিপোর্ট</a>
                        {{-- <a href="{{ url('cmn-exp-rptf') }}" class="btn btn-default btn-block">কমন খরচের রিপোর্ট</a>
                        <a href="{{ url('oil-exp-rptf') }}" class="btn btn-default btn-block">তেল খরচের রিপোর্ট</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-flask"></i>
                        <h3 class="box-title">তেল সংক্রান্ত রিপোর্ট</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a href="{{ url('oil-report-rptf') }}" class="btn btn-default btn-block">তেল সংক্রান্ত রিপোর্ট</a>
                    </div>
                </div>
            </div>
        </div>


    

        
    </section>
</div>
@endsection