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
                            <td width="5%" class="text-center">SL</td>
                            <td width="10%" class="text-center">Date</td>
                            <td width="10%" class="text-center">Head</td>
                            <td width="20%" class="text-center">Income</td>
                            <td width="20%" class="text-center">Expense</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">20-july-2020</td>
                            <td class="text-center">Trip</td>
                            <td class="text-center">16000</td>
                            <td class="text-center">500</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">20-july-2020</td>
                            <td class="text-center">Oil</td>
                            <td class="text-center">0</td>
                            <td class="text-center">12300</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="text-center">19-july-2020</td>
                            <td class="text-center">Driver salary</td>
                            <td class="text-center">0</td>
                            <td class="text-center">5000</td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td class="text-center">18-july-2020</td>
                            <td class="text-center">Papers</td>
                            <td class="text-center">0</td>
                            <td class="text-center">10000</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><b>Total= </b></td>
                            <td class="text-center">5000</td>
                            <td class="text-center">10000</td>
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