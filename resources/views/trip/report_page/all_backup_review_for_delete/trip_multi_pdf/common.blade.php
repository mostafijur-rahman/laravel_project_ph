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
                    <tr class="text-center">
                        @if($request->has('primary_info') && $request->has('primary_info') == 'on')
                        <td width="30%">@lang('cmn.primary_info')</td>
                        @endif
                        @if($request->has('vehicle_transection') && $request->has('vehicle_transection') == 'on')
                        <td width="30%">@lang('cmn.transection_with_vehicle')</td>
                        @endif
                        @if($request->has('company_transection') && $request->has('company_transection') == 'on')
                        <td width="20%">@lang('cmn.transection_with_company')</td>
                        @endif
                        @if($request->has('comission') && $request->has('comission') == 'on')
                        <td width="20%">@lang('cmn.commission')</td>
                        @endif
                        @if($request->has('trip_deposit_expense') && $request->has('trip_deposit_expense') == 'on')
                        <td width="20%">@lang('cmn.own_trip_deposit_expense')</td>
                        @endif
                    </tr>
                    @if(count($trips)>0)
                        @foreach($trips as $trip)

                            @if($trip->type)
                                @switch($trip->type)
                                    @case('out_nagad_commission')
                                        @include('trip.report.trip_multi_pdf.out_nagad_commission')
                                    @break

                                    @case('out_from_market')
                                        @include('trip.report.trip_multi_pdf.out_from_market')
                                    @break

                                    @case('own_vehicle')
                                        @include('trip.report.trip_multi_pdf.own_vehicle')
                                    @break

									@case('own_vehicle_without_commission')
										@include('trip.report.trip_multi_pdf.own_vehicle_without_commission')
									@break
							
									@case('own_vehicle_with_commission')
										@include('trip.report.trip_multi_pdf.own_vehicle_with_commission')
									@break

                                    @default
                                    No Default Trip single pdf script
                                @endswitch
                            @else
                                No Trip Type Found from database!
                            @endif

                        @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                    </tr>
                    @endif
                </table>
			</div>
		</main>
	</body>
</html>