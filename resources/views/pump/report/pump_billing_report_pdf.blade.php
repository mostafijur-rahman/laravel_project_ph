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
							{{ $setComp['company_name'] ?? '' }}
						</div>
						<div>{{ $setComp['slogan'] ?? '' }}</div>
						<div style="font-size: 12px">
							@lang('cmn.address') : {{ $setComp['address'] ?? '' }}
						</div>
						<div style="font-size: 12px">
							@lang('cmn.phone'): {{ $setComp['phone'] ?? '' }}
							@lang('cmn.email') : {{ $setComp['email'] ?? '' }}
							@lang('cmn.web') : {{ $setComp['website'] ?? '' }}
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
                        <td class="center" width="5%">@lang('cmn.no')</td>
                        <td class="center" width="10%">@lang('cmn.date')</td>
                        <td class="center" width="10%">@lang('cmn.trip_number')</td>
                        <td class="center" width="10%">@lang('cmn.vehicle_number')</td>
                        <td class="center" width="10%">@lang('cmn.pump_name')</td>

                        <td class="center" width="10%">@lang('cmn.rate')</td>
                        <td class="center" width="10%">@lang('cmn.liter')</td>
						<td class="center" width="10%">@lang('cmn.taka')</td>
                    </tr>
                    @if(count($lists) > 0)
                        @php 
							$total_liter = 0; 
							$total_bill = 0;
						@endphp
                        @foreach($lists as $key => $list)
                            @php 
                                $total_liter += $list->liter; 
                                $total_bill += $list->bill;
							@endphp
							<tr class="item">
                                <td class="center">{{ ++$key }}</td>
                                <td class="center">{{ date('d M, Y', strtotime($list->trip->date)) }}</td>
                                <td class="center">{{ $list->trip->number }}</td>
                                <td class="center">
                                    {{ $list->trip->provider->vehicle_id ? $list->trip->provider->vehicle->vehicle_number :$list->provider->vehicle_number }}
                                </td>
                            	<td class="center">{{ ($list->pump_id)?$list->pump->name: __('cmn.paid_by_cash') }}</td>
                            	<td class="center">{{ number_format($list->rate) }}</td>
                            	<td class="center">{{ number_format($list->liter) }}</td>
                            	<td class="center">{{ number_format($list->bill) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-right" colspan="6"><b style="font-weight: bold;">@lang('cmn.total') = </b></td>
                            <td class="center"><b style="font-weight: bold;">{{ number_format($total_liter) }}</b></td>
                            <td class="center"><b style="font-weight: bold;">{{ number_format($total_bill) }}</b></td>
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