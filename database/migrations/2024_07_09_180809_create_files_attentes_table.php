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
        Schema::create('files_attentes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('service_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('ClientsEnAttentes')->default(0);
            $table->integer('ClientsTraites')->default(0);
            $table->double('tempsMoyenAttente')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files_attentes');
    }
};
