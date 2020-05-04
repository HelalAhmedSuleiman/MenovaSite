<?php

use Illuminate\Database\Migrations\Migration;

class CreateIndustriesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industries', function ($table) {

            $table->increments('id');
            $table->string("name")->index();
            $table->string("logo")->index();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('industries');
    }
}
