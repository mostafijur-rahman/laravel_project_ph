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
                            <td class="text-center" width="20%">তারিখ</td>
                            <td  class="text-center" width="20%">লিটার</td>
                            <td  class="text-center" width="20%">খরচ</td>
                            <td  class="text-center" width="20%">অবশিষ্ট</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $right_sum = 0;
                        @endphp
                        @if(isset($oil_exps))
                        @foreach($oil_exps as $key => $oil_exp)
                        <tr>
                            <td class="text-center">{{++$key}}</td>
                            <td class="text-center">{{$oil_exp->trip_date}}</td>
                            <td class="text-center">{{$oil_exp->oil_liter_sum}}</td>
                            <td class="text-center">{{$oil_exp->oil_bill_sum}}</td>
                            <td class="text-center">{{ $right_sum += $oil_exp->oil_bill_sum }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>  
        </div>
    </div>
</div>
@endsection