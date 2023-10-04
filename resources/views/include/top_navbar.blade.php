<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
	<!-- Left navbar links -->
	<ul class="navbar-nav mr-auto"  style="width: 100%">
		<li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
		<li class="nav-item"><a class="nav-link" href="#">{{ $top_title ?? '' }}</a></li>
	</ul>

    {{-- @if(isset($menu) &&  $menu == 'dashboard')
        <div style="width: 100%">
            <marquee behavior="" direction="" scrollamount="7">
                <b class="text-success">@lang('cmn.hello') {{ Auth::user()->full_name }}, @setting('client_system.company_name') @lang('cmn.welcome_text')</b>
            </marquee>
        </div>
    @endif --}}

    @if(isset($top_notice))
        <div style="width: 100%">
            <marquee behavior="" direction="" scrollamount="7">
                <b class="{{ $top_notice_class }}">{{ $top_notice }}</b>
            </marquee>
        </div>
    @endif


    {{-- </div> --}}
	<!-- SEARCH FORM -->
	{{-- <form class="form-inline ml-3">
		<div class="input-group input-group-sm">
			<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
			<div class="input-group-append">
				<button class="btn btn-navbar" type="submit"> <i class="fas fa-search"></i>
				</button>
			</div>
		</div>
	</form> --}}
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <span class="d-none d-md-inline">{{ Auth::user()->full_name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-primary">
                    <p>{{ Auth::user()->full_name }}<br>
                        @lang('cmn.position') - {{ Auth::user()->role->name }}<br>
                        @if(Auth::user()->created_at)
                        @lang('cmn.joining_date') - {{ date('d M, Y', strtotime(Auth::user()->created_at)) }}
                        @endif
                    </p>
                </li>
                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat">@lang('cmn.profile')</a>
                    <a 
                        href="{{ url('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="@lang('nav.logout')"
                        class="btn btn-default btn-flat float-right">@lang('nav.logout')</a>
                </li>
            </ul>
        </li>
        @include('include.notification')
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="flag-icon flag-icon-{{ (Session::get('locale')=='en')?'us':'bd' }}"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <a href="{{ url('locale/en') }}" class="dropdown-item {{ (Session::get('locale')=='en')?'active':'' }}">
                    <i class="flag-icon flag-icon-us mr-2"></i> English
                </a>
                <a href="{{ url('locale/bn') }}" class="dropdown-item {{ (Session::get('locale')=='bn')?'active':'' }}">
                    <i class="flag-icon flag-icon-bd mr-2"></i> বাংলা
                </a>
            </div>
        </li>
	</ul>
</nav>
<!-- /.navbar -->