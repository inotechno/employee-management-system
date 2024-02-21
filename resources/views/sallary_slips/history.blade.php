@extends('layouts.app.index')

@section('title')
    History Slip Gaji
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">History Slip Gaji</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">History Slip Gaji</li>
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
                    <h4 class="card-title">Filter</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Nama Karyawan</label>
                                <select name="employee_id" id="" class="form-control select2">
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach ($_employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="periode" class="form-label">Periode</label>
                                <select name="periode" id="" class="form-control select2">
                                    <option value="">-- Pilih Periode --</option>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode->id }}">
                                            {{ $periode->periode_start . ' - ' . $periode->periode_end }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="float-end">
                        <button class="btn btn-primary" id="btn-filter">Filter</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="clearfix row">
                        <div class="col-md">
                            <h4 class="card-title">History Upload</h4>
                            <p class="card-title-desc">Dibawah ini merupakan data history dari hasil upload.
                            </p>
                        </div>
                    </div>

                    <table id="history-table" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>EMPLOYEE ID</th>
                                <th>NAME</th>
                                <th>PERIODE</th>
                                <th>PENDAPATAN</th>
                                <th>POTONGAN</th>
                                <th>THP</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('plugin')
    <!-- Required datatable js -->
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var table = $("#history-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('sallary_slip.datatable') }}',
                    type: 'POST',
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                        d.employee_id = $('[name="employee_id"]').val();
                        d.periode = $('[name="periode"]').val();
                    }
                },
                columnDefs: [{
                    className: "align-middle",
                    targets: "_all"
                }, ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'employee_id',
                        name: 'employee_id',
                    },
                    {
                        data: 'employee.user.name',
                        name: 'name'
                    },
                    {
                        data: 'periode',
                        name: 'periode',
                    },
                    {
                        data: 'total_pendapatan',
                        name: 'pendapatan',
                    },
                    {
                        data: 'total_potongan',
                        name: 'potongan',
                    },
                    {
                        data: 'thp',
                        name: 'thp',
                    },
                ]
            });

            $('.select2').select2();

            $('#btn-filter').click(function() {
                table.draw();
            })

        });
    </script>
@endsection
