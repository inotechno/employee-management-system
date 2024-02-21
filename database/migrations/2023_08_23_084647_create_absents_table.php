<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('date');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('validation_by')->nullable();
            $table->dateTime('validation_at')->nullable();
            $table->integer('status')->comment('0 Waiting, 1 Approve, 2 Rejected')->default(0);
            $table->datetime('seen_at')->nullable();
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
        Schema::dropIfExists('absents');
    }
}
