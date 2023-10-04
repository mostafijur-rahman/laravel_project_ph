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
					<a href="{{ url('dashboard?time_range=all_time&dashboard=two') }}" class="nav-link {{ ($menu=='dashboard')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
						<p>@lang('nav.dashboard')</p>
					</a>
				</li>
			
				{{-- <li class="nav-item">
					<a href="{{ url('vehicle-tracking') }}" class="nav-link {{ ($menu=='vehicle_tracking')?'active font-weight-bold':'' }}"> <i class="fas fa-map-marker-alt"></i>
						<p>@lang('cmn.vehicle_tracking')</p>
					</a>
				</li> --}}
				<li class="nav-item">
					<a href="{{ url('account-transections?page_name=only_transections') }}" class="nav-link {{ ($menu=='only_transections')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-exchange-alt"></i>
						<p>@lang('cmn.all') @lang('cmn.transection')</p>
					</a>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='challan_create')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='challan_create')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-file-alt"></i>
						<p>@lang('cmn.challan') @lang('cmn.create') <i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('trips/own-vehicle-single?page_name=create&type=own_vehicle_single') }}" class="nav-link {{ ($menu=='challan_create' && $sub_menu=='own_vehicle_single')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.single_challan')</p></a>
							<a href="{{ url('trips/own-vehicle-up-down?page_name=create&type=own_vehicle_up_down') }}" class="nav-link {{ ($menu=='challan_create' && $sub_menu=='own_vehicle_up_down')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.up_down_challan')</p></a>

							<a href="{{ url('trips/out-commission-transection?page_name=create&type=out_commission_transection') }}" class="nav-link {{ ($menu=='challan_create' && $sub_menu=='out_commission_transection')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.transection_with_commission_challan')</p></a>
							<a href="#" class="nav-link {{ ($menu=='challan_create' && $sub_menu=='out_commission')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.only_commission_challan')</p></a>
							{{-- {{ url('trips/out-commission?page_name=create&type=out_commission') }} --}}
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='challan_list')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='challan_list')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-list"></i>
						<p>@lang('cmn.challan') @lang('cmn.list')<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('trips?page_name=list&type=own_vehicle_single&per_page=50&order_by=desc') }}" class="nav-link {{ ($menu=='challan_list' && $sub_menu=='own_vehicle_single')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.single_challan')</p></a>
							<a href="{{ url('trips?page_name=list&type=own_vehicle_up_down&per_page=50&order_by=desc') }}" class="nav-link {{ ($menu=='challan_list' && $sub_menu=='own_vehicle_up_down')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.up_down_challan')</p></a>

							<a href="{{ url('trips?page_name=list&type=out_commission_transection&per_page=50&order_by=desc') }}" class="nav-link {{ ($menu=='challan_list' && $sub_menu=='out_commission_transection')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.transection_with_commission_challan')</p></a>
							<a href="#" class="nav-link {{ ($menu=='challan_list' && $sub_menu=='out_commission')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.only_commission_challan')</p></a>
							{{-- {{ url('trips?page_name=list&type=out_commission&per_page=50&order_by=desc') }} --}}

							<a href="{{ url('trips?page_name=list&type=own_vehicle_up_down_new&per_page=50&order_by=desc') }}" class="nav-link {{ ($menu=='challan_list' && $sub_menu=='own_vehicle_up_down_new')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.up_down_challan') (@lang('cmn.beta'))</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='challan_report')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='challan_report')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-file-pdf"></i>
						<p>@lang('cmn.challan') @lang('cmn.report') <i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('trip-report-form') }}" class="nav-link {{ ($menu=='challan_report' && $sub_menu=='challan')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.challan') @lang('cmn.report')</p></a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link {{ ($menu=='challan_report' && $sub_menu=='expense')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.expense_report')</p></a>
						</li>
						{{-- <li class="nav-item">
							<a href="{{ url('trip-report-form') }}" class="nav-link {{ ($menu=='trip' && $sub_menu=='cc')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li> --}}
                    </ul>
				</li>

				{{-- <li class="nav-item has-treeview {{ ($menu=='trip_demarage')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='trip_demarage')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-money-bill-alt"></i>
						<p>@lang('cmn.trip_demarage') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('trips?page_name=demarages') }}" class="nav-link {{ ($menu=='trip_demarage' && $sub_menu=='demarages')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demarage_list')</p></a>
						</li>
						<li class="nav-item">
							{{ url('trips?page_name=demarage_reports') }}
							<a href="#" class="nav-link {{ ($menu=='trip_demarage' && $sub_menu=='trip_demarage_create_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li> --}}

				<li class="nav-item has-treeview {{ ($menu=='provider')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='provider')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-truck"></i>
						<p>@lang('cmn.vehicle_provider') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('providers?page_name=challan_due') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='challan_due')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.challan_due') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('providers?page_name=challan_paid&show_type=trip_number_wise&order_by=desc') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='challan_paid')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.challan_paid') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('providers?page_name=demarage_due') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='demarage_due')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demurrage_due') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('providers?page_name=demarage_paid') }}" class="nav-link {{ ($menu=='provider' && $sub_menu=='demarage_paid')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demurrage_paid')</p></a>
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
							<a href="{{ url('companies?page_name=company_list') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='company_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.company_list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('companies?page_name=challan_due') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='challan_due')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.bill_due') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('companies?page_name=challan_paid&per_page=100&order_by=desc') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='challan_paid')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.bill_received') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('companies?page_name=demarage_due') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='demarage_due')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demurrage_due') @lang('cmn.list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('companies?page_name=demarage_paid') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='demarage_paid')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.demurrage_received') @lang('cmn.list')</p></a>
						</li>
                       	<li class="nav-item">
							<a href="{{ url('companies?page_name=reports') }}" class="nav-link {{ ($menu=='company' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='pump')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='pump')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-gas-pump"></i>
						<p>@lang('cmn.pump') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('pumps?page_name=pump_list') }}" class="nav-link {{ ($menu=='pump' && $sub_menu=='pump_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.pump_list')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('pumps?page_name=pump_reports') }}" class="nav-link {{ ($menu=='pump' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='expense')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='expense')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-money-bill-alt"></i>
						<p>@lang('cmn.expenses') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('challan-expenses') }}" class="nav-link {{ ($menu=='expense' && $sub_menu=='challan_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.challan_expense')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('expenses') }}" class="nav-link {{ ($menu=='expense' && $sub_menu=='general_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.general_expense')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('oil-expenses') }}" class="nav-link {{ ($menu=='expense' && $sub_menu=='oil_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.oil_expense')</p></a>
						</li>
                        <li class="nav-item">
							<a href="{{ url('expense-report-form') }}" class="nav-link {{ ($menu=='expense' && $sub_menu=='expense_report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.reports')</p></a>
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
				<li class="nav-item has-treeview {{ ($menu=='all_report')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='all_report')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-file-alt"></i>
						<p>@lang('cmn.all_reports') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('daily-accounts-report-form') }}" class="nav-link {{ ($menu=='all_report' && $sub_menu=='daily_accounts')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.daily_accounts')</p></a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="{{ url('purchases?page_name=tyre') }}" class="nav-link {{ ($menu=='purchases')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-shopping-cart"></i>
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
				{{-- <li class="nav-item has-treeview {{ ($menu=='documents')?'menu-open':'' }}">
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
				</li> --}}

				<li class="nav-item">
					<a href="{{ url('vehicles-documents') }}" class="nav-link {{ ($menu=='vehicle_documents')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-bell"></i>
						<p>@lang('cmn.document_notification')</p>
					</a>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='vehicle')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='vehicle')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-truck"></i>
						<p>@lang('cmn.vehicle') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('vehicles') }}" class="nav-link {{ ($menu=='vehicle' && $sub_menu=='list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.list')</p></a>
						</li>
                        <li class="nav-item">
							<a href="#" class="nav-link {{ ($menu=='vehicle' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.report')</p></a>
						</li>
                    </ul>
				</li>
				<li class="nav-item has-treeview {{ ($menu=='staff')?'menu-open':'' }}">
					<a href="#" class="nav-link {{ ($menu=='staff')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-users"></i>
						<p>@lang('cmn.staff') <i class="fas fa-angle-left right"></i></p>
                    </a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('staffs') }}" class="nav-link {{ ($menu=='staff' && $sub_menu=='list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.list')</p></a>
						</li>
                        <li class="nav-item">
							<a href="#" class="nav-link {{ ($menu=='staff' && $sub_menu=='report')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p>@lang('cmn.report')</p></a>
						</li>
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
				<li class="nav-item">
					<a href="{{ url('notifications') }}" class="nav-link {{ ($menu=='notification')?'active font-weight-bold':'' }}"> <i class="nav-icon fas fa-bell"></i>
						<p>@lang('cmn.all_notifications')</p>
					</a>
				</li>
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
						{{-- <li class="nav-item">
							<a href="{{ url('settings/staffs') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='staff')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.staff')</p></a>
						</li> --}}
						{{-- <li class="nav-item">
							<a href="{{ url('settings/companies') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='company_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.company')</p></a>
						</li> --}}
						<li class="nav-item">
							<a href="{{ url('settings/suppliers') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='suppliers')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.suppliers')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/areas') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='area')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.load_unload_point')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/expenses') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='general_expense')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.expense')</p></a>
						</li>
						{{-- <li class="nav-item">
							<a href="{{ url('settings/pumps') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='pump_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.pump')</p></a>
						</li> --}}
						{{-- <li class="nav-item">
							<a href="{{ url('settings/vehicles') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='vehicle_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('nav.vehicle')</p></a>
						</li> --}}
						<li class="nav-item">
							<a href="{{ url('settings/brands') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='brand_list')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.brand')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/tyer-positions') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='tyer-position')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.tyre_position')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/default') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='company')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.company_setup')</p></a>
						</li>
						<li class="nav-item">
							<a href="{{ url('settings/system') }}" class="nav-link {{ ($menu=='setting' && $sub_menu=='system')?'active':'' }}"> <i class="fa fa-angle-right nav-icon"></i><p> @lang('cmn.system_setting')</p></a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="{{ url('/cash-memory-clear') }}" class="nav-link"> <i class="nav-icon fas fa-memory"></i>
						<p>@lang('cmn.cash_memory_clear')</p>
					</a>
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