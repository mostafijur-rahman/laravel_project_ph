<datalist id="vehicle_number_else">
    @if(count($unique_vehicle_numbers)>0)
        @foreach( $unique_vehicle_numbers as $unique)
        <option value="{{ $unique->vehicle_number }}"></option>
        @endforeach
    @endif
</datalist>