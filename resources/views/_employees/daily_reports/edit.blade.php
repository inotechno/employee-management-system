@extends('layouts.app.index')

@section('title')
    Edit Daily Report
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
                <h4 class="mb-sm-0 font-size-18">Edit Daily Report</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Edit Daily Report</li>
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
                    <h4 class="card-title">Ubah Laporan Harian</h4>
                    <p class="card-title-desc">Form ini digunakan untuk mengubah laporan harian karyawan, isi sesuai
                        dengan title input.
                    </p>

                    <form action="{{ route('daily_reports.update.employee', $daily_report->id) }}" method="POST"
                        class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date">Tanggal Mulai</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" value="{{ $daily_report->date }}">

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
                                            <option
                                                {{ in_array($employee->user->id,$daily_report->users()->pluck('user_id')->toArray())? 'selected': '' }}
                                                value="{{ $employee->user->id }}">
                                                {{ $employee->user->name }}</option>
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
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ $daily_report->description }}</textarea>

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
                                        lebih dari 1 file</small>
                                    <input name="media[]" type="file" multiple="multiple" class="form-control">
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-4 mt-5">
                                @foreach ($daily_report->getMedia('media') as $image)
                                    <span>
                                        <h5 class="font-size-14 mb-1"><a href="{{ $image->getUrl() }}"
                                                title="{{ $image->getUrl() }}"
                                                class="text-dark">{{ $image->file_name }}</a>
                                        </h5>
                                        <small>Size : {{ $image->size }}</small>
                                    </span>

                                    <span>
                                        <h5 class="font-size-14 mb-1"><a href="{{ $image->getUrl() }}"
                                                title="{{ $image->getUrl() }}"
                                                class="text-dark">{{ $image->file_name }}</a>
                                        </h5>
                                        <small>Size : {{ $image->size }}</small>
                                    </span>

                                    <span>
                                        <h5 class="font-size-14 mb-1"><a href="{{ $image->getUrl() }}"
                                                title="{{ $image->getUrl() }}"
                                                class="text-dark">{{ $image->file_name }}</a>
                                        </h5>
                                        <small>Size : {{ $image->size }}</small>
                                    </span>
                                @endforeach
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
                tags: true,
            });
        });
    </script>
@endsection
