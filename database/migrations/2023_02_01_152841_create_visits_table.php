<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable();
            $table->foreignId('site_id')->nullable()->constrained();
            $table->foreignId('visit_category_id')->default(1)->constrained()->cascadeOnUpdate();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('keterangan');
            $table->integer('status')->comment('0 CheckIn, 1 CheckOut')->default(0);
            $table->string('file')->nullable();
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
        Schema::dropIfExists('visits');
    }
}
