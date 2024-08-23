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
    <style>
        .html5-qrcode-element {
            background-color: red;
            /* Green */
            border: none;
            border-radius: 5px;
            color: white;
            padding: 10px 22px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            transition-duration: 0.4s;
        }

        .html5-qrcode-element:hover {
            background-color: #9a0808;
            /* Green */
            color: white;
        }
    </style>
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
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <div class="float-end row">
                            <div class="col-md">
                                <div class="input-group input-group-sm">
                                    <button id="modal-scanVisit"
                                        class="btn btn-info waves-effect waves-light w-sm"data-bs-toggle="modal"
                                        data-bs-target="#scanVisit">
                                        <i class='bx bxs-add-to-queue d-block font-size-20'></i> Visit Scan
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix">
                        <h4 class="card-title">Visit List</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar visit yang ada pada sistem.</p>
                    </div>

                    <table id="visits-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>SITE</th>
                                <th>MAP</th>
                                <th>STATUS</th>
                                <th>CATEGORY</th>
                                <th>KETERANGAN</th>
                                <th>CREATED AT</th>
                                <th>ACTION</th>
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

    <div class="modal fade" id="scanVisit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="scanVisitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('visits.store.employee') }}" method="POST" id="form-add-visit">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="">Pilih Jenis Absen</label>
                            <select name="event_id" class="form-control" id="event">
                                <option value="">-- Select Option --</option>
                                <option value="tag">Tag</option>
                                <option value="qrcode">QRCode</option>
                            </select>
                            <small>* Visit wajib menggunakan QRCode, Tag hanya untuk yang tidak ada QRCode.</small>
                        </div>

                        <div id="qr-reader"></div>
                        <div id="qr-reader-results"></div>

                        <div class="text-center mt-3">
                            <h4 id="site_name"></h4>
                            <h5 id="location"></h5>
                            <h6 class="badge bg-info" id="distance"></h6>
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-warning btn-sm" id="btn-sync">Refresh Location</button>
                        </div>

                        <div class="form-group mt-3">
                            <label for="" class="form-label d-block">Status</label>
                            <select name="status" id="" class="form-control select2-category">
                                <option value="">-- Pilih Status --</option>
                                <option value="0">Check In</option>
                                <option value="1">Check Out</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="" class="form-label d-block">Kategori Visit</label>
                            <select name="visit_category_id" id="" class="form-control select2-category">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-warning btn-sm" id="btn-sync">Refresh
                                Location</button>
                        </div>

                        <div class="form-group mt-3">
                            <label for="">Keterangan Visit</label>
                            <textarea name="keterangan" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>

                        <input type="hidden" name="longitude">
                        <input type="hidden" name="latitude">
                        <input type="hidden" name="site_uid">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="form-add-visit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-upload" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Upload Berkas</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('visits.upload.employee') }}" method="POST" id="form-upload"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label for="">Pilih Berkas <small class="text-danger">* Max file size
                                    3mb format jpg,png,jpeg,gif,svg</small></label>
                            <input type="file" name="file"
                                class="form-control @error('file') is-invalid @enderror">
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
                    <img class="img-fluid" src="" id="file-visit" alt="">
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
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        $(function() {
            $('#qr-reader').hide();
            $('#btn-sync').hide();
            // $('#qr-reader').hide();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var table = $("#visits-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: '{{ route('visits.datatable.employee') }}',
                    type: "POST",
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                        d.site_id = $('[name="site_id"]').val();
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
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        className: 'text-center align-middle'
                    },
                    {
                        data: '_site',
                        name: '_site',
                    },
                    {
                        data: 'map',
                        name: 'map'
                    },
                    {
                        data: '_status',
                        name: 'status',
                    },
                    {
                        data: 'category.name',
                        name: 'category.name'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
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
                        name: 'action'
                    },
                ]
            });

            $('#event').change(function() {
                var val = $(this).val();
                console.log(val);
                if (val == "tag") {
                    $('#map').show();
                    $('#qr-reader').html('');
                    $('#qr-reader').hide();
                    // map();
                    getLocation();
                } else {
                    $('#map').hide();
                    $('#map').html('');
                    $('#qr-reader').show();
                    qrcode();
                    getLocation();
                }
            })

            function getLocation() {
                const options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                };
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError, options);
                } else {
                    notification("error", "Geolocation is not supported by this browser.");
                }
            }

            function showPosition(position) {
                $('[name="longitude"]').val(position.coords
                    .longitude);
                $('[name="latitude"]').val(position.coords.latitude);

                $('#location').html("Latitude: " + position.coords.latitude + ", Longitude: " + position.coords
                    .longitude);
            }

            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        notification("error", "User denied the request for Geolocation.")
                        break;
                    case error.POSITION_UNAVAILABLE:
                        notification("error", "Location information is unavailable.")
                        break;
                    case error.TIMEOUT:
                        notification("error", "The request to get user location timed out.")
                        break;
                    case error.UNKNOWN_ERROR:
                        notification("error", "An unknown error occurred.")
                        break;
                }
            }

            function qrcode() {
                var resultContainer = document.getElementById('qr-reader-results');
                var lastResult, countResults = 0;

                function onScanSuccess(decodedText, decodedResult) {
                    if (decodedText !== lastResult) {
                        ++countResults;
                        lastResult = decodedText;
                        $('[name="site_uid"]').val(decodedText);
                        notification('success', 'Berhasil scan qrcode, silahkan submit');
                        getSite(decodedText);
                        $('#qr-reader').hide();
                        $('#btn-sync').show();

                        // Handle on success condition with the decoded message.
                        // console.log(`Scan result ${decodedText}`, decodedResult);
                    }
                }

                var html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", {
                        fps: 10,
                        qrbox: 250
                    });

                html5QrcodeScanner.render(onScanSuccess);
            }

            function getSite(uid) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('visits.get_site.employee') }}",
                    data: {
                        uid: uid,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success == false) {
                            notification('success', response.message);
                        }
                        getDistance();
                        $('#site_name').html(response.data.name);
                    }
                });
            }

            function getDistance() {
                getLocation();

                var long = $('[name="longitude"]').val();
                var lat = $('[name="latitude"]').val();
                var uid = $('[name="site_uid"]').val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('visits.get_distance.employee') }}",
                    data: {
                        uid: uid,
                        lat: lat,
                        long: long,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success == false) {
                            notification('success', response.message);
                        }

                        $('#distance').html('Distance : ' + response.distance);
                    }
                });
            }

            $('#btn-sync').click(function() {
                getDistance();
            })

            $('.select2').select2();
            $('.select2-category').select2({
                dropdownParent: $('#scanVisit'),
                width: '100%'
            });

            $('#btn-filter').click(function() {
                table.draw();
            })

            $('#visits-table').on('click', '.btn-upload', function() {
                var id = $(this).data('id');
                $('[name="id"]').val(id);
                $('#modal-upload').modal('show');
            });

            $('#visits-table').on('click', '.btn-view-file', function() {
                var file = $(this).data('file');
                $('#file-visit').attr('src', file);
                $('#modal-view').modal('show');
            });

            $('#form-add-visit').submit(function() {
                if ($('#event').val() == "tag") {
                    if ($('[name="longitude"]').val() == "" && $('[name="latitude"]').val() == "") {
                        notification('error',
                            'Klik pada tombol koordinat terlebih dahulu untuk menentukan lokasi');
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    if ($('[name="site_uid"]').val() == "") {
                        notification('error', 'Scan qr terlebih dahulu');
                        return false;
                    } else {
                        return true;
                    }
                }

                if ($('[name="keterangan"]').val() == "") {
                    notification('error', 'Keterangan wajib di isi');
                    return false;
                } else {
                    return true;
                }
            })
        });
    </script>
@endsection
