@if($trip)
    @if(count($trip->demarage)>0)
    <div class="col-md-8">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered text-center text-nowrap">
                    <thead>
                        <tr>
                            <th>@lang('cmn.bill_date')</th>
                            <th>@lang('cmn.demurrage_bill_of_company')</th>
                            <th>@lang('cmn.demurrage_bill_of_provider')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $company_amount_sum = 0; 
                            $provider_amount_sum = 0;
                        @endphp
                        @foreach($trip->demarage as $key => $demurrage)
                            <tr>
                                <td>
                                    {{ date('d M, Y', strtotime($demurrage->date)) }}
                                    @if($demurrage->note)
                                        <br>
                                        <small>({{ $demurrage->note }})</small>
                                    @endif
                                </td>
                                <td>{{ number_format($demurrage->company_amount) }}</td>
                                <td>{{ number_format($demurrage->provider_amount) }}</td>
                                <td>
                                    <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $demurrage->id }}, 'demarage')" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                    <form id="delete-form-demarage-{{$demurrage->id }}" method="POST" action="{{ url('trips/demurrage-delete', $demurrage->id ) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @php 
                                $company_amount_sum += $demurrage->company_amount; 
                                $provider_amount_sum += $demurrage->provider_amount; 
                            @endphp
                        @endforeach
                        <tr style="font-weight: bold;">
                            <td><b>@lang('cmn.total') =</b></td>
                            <td><small><b>{{ number_format($company_amount_sum) }}</b></small></td>
                            <td><small><b>{{ number_format($provider_amount_sum) }}</b></small></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
@endif