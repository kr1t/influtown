<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('tel');
            $table->bigInteger('user_id');
            $table->bigInteger('influencer_id');
            $table->text('problem');
            $table->boolean('status')->default(0);

            $table->timestamps();
        });

        Schema::create('report_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_id');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}