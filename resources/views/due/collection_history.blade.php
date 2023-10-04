@extends('layout')
@section('content')
<style type="text/css">
    .required{
        color: red;
        font-weight: bold;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h4>"{{ $client->client_name}}" বকেয়া হিসাব </h4>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
            <div class="card">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Trip Due Collection History</h3>
                    <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Trip Due Collection</button>
                </div>

                <!-- Due Collection Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Trip Due Collection</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('dues.due.collection') }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>@lang("cmn.select_vehicle") <span class="required">*</span></label>
                                        <select class="form-control" name="car_id" onchange="getDueAmount(this.value)" required="">
                                            <option value="">@lang("cmn.please_select")</option>
                                            @foreach($cars as $car)
                                            <option value="{{ $car->car_id }}">{{ $car->car_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Date <span class="required">*</span></label>
                                        <input type="date" name="date" class="form-control" required="" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Amount <span class="required">*</span></label>
                                        <!-- <input type="number" name="amount" max="{{ $client->due_trips->sum('trip_due_fair') }}" value="{{ $client->due_trips->sum('trip_due_fair') }}" class="form-control" placeholder="Enter Amount" required=""> -->
                                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" required="">
                                    </div>
                                </div>
                                <input type="hidden" name="client_id" value="{{ $client->client_id }}">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="trip_submitBtn" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Due Collection Modal end-->

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-bordered text-center table-hover" id="expense_table">
                        <thead>
                            <tr align="center">
                                <th>Sl</th>
                                <th>তারিখ</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($client->collection_history))
                            @foreach($client->collection_history as $key => $list)
                            <tr align="center">
                                <td>{{ ++$key }}</td>
                                <td>{{ $list->date }}</td>
                                <td>{{ number_format($list->amount) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm bg-gradient-danger" onclick="return deleteCertification(<?php echo $list->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                    <form id="delete-form-{{$list->id}}" action="{{ url('collection-histories-delete',$list->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right"><b>Total</b></td>
                                    <td>{{ number_format($client->collection_history->sum("amount")) }}</td>
                                </tr>
                            </tfoot>
                            @else
                            <tr>
                                <td colspan="5">Opps!!, No due history found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- transport due collection -->
            <div class="card">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Transport Due Collection History</h3>
                    <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#TransModal"><i class="fa fa-plus"></i> Transport Due Collection</button>
                </div>

                <!-- Due Collection Modal -->
                <div class="modal fade" id="TransModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Transport Due Collection</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ url('transport-due-collection') }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>@lang("cmn.select_vehicle") <span class="required">*</span></label>
                                        <select class="form-control" name="car_id" onchange="getTransAmount(this.value)" required="">
                                            <option value="">@lang("cmn.please_select")</option>
                                            @foreach($cars as $car)
                                            <option value="{{ $car->car_id }}">{{ $car->car_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Date <span class="required">*</span></label>
                                        <input type="date" name="date" class="form-control" required="" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Amount <span class="required">*</span></label>
                                        <!-- <input type="number" name="amount" max="{{ $client->due_trips->sum('trip_due_fair') }}" value="{{ $client->due_trips->sum('trip_due_fair') }}" class="form-control" placeholder="Enter Amount" required=""> -->
                                        <input type="number" name="amount" id="trans_amount" class="form-control" placeholder="Enter Amount" required="">
                                    </div>
                                </div>
                                <input type="hidden" name="client_id" value="{{ $client->client_id }}">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="trans_submitBtn" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Due Collection Modal end-->

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-bordered text-center table-hover" id="expense_table">
                        <thead>
                            <tr align="center">
                                <th>Sl</th>
                                <th>তারিখ</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($client->trans_due_collection))
                            @foreach($client->trans_due_collection as $key => $trans_list)
                            <tr align="center">
                                <td>{{ ++$key }}</td>
                                <td>{{ $trans_list->date }}</td>
                                <td>{{ number_format($trans_list->amount) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm bg-gradient-danger" onclick="return deleteTransHistory(<?php echo $trans_list->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                    <form id="trans-delete-form-{{$trans_list->id}}" action="{{ url('transport-collection-histories-delete',$trans_list->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right"><b>Total</b></td>
                                    <td>{{ number_format($client->trans_due_collection->sum("amount")) }}</td>
                                </tr>
                            </tfoot>
                            @else
                            <tr>
                                <td colspan="5">Opps!!, No due history found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script type="text/javascript">
    function getDueAmount(value) {
        var client_id = {{ $client->client_id }}
        if(value){
            $.ajax({
                type:'get',
                url:'/get-car-and-client-wise-due-amount',
                data: {car_id: value, client_id: client_id},
                success:function(data){
                    if(data.status){
                        $("#trip_amount").val(parseInt(data.data))
                        $("#trip_amount").attr('max', parseInt(data.data))
                        $('#trip_submitBtn').attr('disabled', false)
                    }else{
                        $('#trip_submitBtn').attr('disabled', true)
                        $("#trip_amount").val(0)
                        $("#trip_amount").attr('max', 0)
                        alert(data.message)
                    }
                },
                error:function(data){ 
                    alert(data);
                }
            });
        }
    }

    function getTransAmount(value) {
        var client_id = {{ $client->client_id }}
        if(value){
            $.ajax({
                type:'get',
                url:'/get-car-and-client-wise-trans-due-amount',
                data: {car_id: value, client_id: client_id},
                success:function(data){
                    if(data.status){
                        $("#trans_amount").val(parseInt(data.data))
                        $("#trans_amount").attr('max', parseInt(data.data))
                        $('#trans_submitBtn').attr('disabled', false)
                    }else{
                        $('#trans_submitBtn').attr('disabled', true)
                        $("#trans_amount").val(0)
                        $("#trans_amount").attr('max', 0)
                        alert(data.message)
                    }
                },
                error:function(data){ 
                    alert(data);
                }
            });
        }
    }

    function deleteTransHistory(id){
        const swalWithBootstrapButtons = Swal.mixin({
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
        })

        swalWithBootstrapButtons({
          // title: @lang('cmn.number'),
          title: sweet_alert_message_val,
          text: sweet_alert_message_sub_val,
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: sweet_alert_message_yes,
          cancelButtonText: sweet_alert_message_no,
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            event.preventDefault();
            document.getElementById('trans-delete-form-'+id).submit();
          } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
          ) {
            // swalWithBootstrapButtons()
          }
        })
    }


</script>
@endpush