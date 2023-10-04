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
                    <a href="{{ url('dashboard') }}" class="nav-link {{ ($menu=='dashboard')?'active text-success font-weight-bold':'' }}" style="white-space: nowrap;"><i class="fas fa-tachometer-alt"></i> @lang('nav.dashboard')</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='report')?'active text-success font-weight-bold':'' }}"><i class="fas fa-file-alt"></i> @lang('nav.reports')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('daily-accounts-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.daily_accounts')</a></li>
                        <li><a href="{{ url('transport-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.transport')</a></li>
                        <li><a href="{{ url('deposit-expense-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.deposit_expense')</a></li>
                        <li><a href="{{ url('trip-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.trip')</a></li>
                        <li><a href="{{ url('due-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.due')</a></li>
                        <li><a href="{{ url('expense-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.expense')</a></li>
                        <li><a href="{{ url('discount-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.discount')</a></li>
                        <li><a href="{{ url('installment-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.installment')</a></li>
                        <li><a href="{{ url('capital-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.capitals')</a></li>
                        <li><a href="{{ url('vehicle-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.vehicle')</a></li>
                        <li><a href="{{ url('pump-report-form') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.pump')</a></li>
                        {{-- <li><a href="{{ url('garage-report-form') }}" class="dropdown-item disabled"><i class="fas fa-genderless"></i> @lang('nav.garage')</a></li>
                        <li><a href="{{ url('clients-report-form') }}" class="dropdown-item disabled"><i class="fas fa-genderless"></i> @lang('nav.clients')</a></li>
                        <li><a href="{{ url('staff-report-form') }}" class="dropdown-item disabled"><i class="fas fa-genderless"></i> @lang('nav.staff')</a></li> --}}
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='transport')?'active text-success font-weight-bold':'' }}"><i class="fas fa-truck"></i> @lang('nav.transport')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('booking') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.trip') @lang('cmn.booking')</a></li>
                        <li><a href="{{ url('/booking-list') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.booking') @lang('cmn.list')</a></li>
                        <li><a href="{{ url('/booking-final') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.completed_trip')</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='trip')?'active text-success font-weight-bold':'' }}"><i class="fas fa-map-marker-alt"></i> @lang('nav.trip')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('/trips/create') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.trip_create')</a></li>
                        <li><a href="{{ url('/trips?stage=1') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.running_trip')</a></li>
                        <li><a href="{{ url('/trips?stage=2') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.ending_trip')</a></li>
                        <li><a href="{{ url('/trips?stage=3') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('nav.completed_trip')</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='expenses')?'active text-success font-weight-bold':'' }}"><i class="fas fa-money-bill-alt"></i> @lang('cmn.expense')</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{ url('expenses/general-expenses') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.general') @lang('cmn.expense')</a></li>
                        <li><a href="{{ url('expenses/project-expenses') }}" class="dropdown-item"><i class="fas fa-genderless"></i> @lang('cmn.project') @lang('cmn.expense')</a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a href="{{ url('dues') }}" class="nav-link {{ ($menu=='due')?'active text-success font-weight-bold':'' }}"><i class="fas fa-handshake"></i> @lang('cmn.due')</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ url('loans') }}" class="nav-link {{ ($menu=='loan')?'active text-success font-weight-bold':'' }}"><i class="fas fa-suitcase"></i> @lang('cmn.loan')</a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ url('installment') }}" class="nav-link {{ ($menu=='installment')?'active text-success font-weight-bold':'' }}"><i class="fas fa-truck"></i> @lang('cmn.installment')</a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('capitals') }}" class="nav-link {{ ($menu=='capitals')?'active text-success font-weight-bold':'' }}"><i class="fas fa-money-bill-alt"></i> @lang('cmn.capitals')</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ ($menu=='profile')?'active text-success font-weight-bold':'' }}"><i class="fas fa-user"></i> @lang('nav.hi'), {{ Auth::user()->first_name }}</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <a href="{{ url('setting') }}" class="nav-link {{ ($menu=='setting')?'active text-success font-weight-bold':'' }}" style="white-space: nowrap;"><i class="fas fa-wrench"></i> @lang('nav.setting')</a>
                        <a href="{{ url('activity-logs') }}" class="nav-link {{ ($menu=='activity')?'active text-success font-weight-bold':'' }}"><i class="fas fa-exchange-alt"></i> @lang('cmn.transactions')</a>
                        <li><a href="{{ url('profile') }}" class="dropdown-item"><i class="fas fa-user"></i> @lang('nav.profile')</a></li>
                        <li><a href="{{ url('locale/bn') }}" class="dropdown-item"><i class="fas fa-language"></i> বাংলা</a></li>
                        <li><a href="{{ url('locale/en') }}" class="dropdown-item"><i class="fas fa-language"></i> English</a></li>
                        <li><a href="{{ url('package') }}" class="dropdown-item"><i class="fas fa-file-alt"></i> @lang('cmn.package')</a></li>
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
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                @if($notices)
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">{{ $notice_qty }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">{{ $notice_qty }} Notifications</span>
                    <div class="dropdown-divider"></div>
                    @foreach ($notices as $notc)
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> {{ $notc->notice_subject }}
                        <span class="float-right text-muted text-sm">---</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    @endforeach
                </div>
                @endif
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-success" onClick="window.location.reload();" title="@lang('nav.reload')"><i class="fas fa-sync"></i></a>
            </li>
        </ul>
    {{-- @if(Auth::user()->level != 1) </div> @endif --}}
</nav>
<!-- /.navbar -->