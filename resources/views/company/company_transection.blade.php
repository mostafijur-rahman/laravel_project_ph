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
                <h3 class="card-title">{{ $company->name }} @lang('cmn.of') @lang('cmn.advance_received') @lang('cmn.form')</h3>
            </div>
            @if(Auth::user()->role->create)
            <div class="card-body">
                <form id="action" method="POST" action="{{ url('company-transection') }}">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $request->company_id }}">
                    <input type="hidden" name="transection_type" value="in_from_company">
                    <div class="row">
                        <div class="col-md-3">
                            <label>@lang('cmn.date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="date" placeholder="@lang('cmn.date')" class="form-control datetimepicker-input {{ $errors->has('date') ? 'is-invalid' : '' }}" data-target="#reservationdate" required>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('date'))
                                    <span class="error invalid-feedback">{{ $errors->first('date') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.balance') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                <input type="number"  class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" placeholder="@lang('cmn.balance') (@lang('cmn.required'))" required>
                                @if ($errors->has('amount'))
                                    <span class="error invalid-feedback">{{ $errors->first('amount') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.note')</label>
                                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" rows="1" name="note" placeholder="@lang('cmn.write_note_here')"></textarea>
                                @if ($errors->has('note'))
                                    <span class="error invalid-feedback">{{ $errors->first('note') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" id="show_btn1" class="form-control btn btn-success" onclick="submitForm()">
                                    <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                    <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
        <!-- table -->
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.details')</th>
                            <th>@lang('cmn.date')</th>
                            <th>@lang('cmn.in')</th>
                            <th>@lang('cmn.out')</th>
                            @if(Auth::user()->role->edit or Auth::user()->role->delete)
                            <th>@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $total_in = 0; 
                            $total_out = 0; 
                        @endphp
                        @if(count($lists)>0)
                            @foreach($lists as $key => $list)
                                @php 
                                    $total_in += $list->type=='in_from_company'?$list->amount:0;
                                    $total_out += $list->type=='out_for_trip'?$list->amount:0; 
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        {{ __('cmn.'.$list->type) }}
                                        @if($list->transactionable)
                                            @if($list->transactionable->number)
                                                (@lang('cmn.challan_no') : <b>{{ $list->transactionable->number }}</b>)
                                            @endif
                                        @endif
                                        @if($list->note)
                                        <br>
                                        <small>@lang('cmn.note'): {{ $list->note }}</small>
                                        @endif
                                    </td>
                                    <td>{{ date('d M, Y', strtotime($list->date)) }}</td>
                                    <td>{{ $list->type=='in_from_company'?number_format($list->amount):'---' }}</td> 
                                    <td>{{ $list->type=='out_for_trip'?number_format($list->amount):'---' }}</td>
                                    @if(Auth::user()->role->delete)
                                    <td>
                                        @if($list->type == 'in_from_company')
                                        <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                                        <form id="{{$list->id}}" action="{{ url('settings/companies',$list->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @else
                                        ---
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="3" class="text-right">@lang('cmn.total') = </td>
                            <td class="text-success"><strong>{{ number_format($total_in) }}</strong></td>
                            <td class="text-danger"><strong>{{ number_format($total_out) }}</strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $lists->appends(Request::input())->links() }}
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    $('#reservationdate').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('action').submit();
    }
</script> 
@endpush