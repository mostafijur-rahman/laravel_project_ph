@extends('layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"></section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- first row -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-edit"></i>
                      {{ 'User '. $title }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-sm-3 col-xs-4">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Personal Info</a>
                                <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Change Password</a>
                            </div>
                        </div>
                        <div class="col-7 col-sm-9 col-xs-8">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane text-left fade active show" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            Update
                                        </div>
                                        <form method="POST" action="{{ url('profile/personal-info') }}">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label>First Name</label>
                                                        <input type="text" name="first_name" value="{{ Auth::user()->first_name }}" class="form-control" placeholder="Enter First Name" required="">
                                                    </div>
                                                    <div class="col">
                                                        <label>Last Name</label>
                                                        <input type="text" name="last_name" value="{{ Auth::user()->last_name }}" class="form-control" placeholder="Enter Last Name" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>E-mail</label>
                                                    <input type="email" name="email" placeholder="Enter Your Email" value="{{ Auth::user()->email }}" class="form-control" required="">
                                                </div>
                                            </div>
                                            <div class="card-footer pull-right">
                                                <button class="btn btn-success btn-sm float-right"><i class="fa fa-upload"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            Change Password
                                        </div>
                                        <form method="POST" action="{{ url('profile/change-password') }}">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Old Password</label>
                                                    <input type="password" name="old_password" value="{{ old('old_password') }}" placeholder="Enter Old Password" class="form-control" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="password" name="new_password" value="{{ old('new_password') }}" placeholder="Enter New Password" class="form-control" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Confirm Password" class="form-control" required="">
                                                </div>
                                            </div>
                                            <div class="card-footer pull-right">
                                                <button class="btn btn-success btn-sm float-right"><i class="fa fa-upload"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.card -->
            </div><!-- /.first row -->
        </div>
    </section>
    <!-- /.Main content -->
</div>
@endsection