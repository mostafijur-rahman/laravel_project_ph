<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>{{ $title }}</title>
		<style>
			body{
				font-family: bangla;
			}
			@font-face {
				font-family: "SolaimanLipi";
				font-style: normal;
				font-weight: normal;
				src: url(SolaimanLipi.ttf) format('truetype');
			}
			* {
				font-family: "SolaimanLipi";
			}
			@page {
                margin: 0.5cm 1cm;
            }
			/* @page { margin:0px 25px; } */
			header,
			footer {
				left: 0cm;
                right: 0cm;
				position: fixed;
			}
			header,
			footer,
			.invoice-box,
			.header-table,
			.invoice-box table,
			.header-table table{
				font-size: 12px;
				line-height: 20px;
			}
			
			.invoice-box table td,
			.header-table table td{
				/* padding: 6px 8px; */
				vertical-align: top;
			}
			.table-design tr td:last-child,
			.header-table table tr td:last-child,
			.invoice-box table tr td:last-child{text-align: left;}
			.table-design{
				border-top: 1px solid #ddd;
				border-right: 1px solid #ddd;
			}

            /* .table-design tr{page-break-inside: auto;} */
			.table-design tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}
			.table-design tr:nth-child(even) {background-color: #f9f9f9;}
			.table-design tr td{
				border-left: 1px solid #ddd;
				border-bottom: 1px solid #ddd;
			}
			.table-design tr.item td {
				border-bottom: 1px solid #ddd;
			}
			.table-design tr.item.last td {border-bottom: none;}
			.total-panel,
			.table-header-panel{
				border: 1px solid #ddd;
				background-color:#eeeeee;
				height: 38px;
				width: 100%;
			}
			.center {
				text-align: center;
			}
			.row {

			}
			.column {
				float: left;
				width: 50%;
			}
			/* Clearfix (clear floats) */
			.row::after {
				content: "";
				clear: both;
				display: table;
			}
			table {
				border-collapse: collapse;
				border-spacing: 0;
				width: 100%;
				border: 0;
			}
			/*
				top bar related design
			*/
			.top-bar-logo,
			.top-bar-info,
			.top-bar-time
			{
				float: left;
			}
			.top-bar-logo {
				width: 20%;
			}
			.top-bar-info {
				width: 60%;
			}
			.top-bar-time {
				width: 20%;
			}
			.text-center{
				text-align: center
			}
			.text-right{
				text-align: right
			}
			.text-left{
				text-align: left
			}
			.mb-3{
				margin-bottom: 10px
			}
			.float-right{
				float: right;
			}
		</style>
	</head>
	<body>
		<style>
			body {
				font-family: 'bangla', sans-serif;
			}
		</style>
		<main>
            <div class="top-bar">
				<div class="row mb-3">
					<div class="top-bar-logo text-left">
						Logo
					</div>
					<div class="top-bar-info text-center">
						<div style="font-weight: bolder; font-size: 24px; line-height: 24px">
							@setting('client_system.company_name')
						</div>
						<div>@setting('client_system.slogan')</div>
						<div style="font-size: 12px">
							@lang('cmn.address') : @setting('client_system.address')
						</div>
						<div style="font-size: 12px">
							@lang('cmn.phone'): @setting('client_system.phone')
							@lang('cmn.email') : @setting('client_system.email')
							@lang('cmn.web') : @setting('client_system.website')
						</div>
                        <div style="font-size: 16px">
							{{ $title ?? '' }}
						</div>
					</div>
					<div class="top-bar-time text-right">
						<div style="font-size: 12px">
							@lang('cmn.reporting_time') {{ $reporting_time }}
						</div>
					</div>
				</div>
			</div>

			<div class="invoice-box">
				<table class="table-design" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="center" width="10%">@lang('cmn.challan_number')</td>
                        {{-- <td class="center" width="10%">@lang('cmn.posting_date')</td> --}}
                        <td class="center" width="10%">@lang('cmn.start_date')</td>

                        <td class="center" width="10%">@lang('cmn.vehicle_number')</td>
                        {{-- <td class="center" width="10%">@lang('cmn.load_point')</td>
                        <td class="center" width="10%">@lang('cmn.unload_point')</td> --}}
                        <td class="center" width="10%">@lang('cmn.company')</td>

                        <td class="center" width="10%">@lang('cmn.contract_rent')</td>
						<td class="center" width="10%">@lang('cmn.addv_recev')</td>
                        <td class="center" width="10%">@lang('cmn.challan_due')</td>

						<td class="center" width="10%">@lang('cmn.demurrage_charge')</td>
						<td class="center" width="10%">@lang('cmn.demurrage_received')</td>
                        <td class="center" width="10%">@lang('cmn.demurrage_due')</td>

						<td class="center" width="10%">@lang('cmn.total_deposit')</td>

						<td class="center" width="10%">@lang('cmn.general_expense')</td>
						<td class="center" width="10%">@lang('cmn.oil_expense')</td>
						<td class="center" width="10%">@lang('cmn.total_expense')</td>

						<td class="center" width="10%">@lang('cmn.balance')</td>

                    </tr>
                    @if(count($trips) > 0)
                        @php 
							$total_contract_fair = 0; 
							$total_advance_fair = 0; 
							$total_due_fair = 0;

							$total_demarage = 0; 
							$total_demarage_received = 0; 
							$total_demarage_due = 0;

							$total_deposit = 0;

							$total_general_expense = 0;
							$total_oil_expense = 0;
							$total_expense = 0;
							$sum_total_expense = 0;

							$total_balance = 0;

						@endphp


                        @foreach($trips as $key => $list)
                            @php 
                                $total_contract_fair += $list->company->contract_fair; 
                                $total_advance_fair += $list->company->advance_fair; 
                                $total_due_fair += $list->company->due_fair;

                                $total_demarage += $list->company->demarage; 
                                $total_demarage_received += $list->company->demarage_received; 
                                $total_demarage_due += $list->company->demarage_due;

                                $total_deposit += ($list->company->advance_fair + $list->company->received_fair + $list->company->demarage_received);

								$general_expense = tripExpenseSumByTripId($list->id);
								$total_general_expense += $general_expense;

								$oil_expense = tripOilBillSumByTripId($list->id);
								$total_oil_expense += $oil_expense;

								$total_expense = $general_expense+$oil_expense;
								$sum_total_expense += $total_expense;

								$total_balance = 0;

							@endphp
							<tr class="item">
                                <td class="center">{{ $list->number }}</td>
                                {{-- <td class="center">{{ date('d M, Y', strtotime($list->account_take_date)) }}</td> --}}
                                <td class="center">{{ date('d M, Y', strtotime($list->date)) }}</td>

                                <td class="center">{{ $list->provider->vehicle->number_plate }}</td>
                                <td class="center">{{ $list->company->company->name }}</td>
                            	
								{{-- <td class="center">
									@if($list->points)
									@php $lastKey = count($list->points); @endphp
									@foreach($list->points as $key => $point)
										@if($point->pivot->point == 'load')
										{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}
										@endif
									@endforeach
									@endif
								</td>
                            	<td class="center">
									@if($list->points)
									@php $lastKey = count($list->points); @endphp
									@foreach($list->points as $key => $point)
										@if($point->pivot->point == 'unload')
										{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}
										@endif
									@endforeach
									@endif
								</td> --}}

                            	<td class="center">{{ number_format($list->company->contract_fair) }}</td>
                            	<td class="center">{{ number_format($list->company->advance_fair) }}</td>
                            	<td class="center">{{ number_format($list->company->due_fair) }}</td>

								<td class="center">{{ number_format($list->company->demarage) }}</td>
                            	<td class="center">{{ number_format($list->company->demarage_received) }}</td>
                            	<td class="center">{{ number_format($list->company->demarage_due) }}</td>

								<td class="center">{{ number_format($list->company->advance_fair+$list->company->received_fair+$list->company->demarage_received) }}</td>

								<td class="center" width="10%">{{ number_format($general_expense) }}</td>
								<td class="center" width="10%">{{ number_format($oil_expense) }}</td>
								<td class="center" width="10%">{{ number_format($total_expense) }}</td>

                            	<td class="center">{{ number_format(($list->company->advance_fair+$list->company->received_fair+$list->company->demarage_received) - $total_expense) }}</td>

                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-right" colspan="4"><b style="font-weight: bold;">@lang('cmn.total') = </b></td>
                            

                            <td class="center"><b style="font-weight: bold;">{{ number_format($total_contract_fair) }}</b></td>
                            <td class="center"><b style="font-weight: bold;">{{ number_format($total_advance_fair) }}</b></td>
                            <td class="center"><b style="font-weight: bold;">{{ number_format($total_due_fair) }}</b></td>

							<td class="center"><b style="font-weight: bold;">{{ number_format($total_demarage) }}</b></td>
                            <td class="center"><b style="font-weight: bold;">{{ number_format($total_demarage_received) }}</b></td>
                            <td class="center"><b style="font-weight: bold;">{{ number_format($total_demarage_due) }}</b></td>

							<td class="center">{{ number_format($total_deposit) }}</td>

							<td class="center" width="10%">{{ number_format($total_general_expense) }}</td>
							<td class="center" width="10%">{{ number_format($total_oil_expense) }}</td>
							<td class="center" width="10%">{{ number_format($sum_total_expense) }}</td>

							<td class="center">{{ number_format($total_deposit - $sum_total_expense) }}</td>
                            
                        </tr>
                    @else
                        <tr>
                            <td colspan="9" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                        </tr>
                    @endif
                </table>
			</div>

		</main>
	</body>
</html>