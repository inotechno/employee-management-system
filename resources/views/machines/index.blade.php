@extends('layouts.app.index')

@section('title')
    Machine Fingerprint
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
                <h4 class="mb-sm-0 font-size-18">Machines</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Machines</li>
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
                                <a href="{{ route('machines.create') }}" class="btn btn-info">
                                    <i class='bx bxs-add-to-queue'></i> Add Machine
                                </a>
                            </div>
                        </div>

                        <h4 class="card-title">Machines List</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar mesin fingerprint yang ada pada sistem,
                            dapat berfungsi untuk mengambil data karyawan serta absensi karyawan dengan cara mengaktifkan
                            mesin
                            yang ingin dipilih.
                        </p>
                    </div>

                    <table id="machines-table" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Machine Name</th>
                                <th>IP</th>
                                <th>Port</th>
                                <th>Comkey</th>
                                <th>Active?</th>
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

    <form action="" id="form-update-active" method="POST">
        @csrf
        @method('PUT')
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
            $("#machines-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                columnDefs: [{
                    className: "align-middle",
                    targets: "_all"
                }, ],
                ajax: "{{ route('machines.datatable') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'name_connect',
                        name: 'name'
                    },
                    {
                        data: 'ip',
                        name: 'ip'
                    },
                    {
                        data: 'port',
                        name: 'port'
                    },
                    {
                        data: 'comkey',
                        name: 'comkey'
                    },
                    {
                        data: 'active_switch',
                        name: 'active_switch'
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

            $('#machines-table').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                $('#form-delete').attr('action', "{{ url('admin/machines/delete') }}/" + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin menghapus mesin fingerprint ini ?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes, delete it!",
                }).then(function(t) {
                    // console.log(t.isConfirmed);
                    if (t.isConfirmed != false) {
                        $('#form-delete').submit();
                    }
                });
            })

            $('#machines-table').on('change', '.btn-update-active', function() {
                var id = $(this).data('id');
                $('#form-update-active').attr('action', "{{ url('admin/machines/active') }}/" + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin mengaktifkan fingerprint ini ?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes, active it!",
                }).then(function(t) {
                    $('#form-update-active').submit();
                });
            })
        });
    </script>
@endsection
