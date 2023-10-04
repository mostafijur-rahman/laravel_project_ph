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

			/* font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
			/* header{
                top: 0cm;
                height:230px;
            }
			footer {
                bottom: 0.5cm; 
                color:#999999;
                text-align: center;
            }
			footer .page:after { content: counter(page, decimal);}
			main{
				position: relative;
                top: 228px;
                left: 0cm;
                right: 0cm;
			}
			.invoice-box,
			.header-table {
				max-width: 100%;
				margin: auto;
				padding: 0px;
				border: 0px solid #ddd;
				color: #000000;
			}
			.invoice-box table,
			.header-table table{
				color: #000000;
				width: 100%;
				line-height: inherit;
				text-align: left;
			} */


			/* page-break-inside: always; */
            /* .invoice-box table tr,
			.header-table table tr{page-break-inside: auto;} */

			
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
			/* page-break-inside: always; */


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


			/* .total-panel div,
			.table-header-panel div{
				float: left;
				overflow: hidden;
				padding: 6px 8px;
				border-left: 1px solid #ddd;
			}
			.total-panel div:first-child,
			.table-header-panel div:first-child{
				border-left: 0px solid #ddd;
			}
			.table-header-panel .purchase-id{width: 93px;}
			.table-header-panel .date{width: 139px;}
			.table-header-panel .item{width: 174px;}
			.table-header-panel .type{width: 131px;}
			.table-header-panel .charge{width: 90px;}
			.total-panel div,
			.table-design .heading,
			.table-header-panel div{
				font-size:14px;
				line-height:24px;
			}
			.total-panel{
				margin-top:-1px;
				height: 37px;
			}
			.total-panel .total{
				width: 588px;
				text-align: right;
			}
			.total-panel .amount{width: 100px;} */

			
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
				<div class="row">
					<div class="column">
						@php $total_deposit = 0; @endphp
						<table class="table-design" cellpadding="0" cellspacing="0">
							<tr>
								<td class="center" width="5%">@lang('cmn.nong')</td>
								<td class="center" width="10%">@lang('cmn.deposit')</td>
								<td class="center" width="10%">@lang('cmn.amount')</td>
							</tr>
							<tr>
								<td class="center">@lang('cmn.1')</td>
								<td class="center">@lang('cmn.own_vehicle_single_challan') @lang('cmn.deposit')</td>
								<td class="center">{{ number_format($single_challan_deposit) }}</td>
								@php $total_deposit += $single_challan_deposit; @endphp
							</tr>
							<tr>
								<td class="center">@lang('cmn.2')</td>
								<td class="center">@lang('cmn.own_vehicle_up_down_challan') @lang('cmn.deposit')</td>
								<td class="center">{{ number_format($up_down_challan_deposit) }}</td>
								@php $total_deposit += $up_down_challan_deposit; @endphp
							</tr>
							<tr>
								<td colspan="2" class="text-right">@lang('cmn.total') = </td>
								<td class="text-center">{{ number_format($total_deposit) }}</td>
							</tr>
						</table>
					</div>

					<div class="column">
						@php
							$total_expense = 0; 
						@endphp
						<table class="table-design" cellpadding="0" cellspacing="0">							
							<tr>
								<td class="center" width="5%">@lang('cmn.no')</td>
								<td class="center" width="10%">@lang('cmn.expense')</td>
								<td class="center" width="10%">@lang('cmn.amount')</td>
							</tr>

							<tr>
								<td class="center">@lang('cmn.1')</td>
								<td class="center">@lang('cmn.challan_general_expense')</td>
								<td class="center">{{ number_format($inside_challan_general_expense) }}</td>
								@php $total_expense += $inside_challan_general_expense; @endphp
							</tr>

							<tr>
								<td class="center">@lang('cmn.2')</td>
								<td class="center">@lang('cmn.challan_oil_expense')</td>
								<td class="center">{{ number_format($inside_challan_oil_expense) }}</td>
								@php $total_expense += $inside_challan_oil_expense; @endphp
							</tr>

							<tr>
								<td class="center">@lang('cmn.3')</td>
								<td class="center">@lang('cmn.other') @lang('cmn.general_expense')</td>
								<td class="center">{{ number_format($outside_challan_general_expense) }}</td>
								@php $total_expense += $outside_challan_general_expense; @endphp
							</tr>

							<tr>
								<td class="center">@lang('cmn.4')</td>
								<td class="center">@lang('cmn.other') @lang('cmn.oil_expense')</td>
								<td class="center">{{ number_format($outside_challan_oil_expense) }}</td>
								@php $total_expense += $outside_challan_oil_expense; @endphp
							</tr>

							<tr>
								<td colspan="2" class="text-right">@lang('cmn.total') = </td>
								<td class="center">{{ number_format($total_expense) }}</td>
							</tr>

							<tr>
								<td colspan="2" class="text-right">@lang('cmn.balance') = </td>
								<td class="center">{{ number_format($total_deposit - $total_expense) }}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</main>
	</body>
</html>