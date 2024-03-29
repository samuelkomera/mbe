<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendorid');
            $table->string('make');
            $table->string('model');
            $table->string('price');
            $table->string('carnumber');
            $table->string('carstatus')->default('available');
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
        Schema::dropIfExists('cars');
    }
}
