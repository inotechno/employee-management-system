<?php

namespace App\Http\Controllers;

use App\Jobs\AttendanceSyncJob;
use App\Models\ConfigAttendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class IClockController extends Controller
{
    public function __invoke(Request $request)
    {

    }

    public function handshake(Request $request)
    {
        $r = "GET OPTION FROM: {$request->input('SN')}\r\n" .
            "Stamp=9999\r\n" .
            "OpStamp=" . time() . "\r\n" .
            "ErrorDelay=60\r\n" .
            "Delay=30\r\n" .
            "ResLogDay=18250\r\n" .
            "ResLogDelCount=10000\r\n" .
            "ResLogCount=50000\r\n" .
            "TransTimes=00:00;14:05\r\n" .
            "TransInterval=1\r\n" .
            "TransFlag=1111000000\r\n" .
            //  "TimeZone=7\r\n" .
            "Realtime=1\r\n" .
            "Encrypt=0";

        \Log::info('Handshake', $request->all());
        return $r;
    }

    public function test(Request $request)
    {
        \Log::info('Test', $request->all());
    }

    public function receiveRecords(Request $request)
    {
        $configurations = ConfigAttendance::whereIn('id', [1, 2])->select('id', 'start', 'end')->get()->keyBy('id');
        $siteId = 84;

        try {
            $arr = preg_split('/\\r\\n|\\r|,|\\n/', $request->getContent());

            $tot = 0;

            //operation log
            if ($request->input('table') == "OPERLOG") {
                foreach ($arr as $rey) {
                    if (isset($rey)) {
                        $tot++;
                    }
                }

                \Log::info('Operation Log', $request->all());
                return "OK: " . $tot;
            }

            //attendance
            foreach ($arr as $rey) {
                if (empty($rey)) {
                    continue;
                }

                $data = explode("\t", $rey);

                $time = date('H:i:s', strtotime($data[1]));

                $type = $this->getAttendanceType($time, $configurations);
                $employee = $this->getEmployee($data[0]);

                $email = '';
                $name = '';

                if($employee != null) {
                    $email = $employee->user->email;
                    $name = $employee->user->name;
                }

                $attendanceData[] = [
                    'uid' => $data[0] . date('Hi'),
                    'employee_id' => $data[0],
                    'state' => $data[3],
                    'timestamp' => $data[1],
                    'type' => $type,
                    'site_id' => $siteId,
                    'event_id' => 3,
                    'longitude' => '106.798818',
                    'latitude' => '-6.263122',
                    'email' => $email,
                    'name' => $name
                ];

                activity()->log('Record Attendance: ' . $data[0]);

                AttendanceSyncJob::dispatch($attendanceData);
                $tot++;
            }

            \Log::info('Receive Records', $request->all());
            return "OK: " . $tot;
        } catch (Throwable $e) {
            \Log::error('Error', $e->getMessage());
            return "ERROR: " . $tot . "\n";
        }
    }

    public function getrequest(Request $request)
    {
        // \Log::info('Get Request', $request->all());
        return "OK";
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

    protected function getEmployee($id)
    {
        return Employee::with('user')->find($id) ?? null;
    }
}
