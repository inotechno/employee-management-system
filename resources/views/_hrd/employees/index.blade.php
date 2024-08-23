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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
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
                    <div class="clearfix">
                        <div class="float-end">
                            <div class="input-group input-group-sm">
                                <a href="{{ route('import_data.template') }}" class="btn btn-warning"
                                    style="margin-right: 8px;">Download
                                    Template Update</a>
                                <a href="{{ route('import_data.employee') }}" class="btn btn-info"
                                    style="margin-right: 8px;">Update Massal</a>
                                {{-- <a href="{{ route('employees.create.hrd') }}" class="btn btn-primary">
                                    <i class='bx bxs-add-to-queue'></i> Tambah Karyawan
                                </a> --}}
                                {{-- <a href="{{ route('employees.sync') }}" class="btn btn-info">
                                    <i class='bx bxs-add-to-queue'></i> Sync
                                </a> --}}
                            </div>
                        </div>

                        <h4 class="card-title">Employee List</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar karyawan yang ada pada sistem,
                            dapat berfungsi untuk mengelola data karyawan & user.
                        </p>
                    </div>

                    <table id="employees-table" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Join Date</th>
                                <th>Jumlah Cuti</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
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
            $("#employees-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: "{{ route('employees.datatable.hrd') }}",
                    type: "POST",
                    data: {
                        "_token": CSRF_TOKEN,
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
                        data: 'join_date',
                        name: 'join_date',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).lang('id').format(
                                'Do MMMM YYYY');
                        }
                    },
                    {
                        data: 'jumlah_cuti',
                        name: 'jumlah_cuti'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(value) {
                            if (value === 1) return "Aktif";
                            return "Nonaktif";
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).lang('id').format(
                                'Do MMMM YYYY H:mm:ss');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#employees-table').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                $('#form-delete').attr('action', "{{ url('hrd/employees/delete') }}/" + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin menghapus mesin fingerprint ini ?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes, delete it!",
                }).then(function(t) {
                    if (t.isConfirmed != false) {
                        $('#form-delete').submit();
                    }
                });
            })
        });
    </script>
@endsection
