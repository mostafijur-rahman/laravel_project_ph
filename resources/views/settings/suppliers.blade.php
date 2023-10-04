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
                    <h3 class="card-title">@lang('cmn.suppliers_form')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="action" method="POST" action="{{ url('settings/suppliers') }}">
                        @csrf
                        <input type="hidden" id="request_type" name="" value="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}" placeholder="@lang('cmn.suppliers') @lang('cmn.name')" required>
                                </div>
                            </div>
                            <div  class="col-md-3">
                                <div class="form-group">
                                    <select name="type" id="type" class="form-control">
                                        <option value="vehicle">@lang('cmn.vehicle')</option>
                                        <option value="goods">@lang('cmn.goods')</option>
                                   </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" id="phone" class="form-control" name="phone" value="{{ old('phone')}}" placeholder="@lang('cmn.phone')">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" id="receivable_amount" class="form-control" name="receivable_amount" value="{{ old('receivable_amount', 0)}}" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" id="payable_amount" class="form-control" name="payable_amount" value="{{ old('payable_amount', 0)}}" placeholder="0">
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
                            <div class="col-md-3">
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
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.name')</th>
                            <th>@lang('cmn.our_receivable')</th>
                            <th>@lang('cmn.company_payable')</th>
                            <th>@lang('cmn.phone')</th>
                            @if(Auth::user()->role->edit or Auth::user()->role->delete)
                            <th>@lang('cmn.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($suppliers))
                        @php 
                            $total_receivable_amount = 0; 
                            $total_payable_amount = 0; 
                        @endphp
                        @foreach($suppliers as $key => $list)
                        @php $total_receivable_amount += $list->receivable_amount; @endphp
                        @php $total_payable_amount += $list->payable_amount; @endphp
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->name }}</td>
                            <td class="text-success"><strong>{{ number_format($list->receivable_amount) }}</strong></td>
                            <td class="text-danger"><strong>{{ number_format($list->payable_amount) }}</strong></td>
                            <td>{{ $list->phone }}</td>
                            @if(Auth::user()->role->edit or Auth::user()->role->delete)
                            <td>
                                @if(Auth::user()->role->edit)
                                <button type="button" class="btn btn-xs bg-gradient-primary" onclick="editData({{json_encode($list) }})" title="Edit"><i class="fas fa-edit"></i></button>
                                @endif
                                @if(Auth::user()->role->delete)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$list->id}}" action="{{ url('settings/suppliers',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="2" class="text-right">@lang('cmn.total') = </td>
                            <td class="text-success"><strong>{{ number_format($total_receivable_amount) }}</strong></td>
                            <td class="text-danger"><strong>{{ number_format($total_payable_amount) }}</strong></td>
                            <td></td>
                            @if(Auth::user()->role->edit or Auth::user()->role->delete)
                            <td></td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="paginate" style="float: right;">
                {!! $suppliers->links() !!}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
    function editData(value){
        $("#name").val(value.name)
        $("#type").val(value.type)
        $("#receivable_amount").val(value.receivable_amount)
        $("#payable_amount").val(value.payable_amount)
        $("#phone").val(value.phone)
        $("#address").val(value.address)
        $("#note").val(value.note)
        $('#action').attr('action', '');
        $('#action').attr('action', '/settings/suppliers/' + value.id);

        $("#request_type").attr('name','_method');
        $("#request_type").val('PUT');
    }
    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;
        event.preventDefault();
        document.getElementById('action').submit();
    }
</script>

@endsection