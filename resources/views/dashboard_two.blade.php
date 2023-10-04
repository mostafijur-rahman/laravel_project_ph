@extends('layout')

@push('css')
<style type="text/css">
    .inner{
        background: #fff;
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        border-radius: 10px;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush


@section('content')
<div class="content-wrapper">
    <section class="content-header">
        
    </section>
    <section class="content">

        <!-- filter and company name -->
        <form action="dashboard" action="get" id="form">
            <input type="hidden" name="dashboard" value="two">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="time_range" id="time_range_id" class="form-control" onchange="form_submit()">
                            <option value="today" {{ ($request->time_range == 'today')?'selected':'' }}>@lang('cmn.today')</option>
                            <option value="yesterday" {{ ($request->time_range == 'yesterday')?'selected':'' }}>@lang('cmn.yesterday')</option>
                            <option value="last_one_week" {{ ($request->time_range == 'last_one_week')?'selected':'' }}>@lang('cmn.last_one_week')</option>
                            <option value="last_fifteen_days" {{ ($request->time_range == 'last_fifteen_days')?'selected':'' }}>@lang('cmn.last_fifteen_days')</option>
                            <option value="last_thirty_days" {{ ($request->time_range == 'last_thirty_days')?'selected':'' }}>@lang('cmn.last_thirty_days')</option>                                
                            <option value="last_ninety_days" {{ ($request->time_range == 'last_ninety_days')?'selected':'' }}>@lang('cmn.last_ninety_days')</option>
                            <option value="all_time" {{ ($request->time_range == 'all_time')?'selected':'' }}>@lang('cmn.all_time')</option>
                            <option value="date_wise" {{ ($request->time_range == 'date_wise')?'selected':'' }}>@lang('cmn.date_wise')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3" id="daterange_field" style="display: {{ $display }};">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation" name="daterange" value="{{old('daterange', $request->daterange)}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="submit_button" style="display: {{ $display }};">
                    <div class="form-group">
                        <button type="button" class="btn btn-sm btn-primary" onclick="submit()">
                            @lang('cmn.search')
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">

            <div class="col-md-12">
                <div class="row justify-content-center">
                    <h4>@setting('client_system.company_name') ({{ $title }})</h4>                        
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">

                    {{-- <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Sales</h3>
                            <a href="{{ url('dashboard?time_range=all_time&dashboard=one') }}">@lang('cmn.old') @lang('cmn.dashboard')</a>
                        </div>
                    </div> --}}

                    <div class="card-body">

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                {{-- <span class="text-bold text-lg">0</span>
                                <span>@lang('cmn.total') @lang('cmn.deposit')</span> --}}
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <a href="{{ url('dashboard?time_range=all_time&dashboard=one') }}">@lang('cmn.old') @lang('cmn.dashboard')</a>
                                {{-- <span class="text-success">
                                <i class="fas fa-arrow-up"></i> 33.1%
                                </span>
                                <span class="text-muted">Since last month</span> --}}
                            </p>
                        </div>
    
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>
    
                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-success"></i> @lang('cmn.deposit')
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-square" style="color: #ffadad !important"></i> @lang('cmn.expense')
                            </span>
                            <span>
                                <i class="fas fa-square text-warning"></i> @lang('cmn.due')
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <span class="nav-link"><b>@lang('cmn.deposit')</b>
                                    <span class="float-right text-success"><b>{{ number_format($pie_deposit) }}</b></span>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link"><b>@lang('cmn.expense')</b>
                                    <span class="float-right" style="color: #ffadad !important"><b>{{ number_format($pie_expense) }}</b></span>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link"><b>@lang('cmn.due')</b>
                                    <span class="float-right text-warning"><b>{{ number_format($pie_due) }}</b></span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <!-- /.footer -->
                </div>

            </div>

            <!-- table -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-bordered text-center table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>@lang('cmn.type_of_account')</th>
                                    <th>@lang('cmn.qty')</th>

                                    <th>@lang('cmn.contract_rent')</th>
                                    <th>@lang('cmn.advance_received')</th>
                                    <th>@lang('cmn.after_advance')</th>
                                    <th>@lang('cmn.due')</th>

                                    {{-- <th>@lang('cmn.demurrage_bill')</th> --}}
                                    <th>@lang('cmn.demurrage_received')</th>
                                    {{-- <th>@lang('cmn.demurrage_due')</th> --}}
                                
                                    <th>@lang('cmn.deposit')</th>
                                    <th>@lang('cmn.expense')</th>
                                    <th>@lang('cmn.oil_expense')</th>
                                    <th>@lang('cmn.balance')</th>

                                    <th>@lang('cmn.liter')</th>
                                    <th>@lang('cmn.distance_without_km')</th>
                                    <th>@lang('cmn.mileage')</th>

                                </tr>
                            </thead>

                            

                            <tbody>
                                <tr>
                                    <td>@lang('cmn.single_challan')</td>
                                    <td>{{ number_format($single_challan_qty) }}</td>

                                    <td>{{ number_format($single_challan_contract_rent) }}</td>
                                    <td>{{ number_format($single_advance_received) }} </td>
                                    <td>{{ number_format($single_after_advance) }}</td>
                                    <td>{{ number_format($single_challan_due) }}</td>

                                    {{-- <td>demurrage_bill</td> --}}
                                    <td>{{ number_format($single_demurrage_received) }}</td>
                                    {{-- <td>demurrage_due</td> --}}

                                    <td>{{ number_format($single_challan_deposit) }}</td>
                                    <td>{{ number_format($single_challan_expense) }}</td>
                                    <td>{{ number_format($single_challan_oil_expense) }}</td>
                                    <td>{{ number_format($single_challan_balance) }}</td>

                                    <td>{{ number_format($single_challan_liter) }}</td>
                                    <td>{{ number_format($single_challan_distance) }}</td>
                                    <td>{{ number_format($single_challan_mileage) }}</td>
        
                                </tr>
                                <tr>
                                    <td>@lang('cmn.up_down_challan')</td>
                                    <td>{{ number_format($up_down_challan_qty) }}</td>

                                    <td>{{ number_format($up_down_challan_contract_rent) }}</td>
                                    <td>{{ number_format($up_down_advance_received) }}</td>
                                    <td>{{ number_format($up_down_after_advance) }}</td>
                                    <td>{{ number_format($up_down_challan_due) }}</td>

                                    {{-- <td>demurrage_bill</td> --}}
                                    <td>{{ number_format($up_down_demurrage_received) }}</td>
                                    {{-- <td>demurrage_due</td> --}}

                                    <td>{{ number_format($up_down_challan_deposit) }}</td>
                                    <td>{{ number_format($up_down_challan_expense) }}</td>
                                    <td>{{ number_format($up_down_challan_oil_expense) }}</td>
                                    <td>{{ number_format($up_down_challan_balance) }}</td>

                                    <td>{{ number_format($up_down_challan_liter) }}</td>
                                    <td>{{ number_format($up_down_challan_distance) }}</td>
                                    <td>{{ number_format($up_down_challan_mileage) }}</td>

                                </tr>
                                <tr>
                                    <td>@lang('cmn.other') @lang('cmn.expense')</td>
                                    <td>---</td>

                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>

                                    <td>---</td>

                                    <td>---</td>
                                    <td>{{ number_format($outside_general_expense_of_trip) }}</td>
                                    <td>{{ number_format($outside_oil_expense_of_trip) }}</td>
                                    <td>---</td>

                                    <td>{{ number_format($outside_oil_liter_of_trip) }}</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td class="text-right"><b>@lang('cmn.total') =</b></td>
                                    <td><b>{{ number_format($single_challan_qty + $up_down_challan_qty) }}</b></td>

                                    <td><b>{{ number_format($single_challan_contract_rent + $up_down_challan_contract_rent) }}</b></td>
                                    <td><b>{{ number_format($single_advance_received + $up_down_advance_received) }}</b></td>
                                    <td><b>{{ number_format($single_after_advance + $up_down_after_advance) }}</b></td>
                                    <td><b>{{ number_format($single_challan_due + $up_down_challan_due) }}</b></td>

                                    <td><b>{{ number_format($single_demurrage_received + $up_down_demurrage_received) }}</b></td>

                                    <td><b>{{ number_format($single_challan_deposit + $up_down_challan_deposit) }}</b></td>
                                    <td><b>{{ number_format($single_challan_expense + $up_down_challan_expense + $outside_general_expense_of_trip) }}</b></td>
                                    <td><b>{{ number_format($single_challan_oil_expense + $up_down_challan_oil_expense + $outside_oil_expense_of_trip) }}</b></td>
                                    <td><b>{{ number_format($single_challan_balance + $up_down_challan_balance) }}</b></td>
                                    
                                    <td><b>{{ number_format($single_challan_liter + $up_down_challan_liter + $outside_oil_liter_of_trip) }}</b></td>
                                    <td><b>{{ number_format($single_challan_distance + $up_down_challan_distance) }}</b></td>
                                    <td><b>{{ number_format($single_challan_mileage + $up_down_challan_mileage) }}</b></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection


@push('js')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    function form_submit(){
        let time = document.getElementById('time_range_id').value;

        if(time == 'date_wise'){
            document.getElementById('daterange_field').style.display = "block";
            document.getElementById('submit_button').style.display = "block";

        } else {
            document.getElementById('daterange_field').style.display = "none";
            document.getElementById('submit_button').style.display = "none";

            event.preventDefault();
            document.getElementById('form').submit();
        }
    }

    function submit(){
        event.preventDefault();
        document.getElementById('form').submit();
    }
    $(function () {
        $('#reservation').daterangepicker();
    })
</script>

<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<script>
/* global Chart:false */
$(function() {
  'use strict'

  var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
          labels:  @json($sales_labels),
          datasets: [{
                  backgroundColor: '#28a745',
                  borderColor: '#28a745',
                  data: @json($final_deposit_sums)
              },
              {
                  backgroundColor: '#ffadad',
                  borderColor: '#ffadad',
                  data: @json($final_expense_sums)
              },
              {
                  backgroundColor: '#ffc107',
                  borderColor: '#ffc107',
                  data: @json($final_due_sums)
              }
          ]
      },
      options: {
          maintainAspectRatio: false,
          tooltips: {
              mode: mode,
              intersect: intersect
          },
          hover: {
              mode: mode,
              intersect: intersect
          },
          legend: {
              display: false
          },
          scales: {
              yAxes: [{
                  // display: false,
                  gridLines: {
                      display: true,
                      lineWidth: '4px',
                      color: 'rgba(0, 0, 0, .2)',
                      zeroLineColor: 'transparent'
                  },
                  ticks: $.extend({
                      beginAtZero: true,

                      // Include a dollar sign in the ticks
                      callback: function(value) {
                          if (value >= 1000) {
                              value /= 1000
                              value += 'k'
                          }

                          return '৳ ' + value
                      }
                  }, ticksStyle)
              }],
              xAxes: [{
                  display: true,
                  gridLines: {
                      display: false
                  },
                  ticks: ticksStyle
              }]
          }
      }
  })


})
// lgtm [js/unused-local-variable]
</script>

<script>
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = {
        labels: @json($pie_labels),
        datasets: [{
            data: @json($pie_datas),
            backgroundColor: @json($pie_colors)
        }]
    }
    var pieOptions = {
        legend: {
            display: false
        }
    }
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // eslint-disable-next-line no-unused-vars
    var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions
    })
</script>
@endpush