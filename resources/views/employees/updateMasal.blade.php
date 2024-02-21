@extends('layouts.app.index')

@section('title')
    Update Masal Employee
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
                <h4 class="mb-sm-0 font-size-18">Update Masal Employee</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Update Masal</a></li>
                        <li class="breadcrumb-item active">Update Masal Employee</li>
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

                    <form action="{{ route('updatemasal.employee.download') }}" method="POST"
                        enctype="multipart/form-data">
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
                        </div>

                        <button class="btn btn-primary" type="submit">Download</button>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@section('plugin')
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>+
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
