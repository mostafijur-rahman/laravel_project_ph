<div class="card">
    <div class="card-header">
        <h3 class="card-title text-primary">
            <b>@lang('cmn.mobil_purchase_form')</b>
        </h3>
        <div class="card-tools">
            <a href="{{ url('purchases?page_name=tyre') }}" class="btn btn-sm {{ ($request->page_name == 'tyre')?'btn-primary':'btn-default' }}">@lang('cmn.tyre')</a>
            <a href="{{ url('purchases?page_name=mobil') }}" class="btn btn-sm {{ ($request->page_name == 'mobil')?'btn-primary':'btn-default' }}">@lang('cmn.mobil')</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form action="{{ url('/purchases') }}" id="action" method="post">
            @csrf
            <input type="hidden" name="form_type" value="mobil">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {{-- <label>@lang('cmn.purchase_date')</label>
                            <input type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d'))}}" placeholder="@lang('cmn.tyre_number')"> --}}
                            <label>@lang('cmn.purchase_date') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <div class="input-group date" id="mobil_purchase_date" data-target-input="nearest">
                                <input type="text" name="date" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                                <div class="input-group-append" data-target="#mobil_purchase_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.supplier_name')</label>
                            <select name="supplier_id" class="form-control" required>
                                @if(isset($suppliers))
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.brand')</label>
                            <select name="brand_id" class="form-control" required>
                                @if(isset($brands))
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.liter') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <input type="number" class="form-control" name="liter" value="{{ old('liter')}}" placeholder="@lang('cmn.liter')" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.price') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <input type="number" class="form-control" name="price" value="{{ old('price')}}" placeholder="@lang('cmn.price')" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.paid') <small class="text-danger">(@lang('cmn.required'))</small></label>
                            <input type="number" class="form-control" name="paid" value="{{ old('paid')}}" placeholder="@lang('cmn.paid')" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.discount')</label>
                            <input type="number" class="form-control" name="discount" value="{{ old('discount')}}" placeholder="@lang('cmn.discount')">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('cmn.note') </label>
                            <textarea class="form-control" rows="1" name="note" placeholder="@lang('cmn.write_note_here')"></textarea>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="button" id="show_btn2" class="form-control btn btn-sm btn-success" onclick="submitMobil()">
                                <i id="load_icon2" style="display: none;" class="fas fa-circle-notch fa-spin"></i>
                                <i id="show_icon2" class="fas fa-save"></i> @lang('cmn.do_posting')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
