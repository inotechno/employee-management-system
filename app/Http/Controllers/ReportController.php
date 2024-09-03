<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use App\Helpers\SelisihHariCuti;
use App\Models\Absent;
use App\Models\ConfigAttendance;
use App\Models\DailyReport;
use App\Models\PaidLeave;
use App\Models\Submission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function paid_leave()
    {
        return view('paid_leaves.report');
    }

    function preview_paid_leave(Request $request)
    {
        $data = [];

        $paid_leaves = PaidLeave::with('employee')->where('validation_director', '!=', NULL);

        if ($request->employee_id) {
            $paid_leaves = $paid_leaves->where('employee_id', $request->employee_id);
        }

        if ($request->periode_start && $request->periode_end) {
            $periode_start = $request->periode_start;
            $periode_end = $request->periode_end;

            $paid_leaves = $paid_leaves->where(function ($query) use ($periode_start, $periode_end) {
                $query->whereBetween('tanggal_mulai', [$periode_start, $periode_end])
                    ->orWhereBetween('tanggal_akhir', [$periode_start, $periode_end])
                    ->orWhere(function ($query) use ($periode_start, $periode_end) {
                        $query->where('tanggal_mulai', '<=', $periode_start)
                            ->where('tanggal_akhir', '>=', $periode_end);
                    });
            });
        }

        $paid_leaves = $paid_leaves->get();

        // dd($paid_leaves);
        $html = '';
        $thead = '';
        $tbody = '';

        $thead .= '<thead>
                        <tr>
                            <th class="align-middle text-center" rowspan="2">ID</th>
                            <th class="align-middle text-center" rowspan="2">Nama</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal Cuti</th>
                            <th class="align-middle text-center" rowspan="2">Total Cuti</th>
                            <th class="align-middle text-center" rowspan="2">Keterangan</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal Validasi</th>
                        </tr>
                    </thead>';
        $tbody .= '<tbody>';

        foreach ($paid_leaves as $paid_leave) {

            $tanggal_mulai = Carbon::parse(date('Y-m-d H:i', strtotime($paid_leave->tanggal_mulai)))->isoFormat('LL');
            $tanggal_akhir = Carbon::parse(date('Y-m-d H:i', strtotime($paid_leave->tanggal_akhir)))->isoFormat('LL');
            $validation_director = Carbon::parse(date('Y-m-d H:i', strtotime($paid_leave->validation_director)))->isoFormat('LL');

            $tbody .= ' <tr>
                            <td>' . $paid_leave->employee_id . '</td>
                            <td>' . $paid_leave->employee->user->name . '</td>
                            <td>' . $tanggal_mulai . ' - ' . $tanggal_akhir . '</td>
                            <td class="text-center">' . $paid_leave->total_cuti . '</td>
                            <td>' . $paid_leave->description . '</td>
                            <td>' . $validation_director . '</td>
                        </tr>';
        }

        $tbody .= '</tbody>';

        $html .= '<div class="table-responsive"><table class="table table-sm table-bordered">' . $thead . $tbody . '</table></div>';

        $data['html'] = $html;
        return view('paid_leaves.report', compact('data'));
    }

    public function download_paid_leave(Request $request)
    {
        $data = [];
        $periode = 'All';
        $paid_leaves = PaidLeave::with('employee')->where('validation_director', '!=', NULL);

        if ($request->employee_id) {
            $paid_leaves = $paid_leaves->where('employee_id', $request->employee_id);
        }

        if ($request->periode_start && $request->periode_end) {
            $periode = $request->periode_start . ' - ' . $request->periode_end;
            $periode_start = $request->periode_start;
            $periode_end = $request->periode_end;

            $paid_leaves = $paid_leaves->where(function ($query) use ($periode_start, $periode_end) {
                $query->whereBetween('tanggal_mulai', [$periode_start, $periode_end])
                    ->orWhereBetween('tanggal_akhir', [$periode_start, $periode_end])
                    ->orWhere(function ($query) use ($periode_start, $periode_end) {
                        $query->where('tanggal_mulai', '<=', $periode_start)
                            ->where('tanggal_akhir', '>=', $periode_end);
                    });
            });
        }

        $paid_leaves = $paid_leaves->get();

        // dd($paid_leaves);
        $html = '';
        $thead = '';
        $tbody = '';

        $thead .= '<thead>
                        <tr>
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">Nama</th>
                            <th class="align-middle text-center">Tanggal Cuti</th>
                            <th class="align-middle text-center">Total Cuti</th>
                            <th class="align-middle text-center">Keterangan</th>
                            <th class="align-middle text-center">Tanggal Validasi</th>
                        </tr>
                    </thead>';
        $tbody .= '<tbody>';

        foreach ($paid_leaves as $paid_leave) {

            $tanggal_mulai = Carbon::parse(date('Y-m-d H:i', strtotime($paid_leave->tanggal_mulai)))->isoFormat('LL');
            $tanggal_akhir = Carbon::parse(date('Y-m-d H:i', strtotime($paid_leave->tanggal_akhir)))->isoFormat('LL');
            $validation_director = Carbon::parse(date('Y-m-d H:i', strtotime($paid_leave->validation_director)))->isoFormat('LL');

            $tbody .= '<tr>
                            <td>' . $paid_leave->employee_id . '</td>
                            <td>' . $paid_leave->employee->user->name . '</td>
                            <td>' . $tanggal_mulai . ' - ' . $tanggal_akhir . '</td>
                            <td class="text-center">' . $paid_leave->total_cuti . '</td>
                            <td>' . $paid_leave->description . '</td>
                            <td>' . $validation_director . '</td>
                        </tr>';
        }

        $tbody .= '</tbody>';

        $html .= '<table class="table table-sm table-bordered">' . $thead . $tbody . '</table>';

        $data['html'] = $html;
        // return view('attendances.download', $data);

        return Excel::download(new ReportExport('paid_leaves.download', $data), 'Report Pengajuan Cuti Periode ' . $periode . '.xlsx');
    }

    public function absent()
    {
        return view('absents.report');
    }

    function preview_absent(Request $request)
    {
        $data = [];

        $absents = Absent::with('employee', 'validation_user')->where('validation_at', '!=', NULL);

        if ($request->employee_id) {
            $absents = $absents->where('employee_id', $request->employee_id);
        }

        if ($request->periode_start && $request->periode_end) {
            $periode_start = $request->periode_start;
            $periode_end = $request->periode_end;
            $absents = $absents->whereBetween('date', [$periode_start, $periode_end]);
        }

        $absents = $absents->get();

        // dd($absents);
        $html = '';
        $thead = '';
        $tbody = '';

        $thead .= '<thead>
                        <tr>
                            <th class="align-middle text-center" rowspan="2">ID</th>
                            <th class="align-middle text-center" rowspan="2">Nama</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal</th>
                            <th class="align-middle text-center" rowspan="2">Keterangan</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal Validasi</th>
                            <th class="align-middle text-center" rowspan="2">User Validasi</th>
                        </tr>
                    </thead>';
        $tbody .= '<tbody>';

        foreach ($absents as $absent) {

            $date = Carbon::parse(date('Y-m-d H:i', strtotime($absent->date)))->isoFormat('LL');
            $validation_at = Carbon::parse(date('Y-m-d H:i', strtotime($absent->validation_at)))->isoFormat('LL');

            $tbody .= ' <tr>
                            <td>' . $absent->employee_id . '</td>
                            <td>' . $absent->employee->user->name . '</td>
                            <td>' . $date . '</td>
                            <td>' . $absent->description . '</td>
                            <td>' . $validation_at . '</td>
                            <td>' . $absent->validation_user->name . '</td>
                        </tr>';
        }

        $tbody .= '</tbody>';

        $html .= '<div class="table-responsive"><table class="table table-sm table-bordered">' . $thead . $tbody . '</table></div>';

        $data['html'] = $html;
        return view('absents.report', compact('data'));
    }

    public function download_absent(Request $request)
    {
        $data = [];
        $periode = 'All';
        $absents = Absent::with('employee', 'validation_user')->where('validation_at', '!=', NULL);

        if ($request->employee_id) {
            $absents = $absents->where('employee_id', $request->employee_id);
        }

        if ($request->periode_start && $request->periode_end) {
            $periode_start = $request->periode_start;
            $periode_end = $request->periode_end;
            $absents = $absents->whereBetween('date', [$periode_start, $periode_end]);
        }

        $absents = $absents->get();

        // dd($absents);
        $html = '';
        $thead = '';
        $tbody = '';

        $thead .= '<thead>
                        <tr>
                            <th class="align-middle text-center" rowspan="2">ID</th>
                            <th class="align-middle text-center" rowspan="2">Nama</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal</th>
                            <th class="align-middle text-center" rowspan="2">Keterangan</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal Validasi</th>
                            <th class="align-middle text-center" rowspan="2">User Validasi</th>
                        </tr>
                    </thead>';
        $tbody .= '<tbody>';

        foreach ($absents as $absent) {

            $date = Carbon::parse(date('Y-m-d H:i', strtotime($absent->date)))->isoFormat('LL');
            $validation_at = Carbon::parse(date('Y-m-d H:i', strtotime($absent->validation_at)))->isoFormat('LL');

            $tbody .= ' <tr>
                            <td>' . $absent->employee_id . '</td>
                            <td>' . $absent->employee->user->name . '</td>
                            <td>' . $date . '</td>
                            <td>' . $absent->description . '</td>
                            <td>' . $validation_at . '</td>
                            <td>' . $absent->validation_user->name . '</td>
                        </tr>';
        }

        $tbody .= '</tbody>';

        $html .= '<table class="table table-sm table-bordered">' . $thead . $tbody . '</table>';

        $data['html'] = $html;
        // return view('attendances.download', $data);

        return Excel::download(new ReportExport('paid_leaves.download', $data), 'Report Pengajuan Cuti Periode ' . $periode . '.xlsx');
    }

    public function attendance()
    {
        return view('attendances.report');
    }

    function preview_attendance(Request $request)
    {
        $data = [];

        $startDate = strtotime($request->periode_start);
        $endDate = strtotime($request->periode_end);

        $config_masuk = ConfigAttendance::find(1);
        $config_pulang = ConfigAttendance::find(2);

        $startMasuk = Carbon::parse($config_masuk->where('type', 'Masuk')->first()->start)->format('H:i:s');
        $endMasuk = Carbon::parse($config_masuk->where('type', 'Masuk')->first()->end)->format('H:i:s');

        $startPulang = Carbon::parse($config_pulang->where('type', 'Pulang')->first()->start)->format('H:i:s');
        $endPulang = Carbon::parse($config_pulang->where('type', 'Pulang')->first()->end)->format('H:i:s');

        if ($request->employee_id) {
            $employees = Employee::where('id', $request->employee_id)->where('status', 1)->get();
        } else {
            $employees = Employee::where('status', 1)->get();
        }

        // dd($employees);

        $html = '';
        $thead = '';
        $tbody = '';

        $jarak = $endDate - $startDate;
        $hari = ($jarak / 60 / 60 / 24) + 1; // Total jumlah hari filter
        $jumlah_hari_kerja = SelisihHariCuti::get($request->periode_start, $request->periode_end); // Total jumlah hari kerja

        $jumlah_libur = $hari - $jumlah_hari_kerja;

        $thead .= '<thead>
                    <tr>
                        <th class="align-middle text-center" rowspan="2">ID</th>
                        <th class="align-middle text-center" rowspan="2">Nama</th>
                        <th class="align-middle text-center" colspan="' . $hari . '">Tanggal/Bulan</th>
                        <th class="align-middle text-center" rowspan="2">Total Hari Kerja</th>
                        <th class="align-middle text-center" rowspan="2">On Time</th>
                        <th class="align-middle text-center" rowspan="2">Telat</th>
                        <th class="align-middle text-center" rowspan="2">Tidak Absen</th>
                        <th class="align-middle text-center" rowspan="2">Sakit</th>
                        <th class="align-middle text-center" rowspan="2">Cuti</th>
                        <th class="align-middle text-center" rowspan="2">Keterangan</th>
                    </tr>
                    <tr>';

        for ($i = $startDate; $i <= $endDate; $i = $i + 86400) {
            $thead .= '<th class="text-center">' . date('d/m', $i) . '</th>';
        }

        $thead .= ' </tr>
                </thead>';
        $tbody .= '<tbody>';

        foreach ($employees as $ke => $employee) {
            $value = '';
            $on_time = 0;
            $telat = 0;
            $tidak_absen = 0;
            $sakit = 0;
            $izin = 0;

            for ($i = $startDate; $i <= $endDate; $i = $i + 86400) {
                $statusIzin = false;
                $statusSakit = false;

                // Menggunakan eager loading untuk mengambil data terkait sekaligus
                $attendanceData = Attendance::with([
                    'employee',  // Gantilah 'employee' dengan nama relasi yang sesuai
                ])
                    ->where('employee_id', $employee->id)
                    ->whereDate('timestamp', date('Y-m-d', $i))
                    ->orderBy('timestamp', 'asc')
                    ->get();

                // Filter for earliest "IN" and latest "OUT"
                $in = $attendanceData->filter(function ($item) use ($startMasuk, $endMasuk) {
                    return Carbon::parse($item->timestamp)->format('H:i:s') >= $startMasuk &&
                        Carbon::parse($item->timestamp)->format('H:i:s') <= $endMasuk;
                })->sortBy('timestamp')->first();

                $out = $attendanceData->filter(function ($item) use ($startPulang, $endPulang) {
                    return Carbon::parse($item->timestamp)->format('H:i:s') >= $startPulang &&
                        Carbon::parse($item->timestamp)->format('H:i:s') <= $endPulang;
                })->sortByDesc('timestamp')->first();

                // Saya ingin IN where timestamp <= endMasuk && timestamp >= endMasuk dan juga outnya

                $leaveAndAbsentData = Employee::with([
                    'paid_leave' => function ($query) use ($i) {
                        $query->where('validation_director', '!=', NULL)
                            ->where(function ($query) use ($i) {
                                $query->whereBetween('tanggal_mulai', [date('Y-m-d', $i), date('Y-m-d', $i)])
                                    ->orWhereBetween('tanggal_akhir', [date('Y-m-d', $i), date('Y-m-d', $i)]);
                            });
                    },
                    'absent' => function ($query) use ($i) {
                        $query->where('validation_at', '!=', NULL)
                            ->whereDate('date', date('Y-m-d', $i));
                    },
                ])->find($employee->id);

                // Dapatkan data terkait
                $getIzin = $leaveAndAbsentData->paid_leave->first();
                $getSakit = $leaveAndAbsentData->absent->first();

                if ($in) {
                    $time_in = date('H:i', strtotime($in->timestamp));
                    $telat += ($time_in > date('H:i', strtotime(config('setting.time_in')))) ? 1 : 0;
                    $on_time += ($time_in <= date('H:i', strtotime(config('setting.time_in')))) ? 1 : 0;
                } else if ($getIzin) {
                    $izin += 1;
                    $statusIzin = true;
                } else if ($getSakit) {
                    $sakit += 1;
                    $statusSakit = true;
                } else {
                    $tidak_absen += 1;
                    $time_in = '';
                }

                $time_out = ($out) ? date('H:i', strtotime($out->timestamp)) : '';

                if ($statusIzin) {
                    $time = 'I';
                    $background = 'yellow';
                    $size = '12px';
                    $color = '';
                } else if ($statusSakit) {
                    $time = 'S';
                    $background = 'blue';
                    $size = '12px';
                    $color = 'white';
                } else {
                    $time = $time_in . ' - ' . $time_out;
                    $background = '';
                    $size = '8px';
                    $color = '';
                }
                // $check = '<pre>' . print_r($in, 1) . '</pre>';

                $value .= '<td style="font-size:' . $size . ';font-weight:bold;text-align:center;color:' . $color . ';background-color:' . $background . '" class="text-center align-middle">' . $time . '</td>';
                // $value .= '<td>' . date('H:i', strtotime($in->timestamp)) . ' | ' . date('H:i', strtotime($out->timestamp)) . '</td>';
            }

            $tbody .= ' <tr>
                            <td>' . $employee->id . '</td>
                            <td>' . $employee->user->name . '</td>
                            ' . $value . '
                            <td>' . $jumlah_hari_kerja . '</td>
                            <td>' . $on_time . '</td>
                            <td>' . $telat . '</td>
                            <td>' . intval($tidak_absen - $jumlah_libur) . '</td>
                            <td>' . $sakit . '</td>
                            <td>' . $izin . '</td>
                        </tr>';
        }

        $tbody .= '</tbody>';

        $html .= '<div class="table-responsive"><table class="table table-sm table-bordered">' . $thead . $tbody . '</table></div>';

        $data['html'] = $html;
        return view('attendances.report', compact('data'));
    }

    public function download_attendance(Request $request)
    {
        // dd(config('setting.time_in'));
        $data = [];

        $startDate = strtotime($request->periode_start);
        $endDate = strtotime($request->periode_end);

        if ($request->employee_id) {
            $employees = Employee::where('id', $request->employee_id)->where('status', 1)->get();
        } else {
            $employees = Employee::where('status', 1)->get();
        }

        $config_masuk = ConfigAttendance::find(1);
        $config_pulang = ConfigAttendance::find(2);

        $startMasuk = Carbon::parse($config_masuk->where('type', 'Masuk')->first()->start)->format('H:i:s');
        $endMasuk = Carbon::parse($config_masuk->where('type', 'Masuk')->first()->end)->format('H:i:s');

        $startPulang = Carbon::parse($config_pulang->where('type', 'Pulang')->first()->start)->format('H:i:s');
        $endPulang = Carbon::parse($config_pulang->where('type', 'Pulang')->first()->end)->format('H:i:s');

        // dd($employees);

        $html = '';
        $thead = '';
        $tbody = '';

        $jarak = $endDate - $startDate;
        $hari = ($jarak / 60 / 60 / 24) + 1; // Total jumlah hari filter
        $jumlah_hari_kerja = SelisihHariCuti::get($request->periode_start, $request->periode_end); // Total jumlah hari kerja

        $jumlah_libur = $hari - $jumlah_hari_kerja;

        $thead .= '<thead>
                    <tr>
                        <th class="align-middle text-center" rowspan="2">ID</th>
                        <th class="align-middle text-center" rowspan="2">Nama</th>
                        <th class="align-middle text-center" colspan="' . $hari . '">Tanggal/Bulan</th>
                        <th class="align-middle text-center" rowspan="2">Total Hari Kerja</th>
                        <th class="align-middle text-center" rowspan="2">On Time</th>
                        <th class="align-middle text-center" rowspan="2">Telat</th>
                        <th class="align-middle text-center" rowspan="2">Tidak Absen</th>
                        <th class="align-middle text-center" rowspan="2">Sakit</th>
                        <th class="align-middle text-center" rowspan="2">Cuti</th>
                        <th class="align-middle text-center" rowspan="2">Keterangan</th>
                    </tr>
                    <tr>';

        for ($i = $startDate; $i <= $endDate; $i = $i + 86400) {
            $thead .= '<th class="text-center">' . date('d/m', $i) . '</th>';
        }

        $thead .= ' </tr>
                </thead>';
        $tbody .= '<tbody>';

        foreach ($employees as $ke => $employee) {
            $value = '';
            $on_time = 0;
            $telat = 0;
            $tidak_absen = 0;
            $sakit = 0;
            $izin = 0;

            for ($i = $startDate; $i <= $endDate; $i = $i + 86400) {
                $statusIzin = false;
                $statusSakit = false;

                // Menggunakan eager loading untuk mengambil data terkait sekaligus
                $attendanceData = Attendance::with([
                    'employee',  // Gantilah 'employee' dengan nama relasi yang sesuai
                ])
                    ->where('employee_id', $employee->id)
                    ->whereDate('timestamp', date('Y-m-d', $i))
                    ->orderBy('timestamp', 'asc')
                    ->get();

                 // Filter for earliest "IN" and latest "OUT"
                 $in = $attendanceData->filter(function ($item) use ($startMasuk, $endMasuk) {
                    return Carbon::parse($item->timestamp)->format('H:i:s') >= $startMasuk &&
                        Carbon::parse($item->timestamp)->format('H:i:s') <= $endMasuk;
                })->sortBy('timestamp')->first();

                $out = $attendanceData->filter(function ($item) use ($startPulang, $endPulang) {
                    return Carbon::parse($item->timestamp)->format('H:i:s') >= $startPulang &&
                        Carbon::parse($item->timestamp)->format('H:i:s') <= $endPulang;
                })->sortByDesc('timestamp')->first();
                $leaveAndAbsentData = Employee::with([
                    'paid_leave' => function ($query) use ($i) {
                        $query->where('validation_director', '!=', NULL)
                            ->where(function ($query) use ($i) {
                                $query->whereBetween('tanggal_mulai', [date('Y-m-d', $i), date('Y-m-d', $i)])
                                    ->orWhereBetween('tanggal_akhir', [date('Y-m-d', $i), date('Y-m-d', $i)]);
                            });
                    },
                    'absent' => function ($query) use ($i) {
                        $query->where('validation_at', '!=', NULL)
                            ->whereDate('date', date('Y-m-d', $i));
                    },
                ])->find($employee->id);

                // Dapatkan data terkait
                $getIzin = $leaveAndAbsentData->paid_leave->first();
                $getSakit = $leaveAndAbsentData->absent->first();

                if ($in) {
                    $time_in = date('H:i', strtotime($in->timestamp));
                    $telat += ($time_in > date('H:i', strtotime(config('setting.time_in')))) ? 1 : 0;
                    $on_time += ($time_in <= date('H:i', strtotime(config('setting.time_in')))) ? 1 : 0;
                } else if ($getIzin) {
                    $izin += 1;
                    $statusIzin = true;
                } else if ($getSakit) {
                    $sakit += 1;
                    $statusSakit = true;
                } else {
                    $tidak_absen += 1;
                    $time_in = '';
                }

                $time_out = ($out) ? date('H:i', strtotime($out->timestamp)) : '';

                if ($statusIzin) {
                    $time = 'I';
                    $background = 'yellow';
                    $size = '12px';
                    $color = '';
                } else if ($statusSakit) {
                    $time = 'S';
                    $background = 'blue';
                    $size = '12px';
                    $color = 'white';
                } else {
                    $time = $time_in . ' - ' . $time_out;
                    $background = '';
                    $size = '8px';
                    $color = '';
                }
                // $check = '<pre>' . print_r($in, 1) . '</pre>';

                $value .= '<td style="font-size:' . $size . ';font-weight:bold;text-align:center;color:' . $color . ';background-color:' . $background . '" class="text-center align-middle">' . $time . '</td>';
                // $value .= '<td>' . date('H:i', strtotime($in->timestamp)) . ' | ' . date('H:i', strtotime($out->timestamp)) . '</td>';
            }

            $tbody .= ' <tr>
                            <td>' . $employee->id . '</td>
                            <td>' . $employee->user->name . '</td>
                            ' . $value . '
                            <td>' . $jumlah_hari_kerja . '</td>
                            <td>' . $on_time . '</td>
                            <td>' . $telat . '</td>
                            <td>' . intval($tidak_absen - $jumlah_libur) . '</td>
                            <td>' . $sakit . '</td>
                            <td>' . $izin . '</td>
                        </tr>';
        }


        $tbody .= '</tbody>';

        $html .= '<table class="table table-sm table-bordered">' . $thead . $tbody . '</table>';

        $data['html'] = $html;
        // return view('attendances.download', $data);

        return Excel::download(new ReportExport('attendances.download', $data), 'Report Attendance Periode ' . $request->periode_start . ' - ' . $request->periode_end . '.xlsx');
    }

    public function daily_report()
    {
        return view('daily_reports.report');
    }

    function preview_daily_report(Request $request)
    {
        $data = [];

        $startDate = strtotime($request->periode_start);
        $endDate = strtotime($request->periode_end);

        if ($request->employee_id) {
            $employees = Employee::where('id', $request->employee_id)->where('status', 1)->get();
        } else {
            $employees = Employee::where('status', 1)->get();
        }

        // dd($employees);
        $html = '';
        $thead = '';
        $tbody = '';

        $jarak = $endDate - $startDate;
        $hari = ($jarak / 60 / 60 / 24) + 1;

        $thead .= '<thead>
                    <tr>
                        <th class="align-middle text-center" rowspan="2">ID</th>
                        <th class="align-middle text-center" rowspan="2">Nama</th>
                        <th class="align-middle text-center" colspan="' . $hari . '">Tanggal/Bulan</th>
                    </tr>
                    <tr>';

        for ($i = $startDate; $i <= $endDate; $i = $i + 86400) {
            $thead .= '<th class="text-center">' . date('d/m', $i) . '</th>';
        }

        $thead .= ' </tr>
                </thead>';
        $tbody .= '<tbody>';

        foreach ($employees as $ke => $employee) {
            $tanggal = '';

            for ($i = $startDate; $i <= $endDate; $i = $i + 86400) {
                $daily_report = DailyReport::where('employee_id', $employee->id)->where('date', date('Y-m-d', $i))->orderBy('date', 'asc')->first();

                if ($daily_report) {
                    $data_daily_report = '&#10004;';
                } else {
                    $data_daily_report = '';
                }

                $tanggal .= '<td style="font-size:8px;" class="text-center">' . $data_daily_report . '</td>';
                // $tanggal .= '<td>' . date('H:i', strtotime($in->timestamp)) . ' | ' . date('H:i', strtotime($out->timestamp)) . '</td>';
            }

            $tbody .= ' <tr>
                            <td>' . $employee->id . '</td>
                            <td>' . $employee->user->name . '</td>
                            ' . $tanggal . '
                        </tr>';
        }

        $tbody .= '</tbody>';
        $html .= '<div class="table-responsive"><table class="table table-sm table-bordered table-nowrap">' . $thead . $tbody . '</table></div>';

        $data['html'] = $html;
        return view('daily_reports.report', compact('data'));
    }

    public function download_daily_report(Request $request)
    {
        // dd(config('setting.time_in'));
        $data = [];

        $startDate = strtotime($request->periode_start);
        $endDate = strtotime($request->periode_end);

        if ($request->employee_id) {
            $employees = Employee::where('id', $request->employee_id)->where('status', 1)->get();
        } else {
            $employees = Employee::where('status', 1)->get();
        }

        // dd($employees);
        $html = '';
        $thead = '';
        $tbody = '';

        $jarak = $endDate - $startDate;
        $hari = ($jarak / 60 / 60 / 24) + 1;

        $thead .= '<thead>
                    <tr>
                        <th class="align-middle text-center" rowspan="2">ID</th>
                        <th class="align-middle text-center" rowspan="2">Nama</th>
                        <th class="align-middle text-center" colspan="' . $hari . '">Tanggal/Bulan</th>
                    </tr>
                    <tr>';

        for ($i = $startDate; $i <= $endDate; $i = $i + 86400) {
            $thead .= '<th class="text-center">' . date('d/m', $i) . '</th>';
        }

        $thead .= ' </tr>
                </thead>';
        $tbody .= '<tbody>';

        foreach ($employees as $ke => $employee) {
            $tanggal = '';

            for ($i = $startDate; $i <= $endDate; $i = $i + 86400) {
                $daily_report = DailyReport::where('employee_id', $employee->id)->where('date', date('Y-m-d', $i))->orderBy('date', 'asc')->first();

                if ($daily_report) {
                    $data_daily_report = '&#10004;';
                } else {
                    $data_daily_report = '';
                }

                $tanggal .= '<td style="font-size:8px;" class="text-center">' . $data_daily_report . '</td>';
                // $tanggal .= '<td>' . date('H:i', strtotime($in->timestamp)) . ' | ' . date('H:i', strtotime($out->timestamp)) . '</td>';
            }

            $tbody .= ' <tr>
                            <td>' . $employee->id . '</td>
                            <td>' . $employee->user->name . '</td>
                            ' . $tanggal . '
                        </tr>';
        }

        $tbody .= '</tbody>';
        $html .= '<table class="table table-sm table-bordered">' . $thead . $tbody . '</table>';

        $data['html'] = $html;
        // return view('daily_reports.download', $data);

        return Excel::download(new ReportExport('daily_reports.download', $data), 'Daily Report Employee Periode ' . $request->periode_start . ' - ' . $request->periode_end . '.xlsx');
    }

    public function submission()
    {
        return view('submissions.report');
    }

    function preview_submission(Request $request)
    {
        $data = [];

        $submissions = Submission::with('employee')->where('validation_finance', '!=', NULL);

        if ($request->employee_id) {
            $submissions = $submissions->where('employee_id', $request->employee_id);
        }

        if ($request->periode_start && $request->periode_end) {
            $periode_start = $request->periode_start;
            $periode_end = $request->periode_end;
            $submissions = $submissions->whereBetween(DB::raw('DATE(created_at)'), [$periode_start, $periode_end]);
        }

        $submissions = $submissions->get();

        // dd($submissions);
        $html = '';
        $thead = '';
        $tbody = '';

        $thead .= '<thead>
                        <tr>
                            <th class="align-middle text-center" rowspan="2">ID</th>
                            <th class="align-middle text-center" rowspan="2">Nama</th>
                            <th class="align-middle text-center" rowspan="2">Title</th>
                            <th class="align-middle text-center" rowspan="2">Nominal</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal Dibuat</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal Approve</th>
                        </tr>
                    </thead>';
        $tbody .= '<tbody>';

        $total = 0;
        foreach ($submissions as $submission) {

            $date = Carbon::parse(date('Y-m-d H:i', strtotime($submission->created_at)))->isoFormat('LL');
            $validation_finance = Carbon::parse(date('Y-m-d H:i', strtotime($submission->validation_finance)))->isoFormat('LL');
            $nominal = $submission->nominal;
            $total += $nominal;

            $tbody .= ' <tr>
                            <td>' . $submission->employee_id . '</td>
                            <td>' . $submission->employee->user->name . '</td>
                            <td>' . $submission->title . '</td>
                            <td>' . number_format($nominal) . '</td>
                            <td>' . $date . '</td>
                            <td>' . $validation_finance . '</td>
                        </tr>';
        }

        $tbody .= '</tbody>
                    <tfoot>
                        <th colspan="3" class="text-end">TOTAL</th>
                        <th colspan="3">' . number_format($total) . '</th>
                    </tfoot>';

        $html .= '<div class="table-responsive"><table class="table table-sm table-bordered">' . $thead . $tbody . '</table></div>';

        $data['html'] = $html;
        return view('submissions.report', compact('data'));
    }

    public function download_submission(Request $request)
    {
        $data = [];
        $periode = 'All';
        $submissions = Submission::with('employee', 'validation_user')->where('validation_at', '!=', NULL);

        if ($request->employee_id) {
            $submissions = $submissions->where('employee_id', $request->employee_id);
        }

        if ($request->periode_start && $request->periode_end) {
            $periode_start = $request->periode_start;
            $periode_end = $request->periode_end;
            $submissions = $submissions->whereBetween('date', [$periode_start, $periode_end]);
        }

        $submissions = $submissions->get();

        // dd($submissions);
        $html = '';
        $thead = '';
        $tbody = '';

        $thead .= '<thead>
                        <tr>
                            <th class="align-middle text-center" rowspan="2">ID</th>
                            <th class="align-middle text-center" rowspan="2">Nama</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal</th>
                            <th class="align-middle text-center" rowspan="2">Keterangan</th>
                            <th class="align-middle text-center" rowspan="2">Tanggal Validasi</th>
                            <th class="align-middle text-center" rowspan="2">User Validasi</th>
                        </tr>
                    </thead>';
        $tbody .= '<tbody>';

        foreach ($submissions as $submission) {

            $date = Carbon::parse(date('Y-m-d H:i', strtotime($submission->date)))->isoFormat('LL');
            $validation_at = Carbon::parse(date('Y-m-d H:i', strtotime($submission->validation_at)))->isoFormat('LL');

            $tbody .= ' <tr>
                            <td>' . $submission->employee_id . '</td>
                            <td>' . $submission->employee->user->name . '</td>
                            <td>' . $date . '</td>
                            <td>' . $submission->description . '</td>
                            <td>' . $validation_at . '</td>
                            <td>' . $submission->validation_user->name . '</td>
                        </tr>';
        }

        $tbody .= '</tbody>';

        $html .= '<table class="table table-sm table-bordered">' . $thead . $tbody . '</table>';

        $data['html'] = $html;
        // return view('attendances.download', $data);

        return Excel::download(new ReportExport('paid_leaves.download', $data), 'Report Pengajuan Cuti Periode ' . $periode . '.xlsx');
    }
}
