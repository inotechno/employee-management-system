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

    <style>
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 100%;
            /* Adjust based on your layout */
        }

        #cameraFeed {
            width: 100%;
            height: auto;
        }

        .camera-controls {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px;
            border-radius: 10px;
        }

        .camera-controls button {
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
                            <label for="camera" class="form-label">Capture Photo</label>
                            <p>Izinkan akses kamera untuk mengambil gambar</p>
                            <div class="camera-container">
                                <video id="cameraFeed" autoplay></video>
                                <canvas id="cameraCanvas" style="display: none;"></canvas>
                                <div class="camera-controls">
                                    <button type="button" id="switchCamera"
                                        class="bx bx-transfer-alt bx-sm btn text-white"></button>
                                    <button type="button" id="capturePhoto"
                                        class="bx bx-camera bx-sm btn text-white"></button>
                                </div>

                                <input type="hidden" name="photo" id="photo-data">

                            </div>
                            {{-- <label for="">Upload Foto <span class="text-danger text-sm">* Maksimal ukuran
                                    3MB</span></label>
                            <input name="photo" type="file" class="form-control"> --}}
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

            const video = document.getElementById('cameraFeed');
            video.setAttribute('playsinline', '');
            video.setAttribute('webkit-playsinline', '');
            const canvas = document.getElementById('cameraCanvas');
            const captureButton = document.getElementById('capturePhoto');
            const switchButton = document.getElementById('switchCamera');
            const context = canvas.getContext('2d');
            let currentStream = null;
            let videoDevices = [];
            let currentIndex = 0;

            function stopCamera() {
                if (currentStream) {
                    currentStream.getTracks().forEach(track => track.stop());
                    currentStream = null;
                }
            }

            function startCamera(deviceId) {
                setTimeout(() => {
                    const constraints = {
                        video: deviceId ? {
                            deviceId: {
                                exact: deviceId
                            }
                        } : true
                    };

                    navigator.mediaDevices.getUserMedia(constraints)
                        .then(function(stream) {
                            currentStream = stream;
                            video.srcObject = stream;
                            return video.play();
                        })
                        .catch(function(err) {
                            console.error("Error accessing camera:", err);
                        });
                }, 100);
            }

            getVideoDevices();
            getLocation();

            function getVideoDevices() {
                navigator.mediaDevices.enumerateDevices()
                    .then(function(devices) {
                        videoDevices = devices.filter(device => device.kind === 'videoinput');
                        if (videoDevices.length > 0) {
                            startCamera(videoDevices[currentIndex].deviceId);
                        } else {
                            console.error('No video input devices found.');
                        }
                    })
                    .catch(function(err) {
                        console.error("Error getting devices:", err);
                    });
            }

            captureButton.addEventListener('click', function() {
                if (video.srcObject) {
                    const MAX_WIDTH = 800;
                    const MAX_HEIGHT = 600;
                    let width = video.videoWidth;
                    let height = video.videoHeight;

                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    context.drawImage(video, 0, 0, width, height);
                    const dataURL = canvas.toDataURL('image/jpeg');
                    document.getElementById('photo-data').value = dataURL;

                    notification('success', 'Capture image successfully');
                    video.pause();
                } else {
                    console.error("Tidak ada stream video yang aktif.");
                }
            });

            switchButton.addEventListener('click', function() {
                if (videoDevices.length > 1) {
                    currentIndex = (currentIndex + 1) % videoDevices.length;
                    stopCamera();

                    startCamera(videoDevices[currentIndex].deviceId);
                } else {
                    alert("Hanya ada satu kamera yang tersedia.");
                    console.log("Hanya ada satu kamera yang tersedia.");
                }
            });

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
                    $('#form-photo').show();
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
                // Cek dukungan geolocation
                if (!navigator.geolocation) {
                    notification("error", "Geolocation is not supported by this browser.");
                    return;
                }

                const options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0 // Selalu dapatkan posisi terbaru
                };

                try {
                    navigator.permissions.query({
                        name: 'geolocation'
                    }).then(function(result) {
                        if (result.state === 'denied') {
                            notification("error", "Please enable location access in your browser settings");
                            return;
                        }

                        // Request position
                        navigator.geolocation.getCurrentPosition(
                            showPosition,
                            showError,
                            options
                        );
                    });
                } catch (error) {
                    notification("error", "Error accessing location: " + error.message);
                }
            }

            function showPosition(position) {
                try {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Validasi koordinat
                    if (!isValidCoordinate(latitude, longitude)) {
                        notification("error", "Invalid coordinates received");
                        return;
                    }

                    $('[name="longitude"]').val(longitude);
                    $('[name="latitude"]').val(latitude);
                    $('#location').html(`Latitude: ${latitude}, Longitude: ${longitude}`);

                    notification("success", "Location successfully obtained");
                } catch (error) {
                    notification("error", "Error processing location data: " + error.message);
                }
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

            // Fungsi helper untuk validasi koordinat
            function isValidCoordinate(lat, lng) {
                return lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;
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
                        video.pause();
                        return true;
                    }
                } else {
                    if ($('[name="site_uid"]').val() == "") {
                        notification('error', 'Scan qr terlebih dahulu');
                        return false;
                    } else {
                        video.pause();
                        return true;
                    }
                }
            })
        });
    </script>
@endsection
