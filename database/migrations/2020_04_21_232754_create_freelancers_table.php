<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreelancersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hourly_rate')->nullable()->index();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('media_id')->nullable()->index();
            $table->unsignedInteger('industry_id')->nullable()->index();
            $table->unsignedInteger('location_id')->nullable()->index();
            $table->string('english_level')->nullable()->index();
            $table->boolean('share_project')->nullable()->default('0')->index();
            $table->timestamps();
        });
        Schema::table('freelancers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('media_id')->references('id')->on('media');
            $table->foreign('industry_id')->references('id')->on('industries');
            $table->foreign('location_id')->references('id')->on('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancers');
    }
}
