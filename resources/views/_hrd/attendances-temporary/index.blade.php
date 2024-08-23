@extends('layouts.app.index')

@section('title')
    Attendance Temporary
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
                <h4 class="mb-sm-0 font-size-18">Attendances Temporary</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Attendances Temporary</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filter</h4>

                    <div class="row">
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="">Nama Karyawan</label>
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
                                <input type="date" class="form-control" name="date">
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
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        {{-- <div class="float-end">
                            <div class="input-group input-group-sm">
                                <a href="{{ route('attendances Temporary.sync.hrd') }}" class="btn btn-info">
                                    <i class='bx bxs-add-to-queue'></i> Sync
                                </a>
                            </div>
                        </div> --}}

                        <h4 class="card-title">Attendance List</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar absensi yang ada pada sistem,
                            dapat berfungsi untuk mengelola data absensi.
                        </p>
                    </div>

                    <table id="attendance-table" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>NAME</th>
                                <th>DATE</th>
                                <th>IN</th>
                                <th>OUT</th>
                                {{-- <th>CREATED AT</th> --}}
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <div class="modal fade" id="modal-detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="modal-detailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detailLabel">Detail Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" readonly id="keterangan"></textarea>
                    </div>

                    <div class="mb-3">
                        <img src="" class="img-fluid" id="photo" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" id="form-validation" method="POST">
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
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var table = $("#attendance-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('attendances.temporary.datatable.hrd') }}",
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
                        data: 'timestamp',
                        name: 'timestamp',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).lang('id').format(
                                'dddd, Do MMMM YYYY');
                        }
                    },
                    {
                        data: '_in',
                        name: '_in',
                        orderable: false,
                        width: '30%'
                    },
                    {
                        data: '_out',
                        name: '_out',
                        orderable: false,
                        width: '30%'
                    },
                    // {
                    //     data: 'created_at',
                    //     name: 'created_at',
                    //     render: function(value) {
                    //         if (value === null) return "";
                    //         return moment(value).lang('id').format(
                    //             'Do MMMM YYYY H:mm:ss');
                    //     }
                    // },
                ]
            });

            $('#attendance-table').on('click', '.btn-detail-in', function() {
                var keterangan = $(this).data('keterangan');
                var photo = $(this).data('photo');

                $('#photo').attr('src', photo);
                $('#keterangan').html(keterangan);
                $('#modal-detail').modal('show');
            });

            $('#attendance-table').on('click', '.btn-detail-out', function() {
                var keterangan = $(this).data('keterangan');
                var photo = $(this).data('photo');

                $('#photo').attr('src', photo);
                $('#keterangan').html(keterangan);
                $('#modal-detail').modal('show');
            });

            $('.select2').select2();

            $('#btn-filter').click(function() {
                table.draw();
            })

            $('#attendance-table').on('click', '.btn-validation', function() {
                var id = $(this).data('id');
                $('#form-validation').attr('action', "{{ url('hrd/attendances-temporary/validation') }}/" +
                    id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin validasi absensi menggunakan Tag ini ?",
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
        });
    </script>
@endsection
