<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('host_id');
            $table->string('name',100);
            $table->double('longitude',15,8);
            $table->double('latitude',15,8);
            $table->string('placeName',100);
            $table->integer('No_of_seat');
            $table->string('time',100);
            $table->integer('status');
            
            //$table-> Reserved Seat
            $table->timestamps();

            $table->foreign('host_id')
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
        Schema::dropIfExists('seat');
    }
}
