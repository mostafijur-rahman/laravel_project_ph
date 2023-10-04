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
                        <td class="text-center">নং</td>
                        <td class="text-center">তারিখ</td>
                        <td class="text-center">সময়</td>
                        <td class="text-center">খরচের খাত</td>
                        <td class="text-center">নাম</td>
                        <td class="text-center">টাকার পরিমান</td>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">1 july 2019</td>
                            <td class="text-right">02:30 PM</td>
                            <td class="text-right">ভাড়া</td>
                            <td class="text-right">মোঃ মাসুদ রানা</td>
                            <td class="text-right">500</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">1 july 2019</td>
                            <td class="text-right">02:30 PM</td>
                            <td class="text-right">খাবার</td>
                            <td class="text-right">মোঃ রোমান মিয়া</td>
                            <td class="text-right">1200</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="text-center">3 july 2019</td>
                            <td class="text-right">04:30 PM</td>
                            <td class="text-right">যাতায়াত</td>
                            <td class="text-right">মোঃ সোহরাব হোসেন</td>
                            <td class="text-right">1800</td>
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