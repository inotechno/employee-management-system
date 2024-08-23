<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->integer('total_cuti')->default(0);
            $table->integer('sisa_cuti')->default(0);
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->dateTime('validation_supervisor')->nullable();
            $table->dateTime('validation_hrd')->nullable();
            $table->dateTime('validation_director')->nullable();
            $table->integer('status')->comment('0 Waiting, 1 Approve HRD, 2 Approve Directur, 3 Rejected')->default(0);
            $table->datetime('seen_at')->nullable();
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
        Schema::dropIfExists('paid_leaves');
    }
}
