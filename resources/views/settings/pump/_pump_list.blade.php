@extends('layout')


@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- form box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('cmn.pump_form')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="action" method="POST" action="{{ url('settings/pumps') }}">
                        @csrf
                        <input type="hidden" id="request_type" name="" value="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text"  class="form-control" id="name" name="name" placeholder="@lang('cmn.pump_name') (@lang('cmn.required'))" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="button" id="show_btn1" class="btn btn-success" onclick="submitForm()">
                                    <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                    <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                                    </button>
                                 </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <form method="GET" name="form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" value="{{ old('name',$request->name) }}" placeholder="@lang('cmn.pump_name')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                <a href="{{ url('pump-report-form') }}" class="btn btn-md btn-warning"><i class="fa fa-print"></i> @lang('cmn.report')</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:10%">@lang('cmn.sort')</th>
                            <th>@lang('cmn.pump_name')</th>
                            @if(Auth::user()->role->edit or Auth::user()->role->delete)
                            <th>@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($lists)
                            @foreach($lists as $key => $list)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    <form action="{{ url('pump-sort') }}" method="POST">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control" min="0" name="sort" value="{{ $list->sort }}" required>
                                            <input type="hidden" class="form-control" name="id" value="{{ $list->id }}" required>
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-success btn-flat" onclick="return (confirm('Are you sure?'))?true:false" title="Sort order"><i class="fa fa-sort"></i></button>
                                            </span>
                                        </div>
                                    </form>
                                </td>
                                <td>{{ $list->name }}</td>
                                <td>
                                    @if(Auth::user()->role->edit)
                                    <button type="button" class="btn btn-xs bg-gradient-primary" onclick="editData({{json_encode($list) }})" title="Edit"><i class="fas fa-edit"></i></button>
                                    @endif
                                    @if(Auth::user()->role->delete)
                                    <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                    <form id="{{$list->id}}" action="{{ url('settings/pumps',$list->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{ $lists->appends(Request::input())->links() }}
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/js.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">

    function editData(value){

        $("#name").val(value.name);
 
        $('#action').attr('action', '');
        $('#action').attr('action', '/settings/pumps/' + value.id);

        $("#request_type").attr('name','_method');
        $("#request_type").val('PUT');
    }
    function submitForm(){
        // console.log('test');
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;
        event.preventDefault();
        document.getElementById('action').submit();
    }
</script>
@endpush