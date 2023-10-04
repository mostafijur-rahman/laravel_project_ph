@if($trip)
@if(count($trip->demarage)>0)
<div class="col-md-8">
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-center text-nowrap">
                <thead>
                    <tr>
                        <th width="20%">@lang('cmn.bill_date')</th>
                        <th width="10%">@lang('cmn.amount')</th>
                        <th width="10%">@lang('cmn.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @php $demarage_sum=0; @endphp
                    @foreach($trip->demarage as $key => $demarage)
                    <tr>
                        <td>
                            <small>
                            {{ $demarage->date }}
                            @if($demarage->note)<br>{{ $demarage->note }}@endif
                            </small>
                        </td>
                        <td><small>{{ number_format($demarage->amount) }}</small></td>
                        <td>
                            <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification({{ $demarage->id  }})" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                            <form id="delete-form-{{$demarage->id }}" method="POST" action="{{ url('trip-oil-expense-delete', $demarage->id ) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @php $demarage_sum += $demarage->amount; @endphp
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td>কোম্পানীর জন্য মোট ডেমারেজ চার্জ = </td>
                        <td>{{ number_format($demarage_sum) }}</td>
                        <td></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>গাড়ী প্রদানকারীর জন্য ডেমারেজ ধার্য্য = </td>
                        <td>{{ number_format($trip->provider->demarage) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
<div class="col-md-12">
    <div class="card">
        <form method="POST" id="action" action="{{ url('trip-demarage-save') }}">
            @csrf
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
            <div class="card-header">
                <h3 class="card-title">@lang('cmn.demarage_entry') @lang('cmn.form')</h3>
                <button type="button" class="btn btn-primary btn-sm float-right" onclick="addRow()"><i class="fa fa-plus"></i></button>
                <button type="button" id="show_btn1" class="btn btn-success btn-sm float-right" style="margin-right: 10px;" onclick="submitForm()">
                    <i id="load_icon1" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                    <i id="show_icon1" class="fas fa-save"></i> @lang('cmn.do_posting')
                </button>
            </div>
            <div class="card-body">
                @php $tr_row_no = 1; @endphp
                <div id="expense_tbody">
                    <div class="row" id="tr_row_{{$tr_row_no}}">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.bill_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                <input type="date" name="date[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('cmn.amount') <small class="text-danger">(@lang('cmn.required'))</small></label>
                                <input type="number" name="amount[]" class="form-control" value="0" value="{{ old('amount') }}" placeholder="@lang('cmn.amount_here')" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('cmn.note') </label>
                            <input type="text"  class="form-control" name="note[]" placeholder="@lang('cmn.note')">
                        </div>
                        <div class="col-md-3">
                            <label>@lang('cmn.action')</label><br>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>গাড়ী প্রদানকারীর ডেমারেজ বিল <small class="text-danger">(@lang('cmn.required'))</small></label>
                        <input type="number" name="provider_demarage" class="form-control" value="0" value="{{ old('provider_demarage') }}" placeholder="@lang('cmn.amount_here')" required>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endif