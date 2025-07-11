@extends('layouts.app.index')

@section('title')
    Edit Machine
@endsection

@section('css')
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Machine</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Edit Machine</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Mesin</h4>
                    <p class="card-title-desc">Form ini digunakan untuk mengubah mesin fingerprint, isi sesuai dengan
                        title input.
                    </p>

                    <form action="{{ route('machines.update', $machine->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $machine->name }}">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="ip">IP Address</label>
                                    <input type="text" class="form-control @error('ip') is-invalid @enderror"
                                        name="ip" value="{{ $machine->ip }}">

                                    @error('ip')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="port">Port</label>
                                    <input type="text" class="form-control @error('port') is-invalid @enderror"
                                        name="port" value="{{ $machine->port }}">

                                    @error('port')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="comkey">Comkey</label>
                                    <input type="text" class="form-control @error('comkey') is-invalid @enderror"
                                        name="comkey" value="{{ $machine->comkey }}">

                                    @error('comkey')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary float-end" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('plugin')
@endsection
