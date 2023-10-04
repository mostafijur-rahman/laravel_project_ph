@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="element-header text-center"><b>{{$title}}</b></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center" width="5%">নং</td>
                            <td class="text-center" width="10%">ক্লায়েন্টের নাম</td>
                            <td class="text-center" width="20%">মোট বকেয়া</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $due_total = 0;
                        @endphp
                        @foreach($clients as $key=>$list)
                            @php $due_data = $list->dues; @endphp
                            @if(isset($start_date) && isset($end_date))
                                @php $due_data = $due_data->whereBetween('date', [$start_date, $end_date]); @endphp
                            @endif
                            @php
                                $client_total = (count($due_data))? $due_data->sum('amount') : 0;
                                $due_total += $client_total;
                            @endphp
                            <tr align="center">
                                <td>{{ ++$key }}</td>
                                <td>{{ $list->client_name }}</td>
                                <td>{{ number_format($client_total) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-right" style="font-weight: bold;">মোট</td>
                            <td class="text-center" style="font-weight: bold;">{{ number_format($due_total) }}</td>
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