@extends('layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="card"> 
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped text-center table-hover">
                        <thead>
                            <tr>
                                <th style="width:5%">#</th>
                                <th>@lang('cmn.table_name')</th>
                                <th>@lang('cmn.table_id')</th>
                                <th>@lang('cmn.for')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($lists))
                            @foreach($lists as $key => $list)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $list->table_name }}</td>
                                <td>{{ $list->table_id }}</td>
                                <td>{{ $list->for }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</section>
</div>
@endsection
