@extends('layout')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <form method="GET" name="form">
                    <div class="row">
                        @include('common_filter')
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2" name="expense_id">
                                    <option value="">@lang('cmn.all_expense')</option>
                                    @foreach($expenses as $expense)
                                    <option value="{{ $expense->id }}" {{ ($request->expense_id == $expense->id)?'selected':'' }}>{{ $expense->head }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2" name="vehicle_id">
                                    <option value="">@lang('cmn.all_vehicle')</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ ($request->vehicle_id == $vehicle->id)?'selected':'' }}>{{ $vehicle->number_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="number" value="{{ old('number', $request->number) }}" placeholder="@lang('cmn.write_challan_no_here')">
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="expense_scope">
                                    <option value="">@lang('cmn.inside_and_outside_of_challan')</option>
                                    <option value="inside_of_challan" {{ ($request->expense_scope == 'inside_of_challan')?'selected':'' }}>@lang('cmn.inside_of_challan')</option>
                                    <option value="outside_of_challan" {{ ($request->expense_scope == 'outside_of_challan')?'selected':'' }}>@lang('cmn.outside_of_challan')</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center table-hover text-nowrap" id="expense_table">
                    <thead>
                        <tr align="center">
                            <th>@lang('cmn.id')</th>
                            <th>@lang('cmn.date')</th>
                            <th>@lang('cmn.details')</th>
                            <th>@lang('cmn.expense_head')</th>
                            <th>@lang('cmn.amount')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($lists)>0)
                        @php $total_amount = 0 @endphp

                        @foreach($lists as $key => $list)
                        <tr align="center">
                            <td>{{ $list->id }}</td>
                            <td>
                                <strong>{{ $list->date }}</strong>
                                <small>
                                    @if($list->note)
                                        <br>
                                        @lang('cmn.note') : <strong>({{ $list->note }})</strong>
                                    @endif
                                    <br>
                                    @lang('cmn.posted_by'):
                                    {{ $list->user->first_name}} ({{ date('d M, Y H:m A', strtotime($list->created_at)) }})

                                    @if($list->updated_at)
                                        <br>
                                        @if($list->updated_by)
                                            @lang('cmn.post_updated_by'):
                                            {{ $list->user_update->first_name}} ({{ date('d M, Y H:m A', strtotime($list->updated_at)) }})
                                        @endif
                                    @endif
                                </small>
                            </td>
                            <td>
                                <small>
                                    @if($list->trip_id)
                                        @lang('cmn.challan_no') : <strong>{{ $list->trip->number }}</strong><br>
                                        @lang('cmn.vehicle') : <strong>{{ $list->trip->provider->vehicle_id ? $list->trip->provider->vehicle->number_plate : $list->trip->provider->number_plate }}</strong>
                                    @elseif($list->vehicle_id)
                                        @lang('cmn.challan_no') : <strong>---</strong><br>
                                        @lang('cmn.vehicle') : <strong>{{ $list->vehicle->number_plate }}</strong>
                                    @else
                                        @lang('cmn.challan_no') : <strong>---</strong><br>
                                        @lang('cmn.vehicle') : <strong>---</strong>
                                    @endif
                                    <br>

                                    @if($list->voucher_id)
                                        @lang('cmn.voucher_id') : <strong>{{ $list->voucher_id }}</strong>
                                    @else
                                        @lang('cmn.voucher_id') : <strong>---</strong>
                                    @endif

                                    @if($list->transaction)
                                        <br>
                                        @lang('cmn.account_id') : <strong>{{ $list->transaction->account->user_name }} ({{ $list->transaction->account->account_number??__('cmn.cash') }})</strong>
                                    @endif
                                </small>
                            </td>
                            <td>
                                <strong>{{ $list->expense->head }}</strong>
                            </td>
                            <td>
                                @php $total_amount += $list->amount @endphp
                                <strong>{{ number_format($list->amount) }}</strong><br>
                            </td>
                            <td>
                                @if($list->trip_id)
                                ---
                                @else
                                <button type="button" class="btn btn-xs bg-gradient-primary" onclick="editData({{json_encode($list) }})" title="@lang('cmn.edit')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $list->id  }})" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id }}" method="POST" action="{{ url('expenses', $list->id ) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"><b>@lang('cmn.total')=</b></td>
                                <td><b>{{ number_format($total_amount) }}</b></td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @else
                        <tr>
                            <td colspan="6" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
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
                        &nbsp; <small>(@lang('cmn.database_query_execution_time') = {{ $execution_time }} @lang('cmn.seconds'))</small>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="float-right">
                            {{ $lists->appends(Request::input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('.select2').select2()
    });

    $('#reservationdate').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });

    $('#editDate').datetimepicker({
            defaultDate: "",
            format: 'DD/MM/YYYY'
    });

    function submitExpense(){
        document.getElementById("ex_load_icon1").style.display = "inline-block";
        document.getElementById("ex_show_icon1").style.display = "none";
        document.getElementById("ex_show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('ex_form').submit();
    }

    // delete notice
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

    function editData(value){

        $("#expense_edit").modal('show');

        $("#date").val(value.date_for_edit);
        $("#account_id").val(value.transaction.account_id);
        $("#vehicle_id").val(value.vehicle_id);
        $("#expense_id").val(value.expense_id);
        $("#voucher_id").val(value.voucher_id);
        $("#amount").val(value.amount);
        $("#note").val(value.note);
        
        $('#aciton_edit').attr('action', '');
        $('#aciton_edit').attr('action', base_url + '/expenses/' + value.id);

        $(".select2").select2();
    }


    function dateRangeVisibility(formType){
        // variable assign
        let range_status_type = "range_status_"+formType;
        let month = "month_field_"+formType;
        let year = "year_field_"+formType;
        let daterange = "daterange_field_"+formType;
        let reservation = "#reservation_"+formType;

        let range_status = document.getElementById(range_status_type).value;
        if(range_status == 'monthly_report'){
            document.getElementById(month).style.display = "block";
            document.getElementById(year).style.display = "block";
            document.getElementById(daterange).style.display = "none";
            // reservation
            $(function () {
                $(reservation).daterangepicker();
            })
        } else if(range_status == 'yearly_report'){
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "block";
            document.getElementById(daterange).style.display = "none";
            // reservation
            $(function () {
                $(reservation).daterangepicker();
            })
        } else if(range_status == 'date_wise'){
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "none";
            document.getElementById(daterange).style.display = "block";
            // reservation
            $(function () {
                $(reservation).daterangepicker();
            })
        }else{
            document.getElementById(month).style.display = "none";
            document.getElementById(year).style.display = "none";
            document.getElementById(daterange).style.display = "none";
        }
    }
</script>
@endpush