@inject('carbon', 'Carbon\Carbon')
<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#"> <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge"><b>{{ $notice_qty }}</b></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 340px"> <span class="dropdown-item dropdown-header"><b>{{ $notice_qty }}</b> @lang('cmn.notification')</span>
            <div class="dropdown-divider"></div>
            @if(count($notices) > 0)
                @foreach($notices as $notice)
                    <a href="{{ url('notifications') }}" class="dropdown-item">
                        {{ Str::limit($notice->content, 25) }} <span class="float-right text-muted text-sm">{{ $carbon::parse($notice->created_at)->diffForHumans() }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach
            @endif
            <div class="dropdown-divider"></div> <a href="{{ url('notifications') }}" class="dropdown-item dropdown-footer">@lang('cmn.see_all_notifications')</a>
        </div>
    </li>
</ul>