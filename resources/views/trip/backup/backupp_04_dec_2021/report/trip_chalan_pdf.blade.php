<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Deposit</title>
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
						<div style="font-size: 14px">
							@lang('cmn.address') : {{ $setComp['address'] ?? '' }}
						</div>
						<div style="font-size: 12px">
							@lang('cmn.phone'): {{ $setComp['phone'] ?? '' }}
							@lang('cmn.email') : {{ $setComp['email'] ?? '' }}
							@lang('cmn.web') : {{ $setComp['website'] ?? '' }}
						</div>
					</div>
					<div class="top-bar-time text-right">
						<div style="font-size: 12px">
							@lang('cmn.reporting_time') {{ date('d M, Y h:i:s a') }}
						</div>
					</div>
				</div>
			</div>
			<div class="invoice-box">
				<table class="table-design" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="center" width="20%">@lang('cmn.primary_info')</td>
                        <td class="center" width="25%">@lang('cmn.trip_details')</td>
                        <td class="center" width="25%">@lang('cmn.income')</td>
                        <td class="center" width="20%">@lang('cmn.expense')</td>
                    </tr>
                    @if(count($trips) > 0)
                        @foreach($trips as $key => $trip)
                        @php $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id) @endphp
                        <tr class="item">
                            <td class="text-left">
                                @if($trip->account_take_date)
                                @lang('cmn.account_receiving'): {{ date('d M, Y', strtotime($trip->account_take_date)) }}<br>
                                @endif
                                @lang('cmn.vehicle'): {{ $trip->vehicle->vehicle_number }}<br>
                                @if($trip->number)
                                @lang('cmn.trip_number'): {{ $trip->number }}<br>
                                @endif
                                @lang('cmn.driver'): {{ $trip->vehicle->driver->name }}<br>
                                @if($trip->meter->previous_reading)
                                    @lang('cmn.previous_meter'): {{  number_format($trip->meter->previous_reading) }}<br>
                                    @lang('cmn.running_meter'): {{ number_format($trip->meter->current_reading) }}<br>
                                    @lang('cmn.total') @lang('cmn.km'): {{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}<br>
                                    @lang('cmn.total') @lang('cmn.fuel'): {{ number_format($tripOilLiterSumByGroupId) }}<br>
                                    @lang('cmn.liter_per_km'): {{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}<br>
                                @endif
                                @lang('cmn.created'): {{ $trip->user->first_name .' '.$trip->user->last_name}}<br>
                            </td>
                            <td class="text-left">
                                @if($trip->getTripsByGroupId)
                                    @php $tripLastKey = count($trip->getTripsByGroupId); @endphp
                                    @foreach($trip->getTripsByGroupId as $tripKey => $trip_info)
                                        @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip_info->date)) }}</b><br>
                                        @lang('cmn.route'): <b>{{ $trip_info->load_data->name }}</b> @lang('cmn.from') <b>{{ $trip_info->unload->name }} ({{ $trip_info->trip_distance + $trip_info->empty_distance }} @lang('cmn.km'))</b><br>
                                        @lang('cmn.client'): <b>{{ $trip_info->company->name }}</b>
                                        @if($trip_info->goods)
                                            <br>@lang('cmn.goods'): <b>{{ $trip_info->goods }}</b><br>
                                        @endif
                                        @lang('cmn.rent'): <b>{{ number_format($trip_info->contract_fair) }}</b><br>
                                        @lang('cmn.addv_rent'): <b>{{ number_format($trip_info->advance_fair) }}</b><br>
                                        @lang('cmn.challan_due'): <b>{{ number_format($trip_info->due_fair) }}</b><br>
                                        @if(($tripKey+1) != $tripLastKey)
                                            <br>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            @php
                                $total_general_expense_sum =  tripExpenseSumByGroupId($trip->group_id);
                                $total_oil_bill_sum =  tripOilBillSumByGroupId($trip->group_id);
                                $total_received_rent =  $trip->getTripsByGroupId->sum('advance_fair') + $trip->getTripsByGroupId->sum('received_fair');
                                $trip_general_exp_lists = tripExpenseListSumByGroupId($trip->group_id);
                            @endphp
                            <td class="text-right">
                                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                    @lang('cmn.rent') = <strong>{{ number_format($total_received_rent) }}</strong><br>
                                    @lang('cmn.total_expense') = <strong>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</strong><br>
                                </div>
                                @lang('cmn.net_income') = <strong>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</strong><br>
                                (@lang('cmn.challan_due') = {{ number_format($trip->getTripsByGroupId->sum('due_fair')) }}, @lang('cmn.discount') = {{ number_format($trip->getTripsByGroupId->sum('deduction_fair')) }})
                            </td>
                            <td class="text-right">
                                <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                    @if($trip_general_exp_lists)
                                        @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                                        <b>{{ $trip_general_exp_list->head }} =</b> {{ number_format($trip_general_exp_list->trip_single_expense_sum) }}<br>
                                        @endforeach
                                </div>
                                <b>@lang('cmn.total_expense') = {{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                        </tr>
                    @endif
                    <!-- more loop here -->
                </table>
			</div>
		</main>
	</body>
</html>