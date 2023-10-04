@extends('layout')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            {{-- <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#"><strong>{{ $title }}</strong></a></li>
                    </ol>
                </div>
            </div> --}}
        </div>
        <!-- /.container-fluid -->
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
                                <input type="text" class="form-control" name="name_phone" value="{{ old('name_phone') }}" placeholder="Name or Phone">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#add" title="Add"><i class="fa fa-plus"></i> @lang('cmn.add')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- add modal -->
            <div class="modal fade" id="add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('/installment') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">{{$title}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">কেনার তারিখ  <sup style="color: red">*</sup></label>
                                            <input type="date" class="form-control" name="buy_date" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">গাড়ী প্রদানকারী <sup style="color: red">*</sup></label>
                                            <select class="form-control" name="providers_id" required>
                                                <option value="">নির্বাচন করুন</option>
                                                @foreach($providers as $provider)
                                                <option value="{{$provider->id}}">{{$provider->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">গাড়ী নির্বাচন <sup style="color: red">*</sup></label>
                                            <select class="form-control" name="car_id" required>
                                                <option value="">নির্বাচন করুন</option>
                                                @foreach($cars as $car)
                                                <option value="{{ $car->car_id }}">{{ $car->car_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>প্রতি মাসের কিস্তির  তারিখ</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control reservation" name="install_pay_date" value="">
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">চ্যাসিস মূল্য <sup style="color: red">*</sup></label>
                                            <input type="number" class="form-control" placeholder="চ্যাসিস মূল্য" onkeyup="totalAmount()" id="chassis_price" name="chassis_price" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">কিস্তি সংখ্যা </label>
                                            <input type="number" class="form-control" onkeyup="totalAmount()" id="install_number" placeholder="কিস্তি সংখ্যা" name="install_number" required>
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">সুদের হার </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="interest_percent" onkeyup="totalAmount()" placeholder="সুদের হার" name="interest_percent" required>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-percent"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">সুদের পরিমান <sup style="color: red">*</sup></label>
                                            <input type="number" class="form-control" placeholder="সুদের পরিমান" id="interesr_amount" name="interesr_amount" required readonly="">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">মোট মূল্য </label>
                                            <input type="number" class="form-control" placeholder="মোট মূল্য" id="total_price" name="total_price"  readonly="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">ডিসকাউন্ট </label>
                                            <input type="number" class="form-control" onkeyup="totalAmount()" id="discount" placeholder="ডিসকাউন্ট" name="discount">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="">ডাউন পেমেন্ট</label>
                                            <input type="number" class="form-control" onkeyup="totalAmount()" id="down_payment" placeholder="ডাউন পেমেন্ট" name="down_payment">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="">প্রতি কিস্তির পরিমান </label>
                                            <input type="number" class="form-control" placeholder="প্রতি কিস্তির পরিমান" id="install_amount" name="install_amount" readonly>
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
            <!-- end add modal -->

            <!-- edit modal start -->
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ url('/installment-update') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">{{$title}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">কেনার তারিখ  <sup style="color: red">*</sup></label>
                                            <input type="date" id="edit_buy_date" class="form-control" name="buy_date" required="">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">গাড়ী প্রদানকারী <sup style="color: red">*</sup></label>
                                            <select class="form-control" name="providers_id" id="edit_providers_id" required>
                                                <option value="">নির্বাচন করুন</option>
                                                @foreach($providers as $provider)
                                                <option value="{{$provider->id}}">{{$provider->name}}</option>
                                                @endforeach
                                           </select>
                                        </div>
                                    </div>
                                </div>
                                <label>প্রতি মাসের কিস্তির  তারিখ</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="install_pay_date" id="edit_install_pay_date" value="">
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">গাড়ী নির্বাচন <sup style="color: red">*</sup></label>
                                            <select class="form-control" id="edit_car_id" name="car_id" required>
                                                <option value="">নির্বাচন করুন</option>
                                                @foreach($cars as $car)
                                                <option value="{{ $car->car_id }}">{{ $car->car_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">চ্যাসিস মূল্য <sup style="color: red">*</sup></label>
                                            <input type="number" class="form-control" placeholder="চ্যাসিস মূল্য" onkeyup="editTotalAmount()" id="edit_chassis_price" name="chassis_price" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="">সুদের হার </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="edit_interest_percent" onkeyup="editTotalAmount()" placedit_eholder="সুদের হার" name="interest_percent" required>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-percent"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">ডিসকাউন্ট </label>
                                            <input type="number" class="form-control" onkeyup="editTotalAmount()" id="edit_discount" placeholder="ডিসকাউন্ট" name="discount">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col">
                                         <div class="form-group">
                                            <label for="">ডাউন পেমেন্ট</label>
                                            <input type="number" class="form-control" onkeyup="editTotalAmount()" id="edit_down_payment" placeholder="ডাউন পেমেন্ট" name="down_payment">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">কিস্তি সংখ্যা </label>
                                            <input type="number" class="form-control" onkeyup="editTotalAmount()" id="edit_install_number" placeholder="কিস্তি সংখ্যা" name="install_number" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">মোট মূল্য </label>
                                            <input type="number" class="form-control" placeholder="মোট মূল্য" id="edit_total_price" name="total_price"  readonly="">
                                        </div>
                                    </div>
                                    <div class="col">
                                         <div class="form-group">
                                            <label for="">প্রতি কিস্তির পরিমান </label>
                                            <input type="number" class="form-control" placeholder="প্রতি কিস্তির পরিমান" id="edit_install_amount" name="install_amount" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.save')</button>
                            </div>
                            <input type="hidden" name="installment_code" id="installment_code">
                        </form>
                    </div>
                </div>
            </div>
            <!-- end edit modal -->
        </div>
        <!-- /.card -->
        <div class="table-responsive dt-responsive">
            <table class="table table-striped table-bordered nowrap">
                <thead>
                    <tr align="center">
                        <th style="width:5%">#</th>
                        <th>গাড়ী বিস্তারিত</th>
                        <th>পেমেন্ট তথ্য</th>
                        <th >অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($installments as $key=>$list)
                   <tr>
                        <td>{{ $key+1 }}</td>
                        <td class="text-right">
                            নং: <b>{{ $list->car->car_no }}</b><br>
                            নম্বর: <b>{{ $list->car->car_number }}</b><br>
                            চালক: <b>{{ $list->car->driver->people_name }}</b>
                        </td>
                        <td class="text-right">
                            প্রদানকারী : <b>{{ $list->provider->name }}</b>
                            </br>
                            মোট মূল্য: <strong>{{ number_format($list->total_price) }}</strong>
                            </br>
                            জমা : <strong>{{ number_format($list->down_paymnet + $list->Installment_history->sum("pay_amount")) }}</strong>
                            </br>
                            ----------------------
                            <br>
                            (বাকি) = <strong>{{ number_format($list->total_price - ($list->down_paymnet + $list->Installment_history->sum("pay_amount") )) }}</strong>
                            <!-- পরবর্তী কিস্তি: <b>{{ \Carbon\Carbon::parse($list->install_pay_start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($list->install_pay_end_date)->format('d M y') }}</b><br> -->
                        </td>
                        <td class="text-left">
                            <a class="btn btn-sm bg-gradient-success" href="{{ url('installment-history', $list->code) }}" title="পেমেন্ট ইতিহাস">কিস্তির ইতিহাস</a>
                            <a class="btn btn-sm bg-gradient-warning" href="{{ url('installment-history') }}" title="পেমেন্ট ইতিহাস"><i class="fa fa-print"></i></a>
                            <button class="btn btn-primary btn-sm" onclick="editData({{ $list->id }})" type="button" title="এডিট"><i class="fa fa-edit"></i></button>
                            @if(empty(count($list->installment)))
                            <button type="button" class="btn btn-sm bg-gradient-danger" onclick="return deleteCertification({{ $list->id }})" title="ডিলিট"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-{{ $list->id }}" method="POST" action="{{ url('installment', $list->id ) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                        </td>
                   </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
	    function editData(id){
	        if(id){
	            $.ajax({
	                type: 'GET',
	                dataType: "json",
	                url: "installment/" + id+"/edit",
	                success: function(data) {
	                   if(data.status){
                        console.log(data.data)
	                        $("#editModal").modal("show")
                            $("#edit_buy_date").val(data.data.buy_date)
                            $("#edit_providers_id").val(data.data.providers_id)
                            $("#edit_car_id").val(data.data.car_id)
                            $("#edit_chassis_price").val(data.data.chassis_price)
                            $("#edit_interest_percent").val(data.data.interest_percent)
                            $("#edit_discount").val(data.data.discount)
                            $("#edit_down_payment").val(data.data.down_payment)
                            $("#edit_install_number").val(data.data.install_number)
                            $("#edit_total_price").val(data.data.total_price)
                            $("#installment_code").val(data.data.code)
                            $("#edit_install_amount").val(data.data.install_amount)
                            $("#edit_install_pay_date").val(data.data.pay_date)
                            $("#edit_install_pay_date").attr("class","reservation form-control")
                            $('.reservation').daterangepicker();
	                   }else{
	                    alert(data.message)
	                   }
	                }
	            });
	        }
	    }

        function totalAmount(){
            var chassis_price = parseInt($("#chassis_price").val());
            var interest_percent = parseInt($("#interest_percent").val());
            var discount = parseInt($("#discount").val());
            var total_price = null;
            var  install_amount = null;
            var down_payment = parseInt($("#down_payment").val());
            var install_number = parseInt($("#install_number").val());
            if(chassis_price && interest_percent && install_number){
                total_price = chassis_price + (((chassis_price*interest_percent)/100)*(install_number / 12));
                $("#total_price").val(Math.round(total_price));
                $("#interesr_amount").val(Math.round(((chassis_price*interest_percent)/100)*(install_number / 12)));
            }
            if(chassis_price && interest_percent && down_payment && install_number){
                install_amount = total_price - down_payment;
                if(discount){
                    install_amount = install_amount - discount; 
                }
                $("#install_amount").val(Math.round(install_amount/install_number));

            }
        }

        function editTotalAmount(){
            var chassis_price = parseInt($("#edit_chassis_price").val());
            var interest_percent = parseInt($("#edit_interest_percent").val());
            var discount = parseInt($("#edit_discount").val());
            var total_price = null;
            var  install_amount = null; 
            var down_payment = parseInt($("#edit_down_payment").val());
            var install_number = parseInt($("#edit_install_number").val());
            if(chassis_price && interest_percent && install_number){
                total_price = chassis_price + (((chassis_price*interest_percent)/100)*(install_number / 12));
                $("#edit_total_price").val(Math.round(total_price));
                $("#edit_interesr_amount").val(Math.round(((chassis_price*interest_percent)/100)*(install_number / 12)));
            }
            if(chassis_price && interest_percent && down_payment && install_number){
                install_amount = total_price - down_payment;
                if(discount){
                    install_amount = install_amount - discount; 
                }
                $("#edit_install_amount").val(Math.round(install_amount/install_number));

            }
        }


</script>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    // reservation
    $(function () {
        $('.reservation').daterangepicker();
    })
</script>
@endpush