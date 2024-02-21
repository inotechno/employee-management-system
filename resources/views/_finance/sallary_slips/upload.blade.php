@extends('layouts.app.index')

@section('title')
    Upload Slip Gaji
@endsection

@section('css')
    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Upload Slip Gaji</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Upload Slip Gaji</li>
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
                            <a href="{{ route('sallary_slip.template.finance') }}" class="btn btn-info">Download
                                Template</a>
                        </div>

                        <h4 class="card-title">Upload</h4>
                    </div>

                    <form action="{{ route('sallary_slip.preview_process.finance') }}" method="POST"
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

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="" class="form-label">Periode</label>
                                    <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd"
                                        data-date-autoclose="true" data-provide="datepicker"
                                        data-date-container='#datepicker6'>
                                        <input type="text" name="periode_start"
                                            class="form-control @error('periode_start') is-invalid @enderror"
                                            placeholder="Periode Start" />
                                        <input type="text" name="periode_end"
                                            class="form-control @error('periode_end') is-invalid @enderror"
                                            placeholder="Periode End" />

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

                        <button class="btn btn-primary">Preview</button>
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
                                    <th>EMPLOYEE ID</th>
                                    <th>NAME</th>
                                    <th>GAJI POKOK</th>
                                    <th>TUNJ PULSA</th>
                                    <th>TUNJ JABATAN</th>
                                    <th>TUNJ TRANSPORT</th>
                                    <th>TUNJ MAKAN</th>
                                    <th>TUNJ LAIN LAIN</th>
                                    <th>REVISI</th>
                                    <th>POT PPH21</th>
                                    <th>POT BPJS TK</th>
                                    <th>POT JAMINAN PENSIUN</th>
                                    <th>POT BPJS KESEHATAN</th>
                                    <th>POT PINJAMAN</th>
                                    <th>POT KETERLAMBATAN</th>
                                    <th>POT DAILY REPORT</th>
                                    <th>THP</th>
                                    <th>JUMLAH HARI KERJA</th>
                                    <th>JUMLAH SAKIT</th>
                                    <th>JUMLAH IZIN</th>
                                    <th>JUMLAH ALPHA</th>
                                    <th>JUMLAH CUTI</th>
                                </tr>
                            </thead>
                            <tbody>

                                @isset($data)
                                    <form action="{{ route('sallary_slip.upload_process.finance') }}" method="POST"
                                        id="form-upload">
                                        @csrf
                                        <input type="hidden" name="periode_start" value="{{ $data['periode_start'] }}">
                                        <input type="hidden" name="periode_end" value="{{ $data['periode_end'] }}">

                                        @foreach ($data['rows'] as $index => $row)
                                            <input type="hidden" value="{{ $row['employee_id'] }}"
                                                name="imports[{{ $index }}][employee_id]">
                                            <input type="hidden" value="{{ $row['gaji_pokok'] }}"
                                                name="imports[{{ $index }}][gaji_pokok]">
                                            <input type="hidden" value="{{ $row['tunj_pulsa'] }}"
                                                name="imports[{{ $index }}][tunj_pulsa]">
                                            <input type="hidden" value="{{ $row['tunj_jabatan'] }}"
                                                name="imports[{{ $index }}][tunj_jabatan]">
                                            <input type="hidden" value="{{ $row['tunj_transport'] }}"
                                                name="imports[{{ $index }}][tunj_transport]">
                                            <input type="hidden" value="{{ $row['tunj_makan'] }}"
                                                name="imports[{{ $index }}][tunj_makan]">
                                            <input type="hidden" value="{{ $row['tunj_lain_lain'] }}"
                                                name="imports[{{ $index }}][tunj_lain_lain]">
                                            <input type="hidden" value="{{ $row['revisi'] }}"
                                                name="imports[{{ $index }}][revisi]">
                                            <input type="hidden" value="{{ $row['pot_pph21'] }}"
                                                name="imports[{{ $index }}][pot_pph21]">
                                            <input type="hidden" value="{{ $row['pot_bpjs_tk'] }}"
                                                name="imports[{{ $index }}][pot_bpjs_tk]">
                                            <input type="hidden" value="{{ $row['pot_jaminan_pensiun'] }}"
                                                name="imports[{{ $index }}][pot_jaminan_pensiun]">
                                            <input type="hidden" value="{{ $row['pot_bpjs_kesehatan'] }}"
                                                name="imports[{{ $index }}][pot_bpjs_kesehatan]">
                                            <input type="hidden" value="{{ $row['pot_pinjaman'] }}"
                                                name="imports[{{ $index }}][pot_pinjaman]">
                                            <input type="hidden" value="{{ $row['pot_keterlambatan'] }}"
                                                name="imports[{{ $index }}][pot_keterlambatan]">
                                            <input type="hidden" value="{{ $row['pot_daily_report'] }}"
                                                name="imports[{{ $index }}][pot_daily_report]">
                                            <input type="hidden" value="{{ $row['thp'] }}"
                                                name="imports[{{ $index }}][thp]">
                                            <input type="hidden" value="{{ $row['jumlah_hari_kerja'] }}"
                                                name="imports[{{ $index }}][jumlah_hari_kerja]">
                                            <input type="hidden" value="{{ $row['jumlah_sakit'] }}"
                                                name="imports[{{ $index }}][jumlah_sakit]">
                                            <input type="hidden" value="{{ $row['jumlah_izin'] }}"
                                                name="imports[{{ $index }}][jumlah_izin]">
                                            <input type="hidden" value="{{ $row['jumlah_alpha'] }}"
                                                name="imports[{{ $index }}][jumlah_alpha]">
                                            <input type="hidden" value="{{ $row['jumlah_cuti'] }}"
                                                name="imports[{{ $index }}][jumlah_cuti]">

                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $row['employee_id'] }}</td>
                                                <td>{{ $row['name'] }}</td>
                                                <td>{{ $row['gaji_pokok'] }}</td>
                                                <td>{{ $row['tunj_pulsa'] }}</td>
                                                <td>{{ $row['tunj_jabatan'] }}</td>
                                                <td>{{ $row['tunj_transport'] }}</td>
                                                <td>{{ $row['tunj_makan'] }}</td>
                                                <td>{{ $row['tunj_lain_lain'] }}</td>
                                                <td>{{ $row['revisi'] }}</td>
                                                <td>{{ $row['pot_pph21'] }}</td>
                                                <td>{{ $row['pot_bpjs_tk'] }}</td>
                                                <td>{{ $row['pot_jaminan_pensiun'] }}</td>
                                                <td>{{ $row['pot_bpjs_kesehatan'] }}</td>
                                                <td>{{ $row['pot_pinjaman'] }}</td>
                                                <td>{{ $row['pot_keterlambatan'] }}</td>
                                                <td>{{ $row['pot_daily_report'] }}</td>
                                                <td>{{ $row['thp'] }}</td>
                                                <td>{{ $row['jumlah_hari_kerja'] }}</td>
                                                <td>{{ $row['jumlah_sakit'] }}</td>
                                                <td>{{ $row['jumlah_izin'] }}</td>
                                                <td>{{ $row['jumlah_alpha'] }}</td>
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
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>+
@endsection
