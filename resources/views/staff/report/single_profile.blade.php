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

			@page {
				header: page-header;
				footer: page-footer;
			}

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
				<table class="table-design" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<td class="text-center" width="2%">@lang('cmn.sl')</td>
							<td class="text-center" width="10%" >@lang('cmn.date')</td>
							<td class="text-center" width="10%">@lang('cmn.voucher_id')</td>

							<td class="text-center" width="10%">@lang('cmn.challan_no')</td>
							<td class="text-center" width="10%">@lang('cmn.vehicle')</td>

							<td class="text-center" width="10%">@lang('cmn.account_id')</td>
							<td class="text-center" width="20%">@lang('cmn.expense_head')</td>
							<td class="text-center" width="10%">@lang('cmn.amount')</td>
						</tr>
					</thead>

					@if(count($lists) > 0)
							<tr class="item">

								<td class="center">{{ ++$key }}</td>
								<td class="text-left">{{ date('d M, Y', strtotime($list->date)) }}</td>

								<td class="text-{{ ($list->voucher_id)?'left':'center'}}" >{{ $list->voucher_id??'---' }}</td>

								@if($list->trip_id)
									<td class="text-{{ ($list->trip->number)?'left':'center'}}">{{ $list->trip->number??'---' }}</td>
									<td class="text-left">{{ $list->trip->provider->vehicle_id ? $list->trip->provider->vehicle->number_plate : $list->trip->provider->number_plate }}</td>
								@elseif($list->vehicle_id)
									<td class="text-center">---</td>
									<td class="text-left">{{ $list->vehicle->number_plate }}</td>
								@else
									<td class="text-center">---</td>
									<td class="text-center">---</td>
								@endif

								<td class="text-left">{{ $list->transaction->account->user_name }} ({{ $list->transaction->account->account_number??__('cmn.cash') }})</td>
								<td class="text-left">{{ $list->expense->head }}</td>
								<td class="text-center">{{ number_format($list->amount) }}</td>

							</tr>

					@else
						<tr>
							<td colspan="8" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
						</tr>
					@endif
					<!-- more loop here -->
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