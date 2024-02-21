@extends('layouts.app.index')

@section('title')
    Edit Absent
@endsection

@section('css')
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Absent</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Edit Absent</li>
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
                    <h4 class="card-title">Ubah Permohonan Izin</h4>
                    <p class="card-title-desc">Form ini digunakan untuk mengubah permohonan izin karyawan, isi sesuai
                        dengan title input.
                    </p>

                    <form action="{{ route('absents.update.employee', $absent->id) }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="date">Tanggal</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" value="{{ $absent->date }}">

                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control @error('description') is-invalid @enderror"
                                        name="description" value="{{ $absent->description }}">

                                    @error('description')
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
