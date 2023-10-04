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
                            <td class="text-center" width="10%">তারিখ</td>
                            <td class="text-center" width="20%">খরচের খাত</td>
                            <td  class="text-center" width="20%">খরচ</td>
                            <td  class="text-center" width="20%">মোট</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $right_sum = 0;
                        @endphp
                        @if(isset($car_total_project_exps))
                        @foreach($car_total_project_exps as $key => $car_total_project_exp)
                        <tr>
                            <td class="text-center">{{++$key}}</td>
                            <td class="text-center">{{$car_total_project_exp->car_total_project_exp_date}}</td>
                            <td class="text-center">{{$car_total_project_exp->project_exp_head}}</td>
                            <td class="text-center">{{$car_total_project_exp->car_total_project_exp_amount}}</td>
                            <td class="text-center">{{ $right_sum += $car_total_project_exp->car_total_project_exp_amount }}</td>
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