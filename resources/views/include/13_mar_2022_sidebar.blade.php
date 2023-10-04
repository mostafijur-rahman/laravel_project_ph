<!-- Main Sidebar Container -->
@php $permissions = explode(',',Auth::user()->permissions) @endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ url('/') }}" class="brand-link">
		<img src="{{ asset('storage/setting/default_logo.png') }}" alt="" width="60%" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">{{ Auth::user()->first_name }}</span>
	</a>
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
					<a href="{{ url('dashboard') }}" class="nav-link {{ ($menu=='dashboard')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
						<p>@lang('nav.dashboard')</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('account-transections?page_name=only_transections') }}" class="nav-link {{ ($menu=='only_transections')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-exchange-alt"></i>
						<p>@lang('cmn.all') @lang('cmn.transection')</p>
					</a>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='trip')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='trip')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-truck"></i>
						<p>@lang('cmn.trip_challan') <i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('trips?page_name=create&type=out') }}" class="nav-link {{ ($menu=='trip' && $sub_menu=='trip_create')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.challan_create')</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('/trips?page_name=list&&per_page=50&order_by=from_start') }}" class="nav-link {{ ($menu=='trip' && $sub_menu=='trip_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.chalan_list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('trip-report-form') }}" class="nav-link {{ ($menu=='trip' && $sub_menu=='trip_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='trip_demarage')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='trip_demarage')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-money-bill-alt"></i>
						<p>@lang('cmn.trip_demarage') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						{{-- <li class="nav-item">
							<a href="{{ url('trips?page_name=demarage_create') }}" class="nav-link {{ ($menu=='trip_demarage' && $sub_menu=='trip_demarage_create')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demarage_entry')</p></a>
						</li> --}}
						<li class="nav-item">
							<a href="{{ url('trips?page_name=demarages') }}" class="nav-link {{ ($menu=='trip_demarage' && $sub_menu=='demarages')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demarage_list')</p></a>
						</li>
						<li class="nav-item">
							{{-- {{ url('trips?page_name=demarage_reports') }} --}}
							<a href="#" class="nav-link {{ ($menu=='trip_demarage' && $sub_menu=='trip_demarage_create_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='provider')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='provider')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-truck"></i>
						<p>@lang('cmn.vehicle_provider') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('providers?page_name=challan_due') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='challan_due')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.challan_due') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('providers?page_name=challan_paid') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='challan_paid')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.challan_paid') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('providers?page_name=demarage_due') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='demarage_due')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demarage_due') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('providers?page_name=demarage_paid') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='demarage_paid')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demarage_paid')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('providers?page_name=reports') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='company')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='company')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-handshake"></i>
						<p>@lang('cmn.company') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('companies?page_name=challan_due') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='challan_due')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.bill_due') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('companies?page_name=challan_paid') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='challan_paid')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.bill_received') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('companies?page_name=demarage_due') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='demarage_due')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demarage_due') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('companies?page_name=demarage_paid') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='demarage_paid')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demarage_received') @lang('cmn.list')</p></a>
						</li>
                       	<li class="nav-item">
							<a href="{{ url('companies?page_name=reports') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='expense')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='expense')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-money-bill-alt"></i>
						<p>@lang('cmn.expenses') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('expenses?page_name=list') }}" class="nav-link {{ ($menu=='expense' && $sub_menu=='expense_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.expenses')</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('expenses?page_name=reports') }}" class="nav-link {{ ($menu=='expense' && $sub_menu=='expense_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='accounts')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='accounts')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-money-check"></i>
						<p>@lang('cmn.accounts') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('accounts?page_name=create_bank') }}" class="nav-link {{ ($menu=='accounts' && $sub_menu=='account_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.account_list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('account-transections?page_name=transections') }}" class="nav-link {{ ($menu=='accounts' && $sub_menu=='account_transection')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.cash_in') / @lang('cmn.cash_out')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('account-transections?page_name=balance_transfer') }}" class="nav-link {{ ($menu=='accounts' && $sub_menu=='balance_transfer')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.balance_transfer')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('accounts?page_name=reports') }}" class="nav-link {{ ($menu=='accounts' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					{{-- {{ url('purchases') }} --}}
					<a href="#" class="nav-link {{ ($menu=='purchases')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-shopping-cart"></i>
						<p>@lang('cmn.purchases')</p>
					</a>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='tyres')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='tyres')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-bell"></i>
						<p>@lang('cmn.tyre_notification') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('tyres?page_name=attached') }}" class="nav-link {{ ($menu=='tyres' && $sub_menu=='attached')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.attached')</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('tyres?page_name=not_attached') }}" class="nav-link {{ ($menu=='tyres' && $sub_menu=='not_attached')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.not_attached')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('tyres?page_name=reports') }}" class="nav-link {{ ($menu=='tyres' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='mobils')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='mobils')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-bell"></i>
						<p>@lang('cmn.mobil_notification') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('mobils?page_name=list') }}" class="nav-link {{ ($menu=='mobils' && $sub_menu=='list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.attached')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('mobils?page_name=reports') }}" class="nav-link {{ ($menu=='mobils' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='documents')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='documents')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-bell"></i>
						<p>@lang('cmn.document_notification') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('documents?page_name=list') }}" class="nav-link {{ ($menu=='documents' && $sub_menu=='list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.attached')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('documents?page_name=reports') }}" class="nav-link {{ ($menu=='documents' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				{{-- <li class="nav-item has-treeview {{ ($menu=='purchases')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='purchases')?'active font-weight-bold':'' }}">
						<i class="nav-icon fas fa-money-bill-alt"></i>
						<p>@lang('cmn.purchase') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('purchases/tyre') }}" class="nav-link {{ ($menu=='purchases' && $sub_menu=='tyre_purchase')?'active':'' }}">
								<i class="fa fa-angle-right nav-icon"></i>
								<p>@lang('cmn.tyre')</p>
							</a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('purchases/mobil') }}" class="nav-link {{ ($menu=='purchases' && $sub_menu=='mobil_purchase')?'active':'' }}">
								<i class="fa fa-angle-right nav-icon"></i>
								<p>@lang('cmn.mobil')</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ url('purchases/parts') }}" class="nav-link {{ ($menu=='purchases' && $sub_menu=='parts_purchase')?'active':'' }}">
								<i class="fa fa-angle-right nav-icon"></i>
								<p>@lang('cmn.parts')</p>
							</a>
						</li>
                    </ul>
				</li> --}}
				<li class="nav-item has-treeview {{ ($menu=='report')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='report')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-file-alt"></i>
						<p>@lang('nav.reports') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						
						<li class="nav-item">
							<a href="{{ url('daily-accounts-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='accounts_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.daily_accounts')</p></a>
						</li>
                        {{-- <li class="nav-item">
							<a href="{{ url('transport-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='transport_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('nav.transport')</p></a>
						</li> --}}
                        {{-- <li class="nav-item">
							<a  href="{{ url('deposit-expense-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='deposit_expense')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.deposit_expense')</p></a>
						</li> --}}

                        {{-- <li class="nav-item">
							<a href="{{ url('trip-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='trip_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.trip') @lang('cmn.deposit_expense')</p></a>
						</li> --}}

                        {{-- <li class="nav-item">
							<a onclick="return false;" href="{{ url('due-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='due_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.due')</p></a>
						</li> --}}
                        {{-- <li class="nav-item">
							<a href="{{ url('expense-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='expense_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.expense')</p></a>
						</li> --}}

						{{-- <li class="nav-item">
							<a href="{{ url('payment-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='payment_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.company')</p></a>
						</li> --}}

						{{-- <li class="nav-item">
							<a href="{{ url('discount-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='discount_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.discount')</p></a>
						</li> --}}
                        {{-- <li class="nav-item">
							<a onclick="return false;" href="{{ url('installment-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='install_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.installment')</p></a>
						</li> --}}
                        {{-- <li class="nav-item">
							<a onclick="return false;" href="{{ url('capital-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='capital_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.capitals')</p></a>
						</li> --}}
                        {{-- <li class="nav-item">
							<a href="{{ url('vehicle-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='vehicle_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('nav.vehicle')</p></a>
						</li> --}}
                        {{-- <li class="nav-item">
							<a href="{{ url('pump-report-form') }}" class="nav-link {{ ($menu=='report' && $sub_menu=='pump_report')?'active':'' }} disabled"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('nav.pump')</p></a>
						</li> --}}
                        {{-- <li><a href="{{ url('garage-report-form') }}" class="dropdown-item disabled"><i class="fas fa-genderless"></i> @lang('nav.garage')</a></li>
                        <li><a href="{{ url('clients-report-form') }}" class="dropdown-item disabled"><i class="fas fa-genderless"></i> @lang('nav.clients')</a></li>
                        <li><a href="{{ url('staff-report-form') }}" class="dropdown-item disabled"><i class="fas fa-genderless"></i> @lang('nav.staff')</a></li> --}}
					</ul>
				</li>
				@if(Auth::user()->role->read==1 && Auth::user()->role->create==1 && Auth::user()->role->edit==1 && Auth::user()->role->delete==1)
				<li class="nav-item has-treeview {{ ($menu=='user')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='user')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-user-lock"></i>
						<p>@lang('cmn.system_user') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('user/lists') }}" class="nav-link {{ ($menu=='user' && $sub_menu=='list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.user_list')</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('user/roles') }}" class="nav-link {{ ($menu=='user' && $sub_menu=='role')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.role')</p></a>
						</li>
                    </ul>
				</li>
				@endif
				<li class="nav-item">
					<a href="{{ url('activites') }}" class="nav-link {{ ($menu=='activites')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-users"></i>
						<p>@lang('cmn.user_activity')</p>
					</a>
				</li>
                {{-- <li class="nav-item has-treeview {{ ($menu=='transport')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='transport')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-truck"></i>
						<p>@lang('nav.transport') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('booking') }}" class="nav-link {{ ($menu=='transport' && $sub_menu=='trip_booking')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.trip') @lang('cmn.booking') (@lang('cmn.step') @lang('cmn.1'))</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('booking-list') }}" class="nav-link {{ ($menu=='transport' && $sub_menu=='booking_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('nav.running_trip') (@lang('cmn.step') @lang('cmn.2'))</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('booking-final') }}" class="nav-link {{ ($menu=='transport' && $sub_menu=='booking_completed')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.accounts_closed') (@lang('cmn.step') @lang('cmn.3'))</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('transport-report-form') }}" class="nav-link"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li> --}}
                {{-- <li class="nav-item has-treeview {{ ($menu=='trip')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='trip')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-truck"></i>
						<p>@lang('cmn.trip') @lang('cmn.deposit_expense') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('/trips/create') }}" class="nav-link {{ ($menu=='trip' && $sub_menu=='trip_create')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.trip_create') (@lang('cmn.step') @lang('cmn.1'))</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('/trips?stage=1') }}" class="nav-link {{ ($menu=='trip' && $sub_menu=='trip_stage_1')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('nav.running_trip') (@lang('cmn.step') @lang('cmn.2'))</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('/trips?stage=2') }}" class="nav-link {{ ($menu=='trip' && $sub_menu=='trip_stage_2')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('nav.ending_trip') (@lang('cmn.step') @lang('cmn.3'))</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('/trips?stage=3') }}" class="nav-link {{ ($menu=='trip' && $sub_menu=='trip_stage_3')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('nav.completed_trip') (@lang('cmn.step') @lang('cmn.4'))</p></a>
						</li>
                    </ul>
				</li> --}}
                {{-- <li class="nav-item">
					<a href="{{ url('dues') }}" class="nav-link {{ ($menu=='due')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-money-bill-alt"></i>
						<p>@lang('cmn.payment')</p>
					</a>
				</li> --}}
				{{-- 
                <li class="nav-item">
					<a onclick="return false;" href="{{ url('installment') }}" class="nav-link {{ ($menu=='installment')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-truck"></i>
						<p>@lang('cmn.installment')</p>
					</a>
				</li>
                <li class="nav-item">
					<a onclick="return false;" onclick="return false;" href="{{ url('capitals') }}" class="nav-link {{ ($menu=='capitals')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-money-bill-alt"></i>
						<p>@lang('cmn.capitals')</p>
					</a>
				</li> --}}
				<li class="nav-item has-treeview {{ ($menu=='setting')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='setting')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-wrench"></i>
						<p>@lang('nav.setting') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('settings/investors') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='investor_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.investor')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/banks') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='bank')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.bank')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/staffs') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='staff')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.staff')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/companies') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='company_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.company')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/suppliers') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='suppliers')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.suppliers')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/areas') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='area')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.load_unload_point')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/expenses') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='general_expense')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.expense')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/pumps') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='pump_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.pump')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/vehicles') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='vehicle_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.vehicle')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/brands') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='brand_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.brand')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/tyer-positions') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='tyer-position')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.tyre_position')</p></a>
						</li>
						{{-- <li class="nav-item">
							<a onclick="return false;" href="{{ url('settings/project-expense') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='project_expense')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.project_expenses')</p></a>
						</li>
						<li class="nav-item">
							<a onclick="return false;" href="{{ url('settings/investors') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='investor')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.investors')</p></a>
						</li> --}}
						<li class="nav-item">
							<a href="{{ url('settings/default') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='company')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.company_setup')</p></a>
						</li>
						{{-- <li class="nav-item">
							<a onclick="return false;" href="{{ url('#') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='trip_booking')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.backup')</p></a>
						</li>
						<li class="nav-item">
							<a onclick="return false;" href="{{ url('help') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='help')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.help')</p></a>
						</li> --}}
						<li class="nav-item">
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="{{ url('logout') }}" class="nav-link" 
					onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="@lang('nav.logout')"
					> <i class="nav-icon fas fa-sign-out-alt"></i>
						<p>@lang('nav.logout')</p>
					</a>
					<form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>