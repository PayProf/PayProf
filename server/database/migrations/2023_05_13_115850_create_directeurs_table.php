<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directeurs', function (Blueprint $table) {
           
            $table->id();
            $table->unsignedInteger('PPR')->unique(); //combinaisonde 7chiffres 
            $table->string('nom');
            $table->string('prenom');
            $table->string('email_perso');
            $table->date('date_naissance');
            $table->foreignId('etablissement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('image')->nullable(); 
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
        Schema::dropIfExists('directeurs');


    }
};
