@extends('layouts.app.index')

@section('title')
    Detail Pengajuan Keuangan
@endsection

@section('css')
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Detail Pengajuan Keuangan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Detail Pengajuan Keuangan</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="date">Nama Karyawan</label>
                                <input type="text" class="form-control" value="{{ $submission->employee->user->name }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="mb-3">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" value="{{ $submission->title }}" readonly>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="mb-3">
                                <label for="title">Nominal</label>
                                <input type="text" class="form-control" value="{{ $submission->nominal }}" readonly>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="mb-3">
                                <label for="title">Atasan</label>
                                <input type="text" class="form-control" value="{{ $submission->supervisor->name ?? '' }}"
                                    readonly>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="note" class="mb-3 d-block">Catatan</label>
                                {!! $submission->note !!}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div> <!-- end col -->

    </div> <!-- end row -->
@endsection

@section('plugin')
@endsection
