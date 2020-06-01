<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealDonation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_donation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image')->nullable();
            $table->string('name',100);
            $table->string('quantity',100);
            $table->text('description');
            $table->unsignedBigInteger('seat_id');
            $table->timestamps();

            //foreign
            $table->foreign('seat_id')
                 ->references('id')
                 ->on('seat')
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
        Schema::dropIfExists('meal_donation');
    }
}
