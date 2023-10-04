@extends('backend.layout')

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
        <!-- general form elements -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('admin/pages') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="url">URL<sup>*</sup></label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}" placeholder="your-page-link" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Title<sup>*</sup></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="title" required>
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon<sup>*</sup></label>
                        <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon') }}" placeholder="fa-name" required>
                    </div>
                    <div class="form-group">
                        <label for="code">Header Code</label>
                        <textarea class="form-control" id="code" name="header_code" rows="5" placeholder="code here">{{ old('header_code') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="code">Body Code</label>
                        <textarea class="form-control" id="code" name="body_code" rows="5" placeholder="code here">{{ old('body_code') }}</textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="code">Meta Keywords</label>
                        <textarea class="form-control" id="code" name="meta_key" rows="2" placeholder="keywords here">{{ old('meta_key') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="code">Meta Descriptions</label>
                        <textarea class="form-control" id="code" name="meta_desc" rows="6" placeholder="descriptions here">{{ old('meta_desc') }}</textarea>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ url('pages') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Back</a>
                    <button type="submit" class="btn btn-success float-right"><i class="fas fa-upload"></i> Save</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection