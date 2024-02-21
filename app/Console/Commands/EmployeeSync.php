<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rats\Zkteco\Lib\ZKTeco;

class EmployeeSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // \Log::info('OK');
        $this->zk = new ZKTeco('192.168.20.221', 4370);
        $this->zk->connect();

        try {
            $get = $this->zk->getUser();
            // dd($get);
            $employee = [];
            // dd($get);
            // DB::table('employees')->truncate();
            foreach ($get as $user => $val) {

                if ($val['userid'] == 20221201) {
                    continue;
                }

                $newUser = User::updateOrCreate([
                    'username' => $val['userid']
                ], [
                    'name'      => $val['name'],
                    'password'  => bcrypt($val['userid'])
                ]);

                $newUser->assignRole('employee');

                $employee = Employee::updateOrCreate([
                    'id' => $val['userid']
                ], [
                    'user_id' => $newUser->id,
                    'card_number' => $val['cardno'],
                ]);
            }

            $this->info(date('Y-m-d H:i:s') . ' ' . 'Syncronize Employees Successfully');
        } catch (\Throwable $th) {
            $this->info(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
        }

        $this->zk->disconnect();
    }
}
