@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ url('pump/create') }}" class="btn btn-md btn-success pull-right" title="Add"><i class="fas fa-plus"></i> Add</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-center table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>Pump Name</th>
                            <th>Due Balanced</th>
                            <th>Advanced Balanced</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $list->pump_name }}</td>
                            <td>10,000</td>
                            <td>12,000</td>
                            <td>
                                <a class="btn btn-info" href="#" title="Ledger"><i class='fas fa-print'></i></a>
                                {{-- <a class="btn btn-primary" href="{{ url('pump/' . $list->pump_encrypt. '/edit/') }}" title="Edit"><i class='fa fa-edit'></i></a>
                                <button type="button" class="btn btn-md bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->pump_encrypt}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$list->pump_encrypt}}" action="{{ url('pump',$list->pump_encrypt) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form> --}}
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection