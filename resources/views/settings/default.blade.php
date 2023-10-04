@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('settings.submenu')
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-lg-8 col-12">
                    <!-- general form elements -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">@lang('cmn.company_setting')</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('settings/default') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @foreach ($configs as $config)
                                    @if($config->key == 'module') @continue @endif
                                    <div class="form-group">
                                        <label for="{{ $config->key }} text-uppercase">{{ ucfirst(trans(str_replace('_', ' ', $config->key))) }}</label>
                                        <input type="text" name="{{ $config->key }}" id="{{ $config->key }}" class="form-control" value="{{ $config->value  }}">
                                    </div>
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-icon"><i class="fas fa-upload"></i> @lang('cmn.update')</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script>
    $("#logo").attr('type', 'file'); 
    $("#favicon").attr('type', 'file');
</script>
@endpush