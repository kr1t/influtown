<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('s_gender', ['M', 'F', 'L'])->comment('M(ale) F(email) L(LGBT)')->nullable();
            $table->tinyInteger('s_age')->nullable();
            $table->json('s_type')->nullable();
            $table->tinyInteger('s_follow')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}