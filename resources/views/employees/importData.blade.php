@extends('layouts.app.index')

@section('title')
    Import Data Employee
@endsection

@section('css')
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Import Data Employee</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Configuration</a></li>
                        <li class="breadcrumb-item active">Import Data Employee</li>
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

                    <div class="clearfix">
                        <div class="float-end row">
                            <a href="{{ route('import_data.template') }}" class="btn btn-info">Download
                                Template</a>
                        </div>

                        <h4 class="card-title">Upload</h4>
                    </div>

                    <form action="{{ route('import_data.preview_process') }}" id="form-preview" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row mt-2">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">File</label>
                                    <input class="form-control @error('file') is-invalid @enderror" type="file"
                                        name="file" id="formFile">

                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit" form="form-preview">Preview</button>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="clearfix row">
                        <div class="col-md">
                            <h4 class="card-title">Preview Upload</h4>
                            <p class="card-title-desc">Dibawah ini merupakan data preview dari hasil upload.
                            </p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="preview-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>TANGGAL JOIN</th>
                                    <th>TANGGAL LAHIR</th>
                                    <th>TEMPAT LAHIR</th>
                                    <th>BPJS KESEHATAN</th>
                                    <th>BPJS KETENAGAKERJAAN</th>
                                    <th>NAMA REKENING</th>
                                    <th>NO. REKENING</th>
                                    <th>PEMILIK REKENING</th>
                                    <th>JUMLAH CUTI</th>
                                </tr>
                            </thead>
                            <tbody>

                                @isset($data)
                                    <form action="{{ route('import_data.upload_process') }}" method="POST" id="form-upload">
                                        @csrf
                                        @method('PUT')
                                        @foreach ($data['rows'] as $index => $row)
                                            <input type="hidden" value="{{ $row['id'] }}"
                                                name="imports[{{ $index }}][id]">
                                            <input type="hidden" value="{{ $row['employee_id'] }}"
                                                name="imports[{{ $index }}][employee_id]">
                                            <input type="hidden" value="{{ $row['name'] }}"
                                                name="imports[{{ $index }}][name]">
                                            <input type="hidden" value="{{ $row['email'] }}"
                                                name="imports[{{ $index }}][email]">
                                            <input type="hidden" value="{{ $row['join_date'] }}"
                                                name="imports[{{ $index }}][join_date]">
                                            <input type="hidden" value="{{ $row['tanggal_lahir'] }}"
                                                name="imports[{{ $index }}][tanggal_lahir]">
                                            <input type="hidden" value="{{ $row['tempat_lahir'] }}"
                                                name="imports[{{ $index }}][tempat_lahir]">
                                            <input type="hidden" value="{{ $row['bpjs_kesehatan'] }}"
                                                name="imports[{{ $index }}][bpjs_kesehatan]">
                                            <input type="hidden" value="{{ $row['bpjs_ketenagakerjaan'] }}"
                                                name="imports[{{ $index }}][bpjs_ketenagakerjaan]">
                                            <input type="hidden" value="{{ $row['nama_rekening'] }}"
                                                name="imports[{{ $index }}][nama_rekening]">
                                            <input type="hidden" value="{{ $row['no_rekening'] }}"
                                                name="imports[{{ $index }}][no_rekening]">
                                            <input type="hidden" value="{{ $row['pemilik_rekening'] }}"
                                                name="imports[{{ $index }}][pemilik_rekening]">
                                            <input type="hidden" value="{{ $row['jumlah_cuti'] }}"
                                                name="imports[{{ $index }}][jumlah_cuti]">

                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td>{{ $row['employee_id'] }}
                                                    @if ($row['id'] == 'new')
                                                        <span class="badge bg-info">New</span>
                                                    @endif
                                                </td>
                                                <td>{{ $row['name'] }}</td>
                                                <td>{{ $row['email'] }}</td>
                                                <td>{{ $row['join_date'] }}</td>
                                                <td>{{ $row['tanggal_lahir'] }}</td>
                                                <td>{{ $row['tempat_lahir'] }}</td>
                                                <td>{{ $row['bpjs_kesehatan'] }}</td>
                                                <td>{{ $row['bpjs_ketenagakerjaan'] }}</td>
                                                <td>{{ $row['nama_rekening'] }}</td>
                                                <td>{{ $row['no_rekening'] }}</td>
                                                <td>{{ $row['pemilik_rekening'] }}</td>
                                                <td>{{ $row['jumlah_cuti'] }}</td>
                                            </tr>
                                        @endforeach
                                    </form>
                                @endisset
                            </tbody>
                        </table>

                    </div>

                    @isset($data)
                        <button class="btn btn-primary" type="submit" form="form-upload">Import</button>
                    @endisset
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('plugin')
@endsection
