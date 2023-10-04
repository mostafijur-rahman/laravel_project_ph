<datalist id="unique_recipients_phone_else">
    @if(count($unique_recipients_phones)>0)
        @foreach( $unique_recipients_phones as $unique_recipients_phone)
        <option value="{{ $unique_recipients_phone->recipients_phone }}"></option>
        @endforeach
    @endif
</datalist>