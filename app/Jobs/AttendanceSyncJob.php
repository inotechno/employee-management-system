<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Models\ConfigAttendance;
use App\Models\Machine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rats\Zkteco\Lib\ZKTeco;

class AttendanceSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;

        try {
            foreach ($data as $dt) {
                Attendance::updateOrCreate(
                    ['uid' => $dt['uid']],
                    $dt
                );
            }

            \Log::info(date('Y-m-d H:i:s') . ' ' . 'Attendance Sync Job Completed Successfully');
        } catch (\Throwable $th) {
            \Log::error(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
        }
    }
}
