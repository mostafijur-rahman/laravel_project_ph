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
                margin: 1cm 1cm;
            }
			/* @page {
                margin: 0.5cm 0.5cm;
            } */

			/* @page { margin:0px 25px; } */
			header,
			/* footer {
				left: 0cm;
                right: 0cm;
				position: fixed;
			} */
			header,
			footer,
			.invoice-box,
			.header-table,
			.invoice-box table,
			.header-table table{
				font-size: 10px;
				line-height: 15px;
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

			.signature-top-margin{
				margin-top: 100px
			}
/* 
			@page {
				header: page-header;
				footer: page-footer;
			} */

			/* for footer */
			/* footer {
				left: 0cm;
                right: 0cm;
				position: fixed;
			}
			footer {
                bottom: 0.5cm; 
                color:#999999;
                text-align: center;
            }
			footer .page:after { content: counter(page, decimal);} */

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
					<div class="top-bar-logo text-left">&nbsp;</div>
					<div class="top-bar-info text-center">

						@if($page_header == 'only_company_name_in_header' || $page_header == 'all_info_in_header')
							@if(@setting('client_system.company_name'))
								<div style="font-weight: bolder; font-size: 24px; line-height: 24px">
									@setting('client_system.company_name')
								</div>
							@endif
						@endif
						
						@if($page_header == 'all_info_in_header')
							@if(@setting('client_system.slogan'))
								<div>@setting('client_system.slogan')</div>
							@endif

							@if(@setting('client_system.address'))
								<div style="font-size: 12px">
									@lang('cmn.address') : @setting('client_system.address')
								</div>
							@endif

							<div style="font-size: 12px">

								@if(@setting('client_system.phone'))
									@lang('cmn.phone'): @setting('client_system.phone')
								@endif

								@if(@setting('client_system.email'))
									@lang('cmn.email') : @setting('client_system.email')
								@endif

								@if(@setting('client_system.website'))
									@lang('cmn.web') : @setting('client_system.website')
								@endif

							</div>
						@endif

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
				<table class="table-design" autosize="1.6" cellpadding="0" cellspacing="0" style="table-layout: fixed">
			
					@php 
						$expense_column_sum = []; 
						$row_and_column_sum = 0; 
					@endphp
    
                    <thead>
                        <tr>
                            @if(count($setting_vehicles) > 0)
                                {{-- <td class="center" >@lang('cmn.sl')</td> --}}
                                <td class="center" >@lang('cmn.vehicle')</td>
                            @endif
                
                            @if(count($setting_expenses) > 0)
                                @foreach($setting_expenses as $setting_expense)
                                <td class="center" >{{ $setting_expense->head }}</td>
                                @endforeach
                            @endif
                            <td class="center" >@lang('cmn.total')</td>
                        </tr>
                    </thead>
			
					@if(count($setting_vehicles) > 0)

						@php $key = 0 @endphp
					
						@foreach($setting_vehicles as $vehicle_key => $setting_vehicle)

							<!-- checking this vehicle has any expense amount or not, if 0 then omit this vehilce loop  -->
							@php
								$amount = 0;
								if(count($setting_expenses) > 0){
									foreach ($setting_expenses as $setting_expense) {
										$amount += getExpenseSumByParams($setting_expense->id, $setting_vehicle->id, $request);
									}
								}
								if($amount == 0){
									continue;
								}
							@endphp
			
							@php $row_sum = 0; @endphp
							<tr class="item">
								{{-- <td class="center">{{ ++$key }}</td> --}}
								<td class="center">{{ $setting_vehicle->number_plate }}</td>
			
								@if(count($setting_expenses) > 0)
									@foreach($setting_expenses as $expense_key => $setting_expense)
										@php 
											$amount = getExpenseSumByParams($setting_expense->id, $setting_vehicle->id, $request);
											$row_sum += $amount;
											$expense_column_sum[$expense_key][] = $amount;
										@endphp
										<td class="center">{{ number_format($amount) }}</td>
			
									@endforeach
								@endif
			
								@php $row_and_column_sum += $row_sum; @endphp
								<td class="center">{{ number_format($row_sum) }}</td>
							</tr>
						@endforeach
			
						{{-- @php  dd($expense_column_sum) @endphp --}}
			
					@else
			
						<tr class="item">
							@php $row_sum = 0; @endphp
			
							@if(count($setting_expenses) > 0)
								@foreach($setting_expenses as $setting_expense)
									@php 
										$amount = getExpenseSumByParams($setting_expense->id, null, $request);
										$row_sum += $amount;
										$row_and_column_sum += $row_sum;
									@endphp
									<td class="center">{{ number_format($amount) }}</td>
			
								@endforeach
			
								<td class="center">{{ number_format($row_sum) }}</td>
							@endif
						</tr>
			
					@endif
			
					<!-- column total -->
					<tr>
			
						@if(count($setting_vehicles) > 0)
						
							<td class="center" colspan="1">@lang('cmn.total') =</td>

							@if(count($setting_expenses) > 0)
								@foreach($setting_expenses as $expense_key => $setting_expense)

								@if($expense_column_sum && $expense_column_sum[$expense_key])
									<td class="center">{{ number_format(array_sum($expense_column_sum[$expense_key])) }}</td>
								@else
								<td class="center">0</td>
								@endif

								@endforeach
							@endif

							@if($row_and_column_sum)
								<td class="center">{{ number_format($row_and_column_sum) }}</td>
							@else
								<td class="center">0</td>
							@endif
			
						@endif
			
					</tr>
			
				</table>
			</div>

			<table class="col-md-12 signature-top-margin">
				<tbody>
					<tr style="border: 0px; font-weight: bold">
						<td class="text-left">@lang('cmn.prepared_by')</td>
						<td class="text-center">@lang('cmn.verified_by')</td>
						<td class="text-right">@lang('cmn.approved_by')</td>
					</tr>
				</tbody>
			</table>
		</main>

		{{-- <htmlpagefooter name="page-footer">{PAGENO}</htmlpagefooter> --}}
	</body>
</html>