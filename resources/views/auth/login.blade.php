@extends('auth.layout')

@section('content')
<div class="">
    {{-- login-box --}}
    <div class="text-center" style="color: #fff">
        <h4>
            {{-- <a href="{{ url('/login') }}"><b>{{ $setComp['company_name'] ?? ''}}</b></a> --}}
            <b>@setting('client_system.company_name')</b>
        </h4>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <form method="POST" action="{{ route('login') }}">
            @csrf
                <div class="input-group mb-3">
                    <input id="email" 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="@lang('cmn.enter_email')"
                        required 
                        autocomplete="email" 
                        autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input id="password" 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        placeholder="@lang('cmn.enter_password')"
                        required 
                        autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                @lang('cmn.remember_me')
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-success btn-block">@lang('cmn.login')</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
    <div class="text-center" style="margin-top: 1rem; font-size: 14px; color: #fff;">
        <b>
            <p>
                @lang('cmn.powered_by') - <a style="color: #fff;" href="https://paribahanhishab.com" target="_blank"> @lang('cmn.rowshan_ara_technologies')</a> - (@lang('cmn.version') - @lang('cmn.1')@lang('cmn.3').@lang('cmn.0')) </br>
                @lang('cmn.image_credit') - <a style="color: #fff;" href="https://www.facebook.com/groups/1690276221251524" target="_blank">BD TRUCK LOVERS</a>
            </p>
        </b>
    </div>
</div>
<!-- /.login-box -->
@endsection