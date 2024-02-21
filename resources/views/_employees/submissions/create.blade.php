@extends('layouts.app.index')

@section('title')
    Create Submission
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create Submission</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Create Submission</li>
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
                    <h4 class="card-title">Tambah Pengajuan Keuangan</h4>
                    <p class="card-title-desc">Form ini digunakan untuk menambahkan pengajuan keuangan, isi sesuai
                        dengan title input.
                    </p>

                    <form action="{{ route('submission.store.employee') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">
                                            <label for="title">Judul</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                name="title">

                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="nominal">Nominal</label>
                                            <input type="number"
                                                class="form-control @error('nominal') is-invalid @enderror" name="nominal">

                                            @error('nominal')
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
                                            <select
                                                class="select2 form-control select2 @error('user_id') is-invalid @enderror"
                                                name="user_id" data-placeholder="Pilih Atasan">
                                                <option></option>
                                                @foreach ($_employees as $employee)
                                                    <option value="{{ $employee->user->id }}">{{ $employee->user->name }}
                                                    </option>
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
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="note">Catatan</label>
                                    <textarea class="form-control @error('note') is-invalid @enderror" rows="7" name="note"></textarea>

                                    @error('note')
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('[name="note"]').summernote({
                tabsize: 2,
                lineHeight: 20,
                height: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                ]
            });
        });
    </script>
@endsection
