<?php

use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create("pages", function ($table) {
            $table->increments('id');
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
            $table->json('excerpt')->nullable();
            $table->json('content')->nullable();
            $table->integer('image_id')->index();
            $table->integer('user_id')->index();
            $table->integer('status')->index();
            $table->string("lang")->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
        });

    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
