@extends('layouts.app.index')

@section('title')
    Submissions
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
                <h4 class="mb-sm-0 font-size-18">Submissions</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Submission</li>
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
                                <a href="{{ route('submission.create.employee') }}"
                                    class="btn btn-info waves-effect waves-light w-sm">
                                    <i class='bx bxs-add-to-queue d-block font-size-20'></i> Tambah Pengajuan
                                </a>
                            </div>
                        </div>

                        <h4 class="card-title">Daftar Pengajuan</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar pengajuan anda yang ada pada sistem.
                        </p>
                    </div>

                    <div class="table-responsive">
                        <table id="submission-table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th>JUDUL</th>
                                    <th>NOMINAL</th>
                                    <th>CATATAN</th>
                                    <th>ATASAN</th>
                                    <th>VALIDASI ATASAN</th>
                                    <th>VALIDASI DIREKTUR</th>
                                    <th>VALIDASI FINANCE</th>
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


    <div class="modal fade" id="uploadReceipt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="uploadReceiptLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadReceiptLabel">Upload Bukti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form-upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb3">
                            <label for="">Bukti</label>
                            <input class="form-control" type="file" id="bukti" name="receipt_image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="form-upload" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
    </div>
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
            var table = $("#submission-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{{ route('submission.datatable.employee') }}',
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
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: 'nominal',
                        name: 'nominal',
                        render: $.fn.dataTable.render.number(',', '.', 0)
                    },
                    {
                        data: '_note',
                        name: 'note',
                        render: function(data, type, full, meta) {
                            return "<div class='text-wrap width-200'>" + data + "</div>";
                        },
                    },
                    {
                        data: 'supervisor',
                        name: 'supervisor'
                    },
                    {
                        data: '_validation_supervisor',
                        name: 'validation_supervisor'
                    },
                    {
                        data: '_validation_director',
                        name: 'validation_director'
                    },
                    {
                        data: '_validation_finance',
                        name: 'validation_finance'
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


            $('#submission-table').on('click', '.btn-receipt', function() {
                var id = $(this).data('id');
                $('#form-upload').attr('action', "{{ url('employee/submission/upload_receipt') }}/" +
                    id);
                $('#uploadReceipt').modal('show');
            });


            $('#submission-table').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                $('#form-delete').attr('action', "{{ url('employee/submission/delete') }}/" + id);

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
        });
    </script>
@endsection
