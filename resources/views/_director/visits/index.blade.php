@extends('layouts.app.index')

@section('title')
    Visit
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
                <h4 class="mb-sm-0 font-size-18">Visit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Visit</li>
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

                    <div class="clearfix">
                        <h4 class="card-title">Visit List</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar visit yang ada pada sistem.</p>
                    </div>

                    <table id="visits-table" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>NAME</th>
                                <th>DATE</th>
                                <th>IN</th>
                                <th>OUT</th>
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


    <div id="modal-view" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img class="img-fluid" src="" id="file-visit" alt="">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="modal-detailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detailLabel">Detail Visit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb3">
                        <label for="">Image</label>
                        <img src="" class="img-fluid text-center" alt="" id="file-image">
                    </div>
                    <div class="mb3">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" readonly id="keterangan"></textarea>
                    </div>
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
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var table = $("#visits-table").DataTable({
                lengthChange: !1,
                pageLength: 200,
                scrollCollapse: true,
                scrollY: '50vh',
                processing: true,
                serverSide: true,
                // order: [
                //     [0, 'asc']
                // ],
                ajax: {
                    url: '{{ route('visits.datatable.director') }}',
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
                        name: 'employee.user.name',
                        width: "15%"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(value) {
                            if (value === null) return "";
                            return moment(value).locale('id').format(
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
                ]
            });

            $('.select2').select2();
            $('#visits-table').on('click', '.btn-view-file', function() {
                var file = $(this).data('file');
                $('#file-visit').attr('src', file);
                $('#modal-view').modal('show');
            });

            $('#visits-table').on('click', '.btn-detail-in', function() {
                var keterangan = $(this).data('keterangan');
                var file = $(this).data('file');
                // console.log(keterangan);
                $('#file-image').attr('src', file);
                $('#keterangan').html(keterangan);
                $('#modal-detail').modal('show');
            });

            $('#visits-table').on('click', '.btn-detail-out', function() {
                var keterangan = $(this).data('keterangan');
                var file = $(this).data('file');

                $('#file-image').attr('src', file);
                $('#keterangan').html(keterangan);
                $('#modal-detail').modal('show');
            });

            $('#btn-filter').click(function() {
                table.draw();
            })
        });
    </script>
@endsection
