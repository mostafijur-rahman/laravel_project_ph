@extends('layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid"></div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
            <!-- transport due collection -->
            <div class="card">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">
                        <strong>{{ $company->name }}</strong> @lang('cmn.collection') @lang('cmn.history') 
                        {{-- (@lang('cmn.previous_balance') - <strong>{{ number_format($company->receivable_amount) }}</strong> |
                        @lang('cmn.transport') @lang('cmn.trip') @lang('cmn.due') - <strong>{{ number_format($company->transport_due_fair_histories->sum('company_due_fair')) }}</strong>) --}}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ url('payments?type=company&encrypt='.$company->encrypt.'&history=receivable') }}" class="btn btn-xs btn-primary"  title="@lang('cmn.payment') @lang('cmn.history')">@lang('cmn.history')</a>
                        <a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#TransModal"> @lang('cmn.add_collection')</a>
                    </div>
                </div>
                <!-- Due Collection Modal -->
                <div class="modal fade" id="TransModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">@lang('cmn.collection') @lang('cmn.form')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ url('payment-collection') }}">
                                @csrf
                                <div class="modal-body">
                                    {{-- <div class="form-group">
                                        <label>@lang("cmn.select_vehicle")</label>
                                        <select class="form-control" name="vehicle_id" onchange="getTransAmount(this.value)">
                                            <option value="">@lang("cmn.please_select")</option>
                                            @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_number }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form-group">
                                        <label>@lang("cmn.date") <small class="text-danger">(@lang("cmn.required"))</small></label>
                                        <input type="date" name="date" class="form-control" required="" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("cmn.amount") <small class="text-danger">(@lang("cmn.required"))</small></label>
                                        <input type="number" name="amount" id="trans_amount" class="form-control" value="0" placeholder="Enter Amount" required="">
                                    </div>
                                </div>
                                <input type="hidden" name="company_id" value="{{ $company->id }}">
                                <input type="hidden" name="business_type" value="transport">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                    <button type="submit" id="trans_submitBtn" class="btn btn-success"><i class="fas fa-save"></i> @lang('cmn.add_collection')</button>
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
                                <th>#</th>
                                <th>@lang('cmn.date')</th>
                                <th>@lang('cmn.amount')</th>
                                <th>@lang('cmn.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            
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