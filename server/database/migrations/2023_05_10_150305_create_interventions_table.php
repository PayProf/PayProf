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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained();
            $table->foreignId('etablissement_id')->constrained();
            $table->string('intitule_intervention');
            $table->string('annee_univ')->default('2022/2023');
            $table->string('semestre')->default('S2');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('visa_uae')->default(0);
            $table->boolean('visa_etab')->default(0);
            $table->unsignedInteger('Nbr_heures');

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
        Schema::dropIfExists('interventions');
    }
};
