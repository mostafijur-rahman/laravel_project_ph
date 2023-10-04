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
                        ডিসকাউন্ট রিপোর্ট 
                        @if(isset($date_show))
                        ({{ $date_show }})
                        @endif
                        
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
                            <td class="text-center" width="20%">ডিসকাউন্ট</td>
                        </tr>
                    </thead>
                    <tbody>                        
                        @if(isset($discount_data))
                        @foreach($discount_data as $key => $discount)
                        <tr>
                            <td class="text-center">{{++$key}}</td>
                            <td class="text-center">{{ $discount->trip_date }}</td>
                            <td class="text-center">{{ $discount->trip_no }}</td>
                            <td class="text-center">{{ number_format($discount->trip_deduction_fair) }}</td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="3" class="text-right">মোট ডিসকাউন্ট = </td>
                            <td class="text-center">{{ number_format($discount_data->sum("trip_deduction_fair")) }}</td>
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