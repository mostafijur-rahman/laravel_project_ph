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
                            <td width="30%">@lang('cmn.primary_info')</td>
                            <td width="40%">গাড়ীর লেনদেন</td>
                            <td width="30%">কোম্পানীর লেনদেন</td>
                        </tr>
                    
                        @if(count($trips)>0)
                        @foreach($trips as $trip)
                        <tr class="item">
                            <td class="text-left">
                                <small>
                                    @if($trip->account_take_date)
                                        @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                    @endif
                                    @lang('cmn.trip_number'): <b>{{ $trip->number }}</b><br>
                                    @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b><br>
                                    @lang('cmn.driver'): <b>{{ $trip->provider->driver_name }}({{ $trip->provider->driver_phone }})</b><br>
                                    @lang('cmn.owner'): <b>{{ $trip->provider->owner_name }}({{ $trip->provider->owner_phone }})</b><br>
                                    @lang('cmn.reference'): <b>{{ $trip->provider->reference_name }}({{ $trip->provider->reference_phone }})</b><br>
                                    @if($trip->meter->previous_reading)
                                        @lang('cmn.start_reading'): <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
                                        @lang('cmn.last_reading'): <b>{{ number_format($trip->meter->current_reading) }}</b><br>
                                        @lang('cmn.total') @lang('cmn.km'): <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
                                        @lang('cmn.total') @lang('cmn.fuel'): <b>{{ number_format($tripOilLiterSumByGroupId) }}</b><br>
                                        @if($tripOilLiterSumByGroupId > 0)
                                            @lang('cmn.liter_per_km'): <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}</b><br>
                                        @endif
                                    @endif
                                    @lang('cmn.created'): <b>{{ $trip->user->first_name}}</b><br>
                                    {{-- <div class="row">
                                        <div class="btn-group">
                                            <a href="{{ url('trip-report?type=chalan&group_id='. $trip->group_id) }}" class="btn btn-warning btn-xs" target="_blank" aria-label="Trip Chalan"><i class="fa fa-fw fa-print"></i> @lang('cmn.chalan')</a>
                                        </div>
                                    </div> --}}
                                </small>
                            </td>
                            <td class="text-left">
                                <small>
                                @if($trip->getTripsByGroupId)
                                    @php $tripLastKey = count($trip->getTripsByGroupId); @endphp
                                    @foreach($trip->getTripsByGroupId as $tripKey => $trip_info)
                                        @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip_info->date)) }}</b><br>
                                        @lang('cmn.load_point'):
                                        @if($trip_info->points)
                                        @php $lastKey = count($trip_info->points); @endphp
                                        @foreach($trip_info->points as $key => $point)
                                            @if($point->pivot->point == 'load')
                                            <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                            @endif
                                        @endforeach
                                        @endif
                                        <br>
                                        @lang('cmn.unload_point'):
                                        @if($trip_info->points)
                                        @php $lastKey = count($trip_info->points); @endphp
                                        @foreach($trip_info->points as $key => $point)
                                            @if($point->pivot->point == 'unload')
                                            <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                            @endif
                                        @endforeach
                                        @endif
                                        <br>
                                        @lang('cmn.contract_rent'): <b>{{ number_format($trip_info->provider->contract_fair) }}</b><br>
                                        @if($trip_info->provider->received_fair==0)
                                        @lang('cmn.addv_pay'): <b>{{ number_format($trip_info->provider->advance_fair) }}</b><br>
                                        @else
                                        @lang('cmn.total_pay'): <b>{{ number_format($trip_info->provider->advance_fair+$trip_info->provider->received_fair) }}</b><br>
                                        @endif
                                        @if($trip_info->provider->due_fair>0)
                                        </small>
                                        <span class="text-danger"> 
                                            @lang('cmn.challan_due'): <b>{{ number_format($trip_info->provider->due_fair) }}</b><br>
                                        </span>
                                        <small>
                                        @else
                                        @lang('cmn.challan_due'): <b>{{ number_format($trip_info->provider->due_fair) }}</b><br>
                                        @endif
                                        @lang('cmn.demarage_fixed'): <b>{{ number_format($trip_info->provider->demarage) }}</b><br>
                                        @lang('cmn.demarage_paid'): <b>{{ number_format($trip_info->provider->demarage_received) }}</b><br>
                                        @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->provider->demarage_due) }}</b><br>
                                        @lang('cmn.discount'): <b>{{ number_format($trip_info->provider->deduction_fair) }}</b><br>
                                        @lang('cmn.goods'): <b>{{ $trip_info->goods }}</b>
                                    @endforeach
                                @endif
                                </small>
                            </td>
                            <td class="text-left">
                                <small>
                                    @lang('cmn.company'): <b>{{ $trip_info->company->company->name }}</b><br>
                                    @lang('cmn.contract_rent'): <b>{{ number_format($trip_info->company->contract_fair) }}</b><br>
                                    @if($trip_info->company->received_fair==0)
                                    @lang('cmn.addv_recev'): <b>{{ number_format($trip_info->company->advance_fair) }}</b><br>
                                    @else
                                    @lang('cmn.total_recev'): <b>{{ number_format($trip_info->company->advance_fair+$trip_info->company->received_fair) }}</b><br>
                                    @endif
                                    @if($trip_info->company->due_fair>0)
                                    </small>
                                    <span class="text-danger"> 
                                        @lang('cmn.challan_due'): <b>{{ number_format($trip_info->company->due_fair) }}</b><br>
                                    </span>
                                    <small>
                                    @else
                                    @lang('cmn.challan_due'): <b>{{ number_format($trip_info->company->due_fair) }}</b><br>
                                    @endif
                                    @if($trip_info->company->demarage > $trip_info->company->demarage_received)
                                    </small>
                                    <span class="text-danger"> 
                                        @lang('cmn.demarage_charge'): <b>{{ number_format($trip_info->company->demarage) }}</b><br>
                                    </span>
                                    <small>
                                    @else
                                    @lang('cmn.demarage_charge'): <b>{{ number_format($trip_info->company->demarage) }}</b><br>
                                    @endif
                                    @lang('cmn.demarage_received'): <b>{{ number_format($trip_info->company->demarage_received) }}</b><br>
                                    @lang('cmn.demarage_due'): <b>{{ number_format($trip_info->company->demarage_due) }}</b><br>
                                    @lang('cmn.discount'): <b>{{ number_format($trip_info->company->deduction_fair) }}</b><br>
                                    কার্টুন সংখ্যা: <b>{{ number_format($trip_info->box) }} টি</b><br>
                                    ওজন: <b>{{ number_format($trip_info->weight) }} {{ $trip_info->unit->name }}</b><br>
                                </small>
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center text-red"><h4>@lang('cmn.empty_table')</h4>
                    </tr>
                     @endif
                </table>
			</div>
		</main>
	</body>
</html>