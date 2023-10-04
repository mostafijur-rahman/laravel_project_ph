<div class="col-md-12">
    <form action="{{ url($action_url) }}" method="post" id="trip_form">
        @csrf
        @if(isset($trip) && isset($trip->id))
            <input type="hidden" name="trip_id" value="{{$trip->id}}">
        @endif
        @if(isset($request) && isset($request->page_name) && $request->page_name == 'edit')
            @method('put')
        @endif
        <!-- trip form -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-primary">
                    <b>@lang('cmn.challan_info')</b>
                </h3>
                @if($request->page_name == 'create')
                    <div class="card-tools">
                        <a href="{{ url('trips/own-vehicle-single?page_name=create&type=own_vehicle_single') }}" class="btn btn-sm {{ ($request->type == 'own_vehicle_single')?'btn-primary':'btn-default' }}">@lang('cmn.own_vehicle_single_challan')</a>
                        <a href="{{ url('trips/own-vehicle-up-down?page_name=create&type=own_vehicle_up_down') }}" class="btn btn-sm {{ ($request->type == 'own_vehicle_up_down')?'btn-primary':'btn-default' }}">@lang('cmn.own_vehicle_up_down_challan')</a>
                        <a href="{{ url('trips/out-commission-transection?page_name=create&type=out_commission_transection') }}" class="btn btn-sm {{ ($request->type == 'out_commission_transection')?'btn-primary':'btn-default' }}">@lang('cmn.rental_vehicle_transection_with_commission_challan')</a>
                        <a href="#" class="btn btn-sm {{ ($request->type == 'out_commission')?'btn-primary':'btn-default' }}">@lang('cmn.rental_vehicle_only_commission_challan')</a>
                        {{-- {{ url('trips/out-commission?page_name=create&type=out_commission') }} --}}
                    </div>
                @endif
            </div>
            @switch($request->type)

                @case('out_commission_transection')
                    @include('trip.trip_form.top_common_part')  
                    @break

                @case('out_commission')
                    @include('trip.trip_form.top_common_part')  
                    @break

                @case('own_vehicle_single')
                    @include('trip.trip_form.top_common_part')
                    @break

                @case('own_vehicle_up_down')
                    @include('trip.trip_form.top_common_part')
                    @break

            @endswitch
        </div>

        @if($request->type == 'out_commission_transection')

            <input type="hidden" name="ownership" value="out_commission_transection">
            @include('trip.trip_form.out_commission_transection.provider')
            @include('trip.trip_form.out_commission_transection.company')

        @elseif($request->type == 'out_commission')
            <input type="hidden" name="ownership" value="out_commission">
            @include('trip.trip_form.out_commission.provider')
            @include('trip.trip_form.out_commission.company')

        @elseif($request->type == 'own_vehicle_single')

            <input type="hidden" name="ownership" value="own_vehicle_single">
            @include('trip.trip_form.own_vehicle_single.provider')
            @include('trip.trip_form.own_vehicle_single.company')
            
        @elseif($request->type == 'own_vehicle_up_down')

            <input type="hidden" name="ownership" value="own_vehicle_up_down">
            @include('trip.trip_form.own_vehicle_single.provider')
            @include('trip.trip_form.own_vehicle_single.company')

        @endif

    </form>
</div>
@include('include.unique_challan_numbers')