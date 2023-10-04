<datalist id="challan_number_else">
    @if(count($unique_challan_numbers)>0)
        @foreach( $unique_challan_numbers as $unique_challan)
        <option value="{{ $unique_challan->number }}"></option>
        @endforeach
    @endif
</datalist>