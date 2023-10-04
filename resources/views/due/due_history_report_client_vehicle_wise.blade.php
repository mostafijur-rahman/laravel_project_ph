@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="element-header text-center">
                        @if(isset($car_number))
                        {{ $car_number." নম্বর গাড়ীর " }}
                        @endif
                        @if(isset($car_number) && isset($client_name))
                        এবং 
                        @endif
                        @if(isset($client_name))
                        {{$client_name}}
                        @endif
                        বাকীর @lang('cmn.history') রিপোর্ট {{ (isset($date_show))? "(".$date_show.")" : ""}}
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
                            <td class="text-center" width="10%">ট্রিপ নম্বর</td>
                            <td class="text-center" width="10%">@lang('cmn.route')</td>
                            <td class="text-center" width="20%">বকেয়া</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($due_data))
                        @foreach($due_data as $key => $list)
                        <tr>
                            <td class="text-center">{{++$key}}</td>
                            <td class="text-center">{{ $list->date }}</td>
                            <td class="text-center">{{ ($list->trip)? $list->trip->trip_no : "---" }}</td>
                            <td class="text-center">{{ ($list->trip)? $list->trip->load_data->name : "---" }} থেকে {{ ($list->trip)? $list->trip->unload->name : "---" }}</td>
                            <td class="text-center">{{ number_format($list->amount) }}</td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="4" class="text-right" style="font-weight: bold;">মোট বকেয়া = </td>
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