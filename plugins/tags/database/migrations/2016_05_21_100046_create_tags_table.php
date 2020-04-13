<?php

use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function ($table) {
            $table->increments('id');
            $table->json("name")->nullable();
            $table->json("slug")->nullable();
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
        Schema::drop('tags');
    }
}
