<datalist id="voucher_id_else">
    @if(count($unique_voucher_ids)>0)
        @foreach( $unique_voucher_ids as $unique)
        <option value="{{ $unique->voucher_id }}"></option>
        @endforeach
    @endif
</datalist>