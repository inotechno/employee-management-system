@extends('layouts.app.index')

@section('title')
    Report Absent Sakit Employee
@endsection

@section('css')
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Absent Sakit Employee</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                        <li class="breadcrumb-item active">Absent Sakit Employee</li>
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

                    <form action="{{ route('report.submission.download') }}" method="POST" autocomplete="off">
                        @csrf

                        <div class="row mt-2">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="">Pilih Karyawan</label>
                                    <select name="employee_id" id="" class="form-control select2">
                                        <option value="">Semua Karyawan</option>
                                        @foreach ($_employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="" class="form-label">Periode</label>
                                    <div class="input-daterange input-group" data-date-format="yyyy-mm-dd"
                                        data-date-autoclose="true" data-provide="datepicker">
                                        <input type="text" name="periode_start"
                                            class="form-control @error('periode_start') is-invalid @enderror"
                                            placeholder="Periode Start" value="{{ old('periode_start') }}"
                                            autocomplete="off" />
                                        <input type="text" name="periode_end"
                                            class="form-control @error('periode_end') is-invalid @enderror"
                                            placeholder="Periode End" value="{{ old('periode_end') }}" autocomplete="off" />

                                        @error('periode_start')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                        @error('periode_end')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-info" id="preview" type="button">Preview</button>
                        <button class="btn btn-primary" type="submit">Download</button>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    @if (!empty($data))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! $data['html'] !!}
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    @endif
@endsection

@section('plugin')
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#preview').on('click', function() {
                var employee_id = $('[name="employee_id"]').val();
                var periode_start = $('[name="periode_start"]').val();
                var periode_end = $('[name="periode_end"]').val();
                var url = "{{ url('report/absent/preview') }}";
                window.location.href = url +
                    '?employee_id=' + employee_id + '&periode_start=' + periode_start + '&periode_end=' +
                    periode_end;

            })
        });
    </script>
@endsection
