@extends('layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- /.card-header -->
            <div class="card"> 
                <div class="card-header">
                    <form method="GET" name="form">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                <select  class="form-control" name="division_id">
                                    <option value="">@lang('cmn.please_select')</option>
                                    @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ old('division',$request->division)==$division->id ? 'selected':'' }}>{{ $division->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" value="{{ old('name',$request->name) }}" placeholder="@lang('cmn.name')">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                    @if(Auth::user()->role->create)
                                    <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#area_add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-header -->
                {{-- area add --}}
                <div class="modal fade" id="area_add">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ url('settings/areas') }}"  method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('cmn.area_form')</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">@lang('cmn.division')</label>
                                        <select id="division_id" name="division_id" class="form-control" required>
                                            @if(isset($divisions))
                                            @foreach($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">@lang('cmn.area_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('vehicle_number')}}" placeholder="@lang('cmn.area_name')" required>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- area edit -->
                <div class="modal fade" id="area_edit">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action=""  method="post" id="aciton_edit">
                                @csrf
                                @method('put')
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('cmn.area_form')</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">@lang('cmn.division')</label>
                                        <select id="division_id_edit" name="division_id" class="form-control" required>
                                            @if(isset($divisions))
                                            @foreach($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">@lang('cmn.area_name') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                        <input type="text" class="form-control" name="name" id="name_edit" value="{{ old('vehicle_number')}}" placeholder="@lang('cmn.area_name')" required>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.do_posting')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped text-center table-hover">
                        <thead>
                            <tr>
                                <th style="width:5%">#</th>
                                <th>@lang('cmn.division')</th>
                                <th>@lang('cmn.point_name')</th>
                                <th>@lang('cmn.number_of_trips')</th>
                                @if($setComp['meghna_bridge_distance_show'] > 0)
                                <th>@lang('cmn.distance_to_meghna_bridge')</th>
                                @endif
                                @if(Auth::user()->role->edit or Auth::user()->role->delete)
                                <th>@lang('cmn.action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($lists))
                            @foreach($lists as $key => $list)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $list->division->name }}</td>
                                <td>{{ $list->name }}</td>
                                <td>{{ count($list->trips) }}</td>
                                @if($setComp['meghna_bridge_distance_show'] > 0)
                                <td>{{ $list->distance }} km</td>
                                @endif
                                <td>
                                    @if(Auth::user()->role->edit)
                                    <button type="button" class="btn btn-xs bg-gradient-primary" onclick="editData({{json_encode($list) }})" title="Edit"><i class="fas fa-edit"></i></button>
                                    @endif
                                    @if(Auth::user()->role->delete)
                                        @if(count($list->trips)==0)
                                        <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                        <form id="{{$list->id}}" action="{{ url('settings/areas',$list->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @else
                                        ---
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
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

        $("#area_edit").modal('show');

        $("#division_id_edit").val(value.division_id);
        $("#name_edit").val(value.name);
       
        $('#aciton_edit').attr('action', '');
        $('#aciton_edit').attr('action', '/settings/areas/' + value.id);

    }
    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;
        event.preventDefault();
        document.getElementById('action').submit();
    }
</script>
@endpush