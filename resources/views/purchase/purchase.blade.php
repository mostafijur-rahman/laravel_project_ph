@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        @if($request->page_name == 'tyre')
            @include('purchase.form.tyre_purchase_form')
        @endif
        @if($request->page_name == 'mobil')
            @include('purchase.form.mobil_purchase_form')
        @endif
        <!-- Default box -->
        <div class="card">
            <div class="modal fade" id="buy_mobil">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('/purchases') }}" method="post">
                            @csrf
                            <input type="hidden" name="form_type" value="mobil">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('cmn.mobil_purchase_form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{-- <label>@lang('cmn.purchase_date')</label>
                                            <input type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d'))}}" placeholder="@lang('cmn.tyre_number')"> --}}
                                            <label>@lang('cmn.purchase_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <div class="input-group date" id="mobil_purchase_date" data-target-input="nearest">
                                                <input type="text" name="date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                                <div class="input-group-append" data-target="#mobil_purchase_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.supplier_name')</label>
                                            <select name="supplier_id" class="form-control" required>
                                                @if(isset($suppliers))
                                                @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.brand')</label>
                                            <select name="brand_id" class="form-control" required>
                                                @if(isset($brands))
                                                @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.liter') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="number" class="form-control" name="liter" value="{{ old('liter')}}" placeholder="@lang('cmn.liter')" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.price') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="number" class="form-control" name="price" value="{{ old('price')}}" placeholder="@lang('cmn.price')" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.paid') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                            <input type="number" class="form-control" name="paid" value="{{ old('paid')}}" placeholder="@lang('cmn.paid')" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.discount')</label>
                                            <input type="number" class="form-control" name="discount" value="{{ old('discount')}}" placeholder="@lang('cmn.discount')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cmn.note') </label>
                                            <textarea class="form-control" rows="1" name="note" placeholder="@lang('cmn.write_note_here')"></textarea>
                                        </div>
                                    </div>
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
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th>@lang('cmn.primary_info')</th>
                            <th>@lang('cmn.about_goods')</th>
                            <th>@lang('cmn.about_payment')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($purchases) > 0)
                            @foreach($purchases as $key => $purchase)
                            <tr>
                                <td class="text-left">
                                    @lang('cmn.purchase_date'): <strong>{{ date('d M, Y', strtotime($purchase->date )) }}</strong><br>
                                    @lang('cmn.supplier'): <strong>{{  $purchase->supplier->name }}</strong><br>
                                    <small>
                                        @lang('cmn.created'): <strong>{{ $purchase->created_user->full_name }}</strong><br>
                                    </small>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="return deleteCertification(<?php echo $purchase->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                    <form id="delete-form-{{$purchase->id}}" action="{{ url('purchases', $purchase->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                                <td class="text-left">
                                    @lang('cmn.brand'): <strong>{{ $purchase->purchaseable->brand->name }}</strong><br>
                                    @lang('cmn.goods'): <strong>@lang('cmn.'.$purchase->purchaseable_type)</strong><br>
                                    @if($purchase->purchaseable_type == 'tyre')
                                    @lang('cmn.tyre_number'): <strong>{{ $purchase->purchaseable->tyre_number }}</strong>
                                    @elseif($purchase->purchaseable_type == 'mobil')
                                    @lang('cmn.liter'): <strong>{{  $purchase->purchaseable->liter }}</strong>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @lang('cmn.price') = <strong>{{ number_format($purchase->price) }}</strong><br>
                                    @lang('cmn.paid') = <strong>{{ number_format($purchase->paid) }}</strong><br>
                                    @if($purchase->due > 0)
                                    @lang('cmn.due') = <strong>{{ number_format($purchase->due) }}</strong><br>
                                    @endif
                                    @if($purchase->discount > 0)
                                    @lang('cmn.discount') = <strong>{{ number_format($purchase->discount) }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="3" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{ $purchases->appends(Request::input())->links() }}
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    $('#tyre_purchase_date').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });

    $('#mobil_purchase_date').datetimepicker({
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
    function submitMobil(){
        document.getElementById("load_icon2").style.display = "inline-block";
        document.getElementById("show_icon2").style.display = "none";
        document.getElementById("show_btn2").disabled=true;

        event.preventDefault();
        document.getElementById('action').submit();
    }
</script>
@endpush