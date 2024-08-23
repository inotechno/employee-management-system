<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->string('title');
            $table->bigInteger('nominal');
            // $table->integer('qty');
            $table->text('note');
            $table->foreignId('user_id')->nullable();
            $table->dateTime('validation_supervisor')->nullable();
            $table->dateTime('validation_director')->nullable();
            $table->dateTime('validation_finance')->nullable();
            $table->string('receipt_image')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('submissions');
    }
}
