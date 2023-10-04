<datalist id="unique_recipients_name_else">
    @if(count($unique_recipients_names)>0)
        @foreach( $unique_recipients_names as $unique_recipients_name)
        <option value="{{ $unique_recipients_name->recipients_name }}"></option>
        @endforeach
    @endif
</datalist>