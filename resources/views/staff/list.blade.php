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
                <form method="GET" name="form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="designation_id" class="form-control">
                                    <option value="">@lang('cmn.please_select')</option>
                                    @if(count($designations) > 0)
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ ($request->designation_id == $designation->id) ? 'selected':'' }}>@lang('cmn.'.$designation->name)</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name_phone" value="{{ old('name_phone',$request->name_phone) }}" placeholder="@lang('cmn.name_or_phone')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="company_id" value="{{ old('company_id',$request->company_id) }}" placeholder="@lang('cmn.company_id')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="nid_number" value="{{ old('nid_number',$request->nid_number) }}" placeholder="@lang('cmn.nid_number')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="driving_license_number" value="{{ old('name_phone',$request->driving_license_number) }}" placeholder="@lang('cmn.driving_license_number')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2" name="vehicle_id">
                                    <option value="">@lang('cmn.all_vehicle')</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id',$request->vehicle_id)==$vehicle->id?'selected':'' }}  vehicle_id>{{ $vehicle->number_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                <a href="{{ url('staffs/create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> @lang('cmn.add')</a>
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
                            <th style="width:20%">@lang('cmn.personal_information')</th>
                            <th style="width:20%">@lang('cmn.document')</th>
                            <th style="width:20%">@lang('cmn.reference')</th>
                            <th style="width:10%">@lang('cmn.status')</th>
                            @if(Auth::user()->role->delete or Auth::user()->role->edit)
                            <th  style="width:20%">@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        {{-- id="tablecontents" --}}
                        @if(count($lists) > 0)
                        @foreach($lists as $key => $list)
                        <tr class="row1" data-id="{{ $list->id }}">
                            {{-- <td class="pl-3"><i class="fa fa-sort"></i> {{ $list->id }}</td> --}}
                            <td> {{ $list->id }}</td>
                            <td>
                                @lang('cmn.name') : <b>{{ $list->name }}</b><br>
                                @lang('cmn.designation') : <b>@lang('cmn.'. $list->designation->name)</b><br>
                                @lang('cmn.phone') : <b>{{ $list->phone }}</b>
                                @if($list->email)
                                <br>
                                @lang('cmn.phone') : <b>{{ $list->email }}</b>
                                @endif
                            </td>
                            <td>
                                @lang('cmn.company_id') : <b>{{ $list->company_id??'---' }}</b><br>
                                @lang('cmn.nid_number') : <b>{{ $list->nid_number??'---' }}</b><br>

                                @if($list->driving_license_number)
                                @lang('cmn.driving_license_number') : <b>{{ $list->driving_license_number }}</b><br>
                                @endif
                                @if($list->passport_number)
                                @lang('cmn.passport_number') : <b>{{ $list->passport_number }}</b><br>
                                @endif
                                @if($list->birth_certificate_number)
                                @lang('cmn.birth_certificate_number') : <b>{{ $list->birth_certificate_number }}</b><br>
                                @endif
                                @if($list->port_id)
                                @lang('cmn.port_id') :  <b>{{ $list->port_id }}</b>
                                @endif
                            </td>
                            <td>
                                @lang('cmn.name') : <b>{{ $list->reference_name??'---' }}</b><br>
                                @lang('cmn.phone') : <b>{{ $list->reference_phone??'---' }}</b><br>
                                @if($list->reference_nid_number)
                                @lang('cmn.nid_number') : <b>{{ $list->reference_nid_number }}</b><br>
                                @endif
                                @if($list->reference_present_address)
                                @lang('cmn.present_address') : <b>{{ $list->reference_present_address }}</b>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">

                                    @switch($list->status)

                                        @case('active')
                                            @php $label = __('cmn.active'); $class = 'success'; @endphp
                                            @break

                                        @case('inactive')
                                            @php $label = __('cmn.inactive'); $class = 'warning'; @endphp
                                            @break

                                        @case('blocked')
                                            @php $label = __('cmn.blocked'); $class = 'danger'; @endphp
                                            @break
                                        
                                        @default
                                            @php $label = __('cmn.undefined'); $class = 'info'; @endphp

                                    @endswitch

                                    <button class="btn btn-sm bg-gradient-{{ $class }} dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $label }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        @switch($list->status)

                                            @case('active')
                                                <button type="button" class="dropdown-item" onclick="return (confirm('Are you sure?'))?document.getElementById('status_inactive{{$list->id}}').submit():false">@lang('cmn.inactive')</button>
                                                <button type="button" class="dropdown-item" onclick="return (confirm('Are you sure?'))?document.getElementById('status_blocked{{$list->id}}').submit():false">@lang('cmn.blocked')</button>
                                                <form id="status_inactive{{$list->id}}" action="{{ url('staffs/status') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$list->id}}">
                                                    <input type="hidden" name="status" value="inactive">
                                                </form>
                                                <form id="status_blocked{{$list->id}}" action="{{ url('staffs/status') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$list->id}}">
                                                    <input type="hidden" name="status" value="blocked">
                                                </form>
                                                @break

                                            @case('inactive')
                                                <button type="button" class="dropdown-item" onclick="return (confirm('Are you sure?'))?document.getElementById('status_active{{$list->id}}').submit():false">@lang('cmn.active')</button>
                                                <button type="button" class="dropdown-item" onclick="return (confirm('Are you sure?'))?document.getElementById('status_blocked{{$list->id}}').submit():false">@lang('cmn.blocked')</button>
                                                <form id="status_active{{$list->id}}" action="{{ url('staffs/status') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$list->id}}">
                                                    <input type="hidden" name="status" value="active">
                                                </form>
                                                <form id="status_blocked{{$list->id}}" action="{{ url('staffs/status') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$list->id}}">
                                                    <input type="hidden" name="status" value="blocked">
                                                </form>
                                                @break

                                            @case('blocked')
                                                <button type="button" class="dropdown-item" onclick="return (confirm('Are you sure?'))?document.getElementById('status_active{{$list->id}}').submit():false">@lang('cmn.active')</button>
                                                <button type="button" class="dropdown-item" onclick="return (confirm('Are you sure?'))?document.getElementById('status_inactive{{$list->id}}').submit():false">@lang('cmn.inactive')</button>
                                                <form id="status_active{{$list->id}}" action="{{ url('staffs/status') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$list->id}}">
                                                    <input type="hidden" name="status" value="active">
                                                </form>
                                                <form id="status_inactive{{$list->id}}" action="{{ url('staffs/status') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$list->id}}">
                                                    <input type="hidden" name="status" value="inactive">
                                                </form>
                                                @break
                                        
                                            @default
                                                <button type="button" class="dropdown-item" onclick="return (confirm('Are you sure?'))?document.getElementById('status_active{{$list->id}}').submit():false">@lang('cmn.active')</button>
                                                <button type="button" class="dropdown-item" onclick="return (confirm('Are you sure?'))?document.getElementById('status_inactive{{$list->id}}').submit():false">@lang('cmn.inactive')</button>
                                                <form id="status_active{{$list->id}}" action="{{ url('staffs/status') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$list->id}}">
                                                    <input type="hidden" name="status" value="active">
                                                </form>
                                                <form id="status_inactive{{$list->id}}" action="{{ url('staffs/status') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$list->id}}">
                                                    <input type="hidden" name="status" value="inactive">
                                                </form>
                                                @break

                                        @endswitch
                                    </div>
                                </div>
                            </td>
                            @if(Auth::user()->role->delete or Auth::user()->role->edit)
                            <td>
                                {{-- <a href="{{ url('staffs/print', $list->id) }}" class="btn btn-xs bg-gradient-warning" title="@lang('cmn.print')"><i class="fas fa-print"></i></a> --}}
                                <a href="{{ url('staffs/details', $list->id) }}" class="btn btn-xs bg-gradient-info" title="@lang('cmn.details')"><i class="fas fa-list"></i></a>
                                <a href="{{ url('staff/reference' , $list->id) }}" class="btn btn-xs bg-gradient-info" title="@lang('cmn.reference')"><i class="fas fa-users"></i></a>
                                
                                @if(Auth::user()->role->edit)
                                <a href="{{ url('staffs/' . $list->id . '/edit') }}" class="btn btn-xs bg-gradient-primary" title="@lang('cmn.edit')"><i class="fas fa-edit"></i></a>
                                @endif

                                @if(Auth::user()->role->delete)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $list->id  }})" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{ url('staffs', $list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                            @endif
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
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        @lang('cmn.showing') {{ $lists->firstItem() }} @lang('cmn.to') {{ $lists->lastItem() }} @lang('cmn.counting_of') {{ $lists->total() }}  @lang('cmn.results')
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="float-right">
                            {{ $lists->appends(Request::input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<!-- drag drop -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script type="text/javascript">
    function deleteCertification(id){
        const swalWithBootstrapButtons = Swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger mr-2',
            buttonsStyling: false,
        })
        swalWithBootstrapButtons({
            title: "{{ __('cmn.are_you_sure') }}",
            text: "{{ __('cmn.for_erase_it') }}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('cmn.yes') }}",
            cancelButtonText: "{{ __('cmn.no') }}",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('delete-form-'+id).submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // swalWithBootstrapButtons()
            }
        })
    }

    // drag drop related
    var xmlHttp = new XMLHttpRequest();

    $(function () {

        $("#tablecontents").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });

        function sendOrderToServer(){

            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.row1').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index+1
                });
            });

            $.ajax({
                type: "POST", 
                dataType: "json", 
                url: "{{ url('/staff-sort') }}",
                data: {
                    order: order,
                    _token: token
                },
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });
        }

    });
</script>
@endpush