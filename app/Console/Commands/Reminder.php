<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\ConfigAttendance;
use App\Models\DailyReport;
use App\Models\Employee;
use App\Models\Reminder as ModelsReminder;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder notification daily report, attendance, visit employee';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $data = [];
            $response = [];

            // Carbon::setLocale('id');
            $yesterday = Carbon::now()->subDay();
            // dd($yesterday->format('Y-m-d'));
            if ($yesterday->isWeekday()) {
                $employees = Employee::with('user')->where('status', 1)->get();
                // $employees = Employee::where('status', 1)->whereIn('id', [20221217, 20221220, 20221224, 20230102, 20230201, 20230902])->get();
                // $employees = Employee::where('status', 1)->whereIn('id', [20221224])->get();

                foreach ($employees as $employee) {
                    $config_masuk = ConfigAttendance::find(1);
                    $config_pulang = ConfigAttendance::find(2);

                    $attendance_in = Attendance::whereTime('timestamp', '<', $config_masuk->end)
                        ->whereDate('timestamp', $yesterday->format('Y-m-d'))
                        ->where('employee_id', $employee->id)
                        ->oldest('timestamp')
                        ->first();

                    $attendance_out = Attendance::whereTime('timestamp', '>', $config_pulang->start)
                        ->whereDate('timestamp', $yesterday->format('Y-m-d'))
                        ->where('employee_id', $employee->id)
                        ->latest('timestamp')
                        ->first();

                    $daily_report = DailyReport::where('date', $yesterday->format('Y-m-d'))->where('employee_id', $employee->id)->first();
                    if (!$daily_report) {
                        $data[] = [
                            'employee_id' => $employee->id,
                            'reminder_type' => 'Daily Report Not Found',
                            'description' => 'Belum mengirimkan daily report pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y'),
                            'date' => $yesterday->format('Y-m-d')
                        ];
                        $drInput['description'] = 'Halo ' . $employee->user->name . '<br><br><p style="text-align:justify;text-justify:inter-word;">Hari ini kami ingin mengingatkan bahwa laporan harian Anda untuk kemarin belum diterima.
                        Mohon untuk segera mengirimkan laporan tersebut agar kami dapat melanjutkan pemantauan dan perencanaan dengan baik.</p><br>
                        Terima kasih atas perhatiannya<br>EMS Application';
                        $drInput['subject'] = 'Daily Report Reminder for Employees';
                        $drInput['email'] = $employee->user->email;
                        $drInput['name'] = $employee->user->name;

                        if ($employee->user->email != NULL) {
                            Mail::send('email.send_announcement', $drInput, function ($message) use ($drInput) {
                                $message->to($drInput['email'], $drInput['name'])->subject($drInput['subject']);
                            });

                            if (Mail::failures()) {
                                $response[] = [
                                    'email' => $drInput['email'],
                                    'success' => false,
                                    'reminder_type' => 'Daily Report Not Found',
                                ];
                            } else {
                                $response[] = [
                                    'email' => $drInput['email'],
                                    'success' => true,
                                    'reminder_type' => 'Daily Report Not Found',
                                ];
                            }
                        }
                    }

                    $visit_in = Visit::whereDate('created_at', $yesterday->format('Y-m-d'))
                        ->where('employee_id', $employee->id)
                        ->where('status', 0)
                        ->first();

                    if ($visit_in) {
                        $visit_out = Visit::with('site')
                            ->whereDate('created_at', $yesterday->format('Y-m-d'))
                            ->where('employee_id', $employee->id)
                            ->where('site_id', $visit_in->site_id)
                            ->where('status', 1)
                            ->first();

                        if (!$visit_out) {
                            $data[] = [
                                'employee_id' => $employee->id,
                                'reminder_type' => 'Visit Out Not Found',
                                'description' => 'Belum melakukan kunjungan keluar pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y'),
                                'date' => $yesterday->format('Y-m-d')
                            ];

                            $voInput['description'] = 'Halo ' . $employee->user->name . '<br><br><p style="text-align:justify;text-justify:inter-word;">Hari ini kami ingin mengingatkan bahwa anda belum melakukan kunjungan keluar pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y') . ' di ' . $visit_in->site->name . '.
                            Mohon untuk kedepannya agar dapat melakukan kunjungan keluar sesuai dengan aktivitas supaya monitoring data bisa lebih efisien.</p><br>
                            Terima kasih atas perhatiannya<br>EMS Application';
                            $voInput['subject'] = 'Visit Check Out Reminder for Employees';
                            $voInput['email'] = $employee->user->email;
                            $voInput['name'] = $employee->user->name;

                            if ($employee->user->email != NULL) {
                                Mail::send('email.send_announcement', $voInput, function ($message) use ($voInput) {
                                    $message->to($voInput['email'], $voInput['name'])->subject($voInput['subject']);
                                });

                                if (Mail::failures()) {
                                    $response[] = [
                                        'email' => $voInput['email'],
                                        'success' => false,
                                        'reminder_type' => 'Visit Out Not Found',
                                    ];
                                } else {
                                    $response[] = [
                                        'email' => $voInput['email'],
                                        'success' => true,
                                        'reminder_type' => 'Visit Out Not Found',
                                    ];
                                }
                            }
                        }
                    } else {
                        $visit_out = Visit::with('site')
                            ->whereDate('created_at', $yesterday->format('Y-m-d'))
                            ->where('employee_id', $employee->id)
                            ->where('status', 1)
                            ->first();

                        if ($visit_out) {
                            $data[] = [
                                'employee_id' => $employee->id,
                                'reminder_type' => 'Visit In Not Found',
                                'description' => 'Belum melakukan kunjugan masuk pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y'),
                                'date' => $yesterday->format('Y-m-d')
                            ];

                            $viInput['description'] = 'Halo ' . $employee->user->name . '<br><br><p style="text-align:justify;text-justify:inter-word;">Hari ini kami ingin mengingatkan bahwa anda belum melakukan kunjungan masuk pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y') . ' di ' . $visit_out->site->name . '.
                            Mohon untuk kedepannya agar dapat melakukan kunjungan masuk sesuai dengan aktivitas supaya monitoring data bisa lebih efisien.</p><br>
                            Terima kasih atas perhatiannya<br>EMS Application';
                            $viInput['subject'] = 'Visit Check In Reminder for Employees';
                            $viInput['email'] = $employee->user->email;
                            $viInput['name'] = $employee->user->name;

                            if ($employee->user->email != NULL) {
                                Mail::send('email.send_announcement', $viInput, function ($message) use ($viInput) {
                                    $message->to($viInput['email'], $viInput['name'])->subject($viInput['subject']);
                                });

                                if (Mail::failures()) {
                                    $response[] = [
                                        'email' => $viInput['email'],
                                        'success' => false,
                                        'reminder_type' => 'Visit In Not Found',
                                    ];
                                } else {
                                    $response[] = [
                                        'email' => $viInput['email'],
                                        'success' => true,
                                        'reminder_type' => 'Visit In Not Found',
                                    ];
                                }
                            }
                        }
                    }

                    if (!$attendance_in) {
                        $data[] = [
                            'employee_id' => $employee->id,
                            'reminder_type' => 'Attendance In Not Found',
                            'description' => 'Belum melakukan absensi masuk pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y'),
                            'date' => $yesterday->format('Y-m-d')
                        ];

                        $attInInput['description'] = 'Halo ' . $employee->user->name . '<br><br><p style="text-align:justify;text-justify:inter-word;">Hari ini kami ingin mengingatkan bahwa anda belum melakukan absensi masuk pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y') . '.
                        Mohon untuk kedepannya agar dapat melakukan absensi sesuai dengan peraturan perusahaan supaya monitoring data bisa lebih efisien.</p><br>
                        Terima kasih atas perhatiannya<br>EMS Application';
                        $attInInput['subject'] = 'Attendance Check In Reminder for Employees';
                        $attInInput['email'] = $employee->user->email;
                        $attInInput['name'] = $employee->user->name;

                        if ($employee->user->email != NULL) {
                            Mail::send('email.send_announcement', $attInInput, function ($message) use ($attInInput) {
                                $message->to($attInInput['email'], $attInInput['name'])->subject($attInInput['subject']);
                            });

                            if (Mail::failures()) {
                                $response[] = [
                                    'email' => $attInInput['email'],
                                    'success' => false,
                                    'reminder_type' => 'Attendance In Not Found',
                                ];
                            } else {
                                $response[] = [
                                    'email' => $attInInput['email'],
                                    'success' => true,
                                    'reminder_type' => 'Attendance In Not Found',
                                ];
                            }
                        }
                    } else if (date('H:i', strtotime($attendance_in->timestamp)) >= date('H:i', strtotime(config('setting.time_in')))) {
                        $data[] = [
                            'employee_id' => $employee->id,
                            'reminder_type' => 'Late Attendance In',
                            'description' => 'Telat melakukan absensi masuk pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y'),
                            'date' => $yesterday->format('Y-m-d')
                        ];

                        $lateAttInput['description'] = 'Halo ' . $employee->user->name . '<br><br><p style="text-align:justify;text-justify:inter-word;">Hari ini kami ingin mengingatkan bahwa anda melakukan absensi masuk tidak tepat waktu pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y') . '.
                        Mohon untuk kedepannya agar dapat melakukan absensi lebih tepat waktu sesuai dengan peraturan perusahaan supaya monitoring data bisa lebih efisien.</p><br>
                        Terima kasih atas perhatiannya<br>EMS Application';
                        $lateAttInput['subject'] = 'Late Attendance Reminder for Employees';
                        $lateAttInput['email'] = $employee->user->email;
                        $lateAttInput['name'] = $employee->user->name;

                        if ($employee->user->email != NULL) {
                            Mail::send('email.send_announcement', $lateAttInput, function ($message) use ($lateAttInput) {
                                $message->to($lateAttInput['email'], $lateAttInput['name'])->subject($lateAttInput['subject']);
                            });

                            if (Mail::failures()) {
                                $response[] = [
                                    'email' => $lateAttInput['email'],
                                    'success' => false,
                                    'reminder_type' => 'Late Attendance In',
                                ];
                            } else {
                                $response[] = [
                                    'email' => $lateAttInput['email'],
                                    'success' => true,
                                    'reminder_type' => 'Late Attendance In',
                                ];
                            }
                        }
                    }

                    if (!$attendance_out) {
                        $data[] = [
                            'employee_id' => $employee->id,
                            'reminder_type' => 'Attendance Out Not Found',
                            'description' => 'Belum melakukan absensi keluar pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y'),
                            'date' => $yesterday->format('Y-m-d')
                        ];

                        $attOutInput['description'] = 'Halo ' . $employee->user->name . '<br><br><p style="text-align:justify;text-justify:inter-word;">Hari ini kami ingin mengingatkan bahwa anda belum melakukan absensi keluar pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y') . '.
                        Mohon untuk kedepannya agar dapat melakukan absensi sesuai dengan peraturan perusahaan supaya monitoring data bisa lebih efisien.</p><br>
                        Terima kasih atas perhatiannya<br>EMS Application';
                        $attOutInput['subject'] = 'Attendance Check Out Reminder for Employees';
                        $attOutInput['email'] = $employee->user->email;
                        $attOutInput['name'] = $employee->user->name;

                        if ($employee->user->email != NULL) {
                            Mail::send('email.send_announcement', $attOutInput, function ($message) use ($attOutInput) {
                                $message->to($attOutInput['email'], $attOutInput['name'])->subject($attOutInput['subject']);
                            });

                            if (Mail::failures()) {
                                $response[] = [
                                    'email' => $attOutInput['email'],
                                    'success' => false,
                                    'reminder_type' => 'Attendance Out Not Found',
                                ];
                            } else {
                                $response[] = [
                                    'email' => $attOutInput['email'],
                                    'success' => true,
                                    'reminder_type' => 'Attendance Out Not Found',
                                ];
                            }
                        }
                    } else if (date('H:i', strtotime($attendance_out->timestamp)) < date('H:i', strtotime(config('setting.time_out')))) {
                        $data[] = [
                            'employee_id' => $employee->id,
                            'reminder_type' => 'Late Attendance Out',
                            'description' => 'Melakukan absensi keluar tidak tepat waktu pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y'),
                            'date' => $yesterday->format('Y-m-d')
                        ];

                        $lateAttOutInput['description'] = 'Halo ' . $employee->user->name . '<br><br><p style="text-align:justify;text-justify:inter-word;">Hari ini kami ingin mengingatkan bahwa anda melakukan absensi keluar tidak tepat waktu pada hari ' . $yesterday->isoFormat('dddd, D MMMM Y') . '.
                        Mohon untuk kedepannya agar dapat melakukan absensi lebih tepat waktu sesuai dengan peraturan perusahaan supaya monitoring data bisa lebih efisien.</p><br>
                        Terima kasih atas perhatiannya<br>EMS Application';
                        $lateAttOutInput['subject'] = 'Late Attendance Reminder for Employees';
                        $lateAttOutInput['email'] = $employee->user->email;
                        $lateAttOutInput['name'] = $employee->user->name;

                        if ($employee->user->email != NULL) {
                            Mail::send('email.send_announcement', $lateAttOutInput, function ($message) use ($lateAttOutInput) {
                                $message->to($lateAttOutInput['email'], $lateAttOutInput['name'])->subject($lateAttOutInput['subject']);
                            });

                            if (Mail::failures()) {
                                $response[] = [
                                    'email' => $lateAttOutInput['email'],
                                    'success' => false,
                                    'reminder_type' => 'Late Attendance Out',
                                ];
                            } else {
                                $response[] = [
                                    'email' => $lateAttOutInput['email'],
                                    'success' => true,
                                    'reminder_type' => 'Late Attendance Out',
                                ];
                            }
                        }
                    }
                }

                ModelsReminder::insert($data);
            }

            $this->info(date('Y-m-d H:i:s') . ' ' . json_encode($response));
        } catch (\Throwable $th) {
            $this->info(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
        }
    }
}
