@extends('layouts.app.index')

@section('title')
    Create Paid Leave
@endsection

@section('css')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create Paid Leave</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Create Paid Leave</li>
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
                    <h4 class="card-title">Tambah Permohonan Cuti</h4>
                    <p class="card-title-desc">Form ini digunakan untuk menambahkan permohonan cuti karyawan, isi sesuai
                        dengan title input.
                    </p>

                    <form action="{{ route('paid_leaves.store.employee') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">

                                    @error('tanggal_mulai')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="tanggal_akhir">Tanggal Akhir</label>
                                    <input type="date" class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                        name="tanggal_akhir" value="{{ old('tanggal_akhir') }}">

                                    @error('tanggal_akhir')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">

                                    <label for="user_id">Atasan <small class="text-danger">* Bukan Direktur atau
                                            HRD</small></label>
                                    <select class="select2 form-control select2 @error('user_id') is-invalid @enderror"
                                        name="user_id" data-placeholder="Pilih Atasan">
                                        <option></option>
                                        @foreach ($_employees as $employee)
                                            <option value="{{ $employee->user->id }}">{{ $employee->user->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="5" name="description">{{ old('description') }}</textarea>

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
        </div>
    </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('plugin')
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
