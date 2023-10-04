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
                            <td class="text-center" rowspan="2">তারিখ</td>
                            <td class="text-center" rowspan="2">ট্রিপ সংখ্যা</td>
                            <td  class="text-center" colspan="2">মোট বুকিং</td>
                            <td class="text-center" rowspan="2">লেস মূল্য</td>
                            <td class="text-center" rowspan="2">মোট আয়</td>
                            <td class="text-center" rowspan="2">কমিশন</td>
                            <td class="text-center" rowspan="2">খরচ</td>
                            <td class="text-center" rowspan="2">নীট আয়</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"></td>
                            <td>বিক্রয়</td>
                            <td>সৌজন্য</td>
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
                        </tr>
                        {{-- loop end --}}
                        <tr>
                            <td>মোট =</td>
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