@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <h4 class="element-header text-center">
            <b>
                @if($clients)
                "{{ $clients->client_name }}"
                @endif
                @lang('cmn.due') @lang('cmn.and') @lang('cmn.paid') @lang('cmn.report')
            {{(isset($date_show))? ' ( '.$date_show .' ) ' : ''}}</b>
        </h4>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header text-center">
                @lang('cmn.due') @lang('cmn.history')
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td width="5%" class="text-center">@lang('cmn.no')</td>
                            <td width="15%" class="text-center">@lang('cmn.date')</td>
                            <td width="15%" class="text-center">@lang('cmn.vehicle') @lang('cmn.no')</td>
                            <td width="15%" class="text-center">@lang('cmn.trip') @lang('cmn.no')</td>
                            <td width="15%" class="text-center">@lang('cmn.money')</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if($due_data)
                            @foreach($due_data as $key => $due)
                            <tr align="center">
                                <td>{{ ++$key }}</td>
                                <td>{{ $due->date }}</td>
                                <td>{{ $due->trip->car->car_number }}</td>
                                <td>{{ $due->trip->trip_no }}</td>
                                <td>{{ number_format($due->amount) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="font-weight: bold;" class="text-right text-bold">Total: </td>
                                <td style="font-weight: bold;" class="text-center">{{ number_format($due_data->sum("amount")) }}</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header text-center">
                @lang('cmn.paid') @lang('cmn.history')
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr align="center">
                            <td width="5%" class="text-center">@lang('cmn.no')</td>
                            <td width="15%" class="text-center">@lang('cmn.date')</td>
                            <td width="15%" class="text-center">@lang('cmn.vehicle') @lang('cmn.no')</td>
                            <td width="15%" class="text-center">@lang('cmn.money')</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($due_collection))
                           @foreach($due_collection as $key => $due_collecct)
                            <tr align="center">
                                <td>{{ ++$key }}</td>
                                <td>{{ $due_collecct->date }}</td>
                                <td>{{ $due_collecct->car->car_number }}</td>
                                <td>{{ number_format($due_collecct->amount) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="font-weight: bold;" class="text-right text-bold">Total: </td>
                                <td class="text-center" style="font-weight: bold;">{{ number_format($due_collection->sum("amount")) }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection