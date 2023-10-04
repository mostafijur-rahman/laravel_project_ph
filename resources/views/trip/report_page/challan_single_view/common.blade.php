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

			.signature-top-margin{
				margin-top: 500px
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


            @if($trip->type)
                @switch($trip->type)
                    {{-- @case('out_commission')
                        @include('trip.report_page.challan_single_view.out_commission')
                    	@break --}}

                    @case('out_commission_transection')
                        @include('trip.report_page.challan_single_view.out_commission_transection')
                    	@break

					@case('own_vehicle_single')
						@include('trip.report_page.challan_single_view.own_vehicle_single')
						@break

					@case('own_vehicle_up_down')
						@include('trip.report_page.challan_single_view.own_vehicle_up_down')

                @endswitch
            @else
			@lang('cmn.did_not_found')
            @endif

			<div class="row">
				<br>
				<br>
				<div class="invoice-box" style="float: left; width: 60%">
					<table class="table-design" cellpadding="0" cellspacing="0">
						<tr>
							<td width="25%" class="text-center">@lang('cmn.account_info')</td>
							<td width="35%" class="text-center">@lang('cmn.reason')</td>
							<td width="20%" class="text-center">@lang('cmn.in')</td>
							<td width="20%" class="text-center">@lang('cmn.out')</td>
						</tr>
						@php $in_sum = 0; $out_sum = 0; @endphp
						@if($trip->expenses)
						@foreach($trip->expenses as $expense)
							@php 
								$in_sum += ($expense->transaction->type=='in')?$expense->transaction->amount:0; 
								$out_sum += ($expense->transaction->type=='out')?$expense->transaction->amount:0;
							@endphp
							<tr>
								<td class="text-center">{{ $expense->transaction->account->user_name }} ({{ $expense->transaction->account->account_number??__('cmn.cash') }}) ({{ $expense->transaction->date }})</td>
								<td class="text-center">{{ $expense->expense->head }}</td>
								<td class="text-center"><b>{{ ($expense->transaction->type=='in')?number_format($expense->transaction->amount):'---' }}</b></td>
								<td class="text-center"><b>{{ ($expense->transaction->type=='out')?number_format($expense->transaction->amount):'---' }}</b></td>
							</tr>
						@endforeach
						@endif

						@if($trip->oilExpenses)
						@foreach($trip->oilExpenses as $oilExpense)
							@php 
								$in_sum += ($oilExpense->transaction->type=='in')?$oilExpense->transaction->amount:0; 
								$out_sum += ($oilExpense->transaction->type=='out')?$oilExpense->transaction->amount:0;
							@endphp
							<tr>
								<td class="text-center">{{ $oilExpense->transaction->account->user_name}} ({{ $oilExpense->transaction->account->account_number??__('cmn.cash') }}) ({{ $oilExpense->transaction->date }})</td>
								<td class="text-center">{{ __('cmn.'.$oilExpense->transaction->for) }}</td>
								<td class="text-center"><b>{{ ($oilExpense->transaction->type=='in')?number_format($oilExpense->transaction->amount):'---' }}</b></td>
								<td class="text-center"><b>{{ ($oilExpense->transaction->type=='out')?number_format($oilExpense->transaction->amount):'---' }}</b></td>
							</tr>
						@endforeach
						@endif

						@if($trip->transactions)
						@foreach($trip->transactions as $trans)
							@php 
								$in_sum += ($trans->type=='in')?$trans->amount:0; 
								$out_sum += ($trans->type=='out')?$trans->amount:0;
							@endphp
							<tr>
								<td class="text-center">{{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})</td>
								<td class="text-center">{{ __('cmn.'.$trans->for) }}</td>
								<td class="text-center"><b>{{ ($trans->type=='in')?number_format($trans->amount):'---' }}</b></td>
								<td class="text-center"><b>{{ ($trans->type=='out')?number_format($trans->amount):'---' }}</b></td>
							</tr>
						@endforeach
						@endif

						{{-- when this page is generate from group wsie then this foreach generate only down trip transection, nothing else --}}
						@if(isset($down_trip) && $down_trip->transactions)
							@foreach($down_trip->transactions as $trans)
								@php 
									$in_sum += ($trans->type=='in')?$trans->amount:0; 
									$out_sum += ($trans->type=='out')?$trans->amount:0;
								@endphp
								<tr>
									<td class="text-center">{{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})</td>
									<td class="text-center">{{ __('cmn.'.$trans->for) }}</small></td>
									<td class="text-center"><b>{{ ($trans->type=='in')?number_format($trans->amount):'---' }}</b></td>
									<td class="text-center"><b>{{ ($trans->type=='out')?number_format($trans->amount):'---' }}</b></td>
								</tr>
							@endforeach
						@endif

						<tr>
							<td class="text-right" colspan="2"><b>@lang('cmn.total') = </b></td>
							<td class='text-center'><b>{{ number_format($in_sum) }}</b></td>
							<td class='text-center'><b>{{ number_format($out_sum) }}</b></td>
						</tr>
					</table>
				</div>
			</div>


			<div class="row">
				<table class="col-md-12 signature-top-margin">
					<tbody>
						<tr style="border: 0px; font-weight: bold">
							<td class="text-left">@lang('cmn.prepared_by')</td>
							<td class="text-center">@lang('cmn.verified_by')</td>
							<td class="text-right">@lang('cmn.approved_by')</td>
						</tr>
					</tbody>
				</table>
			</div>


		</main>
	</body>
</html>