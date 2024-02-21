@extends('layouts.app.index')

@section('title')
    Announcement
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
                <h4 class="mb-sm-0 font-size-18">Announcement</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Announcement</li>
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
                                <a href="{{ route('announcements.create') }}" class="btn btn-info">
                                    <i class='bx bxs-add-to-queue'></i> Add Announcement
                                </a>
                            </div>
                        </div>

                        <h4 class="card-title">Announcement List</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar position yang ada pada sistem.
                        </p>
                    </div>

                    <table id="announcements-table" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>Name</th>
                                <th>Description</th>
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
            $("#announcements-table").DataTable({
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
                ajax: {
                    url: "{{ route('announcements.datatable') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center align-middle'
                    }, {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: '_description',
                        name: 'description'
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

            $('#announcements-table').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                $('#form-delete').attr('action', "{{ url('admin/announcements/delete') }}/" + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin menghapus pengumuman ini ?",
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

            $('#announcements-table').on('click', '.btn-send', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Apakah anda yakin ingin mengirim email pengumuman ini ?",
                    icon: "info",
                    showCancelButton: !0,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes, send it!",
                }).then(function(t) {
                    if (t.isConfirmed != false) {
                        window.location.href = "{{ url('admin/announcements/send') }}/" + id;
                    }
                });
            })
        });
    </script>
@endsection
