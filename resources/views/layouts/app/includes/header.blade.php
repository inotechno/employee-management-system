<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('/') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ config('setting.logo_full') }}" alt="" height="45">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ config('setting.logo_full') }}" alt="" height="25">
                    </span>
                </a>

                <a href="{{ url('/') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ config('setting.logo_full') }}" alt="" height="45">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ config('setting.logo_full') }}" alt="" height="25">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="bx bx-search-alt"></span>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @hasrole('hrd')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-bell bx-tada"></i>
                        <span class="badge bg-danger rounded-pill">{{ $_paidleaves->count() + $_absents->count() }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small" key="t-view-all"> View All</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            @foreach ($_paidleaves as $paid_leave)
                                <a href="{{ route('paid_leaves.hrd') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($paid_leave->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $paid_leave->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $paid_leave->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Pengajuan Cuti
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($paid_leave->description), 0, 50) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $paid_leave->tanggal_mulai }} -
                                                        {{ $paid_leave->tanggal_akhir }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($_absents as $absent)
                                <a href="{{ route('absents.hrd') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($absent->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $absent->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $absent->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">{{ strtoupper($absent->type) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($absent->description), 0, 50) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $absent->date }} </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="p-2 border-top d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                    More..</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endrole

            @hasrole('finance')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-bell bx-tada"></i>
                        <span class="badge bg-danger rounded-pill">{{ $_submissions->count() }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small" key="t-view-all"> View All</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            {{-- @foreach ($_daily_reports as $daily_report)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $daily_report->description);
                                @endphp
                                <a href="{{ route('daily_reports.show.finance', $daily_report->id) }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($daily_report->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $daily_report->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $daily_report->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Daily Report
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($desc), 0, 400) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $daily_report->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach --}}

                            @foreach ($_submissions as $submission)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $submission->note);
                                @endphp
                                <a href="{{ route('submission.finance') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($submission->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $submission->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $submission->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-info">Pengajuan Keuangan
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{{ $submission->title }}, nominal
                                                    {{ $submission->nominal }}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $submission->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="p-2 border-top d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                    More..</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endrole

            @hasrole('director')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-bell bx-tada"></i>
                        <span
                            class="badge bg-danger rounded-pill">{{ $_paidleaves->count() + $_submissions->count() + $_absents->count() }}</span>
                        {{-- <span class="badge bg-danger rounded-pill">{{ $_paidleaves->count() + $_submissions->count() + $_daily_reports->count() + $_comment_daily_reports->count() }}</span> --}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small" key="t-view-all"> View All</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">

                            {{-- @foreach ($_comment_daily_reports as $comment)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $comment->comment);
                                @endphp
                                <a href="{{ route('daily_reports.show.all', $comment->daily_report_id) }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($comment->user->foto != null)
                                            <img src="{{ asset('images/users/' . $comment->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $comment->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Comment Daily Report
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($desc), 0, 400) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $comment->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach --}}

                            {{-- @foreach ($_daily_reports as $daily_report)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $daily_report->description);
                                @endphp
                                <a href="{{ route('daily_reports.show.all', $daily_report->id) }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($daily_report->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $daily_report->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $daily_report->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Daily Report
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($desc), 0, 400) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $daily_report->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach --}}

                            @foreach ($_submissions as $submission)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $submission->note);
                                @endphp
                                <a href="{{ route('submission.director') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($submission->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $submission->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $submission->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-info">Pengajuan Keuangan
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{{ $submission->title }}, nominal
                                                    {{ $submission->nominal }}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $submission->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($_paidleaves as $paid_leave)
                                <a href="{{ route('paid_leaves.director') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($paid_leave->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $paid_leave->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $paid_leave->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Pengajuan Cuti
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($paid_leave->description), 0, 50) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $paid_leave->tanggal_mulai }} -
                                                        {{ $paid_leave->tanggal_akhir }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($_absents as $absent)
                                <a href="{{ route('absents.director') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($absent->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $absent->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $absent->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">{{ strtoupper($absent->type) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($absent->description), 0, 50) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $absent->date }} </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="p-2 border-top d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                    More..</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endrole

            @hasrole('administrator')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-bell bx-tada"></i>
                        <span
                            class="badge bg-danger rounded-pill">{{ $_paidleaves->count() + $_submissions->count() + $_absents->count() }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small" key="t-view-all"> View All</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">

                            {{-- @foreach ($_daily_reports as $daily_report)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $daily_report->description);
                                @endphp
                                <a href="{{ route('daily_reports.show', $daily_report->id) }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($daily_report->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $daily_report->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $daily_report->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Daily Report
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($desc), 0, 400) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $daily_report->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach --}}

                            @foreach ($_submissions as $submission)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $submission->note);
                                @endphp
                                <a href="{{ route('submission') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($submission->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $submission->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $submission->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-info">Pengajuan Keuangan
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{{ $submission->title }}, nominal
                                                    {{ $submission->nominal }}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $submission->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($_paidleaves as $paid_leave)
                                <a href="{{ route('paid_leaves') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($paid_leave->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $paid_leave->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $paid_leave->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Pengajuan Cuti
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($paid_leave->description), 0, 50) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $paid_leave->tanggal_mulai }} -
                                                        {{ $paid_leave->tanggal_akhir }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($_absents as $absent)
                                <a href="{{ route('absents') }}" class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($absent->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $absent->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $absent->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">{{ strtoupper($absent->type) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($absent->description), 0, 50) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $absent->date }} </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="p-2 border-top d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                    More..</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endrole

            @hasrole('employee')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-bell bx-tada"></i>
                        <span
                            class="badge bg-danger rounded-pill">{{ $_comment_daily_reports->count() + $_notif_submissions_users->count() + $_notif_paid_leaves_users->count() }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small" key="t-view-all"> View All</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">

                            @foreach ($_comment_daily_reports as $comment)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $comment->comment);
                                @endphp
                                <a href="{{ route('daily_reports.show.all', $comment->daily_report_id) }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($comment->daily_report->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $comment->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $comment->daily_report->employee->user->name }}
                                                    </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Comment Daily Report
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($desc), 0, 400) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $comment->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($_notif_submissions_users as $submission)
                                @php
                                    $desc = preg_replace('~>\s+<~', '><', $submission->title);
                                @endphp
                                <a href="{{ route('submissions.show.all', $submission->id) }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">

                                        @if ($submission->employee->user->foto != null)
                                            <img src="{{ asset('images/users/' . $submission->employee->user->foto) }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @else
                                            <img src="{{ asset('images/users/default.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        @endif

                                        <div class="flex-grow-1">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <h6 class="">{{ $submission->employee->user->name }} </h6>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge bg-warning">Submission
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($desc), 0, 400) !!}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-hours-ago">{{ $submission->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($_notif_paid_leaves_users as $paid_leave)
                                <a href="{{ route('paid_leaves.show.all', $paid_leave->id) }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">

                                        <div class="d-flex">

                                            @if ($paid_leave->employee->user->foto != null)
                                                <img src="{{ asset('images/users/' . $paid_leave->employee->user->foto) }}"
                                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            @else
                                                <img src="{{ asset('images/users/default.jpg') }}"
                                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            @endif

                                            <div class="flex-grow-1">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <h6 class="">{{ $paid_leave->employee->user->name }} </h6>
                                                    </div>
                                                    <div class="col-auto">
                                                        <span class="badge bg-warning">Pengajuan Cuti
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-simplified">{!! Str::substr(strip_tags($paid_leave->description), 0, 50) !!}</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                            key="t-hours-ago">{{ $paid_leave->tanggal_mulai }} -
                                                            {{ $paid_leave->tanggal_akhir }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                        <div class="p-2 border-top d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                    More..</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endrole

            @hasanyrole('administrator|hrd|finance|director')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (auth()->user()->foto != null)
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('images/users/' . auth()->user()->foto) }}" alt="Header Avatar">
                        @else
                            <img class="rounded-circle header-profile-user" src="{{ asset('images/users/default.jpg') }}"
                                alt="Header Avatar">
                        @endif

                        <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ auth()->user()->name }}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit"><i
                                    class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                    key="t-logout">Logout</span></button>
                        </form>
                    </div>
                </div>
            @endhasanyrole
            @hasrole('employee')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (auth()->user()->foto != null)
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('images/users/' . auth()->user()->foto) }}" alt="Header Avatar">
                        @else
                            <img class="rounded-circle header-profile-user" src="{{ asset('images/users/default.jpg') }}"
                                alt="Header Avatar">
                        @endif

                        <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ auth()->user()->name }}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit"><i
                                    class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                    key="t-logout">Logout</span></button>
                        </form>
                    </div>
                </div>
            @endrole
        </div>
    </div>
</header>
