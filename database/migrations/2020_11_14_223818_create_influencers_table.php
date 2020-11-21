<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->dateTime('expiry')->nullable();
            $table->enum('gender', ['M', 'F', 'L'])->comment('M(ale) F(email) L(LGBT)');
            $table->tinyInteger('age');
            $table->json('type');
            $table->text('dislike')->nullable();
            $table->tinyInteger('follow');
            $table->string('profile_url');
            $table->double('budget', [10, 2])->default(0);
            $table->string('name');
            $table->string('nickname');

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
        Schema::dropIfExists('influencers');
    }
}