@extends('layout')
@section('content')
<style type="text/css">
    .required{
        font-weight: 800;
        color: red;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">@lang('cmn.investors_list')</div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.name')</th>
                            <th>ট্রান্সপোর্ট ব্যবসায় বর্তমান বিনিয়োগ</th>
                            <th>গাড়ীর ব্যবসায় বর্তমান বিনিয়োগ</th>
                            <th>@lang('cmn.total')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty(count($investors)))
                        @foreach($investors as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->name }}</td>
                            <td class="text-primary"><strong>{{ ($list->trasport_invest)? number_format($a = $list->trasport_invest->balance) : $a = 0 }}</strong></td>
                            <td class="text-primary"><strong>{{ ($list->trip_invest)? number_format($b = $list->trip_invest->balance) : $b = 0 }}</strong></td>
                            <td class="text-primary"><strong>{{ number_format($a+$b) }}</strong></td>
                            <td>
                                <a href="{{ url('capitals-history', $list->encrypt) }}" class="btn btn-primary btn-sm">@lang('cmn.capitals') @lang('cmn.history')</a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {!! $capitals->links() !!}
            </div>
            <!-- /.card-footer -->
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection