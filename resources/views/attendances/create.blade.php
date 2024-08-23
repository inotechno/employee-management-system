@extends('layouts.app.index')

@section('title')
    Add Attendance
@endsection

@section('css')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add Attendance</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Add Attendance</li>
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
                    <h4 class="card-title">Add Attendance</h4>
                    <p class="card-title-desc">Form ini digunakan untuk mengubah absensi, isi sesuai dengan
                        title input.
                    </p>

                    <form action="{{ route('attendances') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="row">

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Karyawan</label>
                                    <select name="employee_id" id="" class="form-control select2">
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach ($_employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="timestamp">Timestamp</label>
                                    <input type="datetime-local"
                                        class="form-control @error('timestamp') is-invalid @enderror" name="timestamp">

                                    @error('timestamp')
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
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

        });
    </script>
@endsection
