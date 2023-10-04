@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('settings.submenu')
            {{-- <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#"><strong>{{ $title }}</strong></a></li>
                    </ol>
                </div>
            </div> --}}
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <form method="GET" name="form">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" class="form-control" name="name" value="{{ old('name',$request->name) }}" placeholder="@lang('cmn.name')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> @lang('cmn.search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>@lang('cmn.vehicle')</th>
                            <th>@lang('cmn.tax_token')</th>
                            <th>@lang('cmn.fitness')</th>
                            <th>@lang('cmn.road_permit')</th>
                            <th>@lang('cmn.insurance')</th>
                            <th>@lang('cmn.blue_book')</th>
                            <th>@lang('cmn.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td class="text-left">গাড়ী: {{ $list->vehicle_number }}</td>
                            <td class="text-left">
                                <small>@lang('cmn.registration')</small> {{$list->document->tax_token_registration??'---'}}<br>
                                <small>@lang('cmn.expiration')</small> {{$list->document->tax_token_expire??'---'}}
                            </td>
                            <td class="text-left">
                                <small>@lang('cmn.registration')</small> {{$list->document->fitness_registration??'---'}} <br>
                                <small>@lang('cmn.expiration')</small> {{$list->document->fitness_expire??'---'}}
                            </td>
                            <td class="text-left">
                                <small>@lang('cmn.registration')</small> {{$list->document->road_permit_registration??'---'}} <br>
                                <small>@lang('cmn.expiration')</small> {{$list->document->road_permit_expire??'---'}}
                            </td>
                            <td class="text-left">
                                <small>@lang('cmn.registration')</small> {{$list->document->insurance_registration??'---'}} <br>
                                <small>@lang('cmn.expiration')</small> {{$list->document->insurance_expire??'---'}}
                            </td>
                            <td class="text-left">
                                <small>@lang('cmn.registration')</small> {{$list->document->blue_book_registration??'---'}} <br>
                                <small>@lang('cmn.expiration')</small> {{$list->document->blue_book_expire??'---'}}
                            </td>
                            <td>
                                @if(Auth::user()->role->edit)
                                <button type="button" class="btn btn-xs bg-gradient-primary"  data-toggle="modal" data-target="#edit_{{$list->id}}" title="Edit"><i class="fas fa-edit"></i></button>
                                @endif
                                @if(Auth::user()->role->delete && $list->document->id)
                                <button type="button" class="btn btn-xs bg-gradient-danger" onclick="return deleteCertification(<?php echo $list->document->id; ?>)" title="@lang('cmn.delete')"><i class="fas fa-trash"></i></button>
                                <form id="delete-form-{{$list->document->id}}" action="{{ url('documents',$list->document->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                            <div class="modal fade" id="edit_{{$list->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        @if(!$list->document->id)
                                        <form action="{{ url('documents') }}" method="post">
                                            @csrf
                                        @else
                                        <form action="{{ url('documents', $list->document->id) }}" method="post">
                                            @method('PUT')
                                            @csrf
                                        @endif
                                            <input type="hidden" name="setting_vehicle_id" value="{{ $list->id }}">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('cmn.update')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.tax_token') @lang('cmn.registration')</label>
                                                            <input type="date" class="form-control" name="tax_token_registration" value="{{ old('tax_token_registration', $list->document->tax_token_registration)}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.tax_token') @lang('cmn.expiration')</label>
                                                            <input type="date" class="form-control" name="tax_token_expire" value="{{ old('tax_token_expire', $list->document->tax_token_expire)}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.fitness') @lang('cmn.registration')</label>
                                                            <input type="date" class="form-control" name="fitness_registration" value="{{ old('fitness_registration', $list->document->fitness_registration)}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.fitness') @lang('cmn.expiration')</label>
                                                            <input type="date" class="form-control" name="fitness_expire" value="{{ old('fitness_expire', $list->document->fitness_expire)}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.road_permit') @lang('cmn.registration')</label>
                                                            <input type="date" class="form-control" name="road_permit_registration" value="{{ old('road_permit_registration', $list->document->road_permit_registration)}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.road_permit') @lang('cmn.expiration')</label>
                                                            <input type="date" class="form-control" name="road_permit_expire" value="{{ old('road_permit_expire', $list->document->road_permit_expire)}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.insurance') @lang('cmn.registration')</label>
                                                            <input type="date" class="form-control" name="insurance_registration" value="{{ old('insurance_registration', $list->document->insurance_registration)}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.insurance') @lang('cmn.expiration')</label>
                                                            <input type="date" class="form-control" name="insurance_expire" value="{{ old('insurance_expire', $list->document->insurance_expire)}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.blue_book') @lang('cmn.registration')</label>
                                                            <input type="date" class="form-control" name="blue_book_registration" value="{{ old('blue_book_registration', $list->document->blue_book_registration)}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">@lang('cmn.blue_book') @lang('cmn.expiration')</label>
                                                            <input type="date" class="form-control" name="blue_book_expire" value="{{ old('blue_book_expire', $list->document->blue_book_expire)}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> @lang('cmn.close')</button>
                                                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> @lang('cmn.update')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{ $lists->appends(Request::input())->links() }}
    </section>
    <!-- /.content -->
</div>
@endsection