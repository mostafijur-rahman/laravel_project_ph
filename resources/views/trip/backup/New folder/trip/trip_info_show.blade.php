@push('css')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
@endpush
<!-- trip info box  (thinking for include) -->
<div class="col-md-12">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th width="30%">@lang('cmn.primary_info')</th>
                        <th width="30%">গাড়ীর লেনদেন</th>
                        <th width="20%">কোম্পানীর লেনদেন</th>
                        <th width="20%">কমিশন</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class="text-left">
                            <small>
                                @if($trip->account_take_date)
                                    @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                @endif
                                @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
                                @if ($trip->provider->vehicle_id)
                                    @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->vehicle_number }}</b> <span class="btn btn-xs btn-success">@lang('cmn.own')</span><br>
                                    @lang('cmn.driver'): <b>{{ $trip->provider->vehicle->driver->name }} ({{ $trip->provider->vehicle->driver->phone }})</b><br>
                                @else
                                    @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> <span class="btn btn-xs btn-warning">@lang('cmn.from_market')</span><br>
                                    @lang('cmn.driver'): <b>{{ $trip->provider->driver_name??'---' }} {{ $trip->provider->driver_phone?'('.$trip->provider->driver_phone.')':'' }}</b><br>
                                    @lang('cmn.owner'): <b>{{ $trip->provider->owner_name??'---' }} {{ $trip->provider->owner_phone?'('.$trip->provider->owner_phone.')':'' }}</b><br>
                                    @lang('cmn.reference'): <b>{{ $trip->provider->reference_name??'---' }} {{ $trip->provider->reference_phone?'('.$trip->provider->reference_phone.')':'' }}</b><br>
                                @endif
                                @if($trip->meter->previous_reading)
                                    @lang('cmn.start') @lang('cmn.km') <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
                                    @lang('cmn.end') @lang('cmn.km') <b>{{ number_format($trip->meter->current_reading) }}</b><br>
                                    @lang('cmn.used') @lang('cmn.km') <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
                                    @php $tripOilLiterSumByTripId = tripOilLiterSumByTripId($trip->id); @endphp 
                                    @lang('cmn.total') @lang('cmn.fuel'): <b>{{ number_format($tripOilLiterSumByTripId) }}</b><br>
                                    @if($tripOilLiterSumByTripId > 0)
                                        @lang('cmn.mileage') @lang('cmn.km') <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByTripId, 2) }}</b><br>
                                    @endif
                                @endif
                                @lang('cmn.posted_by'): <br>
                                <b>{{ $trip->user->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->created_at)) }})</b>
                                @if($trip->updated_at > $trip->created_at)
                                    <br>
                                    @if($trip->updated_by)
                                        @lang('cmn.post_updated_by'): <br>
                                        <b>{{ $trip->user_update->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->updated_at)) }})</b>
                                    @endif
                                @endif
                                <div class="row mt-2">
                                    <div class="btn-group">
                                        <a href="{{ url('trip-report?trip_id='. $trip->id) }}" target="_blank" class="btn btn-default btn-xs mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                                        <a href="{{ url('trips?page_name=edit&trip_id='. $trip->id) }}" class="btn btn-default btn-xs mr-1" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>
                                        <a href="{{ url('trips?page_name=copy&trip_id='. $trip->id) }}" class="btn btn-default btn-xs mr-1" aria-label="@lang('cmn.copy')">@lang('cmn.copy')</a>
                                        <a href="{{ url('trips?page_name=details&trip_id='. $trip->id) }}" class="btn btn-xs {{ ($request['page_name'] == 'details')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="btn-group">
                                        <a href="{{ url('trips?page_name=transection&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'transection')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                                        <a href="{{ url('trips?page_name=demarage&trip_id='. $trip->id) }}" class="btn btn-xs {{ ($request['page_name'] == 'demarage')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.demarage')">@lang('cmn.demarage')</a>
                                    </div>
                                </div>
                                @if($trip && $trip->provider->ownership == 'own')
                                <div class="row mt-2">
                                    <div class="btn-group">
                                        <a href="{{ url('trips?page_name=general_expense&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'general_expense')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.general_expense')">@lang('cmn.general_expense')</a>
                                        <a href="{{ url('trips?page_name=oil_expense&trip_id='. $trip->id) }}" class="btn btn-xs mr-1 {{ ($request['page_name'] == 'oil_expense')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.oil_expense')">@lang('cmn.oil_expense')</a>
                                        <a href="{{ url('trips?page_name=meter&trip_id='. $trip->id) }}" class="btn btn-xs {{ ($request['page_name'] == 'meter')?'btn-primary':'btn-default' }}" aria-label="@lang('cmn.meter_info')">@lang('cmn.meter_info')</a>
                                    </div>
                                </div>
                                @endif
                                @if($trip && $trip->note)
                                <div class="row mt-2">
                                    @lang('cmn.note'): <b>{{ $trip->note }}</b>
                                </div>
                                @endif
                            </small>
                        </td>
                        <td class="text-left">
                            <small>
                                @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->date)) }}</b><br>
                                @lang('cmn.load_point'):<br>
                                @if($trip->points)
                                @php $lastKey = count($trip->points); @endphp
                                @foreach($trip->points as $key => $point)
                                    @if($point->pivot->point == 'load')
                                    <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                    @endif
                                @endforeach
                                @endif
                                <br>
                                @lang('cmn.unload_point'):<br>
                                @if($trip->points)
                                @php $lastKey = count($trip->points); @endphp
                                @foreach($trip->points as $key => $point)
                                    @if($point->pivot->point == 'unload')
                                    <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                    @endif
                                @endforeach
                                @endif
                                <br>
                                @lang('cmn.contract_rent'): <b>{{ number_format($trip->provider->contract_fair) }}</b><br>
                                @lang('cmn.addv_pay'): <b>{{ number_format($trip->provider->advance_fair) }}</b><br>
                                
                                @if($trip->provider->due_fair>0)
                                </small>
                                <span class="text-danger"> 
                                    @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b><br>
                                </span>
                                <small>
                                @else
                                @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b><br>
                                @endif

                                @lang('cmn.demarage_fixed'): <b>{{ number_format($trip->provider->demarage) }}</b><br>
                                @lang('cmn.demarage_paid'): <b>{{ number_format($trip->provider->demarage_received) }}</b><br>
                                @if($trip->provider->demarage_due>0)
                                </small>
                                <span class="text-danger"> 
                                    @lang('cmn.demarage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b><br>
                                </span>
                                <small>
                                @else
                                @lang('cmn.demarage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b><br>
                                @endif
                                @lang('cmn.discount'): <b>{{ number_format($trip->provider->deduction_fair) }}</b><br>
                                @lang('cmn.goods'): <b>{{ $trip->goods??'---' }}</b><br>
                                
                                <button type="button" class="btn btn-xs btn-danger"  onclick="return deleteCertification({{ $trip->id  }})" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                                <form id="delete-form-{{$trip->id }}" method="POST" action="{{ url('trip-delete-all', $trip->id ) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </small>
                        </td>
                        <td class="text-left">
                            <small>
                                <b>{{ $trip->company->company->name }}</b><br>
                                @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b><br>
                                @lang('cmn.addv_recev'): <b>{{ number_format($trip->company->advance_fair) }}</b><br>
                                
                                @if($trip->company->due_fair>0)
                                </small>
                                <span class="text-danger"> 
                                    @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b><br>
                                </span>
                                <small>
                                @else
                                @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b><br>
                                @endif
                                @if($trip->company->demarage > $trip->company->demarage_received)
                                </small>
                                <span class="text-danger"> 
                                    @lang('cmn.demarage_charge'): <b>{{ number_format($trip->company->demarage) }}</b><br>
                                </span>
                                <small>
                                @else
                                @lang('cmn.demarage_charge'): <b>{{ number_format($trip->company->demarage) }}</b><br>
                                @endif
                                @lang('cmn.demarage_received'): <b>{{ number_format($trip->company->demarage_received) }}</b><br>
                                @lang('cmn.demarage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b><br>
                                @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b><br>
                                কার্টুন সংখ্যা: <b>{{ number_format($trip->box) }}</b> টি<br>
                                ওজন: <b>{{ number_format($trip->weight) }}</b> {{ $trip->unit->name }}<br>
                            </small>
                        </td>
                        <td class="text-right">
                            <small>
                                @lang('cmn.contract_commission') = <b>{{ number_format($trip->company->contract_fair - $trip->provider->contract_fair) }}</b><br>
                                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                    কোম্পানী থেকে গ্রহণ = <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b><br>
                                    ভাড়া বাবদ প্রদান = <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b><br>
                                </div>
                                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                    @lang('cmn.commission_received') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair) - ($trip->provider->advance_fair+$trip->provider->received_fair)) }}</b><br>
                                    @lang('cmn.demarage_commission') = <b>{{ number_format($trip->company->demarage_received - $trip->provider->demarage_received) }}</b><br>
                                </div>
                                @lang('cmn.total_commission') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair+$trip->company->demarage_received) - ($trip->provider->advance_fair+$trip->provider->received_fair+$trip->provider->demarage_received)) }}</b><br>
                                {{-- (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>) --}}
                            </small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- transection info box  (thinking for include) -->
<div class="col-md-8">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th width="25%">@lang('cmn.account_info')</th>
                        <th width="35%">@lang('cmn.reason')</th>
                        <th width="20%">@lang('cmn.in')</th>
                        <th width="20%">@lang('cmn.out')</th>
                    </tr>
                </thead>
                <tbody>
                @php $in_sum = 0; $out_sum = 0; @endphp
                @if($trip->expenses)
                @foreach($trip->expenses as $expense)
                    @php 
                        $in_sum += ($expense->transaction->type=='in')?$expense->transaction->amount:0; 
                        $out_sum += ($expense->transaction->type=='out')?$expense->transaction->amount:0;
                    @endphp
                    <tr>
                        <td><small>{{ $expense->transaction->account->user_name }} ({{ $expense->transaction->account->account_number??__('cmn.cash') }}) ({{ $expense->transaction->date }})</small></td>
                        <td><small>{{ $expense->expense->head }}</small></td>
                        <td><small><b class='text-green'>{{ ($expense->transaction->type=='in')?number_format($expense->transaction->amount):'---' }}</b></small></td>
                        <td><small><b class='text-danger'>{{ ($expense->transaction->type=='out')?number_format($expense->transaction->amount):'---' }}</b></small></td>
                    </tr>
                @endforeach
                @endif
                @if($trip->oilExpenses)
                @foreach($trip->oilExpenses as $oilExpense)
                    @php 
                        $in_sum += ($oilExpense->transaction->type=='in')?$oilExpense->transaction->amount:0; 
                        $out_sum += ($oilExpense->transaction->type=='out')?$oilExpense->transaction->amount:0;
                    @endphp
                    <tr>
                        <td><small>{{ $oilExpense->transaction->account->user_name}} ({{ $oilExpense->transaction->account->account_number??__('cmn.cash') }}) ({{ $oilExpense->transaction->date }})</small></td>
                        <td><small>{{ __('cmn.'.$oilExpense->transaction->for) }}</small></td>
                        <td><small><b class='text-green'>{{ ($oilExpense->transaction->type=='in')?number_format($oilExpense->transaction->amount):'---' }}</b></small></td>
                        <td><small><b class='text-danger'>{{ ($oilExpense->transaction->type=='out')?number_format($oilExpense->transaction->amount):'---' }}</b></small></td>
                    </tr>
                @endforeach
                @endif
                @if($trip->transactions)
                @foreach($trip->transactions as $trans)
                    @php 
                        $in_sum += ($trans->type=='in')?$trans->amount:0; 
                        $out_sum += ($trans->type=='out')?$trans->amount:0;
                    @endphp
                    <tr>
                        <td><small>{{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})</small></td>
                        <td><small>{{ __('cmn.'.$trans->for) }}</small></td>
                        <td><small><b class='text-green'>{{ ($trans->type=='in')?number_format($trans->amount):'---' }}</b></small></td>
                        <td><small><b class='text-danger'>{{ ($trans->type=='out')?number_format($trans->amount):'---' }}</b></small></td>
                    </tr>
                @endforeach
                @endif
                <tr>
                    <td class="text-right" colspan="2"><small><b>@lang('cmn.total') = </b></small></td>
                    <td><small><b class='text-green'>{{ number_format($in_sum) }}</b></small></td>
                    <td><small><b class='text-danger'>{{ number_format($out_sum) }}</b></small></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- own trip deposit expense (thinking for include) -->
