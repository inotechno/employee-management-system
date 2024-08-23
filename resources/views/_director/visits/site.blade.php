@extends('layouts.app.index')

@section('title')
    Site Visitor
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
                <h4 class="mb-sm-0 font-size-18">Site Visitor</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Site Visitor</li>
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
                                <label for="" class="form-label">Nama Site</label>
                                <select name="site_id" id="" class="form-control select2">
                                    <option value="">-- Pilih Site --</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="mb-3">
                                <label for="">Bulan</label>
                                <input type="month" class="form-control" name="month">
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
                        <h4 class="card-title">Site List</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar visit yang ada pada sistem selama periode
                            tertentu.</p>
                    </div>

                    <table id="visits-table" class="table table-bordered dt-responsive w-100">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAME</th>
                                <th>KOORDINAT</th>
                                <th>PERIODE</th>
                                <th>TOTAL</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div id="modal-detail" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Detail Visitor <span id="site_name"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table dt-responsive w-100" id="table-detail">
                        <thead>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                        </thead>
                        <tbody id="body-detail"></tbody>
                    </table>
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
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var table = $("#visits-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: '{{ route('visit.director.datatable.sites') }}',
                    type: "POST",
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                        d.site_id = $('[name="site_id"]').val();
                        d.month = $('[name="month"]').val();
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
                        width: "2%",
                        className: 'text-center'
                    }, {
                        data: 'site.name',
                        name: 'site.name',
                        width: "20%"
                    },
                    {
                        data: 'coordinate',
                        name: 'coordinate',
                        width: "15%"
                    },
                    {
                        data: 'periode',
                        name: 'periode',
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: function(value) {

                            return value + ' Visitor';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ]
            });

            $('#visits-table').on('click', '.btn-detail', function() {
                var site_id = $(this).data('site_id');
                var name = $(this).data('name');
                var month = $(this).data('month');
                var year = $(this).data('year');

                $('#site_name').html(name);

                var detail = $("#table-detail").DataTable({
                    lengthChange: !1,
                    // retrieve: true,
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    searching: true,
                    ajax: {
                        url: '{{ route('visits.director.detail') }}',
                        type: "GET",
                        data: function(d) {
                            d.site_id = site_id;
                            d.month = month;
                            d.year = year;
                            // d._token = CSRF_TOKEN;
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
                            width: "2%",
                            className: 'text-center'
                        },
                        {
                            data: 'employee.user.name',
                            name: 'employee.user.name',
                        },
                        {
                            data: 'date',
                            name: 'date',
                        },
                    ]
                });

                $('#modal-detail').modal('show');
            });

            $('.select2').select2();

            $('#btn-filter').click(function() {
                table.draw();
            })
        });
    </script>
@endsection
