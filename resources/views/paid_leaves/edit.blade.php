@extends('layouts.app.index')

@section('title')
    Edit Paid Leave
@endsection

@section('css')
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Paid Leave</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Edit Paid Leave</li>
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
                    <h4 class="card-title">Ubah Permohonan Cuti</h4>
                    <p class="card-title-desc">Form ini digunakan untuk mengubah permohonan cuti karyawan, isi sesuai
                        dengan title input.
                    </p>

                    <form action="{{ route('paid_leaves.update', $paid_leave->id) }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date"
                                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                name="tanggal_mulai" value="{{ $paid_leave->tanggal_mulai }}">

                                            @error('tanggal_mulai')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="tanggal_akhir">Tanggal Akhir</label>
                                            <input type="date"
                                                class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                                name="tanggal_akhir" value="{{ $paid_leave->tanggal_akhir }}">

                                            @error('tanggal_akhir')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="5" name="description">{{ $paid_leave->description }}</textarea>

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
