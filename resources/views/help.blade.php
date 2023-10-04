@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('settings.submenu')
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- first row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">কিছু প্রশ্নের উত্তর নিচে দেয়া হল</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="accordion">
                                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                (1) "টিম ভিউয়ার" সফটওয়্যার কি, কেন, কিভাবে চালাতে হয়?
                                            </a>
                                        </h4>
                                        <div class="card-tools">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="text-secondary">দেখুন</span></a>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="card-body">
                                            এই সফটওয়্যার এর মাধ্যমে একজনের কম্পিউটার অন্যজন দূর থেকে স্ক্রিন শেয়ার এর মাধ্যমে চালাতে পারে। <br>
                                            ইউটিউবে চালানোর নিয়ম দেখে নিন <a href="https://www.youtube.com/watch?v=wzJ-pNlY7nE" target="_blank">দেখতে ক্লিক করুন</a> <br>
                                            <a href="https://www.teamviewer.com/en/" target="_blank">ডাউনলোড লিংক ক্লিক করুন</a>
                                            <br>
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/wzJ-pNlY7nE" frameborder="0" allowfullscreen=""></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                (2) "এনি ডেস্ক (Any Desk)" সফটওয়্যার কি, কেন, কিভাবে চালাতে হয়?
                                            </a>
                                        </h4>
                                        <div class="card-tools">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="text-secondary">দেখুন</span></a>
                                        </div>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="card-body">
                                            টিম ভিউয়ার এর মতন এই "এনি ডেস্ক" সফটওয়্যার এর মাধ্যমে একজনের কম্পিউটার অন্যজন দূর থেকে স্ক্রিন শেয়ার এর মাধ্যমে চালাতে পারে। <br>
                                            ইউটিউবে চালানোর নিয়ম দেখে নিন <a href="https://www.youtube.com/watch?v=v9i4EirMQtk" target="_blank">দেখতে ক্লিক করুন</a> <br> 
                                            <a href="https://anydesk.com/en" target="_blank">ডাউনলোড লিংক ক্লিক করুন</a> 
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                (3) কিভাবে ড্রাইভার/হেল্পার বা স্টাফদের তথ্য এন্ট্রি দিতে হয় ?
                                            </a>
                                        </h4>
                                        <div class="card-tools">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="text-secondary">দেখুন</span></a>
                                        </div>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse">
                                        <div class="card-body">
                                            ভিডিওসহ উত্তর সামনে আসবে
                                        </div>
                                    </div>
                                </div>
                                {{-- gari, pump, clients, project, general, load/unload, company, help --}}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.first row -->
        </div>
    </section>
    <!-- /.Main content -->
</div>
@endsection