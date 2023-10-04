@inject('carbon', 'Carbon\Carbon')
@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                {{-- <form method="GET" name="form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="number_plate" value="{{ old('number_plate', $request->number_plate) }}" placeholder="@lang('cmn.number_plate')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                            </div>
                        </div>
                    </div>
                </form>  --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.notice')</th>
                            <th>@lang('cmn.time')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($lists) > 0)
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->content??'---' }}</td>
                            <td>{{ $carbon::parse($list->created_at)->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $lists->appends(Request::input())->links() }}
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection