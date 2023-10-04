
@php
    // for total deposit here we consider two trip seperatly
    if($trip->down_trip){
        $total_received_rent =  ($trip->company->advance_fair + $trip->company->received_fair) + ($trip->down_trip->company->advance_fair + $trip->down_trip->company->received_fair);
    } else {
        $total_received_rent =  ($trip->company->advance_fair + $trip->company->received_fair);
    }
    
    // we only consider here only up trip because (first trip id) this
    $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
    $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
    $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
    $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);

    // demarage
    $demarage_received = 0;
    $demarage_received = $trip->company->demarage_received;
    if($trip->down_trip && $trip->down_trip->company->demarage_received){
        $demarage_received += $trip->down_trip->company->demarage_received;
    }

    // distance
    $distance_without_km = '';
    if($trip->meter->previous_reading){
        $distance_without_km = $trip->meter->current_reading - $trip->meter->previous_reading;
    }

    $mileage = '';
    if($tripOilLiterSumByGroupId > 0){
        $mileage = (($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId);
    }
               
@endphp

<tr class="text-center">
    <!-- up/ trip -->
    <td rowspan="2">
        {{ $trip->provider->vehicle->number_plate }} <br>

        <div class="dropdown show">
            <a  class="btn btn-xs btn-default dropdown-toggle" 
                href="#"
                role="button"
                id="dropdownMenuLink" 
                data-toggle="dropdown" 
                aria-haspopup="true" 
                aria-expanded="false"> @lang('cmn.action')</a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a href="{{ url('trips?page_name=print&type='. $trip->type .'&group_id='. $trip->group_id) }}" target="_blank" class="dropdown-item" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>

                <a href="{{ url('trips/own-vehicle-single?page_name=edit&type=own_vehicle_single' .'&trip_id='. $trip->id) }}" class="dropdown-item" aria-label="@lang('cmn.edit')">@lang('cmn.edit')</a>

                <a href="{{ url('trips?page_name=details&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="dropdown-item" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                <a href="{{ url('trips?page_name=transection&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="dropdown-item" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                <a href="{{ url('trips?page_name=demarage&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="dropdown-item" aria-label="@lang('cmn.demurrage')">@lang('cmn.demurrage')</a>
                <a href="{{ url('trips?page_name=general_expense&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="dropdown-item" aria-label="@lang('cmn.general_expense')">@lang('cmn.general_expense')</a>
                <a href="{{ url('trips?page_name=oil_expense&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="dropdown-item" aria-label="@lang('cmn.oil_expense')">@lang('cmn.oil_expense')</a>
                <a href="{{ url('trips?page_name=meter&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="dropdown-item" aria-label="@lang('cmn.meter_info')">@lang('cmn.meter_info')</a>
            </div>

        </div>
    </td>
    <td>{{ date('d M, Y', strtotime($trip->date)) }}</td>
    <td>{{ $trip->number }}</td>

    {{-- <td>{{ $trip->company->company->name }}</td> --}}
    <td>{{ number_format($trip->company->contract_fair) }}</td>
    <td>{{ number_format($trip->company->advance_fair) }}</td>
    <td>
        @if($trip->company->due_fair>0)
            <span class="text-danger">{{ number_format($trip->company->due_fair) }}</span>
        @else
        {{ number_format($trip->company->due_fair) }}
        @endif
    </td>

    <td rowspan="2">{{ number_format($total_received_rent) }}</td>
    <td rowspan="2">{{ number_format($demarage_received) }}</td>
    <td rowspan="2">{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</td>
    <td rowspan="2">{{ $net_income = number_format(($total_received_rent + $demarage_received) - ($total_general_expense_sum + $total_oil_bill_sum)) }}</td>

    <td rowspan="2">{{  number_format($tripOilLiterSumByGroupId) }}</td>
    <td rowspan="2">{{ ($distance_without_km)?number_format($distance_without_km):'---' }}</td>
    <td rowspan="2">{{ ($mileage)?number_format($mileage, 2):'---' }}</td>

</tr>

@if($trip->down_trip)
    <tr class="text-center">
        <!-- down/ trip -->
        
        <td>{{ date('d M, Y', strtotime($trip->down_trip->date)) }}</td>
        <td>{{ $trip->down_trip->number }}</td>

        {{-- <td>{{ $trip->down_trip->company->company->name }}</td> --}}
        <td>{{ number_format($trip->down_trip->company->contract_fair) }}</td>
        <td>{{ number_format($trip->down_trip->company->advance_fair) }}</td>
        <td>
            @if($trip->down_trip->company->due_fair>0)
                <span class="text-danger">{{ number_format($trip->down_trip->company->due_fair) }}</span>
            @else
            {{ number_format($trip->down_trip->company->due_fair) }}
            @endif
        </td>
    </tr>
@else
    <tr class="text-center">
        <td colspan="5">
            <small>
                <a href="{{ url('trips/own-vehicle-up-down?page_name=create&type=own_vehicle_up_down&group_id='. $trip->group_id . '&number=' . $trip->number) }}" class="text-primary" aria-label="@lang('cmn.add_challan')"><i class="fa fa-plus"></i> @lang('cmn.down_import_challan') @lang('cmn.add_challan')</a>
            </small>
        </td>
        {{-- <td colspan="7">
            <small>
                <a href="{{ url('trips?page_name=print&type='. $trip->type .'&group_id='. $trip->group_id) }}" target="_blank" class="text-primary mr-1" aria-label="@lang('cmn.print')">@lang('cmn.print')</a>
                <a href="{{ url('trips?page_name=details&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="text-primary mr-1" aria-label="@lang('cmn.details')">@lang('cmn.details')</a>
                <a href="{{ url('trips?page_name=transection&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="text-primary mr-1" aria-label="@lang('cmn.transection')">@lang('cmn.transection')</a>
                <a href="{{ url('trips?page_name=demarage&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="text-primary mr-1" aria-label="@lang('cmn.demurrage')">@lang('cmn.demurrage')</a>
                <a href="{{ url('trips?page_name=general_expense&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="text-primary mr-1" aria-label="@lang('cmn.general_expense')">@lang('cmn.general_expense')</a>
                <a href="{{ url('trips?page_name=oil_expense&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="text-primary mr-1" aria-label="@lang('cmn.oil_expense')">@lang('cmn.oil_expense')</a>
                <a href="{{ url('trips?page_name=meter&type='. $trip->type .'&group_id='. $trip->group_id) }}" class="text-primary" aria-label="@lang('cmn.meter_info')">@lang('cmn.meter_info')</a>
            </small>
        </td> --}}
    </tr>
@endif