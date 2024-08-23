<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubmissionRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'submission:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update jumlah cuti karyawan';

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
        $employees = Employee::where('status', 1)->get();
        $data = [];
        $now = Carbon::now();

        $lastUpdate = [];
        $i = 0;
        foreach ($employees as $key => $employee) {
            if ($employee->join_date != NULL) {
                $jumlah_cuti = 12;
                $jumlah_cuti_last = $employee->jumlah_cuti;

                $join_date = Carbon::createFromFormat('Y-m-d', $employee->join_date);

                if ($now->format('d-m') == $join_date->format('d-m')) {
                    if ($employee->jumlah_cuti < 0) {
                        $jumlah_cuti = $employee->jumlah_cuti + 12;
                    }

                    $employee->update(['jumlah_cuti' => $jumlah_cuti]);
                    $employee['jumlah_cuti_last'] = $jumlah_cuti_last;
                    $lastUpdate[$i] = $employee->load('user');
                    $i++;
                }
            }
        }

        if (count($lastUpdate) > 0) {
            foreach ($lastUpdate as $employee) {
                $input['description'] = 'Halo ' . $employee->user->name . ' <br><br> Kami beritahukan bahwa pada tanggal ini jumlah cuti anda diubah sebelumnya yaitu ' . $employee->jumlah_cuti_last . ' menjadi ' . $employee->jumlah_cuti . ' <br><br>Berikut informasi yang bisa disampaikan<br>Terima Kasih';
                $input['subject'] = 'Refresh Jumlah Cuti ' . $employee->user->name;

                $input['email'] = $employee->user->email;
                $input['name'] = $employee->user->name;
                // dd($input);

                Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                    $message->to($input['email'], $input['name'])->subject($input['subject']);
                });
            }
        }
        // dd($lastUpdate);
        // return response()->json([
        //     'success' => true,
        //     'data' => $lastUpdate
        // ]);

        $this->info(date('Y-m-d H:i:s') . ' ' . json_encode($lastUpdate));
    }
}
