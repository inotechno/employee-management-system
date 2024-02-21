<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SallarySlip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sallary_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->foreignId('periode_id');
            $table->bigInteger('gaji_pokok')->nullable();
            $table->bigInteger('tunj_pulsa')->nullable();
            $table->bigInteger('tunj_jabatan')->nullable();
            $table->bigInteger('tunj_transport')->nullable();
            $table->bigInteger('tunj_makan')->nullable();
            $table->bigInteger('tunj_lain_lain')->nullable();
            $table->bigInteger('revisi')->nullable();
            $table->bigInteger('pot_pph21')->nullable();
            $table->bigInteger('pot_bpjs_tk')->nullable();
            $table->bigInteger('pot_jaminan_pensiun')->nullable();
            $table->bigInteger('pot_bpjs_kesehatan')->nullable();
            $table->bigInteger('pot_pinjaman')->nullable();
            $table->bigInteger('pot_keterlambatan')->nullable();
            $table->bigInteger('pot_daily_report')->nullable();
            $table->bigInteger('thp')->nullable();
            $table->integer('jumlah_hari_kerja')->nullable();
            $table->integer('jumlah_sakit')->nullable();
            $table->integer('jumlah_izin')->nullable();
            $table->integer('jumlah_alpha')->nullable();
            $table->integer('jumlah_cuti')->nullable();
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
        Schema::dropIfExists('sallary_slips');
    }
}
