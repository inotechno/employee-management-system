<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uid')->nullable();
            $table->foreignId('employee_id');
            $table->integer('state')->unsigned()->nullable();
            $table->dateTime('timestamp');
            $table->integer('type');
            $table->integer('event_id')->default(3);
            $table->unsignedBigInteger('site_id')->nullable()->default(84);
            $table->string('longitude');
            $table->string('latitude');
            $table->text('keterangan')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
