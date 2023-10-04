@if( count($up_trip->demarage) > 0)
<div class="col-md-6">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr>
                        <th>@lang('cmn.date')</th>
                        <th>@lang('cmn.up') @lang('cmn.demurrage') @lang('cmn.bill') </th>
                        <th>@lang('cmn.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @php $company_amount_sum = 0; @endphp
                    @foreach($up_trip->demarage as $key => $demurrage)
                    <tr>
                        <td>{{ date('d M, Y', strtotime($demurrage->date)) }}</td>
                        <td>
                            {{ number_format($demurrage->company_amount) }}
                            @if($demurrage->note)
                                <br>({{ $demurrage->note }})
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $demurrage->id }}, 'demarage')" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                            <form id="delete-form-demarage-{{$demurrage->id }}" method="POST" action="{{ url('trips/demurrage-delete', $demurrage->id ) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @php $company_amount_sum += $demurrage->company_amount; @endphp
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td><b>@lang('cmn.total') =</b></td>
                        <td><small><b>{{ number_format($company_amount_sum) }}</b></small></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if($down_trip && count($down_trip->demarage) > 0)
<div class="col-md-6">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr>
                        <th>@lang('cmn.date')</th>
                        <th>@lang('cmn.down') @lang('cmn.demurrage') @lang('cmn.bill') </th>
                        <th>@lang('cmn.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @php $company_amount_sum = 0; @endphp
                    @foreach($down_trip->demarage as $key => $demurrage)
                    <tr>
                        <td>{{ date('d M, Y', strtotime($demurrage->date)) }}</td>
                        <td>
                            {{ number_format($demurrage->company_amount) }}
                            @if($demurrage->note)
                                <br>({{ $demurrage->note }})
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $demurrage->id }}, 'demarage')" title="@lang('cmn.delete')">@lang('cmn.delete')</button>
                            <form id="delete-form-demarage-{{$demurrage->id }}" method="POST" action="{{ url('trips/demurrage-delete', $demurrage->id ) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @php $company_amount_sum += $demurrage->company_amount; @endphp
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td><b>@lang('cmn.total') =</b></td>
                        <td><small><b>{{ number_format($company_amount_sum) }}</b></small></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif