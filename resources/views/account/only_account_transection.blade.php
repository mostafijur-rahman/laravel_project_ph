@extends('layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>@lang('cmn.no')</th>
                            <th>@lang('cmn.bank_name')</th>
                            <th>@lang('cmn.holder_name')</th>
                            <th>@lang('cmn.account_number')</th>
                            <th>@lang('cmn.user_name')</th>
                            <th>@lang('cmn.connected_system_user')</th>
                            <th>@lang('cmn.current_balance')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($accounts)>0)
                        @php $total = 0; @endphp
                        @foreach($accounts as $key => $account)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                {{ ($account->bank_id)?$account->bank->name:__('cmn.cash') }}
                                @if($account->note)<br><small>({{$account->note}})</small>@endif
                            </td>
                            <td>{{ $account->holder_name??'---' }}</td>
                            <td> {{ $account->account_number??'---' }}</td>
                            <td>{{ $account->user_name }}</td>
                            <td>{{ $account->user_id ? $account->connected_user->first_name : '---' }}</td>
                            <td>
                                {{ number_format($account->balance) }}
                                @php $total += $account->balance @endphp 
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" class="text-right"><b>@lang('cmn.total') =</b></td>
                            <td><b>{{ number_format($total) }}</b></td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="7">@lang('cmn.no_data')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @include('account.transection_list')
    </section>
</div>
@endsection
