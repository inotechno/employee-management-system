@extends('layouts.app.index')

@section('title')
    Edit Attendance
@endsection

@section('css')
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Attendance</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Edit Attendance</li>
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
                    <h4 class="card-title">Edit Attendance</h4>
                    <p class="card-title-desc">Form ini digunakan untuk mengubah absensi, isi sesuai dengan
                        title input.
                    </p>

                    <form action="{{ route('attendances.update', $attendance->id) }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="timestamp">Nama Lengkap</label>
                                    <input type="text" class="form-control" readonly disabled
                                        value="{{ $attendance->employee->user->name }}">
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="timestamp">Timestamp</label>
                                    <input type="datetime-local"
                                        class="form-control @error('timestamp') is-invalid @enderror" name="timestamp"
                                        value="{{ $attendance->timestamp }}">

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
@endsection
