@extends('layouts.app.index')

@section('title')
    Daily Report
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
                <h4 class="mb-sm-0 font-size-18">Daily Reports</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Daily Reports</li>
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
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Karyawan</label>
                                <select name="employee_id" id="" class="form-control select2">
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach ($_employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="mb-3">
                                <label for="">Tanggal</label>
                                <input type="date" class="form-control" name="date" value="{{ $date }}">
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
                            <h4 class="card-title">Daftar Laporan Harian</h4>
                            <p class="card-title-desc">Dibawah ini merupakan daftar laporan harian anda yang ada pada
                                sistem.
                            </p>
                        </div>
                    </div>

                    <table id="daily_reports-table" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>NAME</th>
                                <th>DATE</th>
                                <th>DESCRIPTION</th>
                                <th>STATUS</th>
                                <th>CREATED AT</th>
                                <th>ACTION</th>
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
            var table = $("#daily_reports-table").DataTable({
                // paging: false,
                scrollCollapse: true,
                pageLength: 100,
                scrollY: '50vh',
                lengthChange: !1,
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: '{{ route('daily_reports.datatable.all') }}',
                    type: "POST",
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                        d.employee_id = $('[name="employee_id"]').val();
                        d.date = $('[name="date"]').val();
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
                        searchable: false,
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).locale('id').format(
                                'dddd, Do MMMM YYYY');
                        }
                    },
                    {
                        data: '_description',
                        name: 'description',
                    },
                    {
                        data: '_status',
                        name: 'seen_at',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).locale('id').format(
                                'Do MMMM YYYY H:mm:ss');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ]
            });

            $('.select2').select2();

            $('#btn-filter').click(function() {
                table.draw();
            })
        });
    </script>
@endsection
