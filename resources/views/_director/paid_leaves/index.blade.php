@extends('layouts.app.index')

@section('title')
    Paid Leave
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
                <h4 class="mb-sm-0 font-size-18">Paid Leaves</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Paid Leaves</li>
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
                                <label for="">Tanggal Cuti</label>
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
                        {{-- <div class="float-end row">
                            <div class="input-group input-group-sm">
                                <a href="{{ route('paid_leaves.create') }}"
                                    class="btn btn-info waves-effect waves-light w-sm">
                                    <i class='bx bxs-add-to-queue d-block font-size-20'></i> Tambah Pengajuan
                                </a>
                            </div>
                        </div> --}}

                        <h4 class="card-title">Daftar Cuti</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar cuti karyawan yang ada pada sistem.
                        </p>
                    </div>

                    <div class="table-responsive">
                        <table id="paid_leave-table" class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th>NAMA</th>
                                    <th>TANGGAL MULAI</th>
                                    <th>TANGGAL SELESAI</th>
                                    <th>ATASAN</th>
                                    <th>VALIDASI ATASAN</th>
                                    <th>VALIDASI HRD</th>
                                    <th>VALIDASI DIREKTUR</th>
                                    <th>TOTAL CUTI</th>
                                    <th>SISA CUTI</th>
                                    <th>CREATED AT</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <form action="" id="form-delete" method="POST">
        @csrf
        @method('DELETE')
    </form>

    <form action="" id="form-validation" method="POST">
        @csrf
        @method('PUT')
    </form>

    <form action="" id="form-rejection" method="POST">
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
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(function() {

            var table = $("#paid_leave-table").DataTable({
                lengthChange: !1,
                pageLength: 200,
                scrollCollapse: true,
                scrollY: '50vh',
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: '{{ route('paid_leaves.datatable.director') }}',
                    data: function(d) {
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
                        name: 'name',
                    },
                    {
                        data: 'tanggal_mulai',
                        name: 'tanggal_mulai',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).lang('id').format(
                                'dddd, Do MMMM YYYY');
                        },
                        width: '15%'
                    },
                    {
                        data: 'tanggal_akhir',
                        name: 'tanggal_akhir',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).lang('id').format(
                                'dddd, Do MMMM YYYY');
                        },
                        width: '15%'
                    },
                    {
                        data: 'supervisor',
                        name: 'supervisor'
                    },
                    {
                        data: '_validation_supervisor',
                        name: 'validation_supervisor',
                        width: '4%'

                    },
                    {
                        data: '_validation_hrd',
                        name: 'validation_hrd',
                        width: '4%'

                    },
                    {
                        data: '_validation_director',
                        name: 'validation_director',
                        width: '4%'

                    },
                    {
                        data: 'total_cuti',
                        name: 'total_cuti',
                        width: '2%'
                    },
                    {
                        data: 'sisa_cuti',
                        name: 'sisa_cuti',
                        width: '2%'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(value) {
                            if (value === null) return "";
                            return '<small>' + moment(value).lang('id').format(
                                'Do MM YYYY H:mm:ss') + '</small>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ]
            });

            $('#paid_leave-table').on('click', '.btn-validation', function() {
                var id = $(this).data('id');
                $('#form-validation').attr('action', "{{ url('director/paid-leave/validation') }}/" + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin validasi pengajuan ini ?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes, validation it!",
                }).then(function(t) {
                    if (t.isConfirmed != false) {
                        $('#form-validation').submit();
                    }
                });
            });

            $('#paid_leave-table').on('click', '.btn-rejection', function() {
                var id = $(this).data('id');
                $('#form-rejection').attr('action', "{{ url('director/paid-leave/rejection') }}/" + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin menolak pengajuan ini ?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes, reject it!",
                }).then(function(t) {
                    if (t.isConfirmed != false) {
                        $('#form-rejection').submit();
                    }
                });
            });

            $('.select2').select2();

            $('#btn-filter').click(function() {
                table.draw();
            })
        });
    </script>
@endsection
