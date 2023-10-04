<datalist id="provider_owner_phone_else">
    @if(count($unique_provider_owner_phones)>0)
        @foreach( $unique_provider_owner_phones as $unique_provider_owner_phone)
        <option value="{{ $unique_provider_owner_phone->owner_phone }}"></option>
        @endforeach
    @endif
</datalist>