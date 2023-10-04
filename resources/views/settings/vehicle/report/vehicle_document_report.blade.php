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
                            <td width="20%" class="text-center">Key</td>
                            <td width="50%" class="text-center">Value</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><strong>Vehicle No</strong></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Vehicle Number</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Driver</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Helper</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Reg. Number</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Reg. Date</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Reg. Reminder Date</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Engine Number</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Chassis Number</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Model</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">CC</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Horse Power</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="text-center">Description</td>
                            <td class="text-center"></td>
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