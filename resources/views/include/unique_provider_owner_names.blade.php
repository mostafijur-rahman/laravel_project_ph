<datalist id="provider_owner_name_else">
    @if(count($unique_provider_owner_names)>0)
        @foreach( $unique_provider_owner_names as $unique_provider_owner_name)
        <option value="{{ $unique_provider_owner_name->owner_name }}"></option>
        @endforeach
    @endif
</datalist>