@if($trip && $trip->provider->ownership == 'own')
<div class="col-md-4">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th>ট্রিপের জমা</th>
                        <th>ট্রিপের খরচ</th>
                    </tr>
                </thead>
                <tbody>
                    @if($trip)
                        @php
                            $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
                            $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
                            $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
                            $total_received_rent =  $trip->provider->advance_fair + $trip->provider->received_fair;
                            $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);
                        @endphp
                        <tr class="text-center">
                            <td class="text-right">
                                <small>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @lang('cmn.contract_rent') = <b>{{ number_format($trip->provider->contract_fair) }}</b><br>
                                        @lang('cmn.rent_received') = <b>{{ number_format($total_received_rent) }}</b><br>
                                        @lang('cmn.total_expense') = <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
                                    </div>
                                    @lang('cmn.net_income') = <b>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</b><br>
                                    (@lang('cmn.challan_due') = <b>{{ number_format($trip->provider->due_fair) }}</b>,<br>@lang('cmn.discount') = <b>{{ number_format($trip->provider->deduction_fair) }}</b>)
                                </small>
                            </td>
                            <td class="text-right">
                                <small>
                                    <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @if($trip_general_exp_lists)
                                            @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                                            <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}<br>
                                            @endforeach
                                    </div>
                                    <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                                        @endif
                                </small>
                            </td>
                        </tr>
                    @else
                        <tr class="text-center">
                            <td class="text-right">
                                <small>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        @lang('cmn.contract_rent') = <b>---</b><br>
                                        @lang('cmn.total_expense') = <b>---</b><br>
                                    </div>
                                    @lang('cmn.net_income') = <b>---</b><br>
                                    (@lang('cmn.challan_due') = <b>---</b>,
                                    @lang('cmn.discount') = <b>---</b>)
                                </small>
                            </td>
                            <td class="text-right">
                                <small>
                                    <b>@lang('cmn.fuel') =</b> --- <br>
                                    <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                        <b>@lang('cmn.expense') = </b> ---<br>
                                    </div>
                                    <b>@lang('cmn.total_expense') = ---</b>
                                </small>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@push('js')
<!-- toastr -->
<script src="{{ asset('assets/dist/cdn/toastr.min.js') }}"></script>
<script type="text/javascript">
// delete notice
function deleteCertification(id, type){
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
            if(type){
                document.getElementById('delete-form-' + type +'-'+id).submit();
            } else {
                document.getElementById('delete-form-'+id).submit();
            }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // swalWithBootstrapButtons()
        }
    })
}
</script>
@endpush