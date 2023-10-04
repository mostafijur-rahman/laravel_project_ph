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
                        <td class="text-center">ছাড়ার স্থান</td>
                        <td class="text-center">পৌছাবার স্থান</td>
                        <td class="text-center">গাড়ীর নম্বর</td>
                        <td class="text-center">ড্রাইভার</td>
                        <td class="text-center">ক্লায়েন্ট</td>
                        <td class="text-center">মোট ভাড়া</td>
                        <td class="text-center">অগ্রিম ভাড়া</td>
                        <td class="text-center">বাকী ভাড়া</td>
                        <td class="text-center">কমিশন</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">1 july 2019</td>
                            <td class="text-right">02:30 PM</td>
                            <td class="text-right">মিরপুর-১০, ঢাকা</td>
                            <td class="text-right">চট্টগ্রাম বন্দর</td>
                            <td class="text-right">৮৩২৫</td>
                            <td class="text-right">মোঃ মাসুদ রানা</td>
                            <td class="text-right">খান এন্টারপ্রাইজ</td>
                            <td class="text-right">25,0000</td>
                            <td class="text-right">10,000</td>
                            <td class="text-right">15,000</td>
                            <td class="text-right">2,000</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-center">2 july 2019</td>
                            <td class="text-right">03:30 PM</td>
                            <td class="text-right">মিরপুর-১০, ঢাকা</td>
                            <td class="text-right">চট্টগ্রাম বন্দর</td>
                            <td class="text-right">৮৩২৫</td>
                            <td class="text-right">মোঃ মাসুদ রানা</td>
                            <td class="text-right">খান এন্টারপ্রাইজ</td>
                            <td class="text-right">25,0000</td>
                            <td class="text-right">10,000</td>
                            <td class="text-right">15,000</td>
                            <td class="text-right">2,000</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="text-center">3 july 2019</td>
                            <td class="text-right">04:30 PM</td>
                            <td class="text-right">মিরপুর-১০, ঢাকা</td>
                            <td class="text-right">চট্টগ্রাম বন্দর</td>
                            <td class="text-right">৮৩২৫</td>
                            <td class="text-right">মোঃ মাসুদ রানা</td>
                            <td class="text-right">খান এন্টারপ্রাইজ</td>
                            <td class="text-right">25,0000</td>
                            <td class="text-right">10,000</td>
                            <td class="text-right">15,000</td>
                            <td class="text-right">2,000</td>
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