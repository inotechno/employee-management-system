@extends('layouts.app.index')

@section('title')
    Edit Employee
@endsection

@section('css')
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Employee</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Edit Employee</li>
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
                    <h4 class="card-title">Edit Employee</h4>
                    <p class="card-title-desc">Form ini digunakan untuk mengubah data karyawan, isi sesuai dengan
                        title input.
                    </p>

                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $employee->user->name }}">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ $employee->user->email }}">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="position">Position</label>
                                    <select name="position_id"
                                        class="form-select @error('position_id') is-invalid @enderror">
                                        <option readonly>Pilih Posisi</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                @if ($employee->position_id == $position->id) selected @endif>
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="card_number">Card Number</label>
                                    <input type="text" class="form-control @error('card_number') is-invalid @enderror"
                                        name="card_number" value="{{ $employee->card_number }}">

                                    @error('card_number')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        name="tanggal_lahir" value="{{ $employee->tanggal_lahir }}">

                                    @error('tanggal_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        name="tempat_lahir" value="{{ $employee->tempat_lahir }}">

                                    @error('tempat_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="bpjs_kesehatan">BPJS Kesehatan</label>
                                    <input type="text" class="form-control @error('bpjs_kesehatan') is-invalid @enderror"
                                        name="bpjs_kesehatan" value="{{ $employee->bpjs_kesehatan }}">

                                    @error('bpjs_kesehatan')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="bpjs_ketenagakerjaan">BPJS Ketenagakerjaan</label>
                                    <input type="text"
                                        class="form-control @error('bpjs_ketenagakerjaan') is-invalid @enderror"
                                        name="bpjs_ketenagakerjaan" value="{{ $employee->bpjs_ketenagakerjaan }}">

                                    @error('bpjs_ketenagakerjaan')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nama_rekening">Nama Rekening</label>
                                    <input type="text" class="form-control @error('nama_rekening') is-invalid @enderror"
                                        name="nama_rekening" value="{{ $employee->nama_rekening }}">

                                    @error('nama_rekening')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="no_rekening">No Rekening</label>
                                    <input type="number" class="form-control @error('no_rekening') is-invalid @enderror"
                                        name="no_rekening" value="{{ $employee->no_rekening }}">

                                    @error('no_rekening')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pemilik_rekening">Pemilik Rekening</label>
                                    <input type="text"
                                        class="form-control @error('pemilik_rekening') is-invalid @enderror"
                                        name="pemilik_rekening" value="{{ $employee->pemilik_rekening }}">

                                    @error('pemilik_rekening')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="status">Status</label>
                                            <select name="status"
                                                class="form-select @error('status') is-invalid @enderror">
                                                <option disabled>Pilih Status</option>
                                                <option value="1" @if ($employee->status == 1) selected @endif>
                                                    Aktif
                                                </option>
                                                <option value="0" @if ($employee->status == 0) selected @endif>
                                                    Tidak Aktif
                                                </option>
                                            </select>

                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="jumlah_cuti">Jumlah Cuti</label>
                                            <input type="text"
                                                class="form-control @error('jumlah_cuti') is-invalid @enderror"
                                                name="jumlah_cuti" value="{{ $employee->jumlah_cuti }}">

                                            @error('jumlah_cuti')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
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
