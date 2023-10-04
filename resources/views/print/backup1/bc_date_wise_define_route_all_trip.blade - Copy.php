@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <div class="element-box">
            <div class="row">
                <div class="col-sm-12">
                    <h6 class="element-header text-center">{{$title}}</h6>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center">তারিখ</td>
                            <td class="text-center">ট্রিপ নম্বর</td>
                            <td class="text-center">গাড়ি নম্বর</td>
                            <td  class="text-center" colspan="4">বুকিং</td>
                            <td class="text-center" >লেস মূল্য</td>
                            <td class="text-center" >মোট আয়</td>
                            <td class="text-center" >কমিশন</td>
                            <td class="text-center" >খরচ</td>
                            <td class="text-center" >নীট আয়</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3"></td>
                            <td>আসন সংখ্যা</td>
                            <td>বিক্রয়</td>
                            <td>সৌজন্য</td>
                            <td>সৌজন্য</td>
                            <td>মোট বুকিং</td>
                            <td colspan="5"></td>
                        </tr>
                        <!-- loop -->
                        <tr>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        {{-- loop end --}}
                        <tr>
                            <td>মোট =</td>
                            <td colspan="2">0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
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