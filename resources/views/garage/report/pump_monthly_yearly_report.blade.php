@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp
@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-9">
                    <h5 class="element-header text-left"><strong>{{$title}}</strong></h5>
                </div>
                <div class="col-sm-3">
                    <h6 class="element-header text-right"><strong>{{(isset($date_show))?$date_show:''}}</strong></h6>
                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center" width="3%">SL</td>
                            <td class="text-center" width="10%">Date</td>
                            @if(!$request->pump)
                            <td class="text-center" width="17%">Pump</td>
                            @endif
                            <td class="text-center" width="12%">Trip no</td>
                            @if(!$request->car)
                            <td class="text-center" width="8%">vehicle</td>
                            @endif
                            @if(!$request->people)
                            <td class="text-center" width="12%">Driver</td>
                            @endif
                            <td  class="text-center" width="7%">Liter</td>
                            <td  class="text-center" width="10%">Rate</td>
                            <td  class="text-center" width="10%">Sub Total</td>
                            <td  class="text-center" width="10%">Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($oil_exps))
                        @php $total=0;  @endphp
                        @foreach($oil_exps as $key => $oil_exp)
                        <tr>
                            <td class="text-center">{{++$key}}</td>
                            <td class="text-center">{{$oil_exp->trip_date}}</td>
                            @if(!$request->pump)
                            <td class="text-center">{{$oil_exp->pump_name}}</td>
                            @endif
                            <td class="text-center">{{$oil_exp->trip_no}}</td>
                            @if(!$request->car)
                            <td class="text-center">{{$oil_exp->car_number}}</td>
                            @endif
                            @if(!$request->people)
                            <td class="text-center">{{$oil_exp->people_name}}</td>
                            @endif
                            <td class="text-center">{{$oil_exp->trip_oil_exp_liter}}</td>
                            <td class="text-center">{{$oil_exp->trip_oil_exp_rate+0}}</td>
                            <td class="text-center">{{ $this_value[$key] = $oil_exp->trip_oil_exp_bill+0 }}</td>
                            @php $total += $this_value[$key] @endphp
                            <td class="text-center">{{ $total }}</td>
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