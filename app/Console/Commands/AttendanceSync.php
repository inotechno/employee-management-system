<?php

namespace App\Console\Commands;

use App\Helpers\FingerprintSDK;
use App\Jobs\AttendanceSyncJob;
use App\Models\Attendance;
use App\Models\ConfigAttendance;
use App\Models\Machine;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Rats\Zkteco\Lib\ZKTeco;

class AttendanceSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync absensi dari fingerprint';

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
    // public function handle()
    // {
    //     try {
    //         $this->zk->connect();
    //         $get = $this->zk->getAttendance();
    //         // dd($get);
    //         $config_masuk = ConfigAttendance::find(1);
    //         $config_pulang = ConfigAttendance::find(2);

    //         foreach ($get as $att => $val) {
    //             if ($val['id'] == 20221201) {
    //                 continue;
    //             }

    //             $type = 0;
    //             $time = date('H:i:s', strtotime($val['timestamp']));

    //             if ($time >= $config_masuk->start && $time <= $config_masuk->end) {
    //                 $type = $config_masuk->id;
    //             } else if ($time >= $config_pulang->start && $time <= $config_pulang->end) {
    //                 $type = $config_pulang->id;
    //             }

    //             $att = Attendance::firstOrCreate([
    //                 'uid' => $val['uid'],
    //             ], [
    //                 'employee_id'       => $val['id'],
    //                 'state'             => $val['state'],
    //                 'timestamp'         => $val['timestamp'],
    //                 'type'              => $type,
    //                 'site_id'           => 84,
    //                 'event_id'          => 3,
    //                 'longitude'         => '106.798818',
    //                 'latitude'          => '-6.263122'
    //             ]);
    //         }

    //         $this->zk->disconnect();
    //         $this->info(date('Y-m-d H:i:s') . ' ' . 'Syncronize Attendance Successfully');
    //     } catch (\Throwable $th) {
    //         $this->info(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
    //     }
    // }

    public function handle()
    {
        // $this->zk = new ZKTeco('192.168.20.221', 4370);
        // $this->zk->connect();

        try {
            // Melakukan pemanggilan sekali ke database
            $configurations = ConfigAttendance::whereIn('id', [1, 2])->select('id', 'start', 'end')->get()->keyBy('id');
            $siteId = 84;
            $fingerprintSDK = new FingerprintSDK();
            $getAttendance = $fingerprintSDK->getAttendance();
            // dd($getAttendance);

            $attendanceData = $this->prepareAttendanceData($getAttendance, $configurations, $siteId);
            // Chunk the data to insert in smaller batches
            $chunkedData = array_chunk($attendanceData, 1000); // Split data into chunks of 1000 records

            foreach ($chunkedData as $data) {
                AttendanceSyncJob::dispatch($data);
            }
            // foreach ($attendanceData as $chunk) {
            // foreach ($chunk as $data) {
            // Attendance::updateOrCreate(
            //     ['uid' => $data['uid']],
            //     $data
            // );
            // }
            // }

            // AttendanceSyncJob::dispatch($chunkedData);

            $this->info(date('Y-m-d H:i:s') . ' ' . 'Syncronize Attendance Successfully');
        } catch (\Throwable $th) {
            $this->info(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
        }
    }

    protected function prepareAttendanceData($data, $configurations, $siteId)
    {
        $attendanceData = [];
        foreach ($data as $attendance) {
            if ($attendance['PIN'] == 20221201) {
                continue;
            }

            $employeeId = $attendance['PIN'];
            $timestamp = $attendance['DateTime'];
            $time = date('H:i:s', strtotime($timestamp));

            $type = $this->getAttendanceType($time, $configurations);

            $attendanceData[] = [
                'uid' => $attendance['UID'],
                'employee_id' => $employeeId,
                'state' => $attendance['Verified'],
                'timestamp' => $timestamp,
                'type' => $type,
                'site_id' => $siteId,
                'event_id' => 3,
                'longitude' => '106.798818',
                'latitude' => '-6.263122'
            ];
        }
        return $attendanceData;
    }

    protected function getAttendanceType($time, $configurations)
    {
        $defaultType = 0;

        foreach ($configurations as $config) {
            if ($time >= $config->start && $time <= $config->end) {
                return $config->id;
            }
        }

        return $defaultType;
    }
}
