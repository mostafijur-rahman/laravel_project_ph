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
                                <input type="text" class="form-control" name="number_plate" value="{{ old('number_plate', $request->number_plate) }}" placeholder="@lang('cmn.number_plate')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                <a href="{{ url('vehicles/create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> @lang('cmn.add')</a>
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
                            <th>@lang('cmn.vehicle_info')</th>
                            <th>@lang('cmn.staff')</th>
                            @if(Auth::user()->role->eidt or Auth::user()->role->delete)
                            <th>@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($lists) > 0)
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                @lang('cmn.vehicle_no') : <b>{{ $list->vehicle_serial??'---' }}</b><br>
                                @lang('cmn.number_plate') : <b>{{ $list->number_plate }}</b>
                            </td>
                            <td>
                                @lang('cmn.driver') : <b>{{ $list->driver->name??'---' }}</b><br>
                                @lang('cmn.phone') : <b>{{ $list->driver->phone??'---' }}</b><br>
                                @lang('cmn.helper') : <b>{{ $list->helper->name??'---' }}</b>
                            </td>
                            @if(Auth::user()->role->delete or Auth::user()->role->edit)
                            <td>
                                {{-- <a href="{{ url('vehicles/det' . $list->id) }}" class="btn btn-xs bg-gradient-info" title="@lang('cmn.details')"><i class="fas fa-user"></i></a> --}}
                                @if(Auth::user()->role->edit)
                                <a href="{{ url('vehicles/' . $list->id . '/edit') }}" class="btn btn-xs bg-gradient-primary" title="@lang('cmn.edit')"><i class="fas fa-edit"></i></a>
                                @endif

                                @if(Auth::user()->role->delete)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $list->id  }})" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{ url('vehicles', $list->id) }}" method="POST" style="display: none;">
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
                            <td colspan="4" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4></td>
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
</script>
@endpush