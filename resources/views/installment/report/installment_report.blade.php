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
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="text-center">গাড়ী বিস্তারিত</td>
                                <td class="text-center">পেমেন্ট তথ্য</td>
                            </tr>
                        </thead>
                        <tbody>
                           <tr>
                                <td class="text-left">
                                    নং: <b>{{ $cars->car_no }}</b><br>
                                    নম্বর: <b>{{ $cars->car_number }}</b><br>
                                    চালক: <b>{{ $cars->driver->people_name }}</b>
                                </td>
                                <td class="text-left">
                                    প্রদানকারী : <b>{{ $cars->installment->providers_id }}</b><br>
                                    পেমেন্ট : <b>{{ number_format($cars->installment->installment_history->sum("pay_amount")) }} (জমা) + {{ number_format($cars->installment->total_price - $cars->installment->installment_history->sum("pay_amount")) }} (বাকি) = {{ number_format($cars->installment->total_price) }}</b><br>
                                    পরবর্তী কিস্তি: <b>{{ \Carbon\Carbon::parse($cars->installment->install_pay_start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($cars->installment->install_pay_end_date)->format('d M y') }}</b><br>
                                </td>
                           </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr align="center">
                            <td width="5%">Sl</td>
                            <td width="20%">তারিখ</td>
                            <td width="20%">পেমেন্টের ধরণ</td>
                            <td width="20%">কিস্তি নং</td>
                            <td width="20%">টাকার পরিমান</td>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach($installment_history as $key => $list)
                         <tr align="center">
                            <td>{{ $key+1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($list->pay_date)->format("M d y") }}</td>
                            <td>
                                @if($list->pay_type == 1)
                                কিস্তি
                                @elseif($list->pay_type == 2)
                                ডাউন পেমেন্ট
                                @elseif($list->pay_type == 2)
                                জরিমানা
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ ($list->install_no)?: "-" }}</td>
                            <td>{{ number_format($list->pay_amount) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><b style="font-weight: 600;">Total</b></td>
                            <td class="text-center">{{ number_format($installment_history->sum("pay_amount")) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>  
        </div>
    </div>
</div>
@endsection