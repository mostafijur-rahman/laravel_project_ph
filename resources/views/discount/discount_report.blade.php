@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="element-header text-center"><b>{{$title}} {{ (isset($data_show))? "(". $data_show .")" : "" }}</b></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center" width="5%">নং</td>
                            <td class="text-center" width="10%">ক্লায়েন্টের নাম</td>
                            <td class="text-center" width="10%">ফোন</td>
                            <td class="text-center" width="20%">মোট ডিসকাউন্ট</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $final_sum = 0; @endphp
                        @if(isset($clients))
                        @foreach($clients as $key => $client)
                        @php 
                        $final_sum += ($client->discount) ? $client->discount->sum("trip_deduction_fair") : 0; 
                        @endphp
                        <tr>
                            <td class="text-center">{{++$key}}</td>
                            <td class="text-center">{{$client->client_name}}</td>
                            <td class="text-center">{{$client->client_phone}}</td>
                            <td class="text-center">{{ ($client->discount) ? number_format($client->discount->sum("trip_deduction_fair")) : 0 }}</td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="3" class="text-right">মোট = </td>
                            <td class="text-center">{{ number_format($final_sum) }}</td>
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