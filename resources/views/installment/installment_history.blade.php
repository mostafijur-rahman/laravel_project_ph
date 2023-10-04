@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h4> {{$installment->car->car_number ." গাড়ীটি ".$installment->providers_id}} কোম্পানী থেকে নেয়া কিস্তির ইতিহাস</h4>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->

            <div class="card">
                <form method="POST" action="{{ url('installment-collection') }}">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">সাধারণ খরচ</h3>
                        <button type="button" class="btn btn-primary btn-sm float-right" onclick="addExpenseRow()"><i class="fa fa-plus"></i></button>
                        <button type="submit" class="btn btn-success btn-sm float-right" style="margin-right: 10px;"><i class="fa fa-upload"></i> @lang('cmn.save')</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-bordered text-center table-hover" id="expense_table">
                            <thead>
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="20%">তারিখ</th>
                                    <th width="20%">পেমেন্টের ধরণ</th>
                                    <th width="20%">কিস্তি নং</th>
                                    <th width="20%">টাকার পরিমান</th>
                                    <th width="45%">নোট</th>
                                    <th width="10%">অ্যাকশন</th>
                                </tr>
                            </thead>
                            @php
                                $tr_row_no = 1;
                            @endphp
                            <tbody id="expense_tbody">
                                @if($installment->installment_history)
                                @foreach($installment->installment_history as $key =>$list)
                                <tr id="tr_row_{{$key+1}}">
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($list->pay_date)->format("M d y") }}</td>
                                    <td>
                                        @if($list->pay_type == 1)
                                        <button type="button" class="btn btn-primary btn-sm">কিস্তি</button>
                                        @elseif($list->pay_type == 2)
                                        <button type="button" class="btn btn-success btn-sm">ডাউন পেমেন্ট</button>
                                        @elseif($list->pay_type == 3)
                                        <button type="button" class="btn btn-danger btn-sm">জরিমানা </button>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{ ($list->install_no)?: "-" }}</td>
                                    <td>{{ number_format($list->pay_amount) }}</td>
                                    <td>{{ $list->note }}</td>
                                    <td>
                                        @if($list->pay_type == 1)
                                        <button type="button" class="btn btn-sm btn-primary" title="Edit" {{ ($list->pay_type == 2)? "disabled" : "" }}><i class="fa fa-edit"></i></button>
                                        <a href="{{ ($list->pay_type == 2)? '#' : url('installment-history-delete', $list->code)  }}" onclick="return confirm('Are you sure ? , you want to delete this.')" class="btn btn-sm btn-danger" title="যুক্ত"><i class="fa fa-trash"></i></a>
                                        @else
                                        ---
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $tr_row_no++;
                                @endphp
                                @endforeach
                                @endif
                                <tr style="font-weight: bold;">
                                    <td colspan="4" class="text-right">মোট পরিশোধ =</td>
                                    <td>{{ number_format($installment->installment_history->sum('pay_amount')) }} (বাকি - {{ number_format($installment->total_price - $installment->installment_history->sum('pay_amount')) }} )</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr id="tr_row_{{$tr_row_no}}">
                                    <td></td>
                                    <td><input type="date" name="date[]" class="form-control" required=""></td>
                                    <td>
                                        <select name="pay_type[]" class="form-control" id="payment_type_{{$tr_row_no}}" onchange="paymentTypeCheck({{$tr_row_no}})" required="">
                                            <option value="">ধরণ নির্বাচন করুন</option>
                                            <option value="1">কিস্তি</option>
                                            <option value="2">ডাউন পেমেন্ট</option>
                                            <option value="3">জরিমানা</option>
                                        </select>
                                    </td>
                                    <td id="null_value_generate_{{$tr_row_no}}" style="display: none;">-</td>
                                    <td id="installment_number_td_{{$tr_row_no}}">
                                        <select name="installment_number[]" class="form-control" id="installment_number_{{$tr_row_no}}">
                                            <option value="">কিস্তি নং</option>
                                            @for($i = 1; $i <= $list->installment->install_number; $i++))
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td><input type="number" name="installment_amount[]" class="form-control" placeholder="টাকার পরিমান"></td>
                                    <td><input type="text" name="installment_note[]" class="form-control" placeholder="নোট" ></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="return removeExpenseTr({{$tr_row_no}})" title="যুক্ত"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <input type="hidden" name="installment_history_code" value="{{ $installment->id }}">
                            </tbody>    
                        </table>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>


        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
    function addExpenseRow(){
        var rowCount = ($('#expense_tbody tr').length);
        var html = `
            <tr id="tr_row_${rowCount}">
                <td>${rowCount}</td>
                <td><input type="date" name="date[]" class="form-control" required=""></td>
                <td>
                    <select name="pay_type[]" class="form-control" id="payment_type_${rowCount}" onchange="paymentTypeCheck(${rowCount})" required="">
                        <option value="">ধরণ নির্বাচন করুন</option>
                        <option value="1">কিস্তি</option>
                        <option value="2">ডাউন পেমেন্ট</option>
                        <option value="3">জরিমানা</option>
                    </select>
                </td>
                <td id="null_value_generate_${rowCount}" style="display: none;">-</td>
                <td id="installment_number_td_${rowCount}">
                    <select name="installment_number[]" class="form-control" id="installment_number_${rowCount}">
                        <option value="">কিস্তি নং</option>
                        <option value="3">৩য়</option>
                        <option value="4">৪থ</option>
                        <option value="5">৫ম</option>
                    </select>
                </td>
                <td><input type="number" name="installment_amount[]" class="form-control" placeholder="টাকার পরিমান"></td>
                <td><input type="text" name="installment_note[]" class="form-control" placeholder="নোট" ></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="return removeExpenseTr(${rowCount})" title="যুক্ত"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;

        $("#expense_tbody").append(html);
    }

    function removeExpenseTr(row_count){
        if(confirm("Do you really want to do this?")) {
            $('table #expense_tbody #tr_row_'+row_count).remove();
        }else{
            return false;
        }
    }

    function paymentTypeCheck(tr_row){
        var pay_type = $('#payment_type_'+tr_row).val();
        if(pay_type == 1){
            $('#null_value_generate_'+tr_row).hide();
            $('#installment_number_td_'+tr_row).show();
            $('#installment_number_'+tr_row).attr('required',true);
        }else{
            $('#null_value_generate_'+tr_row).show();
            $('#installment_number_td_'+tr_row).hide();
            $('#installment_number_'+tr_row).attr('required',false);
        }
    }
</script>
<script type="text/javascript">
	    function editData(id){
	        if(id){
	            $.ajax({
	                type: 'GET',
	                dataType: "json",
	                url: "client/" + id+"/edit",
	                success: function(data) {
	                   if(data.status){
	                        let client = data.data
	                        $("#editModal").modal("show");
	                        $("#client_encrypt").val(client.client_encrypt)
	                        $("#name").val(client.client_name)
	                        $("#phone").val(client.client_phone)
	                        $("#address").val(client.client_address)
	                        $("#note").val(client.client_note)
	                   }else{
	                    alert(data.message)
	                   }
	                }
	            });
	        }
	    }
</script>

@endsection