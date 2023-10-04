@extends('layout')
@section('content')
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
            <div class="card-header">
                <strong>{{ $investors->name }}</strong> এর ট্রান্সপোর্ট ব্যবসায় মূলধন বিনিয়োগের ইতিহাস
                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#transportAdd"><i class="fa fa-plus"></i> @lang('cmn.add') </button>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.date')</th>
                            <th>@lang('cmn.invest')</th>
                            <th>উত্তোলন</th>
                            <th>@lang('cmn.balance')</th>
                            <th>@lang('cmn.note')</th>
                            <th style="width:10%">@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_trans_in = 0;
                            $total_trans_out = 0;
                            $trans_balance = 0;
                        @endphp
                        @if($investors->trasport_invest)
                        @foreach($investors->trasport_invest->history as $key => $list)
                        @php
                            $total_trans_in += $list->cash_in;
                            $total_trans_out += $list->cash_out;
                            ($list->cash_in)?$trans_balance +=$list->cash_in : $trans_balance -= $list->cash_out;
                        @endphp
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->date }}</td>
                            <td>{{ ($list->cash_in)? number_format($list->cash_in) : 0 }}</td>
                            <td>{{ ($list->cash_out)? number_format($list->cash_out) : 0 }}</td>
                            <td><strong>{{ number_format($trans_balance) }}</strong></td>
                            <td>{{ $list->note }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" onclick="editData({{json_encode($list) }})"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm bg-gradient-danger" onclick="return deleteCertification(<?php echo $list->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{ url('capitals',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-right"> @lang('cmn.total') = </td>
                            <td><strong>{{ number_format($total_trans_in) }}</strong></td>
                            <td><strong>{{ number_format($total_trans_out) }}</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header">
                <strong>{{ $investors->name }}</strong> এর গাড়ীর ব্যবসায় মূলধন বিনিয়োগের ইতিহাস
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.date')</th>
                            <th>@lang('cmn.vehicle') @lang('cmn.number')</th>
                            <th>@lang('cmn.invest')</th>
                            <th>@lang('cmn.drawing') </th>
                            <th>@lang('cmn.balance')</th>
                            <th>@lang('cmn.note')</th>
                            <th style="width:10%">@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_trip_in = 0;
                            $total_trip_out = 0;
                            $trip_balance = 0;
                        @endphp
                        @if($investors->trip_invest)
                        @foreach($investors->trip_invest->history as $key => $list)
                        @php
                            $total_trip_in += $list->cash_in;
                            $total_trip_out += $list->cash_out;
                            ($list->cash_in)?$trip_balance +=$list->cash_in : $trip_balance -= $list->cash_out;
                        @endphp
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->date }}</td>
                            <td>{{ ($list->car->car_number)?$list->car->car_number:'---' }}</td>
                            <td>{{ ($list->cash_in)? number_format($list->cash_in) : 0 }}</td>
                            <td>{{ ($list->cash_out)? number_format($list->cash_out) : 0 }}</td>
                            <td><strong>{{ number_format($trip_balance) }}</strong></td>
                            <td>{{ $list->note }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" onclick="editData({{json_encode($list) }})"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm bg-gradient-danger" onclick="return deleteCertification(<?php echo $list->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{ url('capitals',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right"> @lang('cmn.total') = </td>
                            <td><strong>{{ number_format($total_trip_in) }}</strong></td>
                            <td><strong>{{ number_format($total_trip_out) }}</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- add -->
        <div class="modal fade" id="transportAdd" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('cmn.capitals') @lang('cmn.add')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ url('capitals-history-store') }}">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="form-group">
                                <label>@lang('cmn.date') <span class="required">*</span></label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required="">
                            </div>
                            <div class="form-group">
                                <label>@lang('cmn.business_type') <span class="required">*</span></label>
                                <select name="business_type" class="form-control" required="" onchange="typeChange(this.value)">
                                    <option value="1">@lang('cmn.transport')</option>
                                    <option value="2">@lang('cmn.vehicle')</option>
                                </select>
                            </div>
                            <div class="form-group" id="car_data">
                                <label>@lang('cmn.vehicle')</label>
                                <select class="form-control" name="car">
                                    <option value="">@lang('cmn.please_select')</option>
                                    @foreach($cars as $car)
                                    <option value="{{ $car->car_id }}">{{ $car->car_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>ক্যাশ অবস্থা <span class="required">*</span></label>
                                <select name="cash_type" class="form-control" required="">
                                    <option value="1">@lang('cmn.invest')</option> 
                                    <option value="2">উত্তোলন</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('cmn.amount') <span class="required">*</span></label>
                                <input type="number" name="amount" value="0" class="form-control" placeholder="Enter Amount" required="">
                            </div>
                            <div class="form-group">
                                <label>@lang('cmn.note') </label>
                                <textarea class="form-control" name="note" placeholder="@lang('cmn.write_note_here')"></textarea>
                            </div>
                            <input type="hidden" name="inv_code" value="{{ $investors->encrypt }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close') </button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save') </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- edit -->
        <div class="modal fade" id="Edit" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditModalLabel">@lang('cmn.capitals') @lang('cmn.edit')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ url('capitals-history-update') }}">
                        @csrf
                        <div class="modal-body">
                            {{-- <div class="form-group">
                                <label>@lang('cmn.date') <span class="required">*</span></label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div> --}}
                            <div class="form-group">
                                <label>@lang('cmn.note') </label>
                                <textarea class="form-control" id="note" name="note" placeholder="@lang('cmn.write_note_here')"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="primary">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close') </button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save') </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Transport History Modals End-->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#car_data').hide();
    });
    function typeChange(type){
        if(type == 2){
            $('#car_data').show();
        }else{
            $('#car_data').hide();
        }
    }
    function editData(value){
        $("#Edit").modal("show");
        // $("#date").val(value.date)
        $("#primary").val(value.id)
        $("#note").val(value.note)
    }
</script>
@endpush