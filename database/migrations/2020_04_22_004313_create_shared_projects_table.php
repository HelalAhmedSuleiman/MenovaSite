<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('industry_id')->nullable()->index();
            $table->unsignedBigInteger('freelancer_id')->index();
            $table->string('name')->index();
            $table->text('description');
            $table->timestamps();
        });
        Schema::table('shared_projects', function (Blueprint $table) {
            $table->foreign('freelancer_id')->references('id')->on('freelancers');
            $table->foreign('industry_id')->references('id')->on('industries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_projects');
    }
}
