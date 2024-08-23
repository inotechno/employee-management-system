@extends('layouts.app.index')

@section('title')
    Employee
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Employees</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Employees</li>
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
                    <div class="clearfix">
                        {{-- <div class="float-end">
                            <div class="input-group input-group-sm">
                                <a href="{{ route('employees.sync.hrd') }}" class="btn btn-info">
                                    <i class='bx bxs-add-to-queue'></i> Sync
                                </a>
                            </div>
                        </div> --}}

                        <h4 class="card-title">Employee Not Present</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar karyawan yang tidak melakukan absensi atau
                            tanpa keterangan pada tanggal <b>{{ date('d M Y', strtotime($date)) }}</b>.
                        </p>
                    </div>

                    <table id="employees-table" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <form action="" id="form-delete" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('plugin')
    <!-- Required datatable js -->
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var table = $("#employees-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                order: [
                    [2, 'asc']
                ],
                ajax: {
                    url: "{{ route('not_present.datatable.director') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = CSRF_TOKEN;
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
                        data: '_image',
                        name: '_image',
                        orderable: false,
                        width: '5%',
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'user.username',
                        name: 'user.username'
                    },
                    {
                        data: 'user.email',
                        name: 'user.email'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(value) {
                            if (value === 1) return "Aktif";
                            return "Nonaktif";
                        }
                    },
                ]
            });

            $('#btn-filter').click(function() {
                table.draw();
            })
        });
    </script>
@endsection
