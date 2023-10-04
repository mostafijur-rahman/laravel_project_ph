@extends('print.PrintLayout')

@php $view = ['landscape']; @endphp

@section('body')
<div class="row">
    <div class="col-sm-12">
        <h4 class="element-header text-center">
            <b>@lang('cmn.deposit_expense') @lang('cmn.accounts') ({{(isset($date_show))?$date_show:''}})</b>
        </h4>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="element-header text-center"><b>জমা</b></h4>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td width="5%" class="text-center">ক্রমিক নং</td>
                        <td width="50%" class="text-center">বিবরণ</td>
                        <td width="15%" class="text-center">পূর্বের স্থিতি</td>
                        <td width="15%" class="text-center">চলতি</td>
                        <td width="15%" class="text-center">মোট</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">পরিবহন প্রকল্প (আয়)</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">মোট</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">আগত তহবিল</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">সর্বমোট</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>  
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="element-header text-center"><b>খরচ</b></h4>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td width="5%" class="text-center">ক্রমিক নং</td>
                        <td width="50%" class="text-center">বিবরণ</td>
                        <td width="15%" class="text-center">পূর্বের স্থিতি</td>
                        <td width="15%" class="text-center">চলতি</td>
                        <td width="15%" class="text-center">মোট</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">ডিজেল</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    @php
                    $exp_prev_total = 0;
                    $exp_running_total = 0;
                    $exp_total = 0;
                    @endphp
                    <!-- project expense -->
                    @foreach($project_expenses as $proj_exp_key => $proj_exp)
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">{{ $proj_exp->project_exp_head }}</td>
                        @php
                        $proj_exp_prev[$proj_exp_key] = get_expense_sum_by_exp_type_exp_id_and_daterange('project', $proj_exp->project_exp_id, $request['daterange'], 'previous')+0;
                        $proj_exp_running[$proj_exp_key] = get_expense_sum_by_exp_type_exp_id_and_daterange('project', $proj_exp->project_exp_id, $request['daterange'], 'running')+0; 
                        @endphp
                        <td class="text-center">{{ $proj_exp_prev[$proj_exp_key] }}</td>
                        @php $exp_prev_total +=  $proj_exp_prev[$proj_exp_key]; @endphp
                        <td class="text-center">{{ $proj_exp_running[$proj_exp_key] }}</td>
                        @php $exp_running_total += $proj_exp_running[$proj_exp_key]; @endphp
                        <td class="text-center">{{ $proj_exp_prev[$proj_exp_key] + $proj_exp_running[$proj_exp_key] }}</td>
                        @php $exp_total += $proj_exp_prev[$proj_exp_key] + $proj_exp_running[$proj_exp_key]; @endphp
                    </tr>
                    @endforeach
                    <!-- common expense -->
                    @foreach($common_expenses as $cmn_exp_key => $cmn_exp)
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">{{ $cmn_exp->exp_head }}</td>
                        @php
                        $cmn_exp_prev[$proj_exp_key] = get_expense_sum_by_exp_type_exp_id_and_daterange('cmn', $cmn_exp->exp_id, $request['daterange'], 'previous')+0;
                        $cmn_exp_running[$proj_exp_key] = get_expense_sum_by_exp_type_exp_id_and_daterange('cmn', $cmn_exp->exp_id, $request['daterange'], 'running')+0;
                        @endphp
                        <td class="text-center">{{ $cmn_exp_prev[$proj_exp_key] }}</td>
                        @php $exp_prev_total += $cmn_exp_prev[$proj_exp_key]; @endphp
                        <td class="text-center">{{ $cmn_exp_running[$proj_exp_key] }}</td>
                        @php $exp_running_total += $cmn_exp_running[$proj_exp_key]; @endphp
                        <td class="text-center">{{ $cmn_exp_prev[$proj_exp_key] + $cmn_exp_running[$proj_exp_key] }}</td>
                        @php $exp_total += $cmn_exp_prev[$proj_exp_key] + $cmn_exp_running[$proj_exp_key]; @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>

                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">মোট</td>
                        <td class="text-center">{{ $exp_prev_total }}</td>
                        <td class="text-center">{{ $exp_running_total }}</td>
                        <td class="text-center">{{ $exp_total }}</td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">ক্যাশ</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">সর্বমোট</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                </tbody>
            </table>
        </div>  
    </div>
</div>


@endsection