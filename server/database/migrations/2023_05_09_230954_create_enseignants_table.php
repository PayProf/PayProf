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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('PPR')->unique();   //il faut au moins 7 chiffres
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('email_perso');
            $table->foreignId('etablissement_id')->constrained()->onDelete('cascade');
            $table->foreignId('grade_id')->constrained()->nullable()->nullOnDelete();
            $table->foreignId('user_id')->unique()->constrained('users')->nullable();
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
        Schema::dropIfExists('enseignants');
    }
};
