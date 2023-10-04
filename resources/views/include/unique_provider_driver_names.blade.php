<datalist id="provider_driver_name_else">
    @if(count($unique_provider_driver_names)>0)
        @foreach( $unique_provider_driver_names as $unique_provider_driver_name)
        <option value="{{ $unique_provider_driver_name->driver_name }}"></option>
        @endforeach
    @endif
</datalist>