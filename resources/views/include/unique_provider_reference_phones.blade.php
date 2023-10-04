<datalist id="provider_reference_phone_else">
    @if(count($unique_provider_reference_phones)>0)
        @foreach( $unique_provider_reference_phones as $unique_provider_reference_phone)
        <option value="{{ $unique_provider_reference_phone->reference_phone }}"></option>
        @endforeach
    @endif
</datalist>