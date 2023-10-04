@extends('layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"></div>
        </section>
        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $title }}</h3>
                            </div>
                            <form action="{{ url('/admin/save-system') }}" method="POST">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="">@lang('cmn.default_challan')</label>
                                        <select class="form-control" name="default_challan" id="">
                                            <option value="out_from_market" {{ (isset($setting['out_from_market']) && $setting['out_from_market'] == 'mail') ? 'selected':'' }}>@lang('cmn.from_market')</option>
                                            <option value="out_nagad_commission" {{ (isset($setting['out_nagad_commission']) &&  $setting['out_nagad_commission'] == 'smtp') ? 'selected':'' }}>@lang('cmn.cash_commission')</option>
                                            <option value="own_vehicle" {{ (isset($setting['own_vehicle']) &&  $setting['own_vehicle'] == 'smtp') ? 'selected':'' }}>@lang('cmn.own_vehicle')</option>
                                            <option value="own_vehicle_up_down" {{ (isset($setting['own_vehicle_up_down']) &&  $setting['own_vehicle_up_down'] == 'smtp') ? 'selected':'' }}>@lang('cmn.up_down')</option>
                                            
                                        </select>
                                    </div>




                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> @lang('cmn.save')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



    </section>
    <!-- /.content -->
</div>
@endsection