@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('settings.submenu')
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- form box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.company_form')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form id="action" method="POST" action="{{ url('settings/companies') }}">
                    @csrf
                    <input type="hidden" id="request_type" name="" value="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.company') @lang('cmn.name')" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group date"  id="reservationdate" data-target-input="nearest">
                                        <input type="text" placeholder="@lang('cmn.date')" name="trip_receivable_date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                            </div>
                            {{-- <div class="form-group">
                                <label for="">@lang('cmn.previous_balance') (@lang('cmn.company_payable'))</label>
                                <input type="number" class="form-control" name="payable_amount" value="{{ old('payable_amount', 0)}}" placeholder="0">
                            </div> --}}
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="number" class="form-control" id="trip_receivable_amount" name="trip_receivable_amount" value="{{ old('receivable_amount', 0)}}" placeholder="@lang('cmn.previous_balance')" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone')}}" placeholder="0171 xxx xxx">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <textarea class="form-control" rows="1" id="address" name="address" placeholder="@lang('cmn.address')">{{ old('address')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <textarea class="form-control" rows="1" id="note" name="note" placeholder="@lang('cmn.note')">{{ old('note')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @if(Auth::user()->role->create)
                                <div class="form-group">
                                    <button type="button" id="show_btn1" class="btn btn-success" onclick="submitForm()">
                                    <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                    <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                                    </button>
                                </div>
                                @endif
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
                                <input type="text" class="form-control" name="name_phone" value="{{ old('name_phone',$request->name_phone) }}" placeholder="Name or Phone">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- @include('include.add_company_form') --}}
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.company_name')</th>
                            <th>@lang('cmn.previous_balance')</th>
                            {{-- <th>@lang('cmn.company_payable')</th> --}}
                            <th>@lang('cmn.phone')</th>
                            @if(Auth::user()->role->edit or Auth::user()->role->delete)
                            <th>@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @php 
                            $total_receivable_amount = 0; 
                            $total_payable_amount = 0; 
                        @endphp
                        @foreach($lists as $key => $list)
                        @php $total_receivable_amount += $list->receivable_amount; @endphp
                        @php $total_payable_amount += $list->payable_amount; @endphp
                        <tr>
                            <td>{{ ++$key }}</td>
                            {{-- <td>
                                <form action="{{ url('pump-sort') }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control" min="0" name="sort" value="{{ $list->people_sort }}" required>
                                        <input type="hidden" class="form-control" name="encrypt" value="{{ $list->pump_encrypt }}" required>
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-success btn-flat" onclick="return (confirm('Are you sure?'))?true:false" title="Sort order"><i class="fa fa-sort"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </td> --}}
                            <td>
                                {{ $list->name }} <br>
                                <small>{{ $list->note }}</small>
                            </td>
                            <td>
                                @if($list->trip_receivable_amount > 0)
                                @lang('cmn.amount') : <strong>{{ number_format($list->trip_receivable_amount) }}</strong><br>
                                @lang('cmn.date') : <strong>{{ date('d M, Y', strtotime($list->trip_receivable_date)) }}</strong>
                                @else
                                -----
                                @endif
                            </td>
                            {{-- <td class="text-danger"><strong>{{ number_format($list->payable_amount) }}</strong></td> --}}
                            <td>{{ $list->phone }}</td>
                            <td>
                                @if(Auth::user()->role->edit)
                                <button type="button" class="btn btn-xs bg-gradient-primary" onclick="editData({{json_encode($list) }})" title="Edit"><i class="fas fa-edit"></i></button>
                                @endif
                                @if(Auth::user()->role->delete)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$list->id}}" action="{{ url('settings/companies',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="2" class="text-right">@lang('cmn.total') = </td>
                            <td class="text-danger"><strong>{{ number_format($total_receivable_amount) }}</strong></td>
                            {{-- <td class="text-danger"><strong>{{ number_format($total_payable_amount) }}</strong></td> --}}
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/js.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    $('#reservationdate').datetimepicker({
            defaultDate: "",
            format: 'DD/MM/YYYY'
        });

    function editData(value){

        $("#name").val(value.name);
        $("#reservationdate").val(value.reservationdate);
        $("#trip_receivable_amount").val(value.trip_receivable_amount);
        $("#phone").val(value.phone);
        $("#address").val(value.address);
        $("#note").val(value.note);
 
        $('#action').attr('action', '');
        $('#action').attr('action', '/settings/companies/' + value.id);

        $("#request_type").attr('name','_method');
        $("#request_type").val('put');
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
