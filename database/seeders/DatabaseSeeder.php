<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(MachineSeeder::class);
        $this->call(ConfigAttendanceSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(SiteSeeder::class);
        // $this->call(AttendanceSeeder::class);
        $this->call(EventAttendanceSeeder::class);
        $this->call(ModelHasRole::class);
        $this->call(DailyReportSeeder::class);
        $this->call(VisitCategorySeeder::class);
        $this->call(VisitSeeder::class);
    }
}
