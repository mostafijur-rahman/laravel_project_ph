@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="element-header text-center">
                        
                        @if(isset($client))
                        {{$client->clinet_name}}
                        @endif
                        @lang('cmn.paid') {{ (isset($date_show))? "(".$date_show.")" : ""}}
                    </h4>

                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center" width="5%">নং</td>
                            <td class="text-center" width="10%">তারিখ</td>
                            <td class="text-center" width="10%">@lang('cmn.client') @lang('cmn.name')</td>
                            <td class="text-center" width="20%">@lang('cmn.amount')</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($due_data))
                        @foreach($due_data as $key => $list)
                        <tr>
                            <td class="text-center">{{++$key}}</td>
                            <td class="text-center">{{ $list->date }}</td>
                            <td class="text-center">{{ $list->client->client_name }}</td>
                            <td class="text-center">{{ number_format($list->amount) }}</td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="3" class="text-right" style="font-weight: bold;">মোট @lang('cmn.amount') = </td>
                            <td class="text-center" style="font-weight: bold;">{{ number_format($due_data->sum("amount")) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>  
        </div>
    </div>
</div>
@endsection