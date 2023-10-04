<div class="row mb-2">
    <div class="col-sm-12">
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='accounts_report')?'success':'default'}}" href="{{ url('daily-accounts-report-form') }}">
            <b>@lang('cmn.daily_accounts')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='transport_report')?'success':'default'}}" href="{{ url('transport-report-form') }}">
            <b>@lang('nav.transport')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='deposit_expense')?'success':'default'}}" href="{{ url('deposit-expense-form') }}">
            <b>@lang('cmn.deposit_expense')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='trip_report')?'success':'default'}}" href="{{ url('trip-report-form') }}">
            <b>@lang('cmn.trip') @lang('cmn.deposit_expense')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='due_report')?'success':'default'}}" href="{{ url('due-report-form') }}">
            <b>@lang('cmn.due')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='expense_report')?'success':'default'}}" href="{{ url('expense-report-form') }}">
            <b>@lang('cmn.expense')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='discount_report')?'success':'default'}}" href="{{ url('discount-report-form') }}">
            <b>@lang('cmn.discount')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='install_report')?'success':'default'}}" href="{{ url('installment-form') }}">
            <b>@lang('cmn.installment')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='capital_report')?'success':'default'}}" href="{{ url('capital-report-form') }}">
            <b>@lang('cmn.capitals')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='vehicle_report')?'success':'default'}}" href="{{ url('vehicle-report-form') }}">
            <b>@lang('nav.vehicle')</b>
        </a>
        <a class="btn btn-sm btn-{{ (isset($sub_menu) && $sub_menu =='pump_report')?'success':'default'}}" href="{{ url('pump-report-form') }}">
            <b>@lang('nav.pump')</b>
        </a>
        {{-- <a class="btn btn-sm btn-default disabled" href="{{ url('garage-report-form') }}">
            <b>@lang('nav.garage')</b>
        </a>
        <a class="btn btn-sm btn-default disabled" href="{{ url('clients-report-form') }}">
            <b>@lang('nav.clients')</b>
        </a>
        <a class="btn btn-sm btn-default disabled" href="{{ url('staff-report-form') }}">
            <b>@lang('nav.staff')</b>
        </a> --}}
    </div>
</div>