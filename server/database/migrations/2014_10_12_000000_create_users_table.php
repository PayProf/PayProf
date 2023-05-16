<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
           
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('role');
            $table->rememberToken();
            $table->timestamps();


            // 4=>"AdminUae",
            // 3=>"AdminEtab",
            // 2=>"DirecteurEtab",
            // 1=>"DirecteurUae",
            // 0=>"Enseignant",
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');




    }
};