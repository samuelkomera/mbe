<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendorid')->nullable();
            $table->integer('customerid')->nullable();
            $table->string('make');
            $table->string('model');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('carnumber')->nullable();
            $table->string('status')->default('booked');
            $table->text('val');
            $table->timestamps();
        });
//        DB::statement("ALTER TABLE cars AUTO_INCREMENT = 3118191;");

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
