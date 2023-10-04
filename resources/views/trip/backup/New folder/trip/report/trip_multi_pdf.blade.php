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
                        <td width="30%">গাড়ীর লেনদেন</td>
                        @endif
                        @if($request->has('company_transection') && $request->has('company_transection') == 'on')
                        <td width="20%">কোম্পানীর লেনদেন</td>
                        @endif
                        @if($request->has('comission') && $request->has('comission') == 'on')
                        <td width="20%">কমিশন</td>
                        @endif
                        @if($request->has('trip_deposit_expense') && $request->has('trip_deposit_expense') == 'on')
                        <td width="20%">নিজেস্ব ট্রিপের জমা - খরচ</td>
                        @endif
                    </tr>
                    @if(count($trips)>0)
                        @foreach($trips as $trip)
                        <tr>
                            @if($request->has('primary_info') && $request->has('primary_info') == 'on')
                            <td class="text-left">
                                @if($trip->account_take_date)
                                    @lang('cmn.posting_date'): <b>{{ date('d M, Y', strtotime($trip->account_take_date)) }}</b><br>
                                @endif
                                @lang('cmn.challan_no'): <b>{{ $trip->number }}</b><br>
                                @if ($trip->provider->vehicle_id)
                                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle->vehicle_number }}</b> <span class="btn btn-xs btn-success">@lang('cmn.own')</span><br>
                                @lang('cmn.driver'): <b>{{ $trip->provider->vehicle->driver->name }} ({{ $trip->provider->vehicle->driver->phone }})</b><br>
                                @else
                                @lang('cmn.vehicle'): <b>{{ $trip->provider->vehicle_number }}</b> <span class="btn btn-xs btn-warning">@lang('cmn.from_market')</span><br>
                                @lang('cmn.driver'): <b>{{ $trip->provider->driver_name??'---' }} {{ $trip->provider->driver_phone?'('.$trip->provider->driver_phone.')':'' }}</b><br>
                                @lang('cmn.owner'): <b>{{ $trip->provider->owner_name??'---' }} {{ $trip->provider->owner_phone?'('.$trip->provider->owner_phone.')':'' }}</b><br>
                                @lang('cmn.reference'): <b>{{ $trip->provider->reference_name??'---' }} {{ $trip->provider->reference_phone?'('.$trip->provider->reference_phone.')':'' }}</b><br>
                                @endif
                                @if($trip->meter->previous_reading)
                                    @lang('cmn.start_reading'): <b>{{ number_format($trip->meter->previous_reading) }}</b><br>
                                    @lang('cmn.last_reading'): <b>{{ number_format($trip->meter->current_reading) }}</b><br>
                                    @lang('cmn.total') @lang('cmn.km'): <b>{{ number_format($trip->meter->current_reading - $trip->meter->previous_reading) }}</b><br>
                                    @php $tripOilLiterSumByGroupId = tripOilLiterSumByGroupId($trip->group_id); @endphp 
                                    @lang('cmn.total') @lang('cmn.fuel'): <b>{{ number_format($tripOilLiterSumByGroupId) }}</b><br>
                                    @if($tripOilLiterSumByGroupId > 0)
                                        @lang('cmn.liter_per_km'): <b>{{ number_format(($trip->meter->current_reading - $trip->meter->previous_reading)/$tripOilLiterSumByGroupId, 2) }}</b><br>
                                    @endif
                                @endif
                                @lang('cmn.posted_by'): <br>
                                <b>{{ $trip->user->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->created_at)) }})</b>
                                @if($trip->updated_at)
                                    <br>
                                    @if($trip->updated_by)
                                        @lang('cmn.post_updated_by'): <br>
                                        <b>{{ $trip->user_update->first_name}} ({{ date('d M, Y H:m A', strtotime($trip->updated_at)) }})</b>
                                    @endif
                                @endif
                                @if($trip && $trip->note)
                                <div class="row mt-2">
                                    @lang('cmn.note'): <b>{{ $trip->note }}</b>
                                </div>
                                @endif
                            </td>
                            @endif
                            @if($request->has('vehicle_transection') && $request->has('vehicle_transection') == 'on')
                            <td class="text-left">
                                @lang('cmn.start_date'): <b> {{ date('d M, Y', strtotime($trip->date)) }}</b><br>
                                @lang('cmn.load_point'): <br>
                                @if($trip->points)
                                @php $lastKey = count($trip->points); @endphp
                                @foreach($trip->points as $key => $point)
                                    @if($point->pivot->point == 'load')
                                    <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                    @endif
                                @endforeach
                                @endif
                                <br>
                                @lang('cmn.unload_point'): <br>
                                @if($trip->points)
                                @php $lastKey = count($trip->points); @endphp
                                @foreach($trip->points as $key => $point)
                                    @if($point->pivot->point == 'unload')
                                    <b>{{ $point->name }} {{($key == $lastKey)?'':'+ ' }}</b>
                                    @endif
                                @endforeach
                                @endif
                                <br>
                                @lang('cmn.contract_rent'): <b>{{ number_format($trip->provider->contract_fair) }}</b><br>
                                @if($trip->provider->received_fair==0)
                                @lang('cmn.addv_pay'): <b>{{ number_format($trip->provider->advance_fair) }}</b><br>
                                @else
                                @lang('cmn.total_pay'): <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b><br>
                                @endif
                                @if($trip->provider->due_fair>0)
                                </small>
                                <span class="text-danger"> 
                                    @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b><br>
                                </span>
                                <small>
                                @else
                                @lang('cmn.challan_due'): <b>{{ number_format($trip->provider->due_fair) }}</b><br>
                                @endif
                                @lang('cmn.demarage_fixed'): <b>{{ number_format($trip->provider->demarage) }}</b><br>
                                @lang('cmn.demarage_paid'): <b>{{ number_format($trip->provider->demarage_received) }}</b><br>
                                @if($trip->provider->demarage_due>0)
                                </small>
                                <span class="text-danger"> 
                                    @lang('cmn.demarage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b><br>
                                </span>
                                <small>
                                @else
                                @lang('cmn.demarage_due'): <b>{{ number_format($trip->provider->demarage_due) }}</b><br>
                                @endif
                                @lang('cmn.discount'): <b>{{ number_format($trip->provider->deduction_fair) }}</b><br>
                                @lang('cmn.goods'): <b>{{ $trip->goods }}</b><br>
                            </td>
                            @endif
                            @if($request->has('company_transection') && $request->has('company_transection') == 'on')
                            <td class="text-left">
                                    <b>{{ $trip->company->company->name }}</b><br>
                                    @lang('cmn.contract_rent'): <b>{{ number_format($trip->company->contract_fair) }}</b><br>
                                    @if($trip->company->received_fair==0)
                                    @lang('cmn.addv_recev'): <b>{{ number_format($trip->company->advance_fair) }}</b><br>
                                    @else
                                    @lang('cmn.total_recev'): <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b><br>
                                    @endif
                                    @if($trip->company->due_fair>0)
                                    </small>
                                    <span class="text-danger"> 
                                        @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b><br>
                                    </span>
                                    <small>
                                    @else
                                    @lang('cmn.challan_due'): <b>{{ number_format($trip->company->due_fair) }}</b><br>
                                    @endif
                                    @if($trip->company->demarage > $trip->company->demarage_received)
                                    </small>
                                    <span class="text-danger"> 
                                        @lang('cmn.demarage_charge'): <b>{{ number_format($trip->company->demarage) }}</b><br>
                                    </span>
                                    <small>
                                    @else
                                    @lang('cmn.demarage_charge'): <b>{{ number_format($trip->company->demarage) }}</b><br>
                                    @endif
                                    @lang('cmn.demarage_received'): <b>{{ number_format($trip->company->demarage_received) }}</b><br>
                                    @if($trip->company->demarage_due>0)
                                    </small>
                                    <span class="text-danger"> 
                                        @lang('cmn.demarage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b><br>
                                    </span>
                                    <small>
                                    @else
                                    @lang('cmn.demarage_due'): <b>{{ number_format($trip->company->demarage_due) }}</b><br>
                                    @endif
                                    @lang('cmn.discount'): <b>{{ number_format($trip->company->deduction_fair) }}</b><br>
                                    কার্টুন সংখ্যা: <b>{{ number_format($trip->box) }} টি</b><br>
                                    ওজন: <b>{{ number_format($trip->weight) }} {{ $trip->unit->name }}</b><br>
                                
                            </td>
                            @endif
                            @if($request->has('comission') && $request->has('comission') == 'on')
                            <td class="text-right">
                                @lang('cmn.contract_commission') = <b>{{ number_format($trip->company->contract_fair - $trip->provider->contract_fair) }}</b><br>
                                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                    কোম্পানী থেকে গ্রহণ = <b>{{ number_format($trip->company->advance_fair+$trip->company->received_fair) }}</b><br>
                                    ভাড়া বাবদ প্রদান = <b>{{ number_format($trip->provider->advance_fair+$trip->provider->received_fair) }}</b><br>
                                </div>
                                <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                    @lang('cmn.commission_received') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair) - ($trip->provider->advance_fair+$trip->provider->received_fair)) }}</b><br>
                                    @lang('cmn.demarage_commission') = <b>{{ number_format($trip->company->demarage_received - $trip->provider->demarage_received) }}</b><br>
                                </div>
                                @lang('cmn.total_commission') = <b>{{ number_format(($trip->company->advance_fair+$trip->company->received_fair+$trip->company->demarage_received) - ($trip->provider->advance_fair+$trip->provider->received_fair+$trip->provider->demarage_received)) }}</b><br>
                                {{-- (@lang('cmn.challan_due') = <b>---</b>, @lang('cmn.discount') = <b>---</b>) --}}
                                
                                <br>
                                @if($trip->provider->vehicle_id)
                                    <b>(শুধু ট্রিপের লেনদেন)</b><br>
                                   
                                        @php $in_sum = 0; $out_sum = 0; @endphp
                                        <!-- trip -->
                                        @if($trip->transactions)
                                        @foreach($trip->transactions as $trans)
                                            @php 
                                                $in_sum += ($trans->type=='in')?$trans->amount:0; 
                                                $out_sum += ($trans->type=='out')?$trans->amount:0;
                                            @endphp
                                            {{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})<br>
                                            @switch($trans->for)
                                                @case('advance_has_been_received_from_the_company_for_the_trip')
                                                    কোম্পানী থেকে অগ্রীম গ্রহণ =
                                                    @break
                                                @case('challan_bill_has_been_received_from_the_company_for_the_trip')
                                                    কোম্পানী থেকে চালান বাকী গ্রহণ =
                                                    @break
                                                @case('demarage_has_been_received_from_the_company_for_the_trip')
                                                    কোম্পানী থেকে ডেমারেজ বিল গ্রহণ =
                                                    @break
                                                @case('the_vehicle_provider_has_been_paid_in_advance_for_the_trip')
                                                    প্রদানকারীকে অগ্রীম প্রদান =
                                                    @break
                                                @case('the_vehicle_provider_has_been_paid_the_challan_due_for_the_trip')
                                                    প্রদানকারীকে চালান বাকী প্রদান =
                                                    @break
                                                @case('the_vehicle_provider_has_been_paid_demarage_for_the_trip')
                                                    প্রদানকারীকে ডেমারেজ বিল প্রদান =
                                                    @break
                                                @default
                                                    <span>লেনদেনের নাম নেই</span>
                                            @endswitch
                                            <b class='text-green'>{{ ($trans->type=='in')?number_format($trans->amount):'' }}</b>
                                            <b class='text-danger'>{{ ($trans->type=='out')?number_format($trans->amount):'' }}</b>
                                            <br>
                                        @endforeach
                                        @endif
                                    
                                @endif
                            </td>
                            @endif
                            @if($request->has('trip_deposit_expense') && $request->has('trip_deposit_expense') == 'on')
                            <td class="text-right">
                                @if($trip->provider->ownership == 'own')
                                    @php
                                        $tripOilLiterSumByGroupId = tripOilLiterSumByTripId($trip->id);
                                        $total_general_expense_sum = tripExpenseSumByTripId($trip->id);
                                        $total_oil_bill_sum =  tripOilBillSumByTripId($trip->id);
                                        $total_received_rent =  $trip->provider->advance_fair + $trip->provider->received_fair;
                                        $trip_general_exp_lists = tripExpenseListSumByTripId($trip->id);
                                    @endphp
                                   
                                        @if ($total_oil_bill_sum>0)
                                        <b>@lang('cmn.fuel') =</b> {{ number_format($total_oil_bill_sum) }} ({{  number_format($tripOilLiterSumByGroupId) }} @lang('cmn.li'))<br>
                                        @endif
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            @if($trip_general_exp_lists)
                                                @foreach($trip_general_exp_lists as $i => $trip_general_exp_list)
                                                {{ $trip_general_exp_list->head }} = <b>{{ number_format($trip_general_exp_list->trip_single_expense_sum) }}</b><br>
                                                @endforeach
                                        </div>
                                        @lang('cmn.total_expense') = <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b>
                                            @endif
                                    
                                    @if ($total_oil_bill_sum>0 || $total_general_expense_sum>0)
                                    <br>
                                    <hr>
                                    @endif
                                    
                                        <div style="border-bottom: 2px dashed grey; margin-left: 16px;">
                                            @lang('cmn.rent') = <b>{{ number_format($total_received_rent) }}</b><br>
                                            @lang('cmn.total_expense') = <b>{{ number_format($total_general_expense_sum+$total_oil_bill_sum) }}</b><br>
                                        </div>
                                        @lang('cmn.net_income') = <b>{{ $net_income = number_format($total_received_rent-($total_general_expense_sum+$total_oil_bill_sum)) }}</b><br>
                                        (@lang('cmn.challan_due') = <b>{{ number_format($trip->provider->due_fair) }}</b>, @lang('cmn.discount') = <b>{{ number_format($trip->provider->deduction_fair) }}</b>)
                                  
                                @else
                                    <b>(শুধু ট্রিপের লেনদেন)</b><br>
                                   
                                        @php $in_sum = 0; $out_sum = 0; @endphp
                                        <!-- trip -->
                                        @if($trip->transactions)
                                        @foreach($trip->transactions as $trans)
                                            @php 
                                                $in_sum += ($trans->type=='in')?$trans->amount:0; 
                                                $out_sum += ($trans->type=='out')?$trans->amount:0;
                                            @endphp
                                            {{ $trans->account->user_name}} ({{ $trans->account->account_number??__('cmn.cash') }}) ({{ $trans->date }})<br>
                                            @switch($trans->for)
                                                @case('advance_has_been_received_from_the_company_for_the_trip')
                                                    কোম্পানী থেকে অগ্রীম গ্রহণ =
                                                    @break
                                                @case('challan_bill_has_been_received_from_the_company_for_the_trip')
                                                    কোম্পানী থেকে চালান বাকী গ্রহণ =
                                                    @break
                                                @case('demarage_has_been_received_from_the_company_for_the_trip')
                                                    কোম্পানী থেকে ডেমারেজ বিল গ্রহণ =
                                                    @break
                                                @case('the_vehicle_provider_has_been_paid_in_advance_for_the_trip')
                                                    প্রদানকারীকে অগ্রীম প্রদান =
                                                    @break
                                                @case('the_vehicle_provider_has_been_paid_the_challan_due_for_the_trip')
                                                    প্রদানকারীকে চালান বাকী প্রদান =
                                                    @break
                                                @case('the_vehicle_provider_has_been_paid_demarage_for_the_trip')
                                                    প্রদানকারীকে ডেমারেজ বিল প্রদান =
                                                    @break
                                                @default
                                                    <span>লেনদেনের নাম নেই</span>
                                            @endswitch
                                            <b class='text-green'>{{ ($trans->type=='in')?number_format($trans->amount):'' }}</b>
                                            <b class='text-danger'>{{ ($trans->type=='out')?number_format($trans->amount):'' }}</b>
                                            <br>
                                        @endforeach
                                        @endif
                                    
                                @endif
                            </td>
                            @endif
                        </tr>
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