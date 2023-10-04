@extends('layout')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- form box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-primary">
                    <h3 class="card-title">@lang('cmn.account_create_form')</h3>
                </h3>
                <div class="card-tools">
                    <a href="{{ url('accounts?page_name=create_bank') }}" class="btn btn-sm {{ ($request->page_name == 'create_bank')?'btn-primary':'btn-default' }}">@lang('cmn.bank_account')</a>
                    <a href="{{ url('accounts?page_name=create_cash') }}" class="btn btn-sm {{ ($request->page_name == 'create_cash')?'btn-primary':'btn-default' }}">@lang('cmn.cash_account')</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($request->page_name == 'create_bank')
                    @include('account.bank_form')
                @endif
                @if($request->page_name == 'create_cash')
                    @include('account.cash_form')
                @endif
            </div>
        </div>
        <!-- table box -->
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered text-center table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>@lang('cmn.no')</th>
                            <th>@lang('cmn.account_details')</th>
                            <th>@lang('cmn.current_balance')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($lists)>0)
                        @php $total = 0; @endphp
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td class="text-left">
                                <small>
                                    @lang('cmn.user_name') : <b>{{ $list->user_name }}</b><br>
                                    @if($list->bank_id)
                                    @lang('cmn.bank') : <b>{{ $list->bank->name }}</b><br>
                                    @lang('cmn.account_number') : <b>{{ $list->account_number }}</b><br>
                                    @lang('cmn.holder_name') : <b>{{ $list->holder_name }}</b>
                                    @else
                                    <b>@lang('cmn.cash_account')</b>
                                    @endif
                                    <br>
                                    @if($list->user_id)
                                    @lang('cmn.connected_system_user') : <b>{{ $list->connected_user->first_name }}</b><br>
                                    @endif
                                    @lang('cmn.posted_by') :<br>
                                    <b>{{ $list->user->first_name }} ({{ date('d M, Y H:m A', strtotime($list->created_at)) }})</b>
                                    @if($list->updated_at)
                                        <br>
                                        @if($list->updated_by)
                                            @lang('cmn.post_updated_by'): <br>
                                            <b>{{ $list->user_update->first_name}} ({{ date('d M, Y H:m A', strtotime($list->updated_at)) }})</b>
                                        @endif
                                    @endif
                                </small>
                            </td>
                            <td>
                                {{ number_format($list->balance) }}
                                @php $total += $list->balance @endphp 
                            </td>
                            <td>
                                @if(Auth::user()->role->edit)
                                @php $page = ($list->bank_id)?'create_bank':'create_cash'; @endphp
                                <a href="{{ url('accounts?page_name='. $page .'&id='. $list->id) }}" class="btn btn-xs bg-gradient-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                @endif
                                @if(Auth::user()->role->delete)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $list->id  }})" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->id }}" action="{{ url('accounts',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-right"><b>@lang('cmn.total') =</b></td>
                            <td><b>{{ number_format($total) }}</b></td>
                            <td></td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="4">@lang('cmn.no_data')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('js')
<!-- toastr -->
<script src="{{ asset('assets/dist/cdn/toastr.min.js') }}"></script>
{!! Toastr::message() !!}

<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    $('#reservationdate').datetimepicker({
        defaultDate: "",
        format: 'DD/MM/YYYY'
    });
    function submitForm(){
        document.getElementById("load_icon1").style.display = "inline-block";
        document.getElementById("show_icon1").style.display = "none";
        document.getElementById("show_btn1").disabled=true;

        event.preventDefault();
        document.getElementById('action').submit();
    }

    // delete notice
    function deleteCertification(id){
        const swalWithBootstrapButtons = Swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger mr-2',
            buttonsStyling: false,
        })
        swalWithBootstrapButtons({
            title: "{{ __('cmn.are_you_sure') }}",
            text: "{{ __('cmn.for_erase_it') }}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('cmn.yes') }}",
            cancelButtonText: "{{ __('cmn.no') }}",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('delete-form-'+id).submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // swalWithBootstrapButtons()
            }
        })
    }
</script>
@endpush