@extends('layouts.app.index')

@section('title')
    Dashboard
@endsection

@section('content')
    @hasrole('administrator|director')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- Total Employee --}}
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total Employee</p>
                                <h4 class="mb-0">{{ $employees }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bxs-user-detail font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attendance --}}
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Attendance (Yesterday)</p>
                                <h4 class="mb-0">{{ $attendances }}</h4>
                            </div>
                            <a href="{{ url('director/attendances?date=' . $yesterday) }}"
                                class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bxs-shield font-size-24"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengajuan Cuti --}}
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Cuti (Yesterday)</p>
                                <h4 class="mb-0">
                                    <h4 class="mb-0">{{ $paid_leave }}</h4>
                                </h4>
                            </div>
                            <a href="{{ url('director/paid-leave?date=' . $yesterday) }}"
                                class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-chevrons-left font-size-24"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengajuan Izin Sakit --}}
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Sakit (Yesterday)</p>
                                <h4 class="mb-0">
                                    <h4 class="mb-0">{{ $ijin }}</h4>
                                </h4>
                            </div>
                            <a href="{{ url('director/absent?date=' . $yesterday) }}" class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-chevrons-left font-size-24"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Absent --}}
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Absent (Yesterday)</p>
                                <h4 class="mb-0">{{ $absent }}</h4>
                            </div>
                            <a href="{{ url('director/not-present?date=' . $yesterday) }}"
                                class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-chevrons-left font-size-24"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Visit --}}
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Visit (Yesterday)</p>
                                <h4 class="mb-0">{{ $visit }}</h4>
                            </div>
                            <a href="{{ url('director/visits?date=' . $yesterday) }}" class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-map-pin font-size-24"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daily Report --}}
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Daily Report (Yesterday)</p>
                                <h4 class="mb-0">{{ $daily_report }}</h4>
                                </h4>
                            </div>
                            <a href="{{ url('daily-report?date=' . $yesterday) }}" class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bxl-dailymotion font-size-24"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Site --}}
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total Site</p>
                                <h4 class="mb-0">{{ $site }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-sitemap font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="me-2">
                                <h5 class="card-title mb-4">Total Employee Visit</h5>
                            </div>
                            {{-- <div class="dropdown ms-auto">
                                <a class="text-muted font-size-16" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div> --}}
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <th scope="col" colspan="2">Employee</th>
                                    <th scope="col">Total</th>
                                </thead>
                                <tbody>
                                    @foreach ($total_visits as $visit)
                                        <tr>
                                            <td style="width: 50px;">
                                                @if ($visit->employee->user->foto == null)
                                                    <img src="{{ asset('images/users/default.jpg') }}" alt=""
                                                        class="avatar-xs h-auto d-block rounded">
                                                @else
                                                    <img src="{{ asset('images/users/' . $visit->employee->user->foto) }}"
                                                        alt="" class="avatar-xs h-auto d-block rounded">
                                                @endif
                                            </td>
                                            <td>
                                                <h5 class="font-size-13 text-truncate mb-1"><a href="javascript: void(0);"
                                                        class="text-dark">{{ $visit->employee->user->name }}</a></h5>
                                                @if ($visit->position == null)
                                                    <p class="mb-0 text-muted">Position</p>
                                                @else
                                                    <p class="mb-0 text-muted">
                                                        {{ $visit->employee->position->name }}
                                                    </p>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $visit->total }} Kunjungan
                                            </td>
                                        </tr><!-- end tr -->
                                    @endforeach
                                </tbody>
                            </table>


                        </div>

                        <div class="d-flex mt-3">
                            @hasrole('administrator')
                                <a class="" href="{{ route('visit.employees') }}">More Employee >>></a>
                            @endhasrole

                            @hasrole('director')
                                <a class="" href="{{ route('visit.director.employees') }}">More Employee >>></a>
                            @endhasrole
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>

            <div class="col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="me-2">
                                <h5 class="card-title mb-4">Total Visitor Site</h5>
                            </div>
                            {{-- <div class="dropdown ms-auto">
                                <a class="text-muted font-size-16" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div> --}}
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <tr>
                                    <th scope="col">Site</th>
                                    <th scope="col">Total</th>
                                </tr>
                                <tbody>
                                    @foreach ($total_visit_sites as $visit)
                                        <tr>
                                            <td class="d-flex">
                                                <div>
                                                    <h5 class="fs-13 mb-0">{{ $visit->site->name }}</h5>
                                                    @if ($visit->site->longitude == null)
                                                        <p class="fs-12 mb-0 text-muted">NULL</p>
                                                    @else
                                                        <p class="fs-12 mb-0 text-muted">
                                                            {{ $visit->site->longitude . ', ' . $visit->site->latitude }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                {{ $visit->total }} Visitor
                                            </td>

                                        </tr><!-- end tr -->
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex mt-3">
                            @hasrole('administrator')
                                <a href="{{ route('visit.sites') }}">More Sites >>></a>
                            @endhasrole

                            @hasrole('director')
                                <a href="{{ route('visit.director.sites') }}">More Sites >>></a>
                            @endhasrole
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>

        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="me-2">
                                <h5 class="card-title mb-4">Reminder List Employees for Date {{ $yesterday }}</h5>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Reminder Type</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Description</th>
                                </thead>
                                <tbody>
                                    @foreach ($reminders as $reminder)
                                        <tr>
                                            <td style="width: 50px;">
                                                @if ($reminder->employee->user->foto == null)
                                                    <img src="{{ asset('images/users/default.jpg') }}" alt=""
                                                        class="avatar-xs h-auto d-block rounded">
                                                @else
                                                    <img src="{{ asset('images/users/' . $reminder->employee->user->foto) }}"
                                                        alt="" class="avatar-xs h-auto d-block rounded">
                                                @endif
                                            </td>

                                            <td>{{ $reminder->employee->user->name }}</td>
                                            <td>{{ $reminder->reminder_type }}</td>
                                            <td>{{ $reminder->date }}</td>
                                            <td>{{ $reminder->description }}</td>
                                        </tr><!-- end tr -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex mt-3">
                            <a class="" href="{{ route('reminders') }}">More Reminder >>></a>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex">
                    <h4 class="card-title mb-4 flex-grow-1">Best Presence</h4>
                    <div>
                        <a href="job-list.html" class="btn btn-primary btn-sm">{{ date('Y') }}</a>
                    </div>
                </div>
            </div>

            @php
                $no = 0;
            @endphp
            @foreach ($best_presences as $key => $best_presence)
                <div class="col-lg-2">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                @if ($best_presence->employee->user->foto == null)
                                    <img src="{{ asset('images/users/default.jpg') }}" alt="" class="avatar-sm">
                                @else
                                    <img src="{{ asset('images/users/' . $best_presence->employee->user->foto) }}"
                                        alt="" class="avatar-sm">
                                @endif
                                <a href="job-details.html" class="text-body">
                                    <h5 class="mt-4 mb-2 font-size-15">{{ $best_presence->employee->user->name }}</h5>
                                </a>

                                @if ($best_presence->position == null)
                                    <p class="mb-0 text-muted">Position</p>
                                @else
                                    <p class="mb-0 text-muted">{{ $best_presence->employee->position->name }}</p>
                                @endif

                            </div>

                            @php
                                $peringkat = ['satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas', 'dua puluh'];
                            @endphp

                            <div class="d-flex">
                                <p class="mb-0 flex-grow-1 text-muted"><i class='bx bxs-trophy'></i>
                                    Ke {{ ucfirst($peringkat[$no++]) }}</p>
                                <p class="mb-0 text-muted">Total <b>{{ $best_presence->total }}</b></p>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
            @endforeach
        </div>
    @endrole

    @hasrole('employee')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>{{ config('setting.app_name') }}</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        @if (auth()->user()->foto != null)
                                            <img src="{{ asset('images/users/' . auth()->user()->foto) }}" alt=""
                                                class="img-thumbnail rounded-circle">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}" alt=""
                                                class="img-thumbnail rounded-circle">
                                        @endif
                                    </div>
                                    <h5 class="font-size-14">{{ auth()->user()->name }}</h5>
                                    <p class="text-muted mb-0 text-truncate">{{ auth()->user()->username }}</p>
                                </div>
                                <div class="col-sm-8">
                                    <div class="pt-4">
                                        <div class="mt-4">
                                            <a href="{{ route('users.employee') }}"
                                                class="btn btn-primary waves-effect waves-light btn-sm">View Profile <i
                                                    class="mdi mdi-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Attendance</p>
                                        <h4 class="mb-0">{{ $attendances }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-fingerprint font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Daily Report</p>
                                        <h4 class="mb-0">{{ $daily_report }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bxl-dailymotion font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Pengajuan Cuti</p>
                                        <h4 class="mb-0">{{ $paid_leave }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-chevrons-left font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Jumlah Cuti</p>
                                        <h4 class="mb-0">{{ $employee->jumlah_cuti }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-chevrons-left font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Tanggal Join</p>
                                        <h4 class="mb-0">{{ $employee->join_date }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-chevrons-left font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    @endrole

    @hasrole('hrd')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>{{ config('setting.app_name') }}</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    @if (auth()->user()->foto != null)
                                        <img src="{{ asset('images/users/' . auth()->user()->foto) }}" alt=""
                                            class="img-thumbnail rounded-circle">
                                    @else
                                        <img src="{{ asset('images/users/default.jpg') }}" alt=""
                                            class="img-thumbnail rounded-circle">
                                    @endif
                                </div>
                                <h5 class="font-size-14">{{ auth()->user()->name }}</h5>
                                <p class="text-muted mb-0 text-truncate">{{ auth()->user()->username }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Attendance</p>
                                        <h4 class="mb-0">{{ $attendances }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-fingerprint font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Position</p>
                                        <h4 class="mb-0">{{ $positions }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bxs-shield font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Employee & User</p>
                                        <h4 class="mb-0">{{ $employees }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bxs-user-detail font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Pengajuan Cuti</p>
                                        <h4 class="mb-0">{{ $paid_leave }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-chevrons-left font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    @endrole

    @hasrole('finance')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>{{ config('setting.app_name') }}</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    @if (auth()->user()->foto != null)
                                        <img src="{{ asset('images/users/' . auth()->user()->foto) }}" alt=""
                                            class="img-thumbnail rounded-circle">
                                    @else
                                        <img src="{{ asset('images/users/default.jpg') }}" alt=""
                                            class="img-thumbnail rounded-circle">
                                    @endif
                                </div>
                                <h5 class="font-size-14">{{ auth()->user()->name }}</h5>
                                <p class="text-muted mb-0 text-truncate">{{ auth()->user()->username }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Daily Report</p>
                                        <h4 class="mb-0">{{ $daily_reports }}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bxl-dailymotion font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection

@section('plugin')
    <!-- apexcharts -->
    <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard.init.js') }}"></script>
@endsection
