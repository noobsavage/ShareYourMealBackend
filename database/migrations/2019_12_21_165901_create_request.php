<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('seat_id');
            $table->integer('host_id');
            $table->unsignedBigInteger('consumer_id');
            $table->integer('requested_seat');
            $table->boolean('status')->default(false);
            $table->timestamps();

            //foreign
            // $table->foreign('seat_id')
            //      ->references('id')
            //      ->on('seat')
            //      ->onDelete('cascade');

            //foreign
            $table->foreign('consumer_id')
                 ->references('id')
                 ->on('users')
                ->onDelete('cascade');     



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request');
    }
}
