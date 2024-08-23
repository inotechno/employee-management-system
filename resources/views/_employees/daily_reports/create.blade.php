@extends('layouts.app.index')

@section('title')
    Create Daily Report
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .img-bg {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            padding-bottom: 100%;
        }
    </style>
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create Daily Report</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Create Daily Report</li>
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
                    <h4 class="card-title">Tambah Laporan Harian</h4>
                    <p class="card-title-desc">Form ini digunakan untuk menambahkan laporan harian karyawan, isi sesuai
                        dengan title input.
                    </p>

                    <form action="{{ route('daily_reports.store.employee') }}" method="POST" class="needs-validation"
                        novalidate enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" value="{{ date('Y-m-d') }}">

                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cc">CC</label>
                                    <select class="select2 form-control select2-multiple @error('cc') is-invalid @enderror"
                                        name="cc[]" multiple="multiple">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->user->id }}">{{ $employee->user->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('cc')
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

                                    @if ($daily_report)
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description">{!! $daily_report->description !!}</textarea>
                                    @else
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description"></textarea>
                                    @endif

                                    @error('description')
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
                                    <label for="">Media upload</label><small class="text-warning"> * Upload bisa
                                        lebih dari 1 file, Max upload 10MB</small>
                                    <input name="media[]" type="file" multiple="multiple" class="form-control">
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
            $('[name="description"]').summernote({
                tabsize: 2,
                lineHeight: 20,
                height: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                // tags: true,
            });
        });
    </script>
@endsection
