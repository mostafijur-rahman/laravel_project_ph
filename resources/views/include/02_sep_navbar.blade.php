<!-- Navbar -->
@php $permissions = explode(',',Auth::user()->permissions) @endphp
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    {{-- @if(Auth::user()->level != 1) <div class="container"> @endif --}}
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="{{ asset('storage/setting/default_logo.svg') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link {{ ($menu=='dashboard')?'active text-primary font-weight-bold':'' }}" style="white-space: nowrap;"><i class="fas fa-tachometer-alt"></i> @lang('nav.dashboard')</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='report')?'active text-primary font-weight-bold':'' }}"><i class="fas fa-file-alt"></i> @lang('nav.reports')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        @if(in_array(1, $permissions))
                        <li><a href="{{ url('transport-report-form') }}" class="dropdown-item btn disabled"><i class="fas fa-genderless"></i> Transport</a></li>
                        @endif
                        @if(in_array(2, $permissions))
                        <li><a href="{{ url('trip-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Trip</a></li>
                        @endif
                        @if(in_array(3, $permissions))
                        <li><a href="{{ url('vehicle-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Vehicle</a></li>
                        @endif
                        @if(in_array(4, $permissions))
                        <li><a href="{{ url('pump-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Pump</a></li>
                        @endif
                        @if(in_array(5, $permissions))
                        <li><a href="{{ url('garage-report-form') }}" class="dropdown-item btn disabled"><i class="fas fa-genderless"></i> Garage</a></li>
                        @endif
                        @if(in_array(6, $permissions))
                        <li><a href="{{ url('clients-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Clients</a></li>
                        @endif
                        @if(in_array(7, $permissions))
                        <li><a href="{{ url('staff-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Staff</a></li>
                        @endif
                    </ul>
                </li>
                @if(in_array(1, $permissions))
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='transport')?'active text-primary font-weight-bold':'' }} btn disabled"><i class="fas fa-home"></i> @lang('nav.transport')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('booking') }}" class="dropdown-item"><i class="fas fa-genderless"></i> New Booking</a></li>
                        <li><a href="{{ url('/booking-list') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Booking List</a></li>
                        <li><a href="{{ url('/booking-running') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Running Trip</a></li>
                        <li><a href="{{ url('/booking-final') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Completed Trip</a></li>
                    </ul>
                </li>
                @endif
                @if(in_array(2, $permissions))
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='trip')?'active text-primary font-weight-bold':'' }}"><i class="fas fa-map-marker-alt"></i> @lang('nav.trip')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('trip') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.trip_create')</a></li>
                        <li><a href="{{ url('/trip-running') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.running_trip')</a></li>
                        <li><a href="{{ url('/trip-taking') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.ending_trip')</a></li>
                        <li><a href="{{ url('/trip-final') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.completed_trip')</a></li>
                    </ul>
                </li>
                @endif
                {{-- @if(in_array(3, $permissions))
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='vehicle')?'active text-primary font-weight-bold':'' }}"><i class="fas fa-truck"></i> @lang('nav.vehicle')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('vehicle') }}" class="dropdown-item btn disabled"><i class="fas fa-genderless"></i> Vehicle Ledger</a></li>
                        <li><a href="{{ url('vehicle') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Vehicle List</a></li>
                        <li><a href="{{ url('vehicle/create') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Add Vehicle</a></li>
                    </ul>
                </li>
                @endif --}}
                {{-- @if(in_array(4, $permissions))
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='pump')?'active text-primary font-weight-bold':'' }}"><i class="fas fa-gas-pump"></i> @lang('nav.pump')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('pump') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Pump List</a></li>
                        <li><a href="{{ url('pump/create') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Add Pump</a></li>
                    </ul>
                </li>
                @endif --}}
                {{-- @if(in_array(5, $permissions))
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='garage')?'active text-primary font-weight-bold':'' }} btn disabled"><i class="fas fa-tools"></i> @lang('nav.garage')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('garages') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Create Expense</a></li>
                        <li><a href="{{ url('garages') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Expenses List</a></li>
                    </ul>
                </li>
                @endif --}}
                {{-- @if(in_array(6, $permissions))
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='client')?'active text-primary font-weight-bold':'' }}"><i class="fas fa-handshake"></i> @lang('nav.clients')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('client') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Client List</a></li>
                        <li><a href="{{ url('client/create') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Add Client</a></li>
                    </ul>
                </li>
                @endif --}}
                {{-- @if(in_array(7, $permissions))
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='staff')?'active text-primary font-weight-bold':'' }}"><i class="fas fa-users"></i> @lang('nav.staff')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('people?type=2') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Driver List</a></li>
                        <li><a href="{{ url('people?type=3') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Helper List</a></li>
                        <li><a href="{{ url('people/create') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Add Staff</a></li>
                    </ul>
                </li>
                @endif --}}
                @if(in_array(8, $permissions))
                <li class="nav-item">
                    <a href="{{ url('activity-logs') }}" class="nav-link {{ ($menu=='activity')?'active text-primary font-weight-bold':'' }} btn disabled"><i class="fas fa-video"></i> @lang('nav.activity')</a>
                </li>
                @endif
                @if(in_array(9, $permissions))
                {{-- <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='setting')?'active text-primary font-weight-bold':'' }}"><i class="fas fa-wrench"></i>  @lang('nav.setting')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('settings/project-expense') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Project Expense</a></li>
                        <li><a href="{{ url('settings/general-expense') }}" class="dropdown-item"><i class="fas fa-genderless"></i> General Expense</a></li>
                        <li><a href="{{ url('settings/area') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Load/Unload Point</a></li>
                        <li><a href="{{ url('settings/company') }}" class="dropdown-item"><i class="fas fa-genderless"></i> Company Setup</a></li>
                    </ul>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ url('setting') }}" class="nav-link {{ ($menu=='setting')?'active text-primary font-weight-bold':'' }}" style="white-space: nowrap;"><i class="fas fa-wrench"></i> @lang('nav.setting')</a>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='profile')?'active text-primary font-weight-bold':'' }}"><i class="fas fa-user"></i> @lang('nav.hi'), {{ Auth::user()->first_name }}</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item"><i class="fas fa-user"></i> @lang('nav.profile')</a></li>
                        <li><a href="{{ url('locale/bn') }}" class="dropdown-item"><i class="fas fa-language"></i> বাংলা</a></li>
                        <li><a href="{{ url('locale/en') }}" class="dropdown-item"><i class="fas fa-language"></i> English</a></li>
                        <li><a href="#" onClick="window.location.reload();" class="dropdown-item"><i class="fas fa-sync text-primary"></i> @lang('nav.reload')</a></li>
                        <li><a href="{{ url('help') }}" class="dropdown-item"><i class="fas fa-heart" style="color: DeepPink"></i> @lang('nav.help')</a></li>
                        <li><a href="#" class="dropdown-item" href="{{ url('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout"
                            ><i class="fas fa-sign-out-alt"></i> @lang('nav.logout')</a>
                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Right navbar links -->
    {{-- @if(Auth::user()->level != 1) </div> @endif --}}
</nav>
<!-- /.navbar -->