<datalist id="provider_reference_name_else">
    @if(count($unique_provider_reference_names)>0)
        @foreach( $unique_provider_reference_names as $unique_provider_reference_name)
        <option value="{{ $unique_provider_reference_name->reference_name }}"></option>
        @endforeach
    @endif
</datalist>