<datalist id="provider_driver_phone_else">
    @if(count($unique_provider_driver_phones)>0)
        @foreach( $unique_provider_driver_phones as $unique_provider_driver_phone)
        <option value="{{ $unique_provider_driver_phone->driver_phone }}"></option>
        @endforeach
    @endif
</datalist>