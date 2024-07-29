<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('agence_id')->constrained()->onDelete('cascade');
            $table->enum('etat', ["ACTIF", "INACTIF"]);
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->timestamps();
            $table->string('nom_en')->nullable();
            $table->string('nom_ar')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->unique(['nom', 'agence_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
