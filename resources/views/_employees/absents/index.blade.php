@extends('layouts.app.index')

@section('title')
    Absent / Sakit
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
                <h4 class="mb-sm-0 font-size-18">Absent / Sakit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Absent / Sakit</li>
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
                            <div class="input-group input-group-sm">
                                <a href="{{ route('absents.create.employee') }}"
                                    class="btn btn-info waves-effect waves-light w-sm">
                                    <i class='bx bxs-add-to-queue d-block font-size-20'></i> Tambah Pengajuan
                                </a>
                            </div>
                        </div>

                        <h4 class="card-title">Daftar Tidak Hadir (Sakit)</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar tidak hadir (Sakit) anda yang ada pada
                            sistem.
                        </p>
                    </div>

                    <div class="table-responsive">
                        <table id="absent-table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th>TANGGAL</th>
                                    <th>DESCRIPTION</th>
                                    <th>VALIDASI AT</th>
                                    <th>VALIDASI BY</th>
                                    <th>STATUS</th>
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

    <div id="modal-upload" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Upload Berkas</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('absents.upload.employee') }}" method="POST" id="form-upload"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label for="">Pilih Berkas <small class="text-danger">* Max file size
                                    3mb format jpg,png,jpeg,gif,svg</small></label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="form-upload" class="btn btn-primary">Submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="modal-view" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img class="img-fluid" src="" id="file-absent" alt="">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
            var table = $("#absent-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: '{{ route('absents.datatable.employee') }}',
                    type: "POST",
                    data: function(d) {
                        d._token = CSRF_TOKEN;
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
                        data: 'date',
                        name: 'date',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).lang('id').format(
                                'dddd, Do MMMM YYYY');
                        }
                    },
                    {
                        data: 'description',
                        name: 'description',
                    },
                    {
                        data: '_validation_at',
                        name: 'validation_at',
                        render: function(value) {
                            if (value === null)
                                return '<span class="badge bg-warning">Belum di validasi</span>';
                            return moment(value).lang('id').format(
                                'dddd, Do MMMM YYYY');
                        }
                    },
                    {
                        data: '_validation_by',
                        name: 'validation_by'
                    },
                    {
                        data: '_status',
                        name: 'status'
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
                    }
                ]
            });

            $('#absent-table').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                $('#form-delete').attr('action', "{{ url('employee/absents/delete') }}/" + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin menghapus pengajuan ini ?",
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
            });

            $('#absent-table').on('click', '.btn-upload', function() {
                var id = $(this).data('id');
                $('[name="id"]').val(id);
                $('#modal-upload').modal('show');
            });

            $('#absent-table').on('click', '.btn-view-file', function() {
                var file = $(this).data('file');
                $('#file-absent').attr('src', file);
                $('#modal-view').modal('show');
            });
        });
    </script>
@endsection
