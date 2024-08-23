@extends('layouts.app.index')

@section('title')
    Attendance
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
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
                <h4 class="mb-sm-0 font-size-18">Attendances</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Attendances</li>
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
                    <div class="clearfix mb-3">
                        <div class="float-end row">
                            <div class="col-md">
                                <div class="input-group input-group-sm">
                                    <button id="modal-addAttendance" class="btn btn-info waves-effect waves-light w-sm"
                                        data-bs-toggle="modal" data-bs-target="#addAttendance">
                                        <i class='bx bxs-add-to-queue d-block font-size-20'></i> Absen Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix">

                        <div class="float-end row mb-2">

                            <label for="" class="col-md-2 col-form-label">Filter</label>
                            <div class="col-md-10">
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd"
                                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" name="start_date" class="form-control" name="start"
                                        placeholder="Start Date" />
                                    <input type="text" name="end_date" class="form-control" name="end"
                                        placeholder="End Date" />
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">Attendance List</h4>
                        <p class="card-title-desc">Dibawah ini merupakan daftar absensi anda yang ada pada sistem.
                        </p>
                    </div>

                    <table id="attendance-table" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
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

    <div class="modal fade" id="addAttendance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="addAttendanceLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('attendance.employee.create') }}" method="POST" id="form-add-attendance"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="">Pilih Jenis Absen</label>
                            <select name="event_id" class="form-control" id="event">
                                <option value="">-- Select Option --</option>
                                @foreach ($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                                @endforeach
                            </select>
                            <small>* Absensi wajib menggunakan QRCode, Tag hanya untuk Event diluar site.</small>
                            <div class="alert alert-danger" role="alert" id="alert-tag">
                                <p>Absensi menggunakan Tag harus melalui
                                    verifikasi HRD tidak
                                    langsung masuk ke
                                    sistem!</p>
                            </div>
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
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="form-group mt-3" id="form-photo">
                            <label for="">Upload Foto <span class="text-danger text-sm">* Maksimal ukuran
                                    3MB</span></label>
                            <input name="photo" type="file" class="form-control">
                        </div>

                        <input type="hidden" name="longitude" value="0">
                        <input type="hidden" name="latitude" value="0">
                        <input type="hidden" name="site_uid">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="form-add-attendance" class="btn btn-primary">Submit</button>
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
    <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        $(function() {
            $('#qr-reader').hide();
            $('#alert-tag').hide();
            // $('#btn-sync').hide();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var table = $("#attendance-table").DataTable({
                lengthChange: !1,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{{ route('attendances.datatable.employee') }}',
                    type: "POST",
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                        d.start_date = $('input[name=start_date]').val();
                        d.end_date = $('input[name=end_date]').val();
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
                        className: 'text-center align-middle',
                        width: '3%'
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
                        width: '40%'
                    },
                    {
                        data: '_out',
                        name: '_out',
                        orderable: false,
                        width: '40%'
                    },
                ]
            });

            $('[name="start_date"]').change(function() {
                table.draw();
            });

            $('[name="end_date"]').change(function() {
                table.draw();
            });

            $('#event').change(function() {
                var val = $(this).val();
                console.log(val);
                if (val == 1) {
                    $('#alert-tag').fadeIn();
                    $('#map').show();
                    $('#qr-reader').html('');
                    $('#qr-reader').hide();
                    // map();
                    getLocation();
                } else {
                    $('#alert-tag').hide();
                    $('#map').hide();
                    $('#map').html('');
                    $('#qr-reader').show();
                    $('#form-photo').hide();
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

            $('#form-add-attendance').submit(function() {
                if ($('#event').val() == 1) {
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
            })
        });
    </script>
@endsection
