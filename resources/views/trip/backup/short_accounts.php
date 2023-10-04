<!-- expense -->
@if($trip->expenses)
                                        @foreach($trip->expenses as $expense)
                                            @php 
                                                $in_sum += ($expense->transaction->type=='in')?$expense->transaction->amount:0; 
                                                $out_sum += ($expense->transaction->type=='out')?$expense->transaction->amount:0;
                                            @endphp
                                            {{ $expense->transaction->account->user_name }} ({{ $expense->transaction->account->account_number??__('cmn.cash') }}) ({{ $expense->transaction->date }})<br>
                                            {{ $expense->expense->head }} =
                                            <b class='text-green'>{{ ($expense->transaction->type=='in')?number_format($expense->transaction->amount):'' }}</b>
                                            <b class='text-danger'>{{ ($expense->transaction->type=='out')?number_format($expense->transaction->amount):'' }}</b>
                                            <br>
                                        @endforeach
                                        @endif
                                        <!-- oil expense -->
                                        @if($trip->oilExpenses)
                                        @foreach($trip->oilExpenses as $oilExpense)
                                            @php 
                                                $in_sum += ($oilExpense->transaction->type=='in')?$oilExpense->transaction->amount:0; 
                                                $out_sum += ($oilExpense->transaction->type=='out')?$oilExpense->transaction->amount:0;
                                            @endphp
                                            {{ $oilExpense->transaction->account->user_name}} ({{ $oilExpense->transaction->account->account_number??__('cmn.cash') }}) ({{ $oilExpense->transaction->date }})<br>
                                            {{ __('cmn.'.$oilExpense->transaction->for) }} =
                                            <b class='text-green'>{{ ($oilExpense->transaction->type=='in')?number_format($oilExpense->transaction->amount):'' }}</b>
                                            <b class='text-danger'>{{ ($oilExpense->transaction->type=='out')?number_format($oilExpense->transaction->amount):'' }}</b>
                                            <br>
                                        @endforeach
                                        @endif